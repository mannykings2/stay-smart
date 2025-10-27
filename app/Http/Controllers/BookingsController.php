<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ChefBooking;
use App\Models\Property;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    public function book(Property $property){
        return view('bookings.book', compact('property'));
    }

    public function mine(){
        $bookings = Booking::where('user_id', auth()->id())->latest()->get();
        $chefBookings = ChefBooking::where('user_id', auth()->id())->latest()->get();
        return view('bookings.mine', compact('bookings', 'chefBookings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'number_of_guests' =>'required|integer',
            'check_in_date' =>'required|date',
            'check_out_date' =>'required|date|after:check_in_date',
        ]);

        $property = Property::find($request->property_id);

        if (!$property) {
            return back()->with('error', 'Invalid property');
        }

        $check_in_date = $request->check_in_date;
        $check_out_date = $request->check_out_date;

        $isBooked = Booking::where('property_id', $property->id)
            ->where('status', 'Confirmed')
            ->whereDate('check_in_date', '<=', $check_out_date)
            ->whereDate('check_out_date', '>=', $check_in_date)
            ->exists();

        if ($isBooked) {
            return back()->with('error', 'The property is already booked during the specified dates');
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
            ->with('success', 'Your booking has been made successfully.Make Payment to confirm.');
    }

    public function view($reference){
        $booking = Booking::where('reference', $reference)->first();

        if (!$booking) {
            return back()->with('error', 'Invalid booking reference');
        }

        return view('bookings.view', compact('booking'));
    }

    private function calcTotalBookingPrice($check_in, $check_out, $property){
        $checkInDate = Carbon::parse($check_in);
        $checkOutDate = Carbon::parse($check_out);
        $days = $checkInDate->diffInDays($checkOutDate);

        $total_cost = $property->price_per_night * $days;

        return $total_cost;
    }

    private function generateBookingReference($propertyId){
        $booking_reference = strtoupper(fake()->bothify('???-#####')) . $propertyId . 'SM';

        return $booking_reference;
    }
}
