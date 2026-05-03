<?php

namespace App\Http\Controllers;

use App\Models\RevenuePayout;
use App\Models\RevenueSplit;
use App\Models\User;
use App\Models\Property;
use App\Models\Chef;
use App\Models\Driver;
use App\Models\AdminBankAccount;
use App\Models\RevenueAuditLog;
use App\Models\AdminRevenueConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RevenueManagementController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $isSuperAdmin = $user->hasRole('Super Admin');

        // Filter Logic for Stats
        $period = $request->get('period', 'all');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        // Proactive Maturation: Check for and promote matured splits for this user
        $this->runPromoteMaturedSplits($user);

        $stats = $this->getSummaryStats($isSuperAdmin ? null : $user->id, $period, $startDate, $endDate);

        // Recent Activity for Overview
        $query = RevenueSplit::with(['admin', 'payment.booking.property']);
        if (!$isSuperAdmin) {
            $query->where('admin_id', $user->id)
                ->where('service_type', 'Property'); // Exclude services for regular admins
        }
        $recentTransactions = $query->latest()->limit(5)->get();

        $payoutQuery = RevenuePayout::with('admin');
        if (!$isSuperAdmin) {
            $payoutQuery->where('admin_id', $user->id);
        }
        $recentPayouts = $payoutQuery->latest()->limit(5)->get();

        // Monthly revenue trend for chart (last 6 months)
        $trendQuery = RevenueSplit::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, SUM(total_amount) as total, SUM(admin_net_amount) as net, SUM(platform_fee_amount) as fees")
            ->where('status', '!=', 'Voided')
            ->where('created_at', '>=', now()->subMonths(6)->startOfMonth());
        if (!$isSuperAdmin) {
            $trendQuery->where('admin_id', $user->id)->where('service_type', 'Property');
        }

        $rawMonthlyTrend = $trendQuery->groupBy('month')->orderBy('month')->get()->keyBy('month');
        
        // Normalize 6 months data for the graph
        $monthlyTrend = collect();
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('Y-m');
            if (isset($rawMonthlyTrend[$month])) {
                $monthlyTrend->push($rawMonthlyTrend[$month]);
            } else {
                $monthlyTrend->push((object)[
                    'month' => $month,
                    'total' => 0,
                    'net' => 0,
                    'fees' => 0
                ]);
            }
        }

        return view('admin.revenue.overview', compact('stats', 'recentTransactions', 'recentPayouts', 'isSuperAdmin', 'monthlyTrend'));
    }

    public function transactions(Request $request)
    {
        $user = Auth::user();
        $isSuperAdmin = $user->hasRole('Super Admin');

        $query = RevenueSplit::with(['admin', 'payment.booking.property', 'payout']);

        if (!$isSuperAdmin) {
            $query->where('admin_id', $user->id)
                ->where('service_type', 'Property'); // Exclude services for regular admins
        }

        // Filtering
        $period = $request->get('period', 'all');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $query = $this->applyDateFilter($query, $period, $startDate, $endDate);

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('payment', fn($pq) => $pq->where('trx_ref', 'like', "%{$search}%"))
                  ->orWhereHas('payment.booking.property', fn($pq) => $pq->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('admin', fn($aq) => $aq->where('first_name', 'like', "%{$search}%")->orWhere('last_name', 'like', "%{$search}%"));
            });
        }

        $transactions = $query->latest()->paginate(20, ['*'], 'tr_page');
        $stats = $this->getSummaryStats($isSuperAdmin ? null : $user->id, $period, $startDate, $endDate);

        return view('admin.revenue.transactions', compact('transactions', 'stats', 'isSuperAdmin'));
    }

    public function payouts(Request $request)
    {
        $user = Auth::user();
        $isSuperAdmin = $user->hasRole('Super Admin');

        // Pending Approval requests
        $pendingQuery = RevenuePayout::with(['admin.bankAccount'])->where('status', 'Pending Approval');
        if (!$isSuperAdmin) {
            $pendingQuery->where('admin_id', $user->id);
        }
        $pendingPayouts = $pendingQuery->latest()->get();

        // Payout history (Paid)
        $historyQuery = RevenuePayout::with(['admin.bankAccount'])->where('status', 'Paid');
        if (!$isSuperAdmin) {
            $historyQuery->where('admin_id', $user->id);
        }
        $payoutHistory = $historyQuery->latest()->paginate(20, ['*'], 'po_page');

        // Proactive Maturation
        if ($isSuperAdmin) {
            User::role('Admin')->with('revenueConfig')->get()->each(fn($admin) => $this->runPromoteMaturedSplits($admin));
        } else {
            $this->runPromoteMaturedSplits($user);
        }

        // Stats for payout cards
        $stats = $this->getSummaryStats($isSuperAdmin ? null : $user->id);

        // Super Admin: compute payout due status for all admins
        $adminDueStatuses = collect();
        if ($isSuperAdmin) {
            $globalFrequency = User::role('Super Admin')->with('revenueConfig')->first()?->revenueConfig?->payout_frequency ?? 'On Demand';

            User::role('Admin')->with('revenueConfig')->get()->each(function ($admin) use (&$adminDueStatuses, $globalFrequency, $pendingPayouts) {
                // Skip admins who already have a pending request
                if ($pendingPayouts->where('admin_id', $admin->id)->isNotEmpty()) {
                    return;
                }

                $availableBalance = RevenueSplit::where('admin_id', $admin->id)
                    ->where('status', 'Available')
                    ->where('service_type', 'Property')
                    ->sum('admin_net_amount');

                // No funds available — nothing to show
                if ($availableBalance <= 0) {
                    return;
                }

                $lastPayout = RevenuePayout::where('admin_id', $admin->id)
                    ->where('status', 'Paid')
                    ->latest('paid_at')
                    ->first();

                $frequency = $admin->revenueConfig?->payout_frequency ?? $globalFrequency;
                $status = $this->getPayoutDueStatus($frequency, $lastPayout?->paid_at ?? $admin->created_at);

                if (in_array($status['state'], ['upcoming', 'due', 'overdue', 'available'])) {
                    $adminDueStatuses->push([
                        'admin' => $admin,
                        'status' => $status,
                        'balance' => $availableBalance,
                        'frequency' => $frequency,
                        'last_paid' => $lastPayout?->paid_at,
                    ]);
                }
            });

            // Sort: overdue first, then due, then upcoming
            $adminDueStatuses = $adminDueStatuses->sortByDesc(fn($a) => ['overdue' => 3, 'due' => 2, 'upcoming' => 1, 'available' => 0][$a['status']['state']] ?? 0);
        }

        return view('admin.revenue.payouts', compact('pendingPayouts', 'payoutHistory', 'stats', 'isSuperAdmin', 'adminDueStatuses'));
    }

    /**
     * Compute payout due status based on frequency and last payout date.
     * Returns ['state' => 'ok|upcoming|due|overdue|available', 'label' => string, 'days_until' => int|null]
     */
    private function getPayoutDueStatus(string $frequency, \Carbon\Carbon|\Illuminate\Support\Carbon $since): array
    {
        $now = now();

        if ($frequency === 'On Demand') {
            return ['state' => 'available', 'label' => 'Funds Available', 'days_until' => null];
        }

        // Find the next due date based on frequency
        $dueDate = match ($frequency) {
            'Monthly' => $since->copy()->addDays(30)->startOfDay(),

            'Quarterly' => (function () use ($now) {
                    // Calendar quarter starts: Jan 1, Apr 1, Jul 1, Oct 1
                    $quarterStarts = [
                    $now->copy()->startOfYear(),
                    $now->copy()->startOfYear()->addMonths(3),
                    $now->copy()->startOfYear()->addMonths(6),
                    $now->copy()->startOfYear()->addMonths(9),
                    ];
                    // Return the most recent quarter start that is today or earlier
                    foreach (array_reverse($quarterStarts) as $qs) {
                        if ($qs->lte($now)) {
                            return $qs;
                        }
                    }
                    return $quarterStarts[0];
                })(),

            'Yearly' => $now->copy()->startOfYear(), // Jan 1 of current year
            default => $since->copy()->addDays(30)->startOfDay(),
        };

        // For Quarterly and Yearly, if $since (last payout) is AFTER the most recent due date,
        // the admin has already been paid for this period — they're OK
        if (in_array($frequency, ['Quarterly', 'Yearly']) && $since->gte($dueDate)) {
            return ['state' => 'ok', 'label' => 'Up to Date', 'days_until' => null];
        }

        // How many days past the due date are we?
        $daysOverdue = $dueDate->diffInDays($now, false); // negative = future, positive = past

        $warningDays = match ($frequency) {
            'Monthly' => 5,
            'Quarterly' => 14,
            'Yearly' => 16,
            default => 5,
        };

        if ($daysOverdue >= 0) {
            return ['state' => 'due', 'label' => 'Due for Payout', 'days_until' => 0];
        }

        $daysUntil = abs($daysOverdue);
        if ($daysUntil <= $warningDays) {
            return ['state' => 'upcoming', 'label' => "Due in {$daysUntil} day" . ($daysUntil === 1 ? '' : 's'), 'days_until' => $daysUntil];
        }

        return ['state' => 'ok', 'label' => 'Up to Date', 'days_until' => null];
    }

    public function settings(Request $request)
    {
        $user = Auth::user();
        $isSuperAdmin = $user->hasRole('Super Admin');

        $properties = collect();
        $chefs = collect();
        $drivers = collect();

        if ($isSuperAdmin) {
            $admins = User::role('Admin')->with('roles')->get();
            $properties = Property::with('user')->paginate(10, ['*'], 'pr_page');
            $chefs = Chef::paginate(10, ['*'], 'ch_page');
            $drivers = Driver::paginate(10, ['*'], 'dr_page');
            $globalAdmin = User::role('Super Admin')->with('revenueConfig')->first();
        } else {
            $admins = collect([$user]);
            $properties = Property::where('user_id', $user->id)->paginate(10, ['*'], 'pr_page');
            $globalAdmin = User::role('Super Admin')->with('revenueConfig')->first();
        }

        $auditLogs = collect();
        if ($isSuperAdmin) {
            $auditLogs = RevenueAuditLog::with('changedByUser')->latest()->limit(10)->get();
        }

        return view('admin.revenue.settings', compact('admins', 'properties', 'chefs', 'drivers', 'globalAdmin', 'isSuperAdmin', 'auditLogs'));
    }

    public function updatePropertySettings(Request $request, Property $property)
    {
        if (!Auth::user()->hasRole('Super Admin')) {
            return back()->with('error', 'Only Super Admins can update property settings.');
        }

        $request->validate([
            'commission_rate' => 'nullable|numeric|min:0|max:100000', // Allow for large fixed amounts too
            'commission_type' => 'required|in:Fixed,Percentage',
            'payout_frequency' => 'nullable|in:Monthly,Quarterly,Yearly,On Demand',
        ]);

        $oldValues = $property->only(['commission_rate', 'commission_type', 'payout_frequency']);
        $property->update($request->only(['commission_rate', 'commission_type', 'payout_frequency']));

        foreach (['commission_rate', 'commission_type', 'payout_frequency'] as $field) {
            if (($oldValues[$field] ?? null) != $property->$field) {
                RevenueAuditLog::create([
                    'changed_by' => Auth::id(),
                    'entity_type' => 'property',
                    'entity_id' => $property->id,
                    'field_changed' => $field,
                    'old_value' => $oldValues[$field],
                    'new_value' => $property->$field,
                ]);
            }
        }

        return back()->with('success', 'Property revenue settings updated successfully.');
    }

    public function updateChefSettings(Request $request, Chef $chef)
    {
        if (!Auth::user()->hasRole('Super Admin')) {
            return back()->with('error', 'Unauthorized.');
        }

        $request->validate([
            'commission_rate' => 'nullable|numeric|min:0',
            'commission_type' => 'required|in:Fixed,Percentage',
        ]);

        $oldValues = $chef->only(['commission_rate', 'commission_type']);
        $chef->update($request->only(['commission_rate', 'commission_type']));

        foreach (['commission_rate', 'commission_type'] as $field) {
            if (($oldValues[$field] ?? null) != $chef->$field) {
                RevenueAuditLog::create([
                    'changed_by' => Auth::id(),
                    'entity_type' => 'chef',
                    'entity_id' => $chef->id,
                    'field_changed' => $field,
                    'old_value' => $oldValues[$field],
                    'new_value' => $chef->$field,
                ]);
            }
        }

        return back()->with('success', 'Chef revenue settings updated.');
    }

    public function updateDriverSettings(Request $request, Driver $driver)
    {
        if (!Auth::user()->hasRole('Super Admin')) {
            return back()->with('error', 'Unauthorized.');
        }

        $request->validate([
            'commission_rate' => 'nullable|numeric|min:0',
            'commission_type' => 'required|in:Fixed,Percentage',
        ]);

        $oldValues = $driver->only(['commission_rate', 'commission_type']);
        $driver->update($request->only(['commission_rate', 'commission_type']));

        foreach (['commission_rate', 'commission_type'] as $field) {
            if (($oldValues[$field] ?? null) != $driver->$field) {
                RevenueAuditLog::create([
                    'changed_by' => Auth::id(),
                    'entity_type' => 'driver',
                    'entity_id' => $driver->id,
                    'field_changed' => $field,
                    'old_value' => $oldValues[$field],
                    'new_value' => $driver->$field,
                ]);
            }
        }

        return back()->with('success', 'Driver revenue settings updated.');
    }

    public function updateSettings(Request $request, User $user)
    {
        if (!Auth::user()->hasRole('Super Admin')) {
            return back()->with('error', 'Only Super Admins can update financial settings.');
        }

        $request->validate([
            'commission_rate' => 'required|numeric|min:0|max:100',
            'staff_commission_rate' => 'required|numeric|min:0|max:100',
            'payout_frequency' => 'required|in:Monthly,Quarterly,Yearly,On Demand',
        ]);

        $config = $user->getOrCreateRevenueConfig();
        $oldSettings = $config->only(['commission_rate', 'staff_commission_rate', 'payout_frequency']);

        $config->update($request->only(['commission_rate', 'staff_commission_rate', 'payout_frequency']));

        // Audit Log
        foreach (['commission_rate', 'staff_commission_rate', 'payout_frequency'] as $field) {
            if (($oldSettings[$field] ?? null) != $config->$field) {
                RevenueAuditLog::create([
                    'changed_by' => Auth::id(),
                    'entity_type' => 'global',
                    'entity_id' => $user->id,
                    'field_changed' => $field,
                    'old_value' => $oldSettings[$field],
                    'new_value' => $config->$field,
                ]);
            }
        }

        return back()->with('success', 'Revenue settings updated successfully.');
    }

    public function requestPayout(Request $request)
    {
        $user = Auth::user();

        // Calculate available amount (Restrict to Property splits for regular Admins)
        $availableAmount = RevenueSplit::where('admin_id', $user->id)
            ->where('status', 'Available')
            ->where('service_type', 'Property')
            ->whereNull('payout_id')
            ->sum('admin_net_amount');

        if ($availableAmount <= 0) {
            return back()->with('error', 'No available funds to withdraw.');
        }

        // Check if there is already a pending request
        $existingPending = RevenuePayout::where('admin_id', $user->id)
            ->where('status', 'Pending Approval')
            ->exists();

        if ($existingPending) {
            return back()->with('error', 'You already have a pending payout request awaiting approval.');
        }

        // Create payout request and lock the current splits to it
        DB::transaction(function () use ($user, $availableAmount) {
            $payout = RevenuePayout::create([
                'admin_id' => $user->id,
                'amount' => $availableAmount,
                'reference' => 'PO-' . Str::upper(Str::random(10)),
                'status' => 'Pending Approval',
            ]);

            // Lock these splits to the payout so new splits won't be included
            RevenueSplit::where('admin_id', $user->id)
                ->where('status', 'Available')
                ->where('service_type', 'Property')
                ->whereNull('payout_id')
                ->update(['payout_id' => $payout->id]);
        });

        return back()->with('success', 'Payout request submitted. Awaiting Super Admin approval.');
    }

    /**
     * Super Admin approves a payout request and marks splits as Withdrawn.
     */
    public function approvePayout(Request $request, RevenuePayout $payout)
    {
        if (!Auth::user()->hasRole('Super Admin')) {
            return back()->with('error', 'Unauthorized.');
        }

        if ($payout->status !== 'Pending Approval') {
            return back()->with('error', 'This payout has already been processed.');
        }

        $request->validate([
            'payment_method' => 'required|string',
            'payment_reference' => 'nullable|string|max:255',
            'admin_note' => 'nullable|string|max:500',
            'receipt_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,pdf|max:2048',
        ]);

        $receiptPath = null;
        if ($request->hasFile('receipt_image')) {
            $file = $request->file('receipt_image');
            $filename = 'receipt_' . $payout->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $receiptPath = $file->storeAs('payout_receipts', $filename, 'public');
        }

        DB::transaction(function () use ($payout, $request, $receiptPath) {
            $payout->update([
                'status' => 'Paid',
                'payment_method' => $request->payment_method,
                'payment_reference' => $request->payment_reference,
                'admin_note' => $request->admin_note,
                'receipt_image' => $receiptPath,
                'paid_at' => now(),
            ]);

            // Withdraw splits locked to this payout
            RevenueSplit::where('payout_id', $payout->id)
                ->update(['status' => 'Withdrawn']);
        });

        return back()->with('success', 'Payout approved and marked as Paid.');
    }

    public function markAsPaid(Request $request)
    {
        if (!Auth::user()->hasRole('Super Admin')) {
            return back()->with('error', 'Unauthorized.');
        }

        $request->validate([
            'payout_ids' => 'required|array',
            'payment_method' => 'required|string',
        ]);

        DB::transaction(function () use ($request) {
            $payouts = RevenuePayout::whereIn('id', $request->payout_ids)->get();

            foreach ($payouts as $payout) {
                $payout->update([
                    'status' => 'Paid',
                    'payment_method' => $request->payment_method,
                    'paid_at' => now(),
                ]);

                // Also mark linked splits as Withdrawn (mirrors approvePayout logic)
                RevenueSplit::where('admin_id', $payout->admin_id)
                    ->where('status', 'Available')
                    ->where('service_type', 'Property')
                    ->update([
                        'payout_id' => $payout->id,
                        'status' => 'Withdrawn',
                    ]);
            }
        });

        return back()->with('success', 'Payouts marked as paid.');
    }

    public function exportReport(Request $request)
    {
        $isSuperAdmin = Auth::user()->hasRole('Super Admin');
        $query = RevenueSplit::with(['admin', 'payment.booking.property']);

        if (!$isSuperAdmin) {
            $query->where('admin_id', Auth::id())
                ->where('service_type', 'Property');
        }

        $splits = $query->latest()->get();

        $filename = "revenue_report_" . date('Y-m-d') . ".csv";

        return response()->streamDownload(function () use ($splits) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Date', 'Reference', 'Service', 'Admin', 'Total Amount', 'Platform Fee', 'Admin Net', 'Status']);

            foreach ($splits as $split) {
                $serviceName = match ($split->service_type) {
                    'Property' => $split->payment->booking->property->name ?? 'Property',
                    'Chef' => 'Chef Service',
                    'Driver' => 'Driver Service',
                    default => 'N/A',
                };

                fputcsv($handle, [
                    $split->created_at->format('Y-m-d'),
                    $split->payment->trx_ref ?? 'N/A',
                    $serviceName,
                    $split->admin->first_name . ' ' . $split->admin->last_name,
                    $split->total_amount,
                    $split->platform_fee_amount,
                    $split->admin_net_amount,
                    $split->status,
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    /**
     * Promote 'Paid' splits to 'Available' if the payout window has opened.
     * Public so the scheduled command can call it.
     */
    public function runPromoteMaturedSplits($admin)
    {
        $hasPaidSplits = RevenueSplit::where('admin_id', $admin->id)
            ->where('status', 'Paid')
            ->exists();

        if (!$hasPaidSplits)
            return;

        $admin->loadMissing('revenueConfig');

        $globalFrequency = User::role('Super Admin')->with('revenueConfig')->first()?->revenueConfig?->payout_frequency ?? 'On Demand';
        $frequency = $admin->revenueConfig?->payout_frequency ?? $globalFrequency;

        $lastPayout = RevenuePayout::where('admin_id', $admin->id)
            ->where('status', 'Paid')
            ->latest('paid_at')
            ->first();

        $status = $this->getPayoutDueStatus($frequency, $lastPayout?->paid_at ?? $admin->created_at);

        // If we are due or overdue, or it's On Demand, promote all 'Paid' to 'Available'
        if (in_array($status['state'], ['due', 'overdue', 'available'])) {
            RevenueSplit::where('admin_id', $admin->id)
                ->where('status', 'Paid')
                ->update(['status' => 'Available']);
        }
    }

    private function getSummaryStats($adminId = null, $period = 'all', $startDate = null, $endDate = null)
    {
        $query = RevenueSplit::where('status', '!=', 'Voided');
        if ($adminId) {
            $query->where('admin_id', $adminId)
                ->where('service_type', 'Property'); // Exclude services for regular admins
        }

        $query = $this->applyDateFilter($query, $period, $startDate, $endDate);

        return [
            'total_revenue' => (clone $query)->sum('total_amount'),
            'platform_fees' => (clone $query)->sum('platform_fee_amount'),
            'admin_net' => (clone $query)->sum('admin_net_amount'),
            'pending' => (clone $query)->where('status', 'Pending')->sum('admin_net_amount'),
            'paid' => (clone $query)->where('status', 'Paid')->sum('admin_net_amount'),
            'available' => (clone $query)->where('status', 'Available')->sum('admin_net_amount'),
            'withdrawn' => (clone $query)->where('status', 'Withdrawn')->sum('admin_net_amount'),
        ];
    }

    private function applyDateFilter($query, $period, $startDate = null, $endDate = null)
    {
        switch ($period) {
            case 'week':
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'month':
                $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
                break;
            case 'year':
                $query->whereYear('created_at', now()->year);
                break;
            case 'custom':
                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
                }
                break;
        }
        return $query;
    }
}
