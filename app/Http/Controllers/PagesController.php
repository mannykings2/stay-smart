<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Property;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;
use App\Models\BlogPost;
use App\Models\ChefBooking;
use App\Models\DriverBooking;
use App\Models\RevenueSplit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingReceipt;
use App\Mail\ContactMail;

use App\Services\PaystackService;

class PagesController extends Controller
{
    protected $paystackService;

    public function __construct(PaystackService $paystackService)
    {
        $this->paystackService = $paystackService;
    }

    public function welcome()
    {
        $properties = Property::whereIn('status', ['Available', 'Booked', 'Under Maintenance'])
            ->with(['images', 'amenities'])
            ->withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->take(20)
            ->get();

        $blog_posts = BlogPost::where('is_published', true)
            ->with('user')
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('welcome', compact('properties', 'blog_posts'));
    }

    public function blogPost($slug)
    {
        $post = BlogPost::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('blog.show', compact('post'));
    }

    public function properties(Request $request)
    {
        $query = Property::query();

        // Location/Search Logic
        if ($request->filled('location')) {
            $searchTerm = $request->location;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('address', 'like', "%{$searchTerm}%")
                    ->orWhere('city', 'like', "%{$searchTerm}%")
                    ->orWhere('country', 'like', "%{$searchTerm}%");
            });
        }

        // City Filter
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        // Price Filters
        if ($request->filled('min_price')) {
            $query->where('price_per_night', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price_per_night', '<=', $request->max_price);
        }

        // Availability Filter
        if ($request->filled('check_in') && $request->filled('check_out')) {
            $start = $request->check_in;
            $end = $request->check_out;

            $query->whereDoesntHave('bookings', function ($q) use ($start, $end) {
                $q->where('status', 'Confirmed')
                    ->where(function ($b) use ($start, $end) {
                        $b->whereBetween('check_in_date', [$start, $end])
                            ->orWhereBetween('check_out_date', [$start, $end])
                            ->orWhere(function ($sub) use ($start, $end) {
                                $sub->where('check_in_date', '<=', $start)
                                    ->where('check_out_date', '>=', $end);
                            });
                    });
            });
        }

        $properties = $query->whereIn('status', ['Available', 'Booked', 'Under Maintenance'])
            ->with(['images', 'amenities'])
            ->withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->paginate(12);

        $cities = Property::distinct()->pluck('city');

        return view('properties', compact('properties', 'cities'));
    }

    public function services()
    {
        return view('services.index');
    }

    /**public function search(Request $request){
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
    }**/

    public function search(Request $request)
    {
        // Step 1: Validate user inputs
        $request->validate([
            'location' => 'nullable|string|max:255',
            'guests' => 'required|integer|min:1',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
        ], [
            'guests.required' => 'Enter Number of Guests',
            'check_in.required' => 'Select a check-in date',
            'check_out.required' => 'Select a check-out date',
            'check_out.after' => 'Check-out must be after check-in',
        ]);

        $location = $request->input('location');
        $guests = (int) $request->input('guests');
        $check_in = $request->input('check_in');
        $check_out = $request->input('check_out');

        // Step 2: Query Properties
        // We now fetch ALL properties matching location/guests, effectively ignoring availability for the initial fetch
        $properties = Property::where('status', 'Available')
            ->where(function ($query) use ($location) {
                if ($location) {
                    $query->where('city', 'like', "%$location%")
                        ->orWhere('address', 'like', "%$location%")
                        ->orWhere('country', 'like', "%$location%");
                }
            })
            ->where('max_guests', '>=', $guests)
            ->with(['images', 'amenities', 'bookings' => function($q) use ($check_in, $check_out) {
                $q->where('status', 'Confirmed')
                  ->where('check_in_date', '<', $check_out)
                  ->where('check_out_date', '>', $check_in);
            }])
            ->withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->paginate(6)
            ->appends($request->all()); // keep query params for pagination links

        // Step 3: Check Availability for each property
        // Optimized: We check availability using the eager-loaded bookings
        foreach ($properties as $property) {
            $isBooked = $property->bookings->contains(function ($booking) use ($check_in, $check_out) {
                return $booking->status === 'Confirmed' &&
                       Carbon::parse($booking->check_in_date)->lt(Carbon::parse($check_out)) &&
                       Carbon::parse($booking->check_out_date)->gt(Carbon::parse($check_in));
            });

            $property->is_unavailable = $isBooked;
        }

        return view('search', compact('properties')); // so old input can be retained in form fields
    }


    public function bookNow(Request $request)
    {
        try {
            $propertyId = Crypt::decrypt($request->propertyId);
            $property = Property::with(['images', 'amenities'])->find($propertyId);

            if (!$property) {
                return redirect()->route('welcome')->with('error', 'Property not found.');
            }

            return view('book_now', compact('property'));
        } catch (\Exception $e) {
            return redirect()->route('welcome')->with('error', 'Invalid property request.');
        }
    }

    public function booking(Request $request)
    {
        $booking = Booking::with(['property.amenities', 'user', 'payment'])->where('reference', $request->reference)->first();

        if (!$booking) {
            return redirect()->route('welcome')->with('error', 'Booking not found.');
        }

        $property = $booking->property;
        return view('booking', compact('property', 'booking'));
    }



    public function book(Request $request)
    {
        // Validate booking details
        $validationRules = [
            'property_id' => 'required|integer',
            'number_of_guests' => 'required|integer',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'check_in_time' => 'required|date_format:H:i',
            'check_out_time' => 'required|date_format:H:i',
            // Guest booking fields
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:20',
        ];

        // Add password validation if creating account
        if ($request->has('create_account') && $request->create_account) {
            $validationRules['password'] = 'required|string|min:8|confirmed';
        }

        $request->validate($validationRules);

        $property = Property::find($request->property_id);

        if (!$property) {
            \Illuminate\Support\Facades\Log::error('Booking failed: Invalid property', ['input' => $request->all()]);
            return back()->with('error', 'Invalid property');
        }

        // Handle user - either authenticated or create guest/full account
        $user = auth()->user();
        $isNewUser = false;

        if (!$user) {
            // Check if user already exists by email
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                // Determine if creating full account or guest account
                $isCreatingAccount = $request->has('create_account') && $request->create_account && $request->filled('password');

                // Create new user
                $user = User::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'phone_number' => $request->phone_number,
                    'password' => $isCreatingAccount ? Hash::make($request->password) : Hash::make(Str::random(16)),
                    'is_guest' => !$isCreatingAccount,
                    'email_verified_at' => null, // Will verify later, not required for booking
                ]);

                // Assign default "User" role (only if user has no existing role)
                if (!$user->roles()->exists()) {
                    $user->assignRole('User');
                }
                $isNewUser = true;

                // Send verification email for full accounts (not guests)
                if ($isCreatingAccount) {
                    try {
                        $user->sendEmailVerificationNotification();
                        \Illuminate\Support\Facades\Auth::login($user);
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error('Failed to send verification email', ['error' => $e->getMessage()]);
                    }
                }
            }
        } else {
            // Update profile if checkbox is checked
            if ($request->has('update_profile') && $request->update_profile) {
                $user->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone_number' => $request->phone_number,
                ]);
            }
        }

        $check_in_date = $request->check_in_date;
        $check_out_date = $request->check_out_date;

        // Check if property is already booked (Confirmed status only)
        $isBooked = Booking::where('property_id', $property->id)
            ->where('status', 'Confirmed')
            ->whereDate('check_in_date', '<', $check_out_date) // Exclusive check
            ->whereDate('check_out_date', '>', $check_in_date)
            ->exists();

        if ($isBooked) {
            \Illuminate\Support\Facades\Log::info('Booking failed: Property already booked or on hold', ['property_id' => $property->id, 'check_in' => $check_in_date, 'check_out' => $check_out_date, 'input' => $request->all()]);
            return back()->with('error', 'Sorry, this property is already booked or reserved for the selected dates. Please choose different dates, try again in a few minutes or browse our other available properties.');
        }

        $available_status = ['Available', 'Booked'];

        if (!in_array($property->status, $available_status)) {
            \Illuminate\Support\Facades\Log::info('Booking failed: Property unavailable', ['property_id' => $property->id, 'status' => $property->status, 'input' => $request->all()]);
            return back()->with('error', 'This property is currently unavailable.');
        }

        if ($request->number_of_guests > $property->max_guests) {
            \Illuminate\Support\Facades\Log::info('Booking failed: Too many guests', ['property_id' => $property->id, 'max_guests' => $property->max_guests, 'input' => $request->all()]);
            return back()->with('error', "The number of guests exceeds the property's maximum capacity of {$property->max_guests}.");
        }

        try {
            $booking = new Booking();
            $booking->reference = $this->generateBookingReference($property->id);
            $booking->property_id = $property->id;
            $booking->user_id = $user->id;
            $booking->number_of_guests = $request->number_of_guests;
            $booking->check_in_date = $check_in_date;
            $booking->check_out_date = $check_out_date;
            $booking->check_in_time = $request->check_in_time;
            $booking->check_out_time = $request->check_out_time;
            $booking->total_price = $this->calcTotalBookingPrice($check_in_date, $check_out_date, $property);
            $booking->save();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Exception while creating booking', ['error' => $e->getMessage(), 'input' => $request->all()]);
            return back()->with('error', 'An error occurred while creating your booking. Please try again.');
        }

        return redirect()->route('booking', ['reference' => $booking->reference])
            ->with('success', 'Your booking has been made successfully. Make payment to confirm.');
    }

    public function view($reference)
    {
        $booking = Booking::where('reference', $reference)->with(['property.amenities', 'user', 'payment'])->first();

        if (!$booking) {
            return back()->with('error', 'Invalid booking reference');
        }

        return view('bookings.view', compact('booking'));
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

    public function payNow(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|integer',
            'booking_type' => 'nullable|string|in:property,chef,driver',
            'reference' => 'nullable|string'
        ]);

        $type = $request->booking_type ?? 'property';
        $booking = null;

        if ($type === 'chef') {
            $booking = ChefBooking::find($request->booking_id);
        } elseif ($type === 'driver') {
            $booking = DriverBooking::find($request->booking_id);
        } else {
            $booking = Booking::with('property')->find($request->booking_id);
        }

        if (!$booking) {
            return back()->with('error', 'Booking not found.');
        }

        // Pre-Payment Availability Check (Properties only)
        if ($type === 'property') {
            $isBooked = Booking::where('property_id', $booking->property_id)
                ->where('status', 'Confirmed')
                ->whereDate('check_in_date', '<', $booking->check_out_date) // Exclusive check
                ->whereDate('check_out_date', '>', $booking->check_in_date)
                ->exists();

            if ($isBooked) {
                return back()->with('error', 'Sorry, this apartment was just confirmed by another guest. Please select different dates.');
            }
        }

        if (in_array($booking->status, ['Cancelled', 'Confirmed'])) {
            return back()->with('error', 'This booking cannot be paid (already confirmed or cancelled).');
        }

        $email = $booking->user->email ?? auth()->user()->email;
        if (!$email) {
            return back()->with('error', 'Booking buyer does not have an email address.');
        }

        $price = ($type === 'property') ? $booking->total_price : $booking->price;
        $amountInKobo = (int) round($price * 100);

        if ($amountInKobo <= 0) {
            return back()->with('error', 'Invalid booking amount.');
        }

        $baseReference = $request->reference ?: $booking->reference;
        $reference = $baseReference . '-' . time();

        // For non-property bookings, we leave booking_id NULL in payments table to avoid constraint errors
        $payment = Payment::create([
            'booking_id' => ($type === 'property') ? $booking->id : null,
            'user_id' => $booking->user_id,
            'payment_method' => 'Paystack',
            'amount' => $price,
            'trx_ref' => $reference,
            'status' => 'Pending',
        ]);

        $response = $this->paystackService->initializeTransaction([
            'email' => $email,
            'amount' => $amountInKobo,
            'reference' => $reference,
            'callback_url' => route('verify.payment'),
            'metadata' => [
                'redirect_to' => $request->redirect_to,
                'booking_id' => $booking->id,
                'booking_type' => $type
            ]
        ]);

        if (isset($response['status']) && $response['status'] === true) {
            $authUrl = $response['data']['authorization_url'];
            $payment->update(['trx_ref' => $response['data']['reference']]);
            return redirect()->away($authUrl);
        }

        return back()->with('error', $response['message'] ?? 'Failed to initialize payment.');
    }

    public function initializePayment(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|integer',
            'booking_type' => 'nullable|string|in:property,chef,driver'
        ]);

        $type = $request->booking_type ?? 'property';
        $booking = null;

        if ($type === 'chef') {
            $booking = ChefBooking::find($request->booking_id);
        } elseif ($type === 'driver') {
            $booking = DriverBooking::find($request->booking_id);
        } else {
            $booking = Booking::with('property')->find($request->booking_id);
        }

        if (!$booking) {
            return response()->json(['status' => 'failed', 'message' => 'Booking not found.'], 404);
        }

        $price = ($type === 'property') ? $booking->total_price : $booking->price;

        // Pre-Payment Availability Check (Only for properties)
        if ($type === 'property') {
            $isBooked = Booking::where('property_id', $booking->property_id)
                ->where('status', 'Confirmed')
                ->whereDate('check_in_date', '<', $booking->check_out_date)
                ->whereDate('check_out_date', '>', $booking->check_in_date)
                ->exists();

            if ($isBooked) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sorry, this apartment was just confirmed by another guest. Please select different dates.'
                ], 409);
            }
        }

        $reference = $booking->reference . '-' . time();

        // REUSE OR CREATE PAYMENT
        $paymentData = [
            'user_id' => $booking->user_id,
            'payment_method' => 'Paystack',
            'amount' => $price,
            'trx_ref' => $reference,
            'status' => 'Pending',
        ];

        if ($type === 'property') {
            $paymentData['booking_id'] = $booking->id;
            $payment = Payment::updateOrCreate(
                ['booking_id' => $booking->id, 'status' => 'Pending'],
                $paymentData
            );
        } elseif ($type === 'chef') {
            $paymentData['chef_booking_id'] = $booking->id;
            $payment = Payment::updateOrCreate(
                ['chef_booking_id' => $booking->id, 'status' => 'Pending'],
                $paymentData
            );
        } elseif ($type === 'driver') {
            $paymentData['ride_booking_id'] = $booking->id;
            $payment = Payment::updateOrCreate(
                ['ride_booking_id' => $booking->id, 'status' => 'Pending'],
                $paymentData
            );
        }

        $email = $booking->user->email ?? auth()->user()->email;
        $redirectTo = $request->redirect_to ?? 'frontend';

        return response()->json([
            'status' => 'success',
            'reference' => $payment->trx_ref,
            'email' => $email,
            'amount' => $price,
            'metadata' => [
                'redirect_to' => $redirectTo,
                'booking_id' => $booking->id,
                'booking_type' => $type
            ]
        ]);
    }

    public function recordFailedPayment(Request $request)
    {
        $request->validate([
            'reference' => 'required|string',
        ]);

        $payment = Payment::where('trx_ref', $request->reference)->first();
        if ($payment && $payment->status === 'Pending') {
            $payment->update(['status' => 'Failed']);
        }

        return response()->json(['status' => 'success']);
    }

    public function verifyPayment(Request $request)
    {
        $request->validate([
            'reference' => 'required|string',
            'booking_id' => 'nullable|integer'
        ]);

        $reference = $request->reference;
        $bookingId = $request->booking_id ?? null;

        $response = $this->paystackService->verifyTransaction($reference);

        $isSuccessful = isset($response['status']) && $response['status'] === true &&
            isset($response['data']['status']) && $response['data']['status'] === 'success';

        $payment = Payment::where('trx_ref', $reference)->first();

        // If no payment record is found (shouldn't happen with new flow, but for safety)
        if (!$payment && $bookingId && $isSuccessful) {
            $booking = Booking::find($bookingId);
            if ($booking) {
                $payment = Payment::create([
                    'booking_id' => $booking->id,
                    'user_id' => $booking->user_id,
                    'payment_method' => 'Paystack',
                    'amount' => $booking->total_price,
                    'trx_ref' => $reference,
                    'status' => 'Pending',
                ]);
            }
        }

        if ($isSuccessful) {
            if ($payment) {
                return DB::transaction(function () use ($payment, $response, $request, $isSuccessful) {
                    $metadata = $response['data']['metadata'] ?? [];
                    $bookingId = $metadata['booking_id'] ?? null;
                    $bookingType = $metadata['booking_type'] ?? 'property';

                    if ($bookingType === 'chef') {
                        $booking = ChefBooking::lockForUpdate()->find($bookingId);
                    } elseif ($bookingType === 'driver') {
                        $booking = DriverBooking::lockForUpdate()->find($bookingId);
                    } else {
                        $booking = Booking::lockForUpdate()->find($payment->booking_id);
                    }

                    if (!$booking) {
                        return response()->json(['status' => 'error', 'message' => 'Booking not found during verification.'], 404);
                    }

                    // FINAL ATOMIC AVAILABILITY CHECK (Properties only)
                    if ($bookingType === 'property') {
                        $conflict = Booking::where('property_id', $booking->property_id)
                            ->where('status', 'Confirmed')
                            ->where('id', '!=', $booking->id)
                            ->whereDate('check_in_date', '<', $booking->check_out_date)
                            ->whereDate('check_out_date', '>', $booking->check_in_date)
                            ->exists();

                        if ($conflict) {
                            $payment->update(['status' => 'Failed', 'notes' => 'Conflict: Dates were booked by another guest during payment. Refund required.']);
                            Log::critical("PAYMENT CONFLICT: Payment successful for Booking #{$booking->id} but dates are now occupied. REFUND REQUIRED.");

                            if ($request->expectsJson()) {
                                return response()->json([
                                    'status' => 'error',
                                    'message' => 'Sorry, another guest completed their payment for these dates just seconds before you. Please contact support for a priority refund or date change.'
                                ], 409);
                            }
                            return redirect()->route('booking', ['reference' => $booking->reference])
                                ->with('error', 'Another guest just secured these dates. Please contact support for your refund.');
                        }
                    }

                    if ($isSuccessful) {
                        $payment->update(['status' => 'Completed']);
                        $booking->update(['status' => 'Confirmed']);

                        // REVENUE MANAGEMENT: Create Revenue Split
                        try {
                            $globalAdmin = User::role('Super Admin')->with('revenueConfig')->first();
                            $admin = null;
                            $commissionRate = 10.00;
                            $commissionType = 'Percentage';

                            if ($bookingType === 'chef') {
                                $serviceType = 'Chef';
                                $chef = $booking->chef;
                                $commissionRate = $chef->commission_rate ?? ($globalAdmin->revenueConfig?->staff_commission_rate ?? 10.00);
                                $commissionType = $chef->commission_type ?? 'Percentage';
                                $admin = $globalAdmin; // Revenue centralized to platform
                            } elseif ($bookingType === 'driver') {
                                $serviceType = 'Driver';
                                $driver = $booking->driver;
                                $commissionRate = $driver->commission_rate ?? ($globalAdmin->revenueConfig?->staff_commission_rate ?? 10.00);
                                $commissionType = $driver->commission_type ?? 'Percentage';
                                $admin = $globalAdmin; // Revenue centralized to platform
                            } else {
                                $serviceType = 'Property';
                                $property = $booking->property;
                                if ($property && !is_null($property->commission_rate)) {
                                    $commissionRate = $property->commission_rate;
                                } elseif ($globalAdmin) {
                                    $commissionRate = $globalAdmin->revenueConfig?->commission_rate ?? 10.00;
                                }
                                $commissionType = $property->commission_type ?? 'Percentage';
                                if ($property && $property->user_id) {
                                    $admin = User::with('revenueConfig')->find($property->user_id);
                                }
                            }

                            $totalAmount = $payment->amount;
                            if ($commissionType === 'Fixed') {
                                $platformFee = min($commissionRate, $totalAmount); // Cap at payment amount
                            } else {
                                $platformFee = ($totalAmount * $commissionRate) / 100;
                            }

                            // PURE CALCULATION: admin_net is exactly Total - Fee
                            $adminNet = $totalAmount - $platformFee;

                            // Determine admin ID — skip if no admin found
                            $adminId = $admin?->id ?? $globalAdmin?->id;
                            if (!$adminId) {
                                Log::warning('No admin found for revenue split', ['payment_id' => $payment->id]);
                            } elseif (!RevenueSplit::where('payment_id', $payment->id)->exists()) {
                                // Guard against duplicate splits from callback retries
                                $status = 'Pending';
                                    
                                // Check if frequency is On Demand - if so, skip the 'Paid' state and go straight to 'Available'
                                $globalFrequency = User::role('Super Admin')->with('revenueConfig')->first()?->revenueConfig?->payout_frequency ?? 'On Demand';
                                $frequency = $admin?->revenueConfig?->payout_frequency ?? $globalFrequency;
                                    
                                // Note: At checkout, funds aren't technically 'Paid' by the system yet (earned), but if On Demand is set,
                                // we can mark as Paid immediately. Then once they check out, the system will move it to Available.
                                // However, the user wants 'On Demand' to be fast. 
                                // In our current flow: Confirmed -> Checkout (moves to Paid).
                                // Let's keep initial creates as 'Pending' and only trigger maturation in the checkout method below.

                                RevenueSplit::create([
                                    'payment_id' => $payment->id,
                                    'admin_id' => $adminId,
                                    'service_type' => $serviceType,
                                    'total_amount' => $totalAmount,
                                    'platform_fee_amount' => $platformFee,
                                    'admin_net_amount' => $adminNet,
                                    'commission_rate_applied' => $commissionRate,
                                    'status' => $status,
                                ]);
                            }
                        } catch (\Exception $e) {
                            Log::error('Revenue Splitting Failed', ['error' => $e->getMessage()]);
                        }
                    }

                    try {
                        if ($booking->user && !empty($booking->user->email)) {
                            Mail::to($booking->user->email)->send(new BookingReceipt($booking));
                        }
                    } catch (\Exception $e) {
                        Log::error('Failed to send booking receipt email', ['error' => $e->getMessage()]);
                    }

                    if ($request->expectsJson()) {
                        return response()->json([
                            'status' => 'success',
                            'message' => 'Payment successful! Your booking is now confirmed.',
                            'booking_reference' => $booking->reference,
                        ]);
                    }

                    $metadata = $response['data']['metadata'] ?? [];
                    $redirectTo = $metadata['redirect_to'] ?? 'frontend';

                    $route = ($redirectTo === 'backend') ? 'booking.view' : 'booking';
                    return redirect()->route($route, ['reference' => $booking->reference])
                        ->with('success', 'Payment successful! Your booking is now confirmed.');
                });
            }

        } else {
            // Mark as failed if it was pending
            if ($payment && $payment->status === 'Pending') {
                $payment->update(['status' => 'Failed']);
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Payment verification failed. Please try again.',
                ], 400);
            }

            return redirect()->route('welcome')->with('error', 'Payment verification failed.');
        }
    }

    public function checkIn(Request $request)
    {
        $request->validate([
            'booking_reference' => 'required|string',
            'last_name' => 'required|string'
        ]);

        $reference = $request->booking_reference;
        $last_name = $request->last_name;

        $booking = Booking::with('property.images')->where('reference', $reference)->first();
        if (!$booking) {
            return back()->with('error', 'Booking not found');
        }

        $property = $booking->property;
        $user = User::where('id', $booking->user_id)->where('last_name', $last_name)->first();
        if (!$user) {
            return back()->with('error', 'User not found for this booking');
        }

        // Determine if booking has already been checked in by checking the digital_check_ins table only.
        // We intentionally do NOT use booking.status for check-in state to keep the bookings.status enum limited
        // to ('Confirmed','Pending','Cancelled').
        try {
            $isCheckedIn = DB::table('digital_check_ins')
                ->where('booking_id', $booking->id)
                ->where('status', 'Checked In')
                ->exists();
        } catch (\Exception $e) {
            Log::warning('Failed to determine digital_check_ins existence: ' . $e->getMessage());
            $isCheckedIn = false;
        }

        // Consider the booking checked-out if a digital_check_ins record with status 'Checked Out' exists
        // or if booking.status has already been moved to 'Completed' (checkout flow sets that).
        try {
            $isCheckedOut = DB::table('digital_check_ins')
                ->where('booking_id', $booking->id)
                ->where('status', 'Checked Out')
                ->exists();
        } catch (\Exception $e) {
            Log::warning('Failed to determine digital_check_ins checked-out existence: ' . $e->getMessage());
            $isCheckedOut = ($booking->status === 'Completed');
        }

        return view('check_in', compact('booking', 'user', 'property', 'isCheckedIn', 'isCheckedOut'));
    }

    public function checkInBooking(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|integer',
            'last_name' => 'nullable|string'
        ]);

        $booking_id = $request->input('booking_id');
        $provided_last_name = $request->input('last_name');

        $booking = Booking::with(['user', 'property'])->find($booking_id);
        if (!$booking) {
            return response()->json(['status' => 'error', 'message' => 'Booking not found'], 404);
        }

        // Authorization Check
        $user = auth()->user();
        $authorized = false;
        $authMethod = 'None';

        if ($user) {
            if ($user->hasRole('Super Admin')) {
                $authorized = true;
                $authMethod = 'Super Admin Role';
            } elseif ($user->hasRole('Admin') && $booking->property->user_id === $user->id) {
                $authorized = true;
                $authMethod = 'Admin Role (Property Owner)';
            } elseif ($user->id === $booking->user_id) {
                $authorized = true;
                $authMethod = 'Logged-in Guest';
            }
        }

        // Fallback to Last Name check (especially for unauthenticated guests)
        if (!$authorized && $provided_last_name && $booking->user) {
            if (strtolower($booking->user->last_name) === strtolower($provided_last_name)) {
                $authorized = true;
                $authMethod = 'Last Name Match';
            }
        }

        if (!$authorized) {
            Log::warning('Unauthorized check-in attempt', [
                'booking_id' => $booking_id,
                'ip' => $request->ip(),
                'provided_last_name' => $provided_last_name
            ]);
            return response()->json(['status' => 'error', 'message' => 'Booking details mismatch'], 403);
        }

        try {
            // 1. Prevent duplicate check-ins for the SAME booking
            if (DB::table('digital_check_ins')->where('booking_id', $booking_id)->where('status', 'Checked In')->exists()) {
                return response()->json(['status' => 'failed', 'message' => 'This booking has already been checked in.']);
            }

            // 2. Prevent check-in if apartment is already occupied by ANY booking
            $apartmentOccupied = DB::table('digital_check_ins')
                ->join('bookings', 'digital_check_ins.booking_id', '=', 'bookings.id')
                ->where('bookings.property_id', $booking->property_id)
                ->where('digital_check_ins.status', 'Checked In')
                ->exists();

            if ($apartmentOccupied) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'This apartment is already occupied by another guest. Please check them out first.'
                ]);
            }

            // 3. Ensure booking is in correct status
            if ($booking->status !== 'Confirmed') {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'This booking cannot be checked in. Current status: ' . $booking->status
                ]);
            }

            // Proceed with check-in
            $now = Carbon::now();
            $insertData = [
                'booking_id' => $booking_id,
                'check_in_time' => $now,
                'status' => 'Checked In',
                'created_at' => $now,
                'updated_at' => $now
            ];

            $insertedId = DB::table('digital_check_ins')->insertGetId($insertData);

            // Audit Log
            Log::info("Successful Check-In: Booking #{$booking_id} | Method: {$authMethod} | IP: {$request->ip()} | UA: {$request->userAgent()}");

            return response()->json([
                'status' => 'success',
                'message' => 'Checked in successfully',
                'booking_status' => $booking->status,
                'check_in_id' => $insertedId
            ]);

        } catch (\Exception $e) {
            Log::error('Exception in checkInBooking', [
                'message' => $e->getMessage(),
                'booking_id' => $booking_id
            ]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function checkOutBooking(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|integer',
            'last_name' => 'nullable|string'
        ]);

        $booking_id = $request->input('booking_id');
        $provided_last_name = $request->input('last_name');

        $booking = Booking::with(['user', 'property', 'payment'])->find($booking_id);
        if (!$booking) {
            return response()->json(['status' => 'error', 'message' => 'Booking not found'], 404);
        }

        // Authorization Check
        $user = auth()->user();
        $authorized = false;
        $authMethod = 'None';

        if ($user) {
            if ($user->hasRole('Super Admin')) {
                $authorized = true;
                $authMethod = 'Super Admin Role';
            } elseif ($user->hasRole('Admin') && $booking->property->user_id === $user->id) {
                $authorized = true;
                $authMethod = 'Admin Role (Property Owner)';
            } elseif ($user->id === $booking->user_id) {
                $authorized = true;
                $authMethod = 'Logged-in Guest';
            }
        }

        // Fallback to Last Name check
        if (!$authorized && $provided_last_name && $booking->user) {
            if (strtolower($booking->user->last_name) === strtolower($provided_last_name)) {
                $authorized = true;
                $authMethod = 'Last Name Match';
            }
        }

        if (!$authorized) {
            Log::warning('Unauthorized check-out attempt', [
                'booking_id' => $booking_id,
                'ip' => $request->ip(),
                'provided_last_name' => $provided_last_name
            ]);
            return response()->json(['status' => 'error', 'message' => 'Booking details mismatch'], 403);
        }

        try {
            // Determine if booking has an active check-in
            $checkedInCount = DB::table('digital_check_ins')
                ->where('booking_id', $booking_id)
                ->where('status', 'Checked In')
                ->count();

            if ($checkedInCount === 0) {
                return response()->json(['status' => 'failed', 'message' => 'Booking is not checked in']);
            }

            // Update the digital_check_ins record(s) to mark check out
            DB::table('digital_check_ins')
                ->where('booking_id', $booking_id)
                ->where('status', 'Checked In')
                ->update([
                    'status' => 'Checked Out',
                    'check_out_time' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

            // Update booking status to Completed
            $booking->status = 'Completed';
            $booking->save();

            // Update RevenueSplit status to 'Paid'
            if ($booking->payment) {
                RevenueSplit::whereHas('payment', function ($q) use ($booking) {
                $q->where('id', $booking->payment->id);
            })->update(['status' => 'Paid']);

            // AFTER marking as Paid, run promotion logic to see if it should move to 'Available' immediately
            if ($booking->property && $booking->property->user) {
                $rmController = app(\App\Http\Controllers\RevenueManagementController::class);
                $admin = $booking->property->user;
                $admin->loadMissing('revenueConfig');
                $rmController->runPromoteMaturedSplits($admin);
            } else {
                Log::warning('Skipped runPromoteMaturedSplits: property owner missing', [
                    'booking_id' => $booking_id,
                    'property_id' => $booking->property_id,
                ]);
            }
            }

            // Update property status to Available
            if ($booking->property) {
                $booking->property->update(['status' => 'Available']);
            }

            // Audit Log
            Log::info("Successful Check-Out: Booking #{$booking_id} | Method: {$authMethod} | IP: {$request->ip()} | UA: {$request->userAgent()}");

            return response()->json(['status' => 'success', 'message' => 'Checked out successfully', 'booking_status' => $booking->status]);
        } catch (\Throwable $e) {
            Log::error('Exception in checkOutBooking', [
                'message' => $e->getMessage(),
                'booking_id' => $booking_id
            ]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function cancelBooking(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|integer',
            'booking_type' => 'nullable|string'
        ]);

        $booking_id = $request->input('booking_id');
        $type = $request->input('booking_type', 'property');

        if ($type === 'chef') {
            $booking = ChefBooking::find($booking_id);
        } elseif ($type === 'driver') {
            $booking = DriverBooking::find($booking_id);
        } else {
            $booking = Booking::with('property')->find($booking_id);
        }

        if (!$booking) {
            return response()->json(['status' => 'error', 'message' => 'Booking not found'], 404);
        }

        // Authorization Check
        $user = auth()->user();
        $isGuest = $user->id === $booking->user_id;

        $isOwner = false;
        if ($type === 'property' && $booking->property) {
            $isOwner = $user->id === $booking->property->user_id;
        }

        $isSuperAdmin = $user->hasRole('Super Admin');

        if (!$isGuest && !$isOwner && !$isSuperAdmin) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized action.'], 403);
        }

        try {
            if ($booking->status === 'Cancelled') {
                return response()->json(['status' => 'failed', 'message' => 'Booking is already cancelled']);
            }

            $booking->status = 'Cancelled';
            $booking->save();

            // Void associated revenue split (only if not already Withdrawn)
            $paymentQuery = null;
            if ($type === 'property') {
                $paymentQuery = Payment::where('booking_id', $booking->id)->where('status', 'Completed');
            } elseif ($type === 'chef') {
                $paymentQuery = Payment::where('chef_booking_id', $booking->id)->where('status', 'Completed');
            } elseif ($type === 'driver') {
                $paymentQuery = Payment::where('ride_booking_id', $booking->id)->where('status', 'Completed');
            }

            if ($paymentQuery) {
                $relatedPayment = $paymentQuery->first();
                if ($relatedPayment) {
                    RevenueSplit::where('payment_id', $relatedPayment->id)
                        ->whereIn('status', ['Pending', 'Paid', 'Available'])
                        ->update(['status' => 'Voided']);
                }
            }

            return response()->json(['status' => 'success', 'message' => 'Booking cancelled successfully', 'booking_status' => $booking->status]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Exception in cancelBooking', ['message' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function sendContactMessage(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string|min:10',
        ]);

        $data = $request->only(['name', 'phone', 'message']);

        // Send email to admin
        try {
            Mail::to('chibuchimemmanuel@gmail.com')->send(new ContactMail($data));
        } catch (\Exception $e) {
            Log::error('Failed to send contact email', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to send message. Please try again later.');
        }

        return back()->with('success', 'Thank you for contacting us! We will get back to you shortly.');
    }
}
