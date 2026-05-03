<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ChefBooking;
use App\Models\DriverBooking;
use App\Models\Property;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BookingsController extends Controller
{
    public function book(Property $property)
    {
        $property->load('amenities');
        return view('bookings.book', compact('property'));
    }

    public function mine()
    {
        $activeBookings = null;
        $completedBookings = null;

        // Add pagination to bookings lists. Use distinct page query names to avoid conflicts.
        if (auth()->user()->hasRole('Super Admin')) {
            $bookings = Booking::with(['property', 'user', 'digitalCheckIns'])->latest()->paginate(15, ['*'], 'book_page');

            $chefBookings = ChefBooking::with(['user', 'chef'])->latest()->paginate(10, ['*'], 'chef_page');
            $driverBookings = DriverBooking::with(['user', 'driver'])->latest()->paginate(10, ['*'], 'driver_page');
        } elseif (auth()->user()->hasRole('Admin')) {
            $bookings = Booking::with(['property', 'user', 'digitalCheckIns'])->whereHas('property', function ($q) {
                $q->where('user_id', auth()->id());
            })->latest()->paginate(15, ['*'], 'book_page');

            // Admins should not see chef/driver bookings
            $chefBookings = collect([]);
            $driverBookings = collect([]);
        } else {
            // Regular user: separate paginated lists for active and completed bookings (cards view)
            $activeBookings = Booking::with(['property', 'digitalCheckIns'])
                ->where('user_id', auth()->id())
                ->where('status', '!=', 'Completed')
                ->latest()
                ->paginate(6, ['*'], 'book_active_page');

            $completedBookings = Booking::with(['property', 'digitalCheckIns'])
                ->where('user_id', auth()->id())
                ->where('status', 'Completed')
                ->latest()
                ->paginate(6, ['*'], 'book_completed_page');

            $chefBookings = ChefBooking::with(['chef'])->where('user_id', auth()->id())->latest()->paginate(6, ['*'], 'chef_page');
            $driverBookings = DriverBooking::with(['driver'])->where('user_id', auth()->id())->latest()->paginate(6, ['*'], 'driver_page');

            // Backwards-compat: some views expect $bookings variable. Set to null when using separate paginators.
            $bookings = null;
        }

        return view('bookings.mine', compact('bookings', 'activeBookings', 'completedBookings', 'chefBookings', 'driverBookings'));
    }

    public function store(Request $request)
    {
        $rules = [
            'property_id' => 'required|integer',
            'number_of_guests' => 'required|integer',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
        ];

        if (!auth()->check()) {
            $rules['first_name'] = 'required|string|max:255';
            $rules['last_name'] = 'required|string|max:255';
            $rules['email'] = 'required|email|max:255';
            $rules['phone_number'] = 'required|string|max:255';
        }

        $request->validate($rules);

        if (!auth()->check()) {
            $user = User::where('email', $request->email)->first();

            if ($user && !$user->is_guest) {
                return back()->with('error', 'An account already exists with this email. Please login to continue.');
            }

            if (!$user) {
                $user = User::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'phone_number' => $request->phone_number,
                    'password' => Hash::make(Str::random(16)),
                    'is_guest' => true,
                ]);
            } else {
                // If it's an existing guest user, update info if needed
                $user->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone_number' => $request->phone_number,
                ]);
            }

            auth()->login($user);
        } else {
            // Just-In-Time Profile Completion for logged in users
            $user = auth()->user();
            if (empty($user->last_name) || empty($user->phone_number)) {
                $request->validate([
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'phone_number' => 'required|string|max:255',
                ]);

                $user->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone_number' => $request->phone_number,
                ]);
            }
        }

        $property = Property::find($request->property_id);

        if (!$property) {
            return back()->with('error', 'Invalid property');
        }

        $check_in_date = $request->check_in_date;
        $check_out_date = $request->check_out_date;

        // Check if property is already booked (Confirmed status only)
        $existingBooking = Booking::where('property_id', $property->id)
            ->whereDate('check_in_date', '<', $check_out_date) // Exclusive check
            ->whereDate('check_out_date', '>', $check_in_date)
            ->where('status', 'Confirmed')
            ->first();

        if ($existingBooking) {
            return back()->with('error', 'Sorry, this property is already booked for the selected dates. Please choose different dates.');
        }

        $available_status = ['Available', 'Booked'];

        if (!in_array($property->status, $available_status)) {
            return back()->with('error', 'This property is currently unavailable.');
        }

        if ($request->number_of_guests > $property->max_guests) {
            return back()->with('error', "The number of guests exceeds the property's maximum capacity of {$property->max_guests}.");
        }

        try {
            $booking = new Booking();
            $booking->reference = $this->generateBookingReference($property->id);
            $booking->property_id = $property->id;
            $booking->user_id = auth()->id();
            $booking->number_of_guests = $request->number_of_guests;
            $booking->check_in_date = $check_in_date;
            $booking->check_out_date = $check_out_date;
            $booking->total_price = $this->calcTotalBookingPrice($check_in_date, $check_out_date, $property);
            $booking->save();
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while creating your booking. Please try again.');
        }

        return redirect()->route('booking.view', $booking->reference)
            ->with('success', 'Your booking has been made successfully. Make Payment to confirm.');
    }

    public function view($reference)
    {
        // 1. Check Property Booking
        $booking = Booking::with(['payment', 'user', 'property'])
            ->where('reference', $reference)
            ->first();

        if ($booking) {
            $type = 'property';
            return view('bookings.view', compact('booking', 'type'));
        }

        // 2. Check Chef Booking
        $booking = ChefBooking::with(['user', 'chef', 'chefServiceType.chefService'])
            ->where('reference', $reference)
            ->first();

        if ($booking) {
            $type = 'chef';
            return view('bookings.view', compact('booking', 'type'));
        }

        // 3. Check Driver Booking
        $booking = DriverBooking::with(['user', 'driver', 'driverServiceType.driverService'])
            ->where('reference', $reference)
            ->first();

        if ($booking) {
            $type = 'driver';
            return view('bookings.view', compact('booking', 'type'));
        }

        return back()->with('error', 'Invalid booking reference');
    }


    private function calcTotalBookingPrice($check_in, $check_out, $property)
    {
        $checkInDate = Carbon::parse($check_in);
        $checkOutDate = Carbon::parse($check_out);
        $days = $checkInDate->diffInDays($checkOutDate);

        $total_cost = $property->price_per_night * $days;

        return $total_cost;
    }

    private function generateBookingReference($propertyId)
    {
        $booking_reference = Str::upper(Str::random(3)) . '-' . rand(10000, 99999) . $propertyId . 'SM';

        return $booking_reference;
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
        ]);

        $isBooked = Booking::where('property_id', $request->property_id)
            ->where('status', 'Confirmed')
            ->whereDate('check_in_date', '<', $request->check_out_date)
            ->whereDate('check_out_date', '>', $request->check_in_date)
            ->exists();

        if ($isBooked) {
            return response()->json([
                'available' => false,
                'message' => 'Apartment is unavailable/already booked for the required dates'
            ]);
        }

        return response()->json([
            'available' => true,
            'message' => 'Apartment is available'
        ]);
    }

    /**
     * Admin Feature: Bulk cancel stale pending bookings
     */
    public function bulkCancelPending(Request $request)
    {
        $hours = $request->input('hours', 24); // Default to 24 hours if not specified
        $cutoff = Carbon::now()->subHours($hours);

        $count = Booking::where('status', 'Pending')
            ->where('created_at', '<', $cutoff)
            ->count();

        if ($count > 0) {
            Booking::where('status', 'Pending')
                ->where('created_at', '<', $cutoff)
                ->update(['status' => 'Cancelled']);

            return back()->with('success', "Successfully cancelled {$count} stale pending bookings.");
        }

        return back()->with('info', 'No stale pending bookings found to cancel.');
    }
}
