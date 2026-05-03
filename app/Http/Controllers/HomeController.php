<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Property;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Http\Request;

use App\Models\RevenueSplit;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $timeframe = $request->get('timeframe', 'month');
        $user = auth()->user();

        $bookings = Booking::with(['property', 'digitalCheckIns'])->latest()->get();
        $my_bookings = Booking::with(['property', 'digitalCheckIns'])->where('user_id', $user->id)->latest()->get();
        $properties = Property::latest()->get();
        $trending_properties = Property::whereIn('status', ['Available', 'Booked', 'Under Maintenance'])->withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->take(20)
            ->get();

        $usersCount = User::count();

        $to_clean = [];
        $cleaned_today = 0;
        $reported_issues = 0;

        $admin_revenue = 0;
        $admin_upcoming_checkins = 0;
        $admin_total_bookings = 0;
        $admin_recent_bookings = [];
        $admin_bookings = [];

        // Revenue Stats
        $revenueStats = [
            'total' => 0,
            'platform' => 0,
            'net' => 0,
            'pending' => 0,
            'available' => 0,
            'platform_percentage' => 0,
            'admin_percentage' => 0
        ];
        $chartData = ['labels' => [], 'datasets' => []];

        if ($user->hasRole('Cleaner')) {
            $adminIds = $user->managingAdmins()->pluck('users.id');
            $assignedIds = $user->assignedProperties()->where('role_type', 'cleaner')->pluck('properties.id');

            $to_clean = Property::where('status', 'Under Maintenance')
                ->where(function($q) use ($adminIds, $assignedIds) {
                    $q->whereIn('user_id', $adminIds)
                      ->orWhereIn('id', $assignedIds);
                })
                ->get();

            $cleaned_today = Property::where('last_cleaned_by', $user->id)
                ->whereDate('last_cleaned_at', now()->today())
                ->where(function($q) use ($adminIds, $assignedIds) {
                    $q->whereIn('user_id', $adminIds)
                      ->orWhereIn('id', $assignedIds);
                })
                ->count();

            $reported_issues = SupportTicket::where('user_id', $user->id)->count();
        } elseif ($user->hasRole('Admin') || $user->hasRole('Super Admin')) {
            if ($user->hasRole('Admin')) {
                $adminProperties = Property::where('user_id', $user->id)->pluck('id');
                $admin_revenue = Booking::whereIn('property_id', $adminProperties)
                    ->where('status', 'Confirmed')
                    ->sum('total_price');
                $admin_upcoming_checkins = Booking::whereIn('property_id', $adminProperties)
                    ->where('status', 'Confirmed')
                    ->whereNotExists(function ($query) {
                        $query->select(\Illuminate\Support\Facades\DB::raw(1))
                            ->from('digital_check_ins')
                            ->whereColumn('digital_check_ins.booking_id', 'bookings.id');
                    })
                    ->count();
                $admin_total_bookings = Booking::whereIn('property_id', $adminProperties)->count();
                $admin_recent_bookings = Booking::whereIn('property_id', $adminProperties)
                    ->with(['user', 'property'])
                    ->latest()
                    ->take(5)
                    ->get();
                $admin_bookings = Booking::whereIn('property_id', $adminProperties)
                    ->with(['user', 'property'])
                    ->latest()
                    ->get();
            }

            // Revenue Logic
            $revQuery = RevenueSplit::query();
            if ($user->hasRole('Admin')) {
                $revQuery->where('admin_id', $user->id);
            }

            $revenueStats = $this->getRevenueStats($revQuery->clone());
            $chartData = $this->getRevenueChartData($revQuery->clone(), $timeframe);
        }

        if ($user->hasRole('Cleaner')) {
            $adminIds = $user->managingAdmins()->pluck('users.id');
            $assignedIds = $user->assignedProperties()->where('role_type', 'cleaner')->pluck('properties.id');

            $properties = Property::where(function($q) use ($adminIds, $assignedIds) {
                    $q->whereIn('user_id', $adminIds)
                      ->orWhereIn('id', $assignedIds);
                })
                ->latest()->get();

            return view('cleaner.dashboard', compact(
                'bookings',
                'my_bookings',
                'properties',
                'usersCount',
                'trending_properties',
                'to_clean',
                'cleaned_today',
                'reported_issues',
                'timeframe'
            ));
        }

        return view('dashboard', compact(
            'bookings',
            'my_bookings',
            'properties',
            'usersCount',
            'trending_properties',
            'to_clean',
            'cleaned_today',
            'reported_issues',
            'admin_revenue',
            'admin_upcoming_checkins',
            'admin_total_bookings',
            'admin_recent_bookings',
            'admin_bookings',
            'revenueStats',
            'chartData',
            'timeframe'
        ));
    }

    private function getRevenueStats($query)
    {
        $total = $query->sum('total_amount');
        $platform = $query->sum('platform_fee_amount');
        $net = $query->sum('admin_net_amount');

        return [
            'total' => $total,
            'platform' => $platform,
            'net' => $net,
            'pending' => $query->clone()->where('status', 'Pending')->sum('admin_net_amount'),
            'available' => $query->clone()->where('status', 'Available')->sum('admin_net_amount'),
            'platform_percentage' => $total > 0 ? ($platform / $total) * 100 : 0,
            'admin_percentage' => $total > 0 ? ($net / $total) * 100 : 0,
        ];
    }

    private function getRevenueChartData($query, $timeframe)
    {
        $data = [];
        $labels = [];

        if ($timeframe === 'week') {
            $start = now()->startOfWeek();
            for ($i = 0; $i < 7; $i++) {
                $day = $start->copy()->addDays($i);
                $labels[] = $day->format('D');
                $data[] = $query->clone()->whereDate('created_at', $day)->sum('total_amount');
            }
        } elseif ($timeframe === 'year') {
            for ($i = 1; $i <= 12; $i++) {
                $month = \Carbon\Carbon::create(date('Y'), $i, 1);
                $labels[] = $month->format('M');
                $data[] = $query->clone()
                    ->whereMonth('created_at', $i)
                    ->whereYear('created_at', date('Y'))
                    ->sum('total_amount');
            }
        } else { // month
            $daysInMonth = now()->daysInMonth;
            for ($i = 1; $i <= $daysInMonth; $i++) {
                $day = now()->day($i);
                $labels[] = $i;
                $data[] = $query->clone()->whereDate('created_at', $day)->sum('total_amount');
            }
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Total Revenue',
                    'data' => $data,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.4)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1
                ]
            ]
        ];
    }
}
