<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Property;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;
use App\Models\BlogPost;
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
            ->with(['images'])
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
            ->with(['images'])
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
            ->with(['images'])
            ->withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->paginate(6)
            ->appends($request->all()); // keep query params for pagination links

        // Step 3: Check Availability for each property
        // We iterate through the paginated results and set a temporary flag 'is_unavailable'
        $properties->getCollection()->transform(function ($property) use ($check_in, $check_out) {
            $isBooked = $property->bookings()
                ->where(function ($q) use ($check_in, $check_out) {
                    $q->where('check_in_date', '<', $check_out)
                        ->where('check_out_date', '>', $check_in)
                        ->where('status', '!=', 'Cancelled');
                })
                ->exists();

            $property->is_unavailable = $isBooked;
            return $property;
        });

        return view('search', compact('properties')); // so old input can be retained in form fields
    }


    public function bookNow(Request $request)
    {
        try {
            $propertyId = Crypt::decrypt($request->propertyId);
            $property = Property::with('images')->find($propertyId);

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
        $booking = Booking::where("reference", $request->reference)->first();

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
            'check_in_date' => 'required|date',
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

        // Check if property is already booked
        $isBooked = Booking::where('property_id', $property->id)
            ->where('status', 'Confirmed')
            ->whereDate('check_in_date', '<=', $check_out_date)
            ->whereDate('check_out_date', '>=', $check_in_date)
            ->exists();

        if ($isBooked) {
            \Illuminate\Support\Facades\Log::info('Booking failed: Property already booked', ['property_id' => $property->id, 'check_in' => $check_in_date, 'check_out' => $check_out_date, 'input' => $request->all()]);
            return back()->with('error', 'Sorry, this property is already booked for the selected dates. Please choose different dates or browse our other available properties.');
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
        $booking = Booking::where('reference', $reference)->first();

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
            'reference' => 'nullable|string'
        ]);

        $booking = Booking::find($request->booking_id);
        if (!$booking) {
            return back()->with('error', 'Booking not found.');
        }

        if (in_array($booking->status, ['Cancelled', 'Confirmed'])) {
            return back()->with('error', 'This booking cannot be paid (already confirmed or cancelled).');
        }

        $email = $booking->user->email ?? null;
        if (!$email) {
            return back()->with('error', 'Booking buyer does not have an email address.');
        }

        $amountInKobo = (int) round($booking->total_price * 100);
        if ($amountInKobo <= 0) {
            return back()->with('error', 'Invalid booking amount.');
        }

        $baseReference = $request->reference ?: $booking->reference;
        $reference = $baseReference . '-' . time();

        $payment = Payment::where('booking_id', $booking->id)->first();
        if ($payment && $payment->status === 'Completed') {
            return redirect()->route('booking', ['reference' => $booking->reference])->with('success', 'Booking already paid.');
        }

        if (!$payment) {
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'user_id' => $booking->user_id,
                'payment_method' => 'Paystack',
                'amount' => $booking->total_price,
                'trx_ref' => $reference,
                'status' => 'Pending',
            ]);
        } else {
            $payment->update([
                'trx_ref' => $reference,
                'status' => 'Pending',
            ]);
        }

        $response = $this->paystackService->initializeTransaction([
            'email' => $email,
            'amount' => $amountInKobo,
            'reference' => $reference,
            'callback_url' => route('verify.payment'),
            'metadata' => [
                'redirect_to' => $request->redirect_to
            ]
        ]);

        if (isset($response['status']) && $response['status'] === true) {
            $authUrl = $response['data']['authorization_url'];
            $payment->update(['trx_ref' => $response['data']['reference']]);
            return redirect()->away($authUrl);
        }

        return back()->with('error', $response['message'] ?? 'Failed to initialize payment.');
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

        if (isset($response['status']) && $response['status'] === true && isset($response['data']['status']) && $response['data']['status'] === 'success') {

            $payment = Payment::where('trx_ref', $reference)->first();

            if (!$payment && $bookingId) {
                $booking = Booking::find($bookingId);
                if ($booking) {
                    $payment = Payment::create([
                        'booking_id' => $booking->id,
                        'user_id' => $booking->user_id,
                        'payment_method' => 'Paystack',
                        'amount' => ($response['data']['amount'] ?? 0) / 100 ?: $booking->total_price,
                        'trx_ref' => $reference,
                        'status' => 'Completed',
                    ]);
                }
            }

            if ($payment && $payment->status !== 'Completed') {
                $payment->update([
                    'status' => 'Completed',
                    'trx_ref' => $reference,
                ]);
            }

            if ($payment && $payment->booking_id) {
                $booking = Booking::find($payment->booking_id);
                if ($booking) {
                    $booking->update(['status' => 'Confirmed']);

                    try {
                        if ($booking->user && !empty($booking->user->email)) {
                            Mail::to($booking->user->email)->send(new BookingReceipt($booking));
                        }
                    } catch (\Exception $e) {
                        Log::error('Failed to send booking receipt email', ['error' => $e->getMessage()]);
                    }
                }
            }

            if ($booking) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Payment successful! Your booking is now confirmed.',
                        'booking_reference' => $booking->reference,
                        'booking_id' => $booking->id,
                    ]);
                }

                $metadata = $response['data']['metadata'] ?? [];
                $redirectTo = $metadata['redirect_to'] ?? null;

                if ($redirectTo === 'backend') {
                    return redirect()->route('booking.view', ['reference' => $booking->reference])
                        ->with('success', 'Payment successful! Booking confirmed.');
                }

                // Redirect to frontend booking details page instead of backend view
                return redirect()->route('booking', ['reference' => $booking->reference])
                    ->with('success', 'Payment successful! Your booking is now confirmed.');
            }
        }

        return redirect()->route('welcome')->with('error', 'Payment verification failed.');
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

            // Update property status to Available
            if ($booking->property) {
                $booking->property->update(['status' => 'Available']);
            }

            // Audit Log
            Log::info("Successful Check-Out: Booking #{$booking_id} | Method: {$authMethod} | IP: {$request->ip()} | UA: {$request->userAgent()}");

            return response()->json(['status' => 'success', 'message' => 'Checked out successfully', 'booking_status' => $booking->status]);
        } catch (\Exception $e) {
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
            'booking_id' => 'required|integer'
        ]);

        $booking_id = $request->input('booking_id');
        $booking = Booking::find($booking_id);
        if (!$booking) {
            return response()->json(['status' => 'error', 'message' => 'Booking not found'], 404);
        }

        // Authorization Check
        $user = auth()->user();
        $isGuest = $user->id === $booking->user_id;
        $isOwner = $user->id === $booking->property->user_id;
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
            Mail::to('Contact@staysmartbookings.com')->send(new ContactMail($data));
        } catch (\Exception $e) {
            Log::error('Failed to send contact email', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to send message. Please try again later.');
        }

        return back()->with('success', 'Thank you for contacting us! We will get back to you shortly.');
    }
}
