<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
{
    public function welcome(){
        $properties = Property::where('status', 'Available')->withCount('bookings')
                    ->orderBy('bookings_count', 'desc')
                    ->take(20)
                    ->get();

        return view('welcome', compact('properties'));
    }

    public function services(){
        return view('services.index');
    }

    public function search(Request $request){
        $location = $request->location;
        $guests = $request->guests;
        $check_in = $request->check_in;
        $check_out = $request->check_out;

        $properties = Property::where('status', 'Available')
            ->where(function ($query) use ($location) {
                $query->where('city', 'like', "%$location%")
                    ->orWhere('address', 'like', "%$location%")
                    ->orWhere('country', 'like', "%$location%");
            })
            ->where('max_guests', '>=', $guests)
            ->whereDoesntHave('bookings', function ($query) use ($check_in, $check_out) {
                $query->where(function ($q) use ($check_in, $check_out) {
                    $q->where('check_in_date', '<', $check_out)
                    ->where('check_out_date', '>', $check_in)
                    ->where('status', '!=', 'Cancelled');
                });
            })
            ->withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->paginate(6);

        return view('search', compact('properties'));
    }

    public function bookNow(Request $request){
        $propertyId = Crypt::decrypt($request->propertyId);
        $location = $request->location;
        $guests = $request->guests;
        $check_in = $request->check_in;
        $check_out = $request->check_out;
        $property = Property::find($propertyId);

        return view('book_now', compact('property'));
    }

    public function booking(Request $request){
        $booking = Booking::where("reference", $request->reference)->first();
        $propertyId = $booking->property_id;
        $property = Property::find($propertyId);
        return view('booking', compact('property', 'booking'));
    }

    public function book(Request $request){
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
            $user = User::where("email", $request->email)->first();
            if(!isset($user)){
                $user = new User();
                $user->email = $request->email;
                $user->phone_number = $request->phone_number;
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->gender = $request->gender;
                $user->password = Hash::make($request->email);
                $user->save();
            }
            $booking = new Booking();
            $booking->reference = $this->generateBookingReference($property->id);
            $booking->property_id = $property->id;
            $booking->user_id = $user->id;
            $booking->number_of_guests = $request->number_of_guests;
            $booking->check_in_date = $check_in_date;
            $booking->check_out_date = $check_out_date;
            $booking->total_price = $this->calcTotalBookingPrice($check_in_date, $check_out_date, $property);
            $booking->save();
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while creating your booking. Please try again.');
        }

        return redirect()->route('booking', ['reference' => $booking->reference])
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

    public function payNow(Request $request){
        $booking = Booking::find($request->booking_id);
        $payment = Payment::where("booking_id", $request->booking_id)->first();
        if(!isset($payment)){
            $payment = new Payment();
            $payment->booking_id = $booking->id;
            $payment->user_id = $booking->user_id;
            $payment->payment_method = "Paystack";
            $payment->amount = $booking->total_price;
            $payment->trx_ref = $request->reference;
            $payment->status = "Pending";
            $payment->save();
        }
        else{
            if($payment->status == "Pending"){
                $payment->status = "Completed";
                $payment->trx_ref = $request->reference;
                $payment->save();
                Booking::where("id", $request->booking_id)->update(["status"=>"Confirmed"]);
            }
        }
        
        return response()->json(["status"=>"success", "message"=>"Booking Confirmed"]);
    }
    
    public function verifyPayment(Request $request)
    {
            $paystack_response = Http::withToken(env('PAYSTACK_SECRET_KEY'))->get('https://api.paystack.co/transaction/verify/' . $request->reference);
            $paystack_response = json_decode($paystack_response);
            $paystack_response->data->status === "success" ? $verify_status = true : $verify_status = false;

        if ($verify_status) {
            $payment = Payment::where("trx_ref", $request->reference)->first();
            if($payment->status == "Pending"){
                $payment->status = "Completed";
                $payment->trx_ref = $request->reference;
                $payment->save();

                Booking::where("id", $request->booking_id)->update(["status"=>"Confirmed"]);
            }
            return response()->json(["status"=>"success", "message" => "Payment Successful"]);
        } else {
            return response()->json(['status' => "error", "message" => "Payment unsuccessful"]);
        }
    }

    public function checkIn(Request $request){
        $reference = $request->booking_reference;
        $last_name = $request->last_name;
        $booking = Booking::where("reference", $reference)->first();
        $property = $booking->property;
        $user = User::where("id", $booking->user_id)->where("last_name", $last_name)->first();
        
        return view('check_in', compact('booking', 'user', 'property'));
    }

    public function checkInBooking(Request $request){
        $booking_id = $request->input('booking_id');

        try {
            DB::table("digital_check_ins")->insert([
                "booking_id"   => $booking_id,
                "check_in_time"=> Carbon::now(),
                "status"       => "Checked In"
            ]);
    
            return response()->json(["status" => "success"]);
        } catch (\Exception $e) {
            return response()->json([
                "status"  => "error",
                "message" => $e->getMessage()
            ], 500);
        }
    }

}
