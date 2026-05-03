<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentsController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('Admin')) {
            $payments = Payment::with(['user', 'booking.property', 'chefBooking.chefServiceType.chefService', 'rideBooking.driverServiceType.driverService'])
                ->whereHas('booking.property', function ($q) {
                    $q->where('user_id', auth()->id());
                })
                ->where('status', 'Completed')
                ->latest()->paginate(12, ['*'], 'pay_page');
        } else {
            $payments = Payment::with(['user', 'booking.property', 'chefBooking.chefServiceType.chefService', 'rideBooking.driverServiceType.driverService'])
                ->where('user_id', auth()->id())
                ->where('status', 'Completed')
                ->latest()->paginate(12, ['*'], 'pay_page');
        }

        return view('payments.index', compact('payments'));
    }

    public function show($id)
    {
        $payment = Payment::with(['booking.property', 'booking.user', 'booking.chefBookings', 'booking.rideBookings', 'chefBooking.chefServiceType.chefService', 'chefBooking.chef', 'rideBooking.driverServiceType.driverService', 'rideBooking.driver'])
            ->where('id', $id)
            ->firstOrFail();

        // Allow the paying user, admins, or super admins
        $user = auth()->user();
        $isOwner = $payment->user_id === $user->id;
        $isAdmin = $user->hasRole('Admin') || $user->hasRole('Super Admin');

        if (!$isOwner && !$isAdmin) {
            abort(403, 'Unauthorized.');
        }

        $response = [
            'id' => $payment->id,
            'trx_ref' => $payment->trx_ref,
            'amount' => number_format($payment->amount, 2),
            'status' => $payment->status,
            'payment_method' => $payment->payment_method,
            'paid_at' => $payment->created_at->format('M d, Y h:i A'),
            'booking' => [
                'reference' => $payment->booking->reference ?? 'N/A',
                'check_in' => optional($payment->booking)->check_in_date,
                'check_out' => optional($payment->booking)->check_out_date,
                'guests' => optional($payment->booking)->number_of_guests,
                'total_price' => number_format(optional($payment->booking)->total_price, 2),
                'property_name' => optional(optional($payment->booking)->property)->name ?? 'N/A',
                'property_addr' => optional(optional($payment->booking)->property)->address ?? '',
                'guest_name' => trim((optional(optional($payment->booking)->user)->first_name ?? '') . ' ' . (optional(optional($payment->booking)->user)->last_name ?? '')),
            ],
        ];

        if ($payment->chefBooking) {
            $response['chef_booking'] = [
                'reference' => $payment->chefBooking->reference ?? 'N/A',
                'chef_name' => trim(($payment->chefBooking->chef?->first_name ?? '') . ' ' . ($payment->chefBooking->chef?->last_name ?? '')),
                'service' => $payment->chefBooking->chefServiceType?->chefService?->name ?? 'Chef Service',
                'service_date' => $payment->chefBooking->service_date ?? 'N/A',
                'price' => number_format($payment->chefBooking->price ?? 0, 2),
            ];
        }

        if ($payment->rideBooking) {
            $response['ride_booking'] = [
                'reference' => $payment->rideBooking->reference ?? 'N/A',
                'driver_name' => trim(($payment->rideBooking->driver?->first_name ?? '') . ' ' . ($payment->rideBooking->driver?->last_name ?? '')),
                'service' => $payment->rideBooking->driverServiceType?->driverService?->name ?? 'Driver Service',
                'ride_date' => $payment->rideBooking->ride_date ?? 'N/A',
                'price' => number_format($payment->rideBooking->price ?? 0, 2),
            ];
        }

        return response()->json($response);
    }
    public function downloadReceipt($reference)
    {
        $payment = Payment::with([
            'user',
            'booking.property',
            'booking.user',
            'booking.chefBookings.chefServiceType.chefService',
            'booking.rideBookings.driverServiceType.driverService',
            'chefBooking.chefServiceType.chefService',
            'chefBooking.chef',
            'rideBooking.driverServiceType.driverService',
            'rideBooking.driver'
        ])
            ->where('trx_ref', $reference)
            ->where('status', 'Completed')
            ->firstOrFail();

        // Authorize: if logged in, enforce ownership or admin role.
        // If not logged in, the transaction reference itself serves as a bearer token
        // (only the paying user receives this reference via email/booking page).
        if (auth()->check()) {
            $user = auth()->user();
            $isOwner = $payment->user_id === $user->id;
            $isAdmin = $user->hasRole('Admin') || $user->hasRole('Super Admin');

            if (!$isOwner && !$isAdmin) {
                abort(403, 'Unauthorized.');
            }
        }

        $pdf = Pdf::loadView('payments.receipt', compact('payment'));
        return $pdf->download('receipt-' . $payment->trx_ref . '.pdf');
    }

    public function form()
    {
        return view('payments.form');
    }
}
