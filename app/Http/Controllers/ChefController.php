<?php

namespace App\Http\Controllers;

use App\Models\Chef;
use App\Models\ChefBooking;
use App\Models\ChefService;
use App\Models\ChefServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChefController extends Controller
{
    /**
     * Display a listing of the chefs.
     */
    public function index()
    {
        $chefs = Chef::with('chefServices')->get();
        $servicesList = ChefService::all();
        return view('chefs.index', compact('chefs', 'servicesList'));
    }

    /**
     * Show the form for creating a new chef.
     */
    public function create()
    {
        return view('chefs.create');
    }

    /**
     * Store a newly created chef in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'specialty' => 'nullable|string|max:255',
            'phone_number' => 'required|string|unique:chefs,phone_number',
            'availability_status' => 'required|in:Available,Busy',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/chefs'), $imageName);
            $validated['image'] = 'uploads/chefs/' . $imageName;
        }

        Chef::create($validated);

        return redirect()->route('chefs.index')->with('success', 'Chef added successfully!');
    }

    public function book()
    {
        $chefs = Chef::where('availability_status', 'Available')->get();
        return view('chefs.book', compact('chefs'));
    }

    /**
     * Show services for the selected chef
     */

    public function getServices($chefId)
    {
        $chef = Chef::findOrFail($chefId);
        $services = $chef->chefServices;
        // dd($services);
        return response()->json($services);
    }

    /**
     * Book a chef.
     */

    public function storeBooking(Request $request)
    {

        try {
            $service = ChefServiceType::where('id', $request->chef_service)->first();

            if (!$service) {
                return response()->json(['error' => true, 'message' => 'Service not found', 'booking' => '']);
            }

            $chef = Chef::findOrFail($request->chef_id);

            // 1. Capacity Validation
            if ($request->number_of_guests > $chef->max_guests) {
                return response()->json([
                    'error' => true,
                    'message' => "This chef can only accommodate up to {$chef->max_guests} guests."
                ]);
            }

            // 2. Availability / Overlap Check (3 hour buffer)
            $requestedTime = \Carbon\Carbon::parse($request->service_date . ' ' . $request->service_time);
            $startTime = $requestedTime->copy()->subHours(2);
            $endTime = $requestedTime->copy()->addHours(2);

            $overlap = ChefBooking::where('chef_id', $request->chef_id)
                ->where('status', '!=', 'Cancelled')
                ->where('service_date', $request->service_date)
                ->whereBetween('service_time', [
                    $startTime->format('H:i:s'),
                    $endTime->format('H:i:s')
                ])
                ->exists();

            if ($overlap) {
                return response()->json([
                    'error' => true,
                    'message' => 'This chef is already booked around this time. Please choose a different time or chef.'
                ]);
            }

            // 3. Pricing Calculation
            $guests = (int) ($request->number_of_guests ?: 1);
            $baseTotal = $service->base_price ?: ($service->price ?: 0);
            $extraTotal = $guests * ($service->per_unit_price ?: 0);
            $grandTotal = $baseTotal + $extraTotal;

            // Generate booking ID
            $reference = 'CHEF-' . Str::upper(Str::random(4)) . '-' . rand(10000, 99999);

            $booking = ChefBooking::create([
                'user_id' => Auth::id(),
                'chef_id' => $request->chef_id,
                'chef_service_type_id' => $request->chef_service,
                'price' => $grandTotal,
                'reference' => $reference,
                'booking_id' => $request->booking_id ?: null,
                'service_date' => $request->service_date,
                'service_time' => $request->service_time,
                'number_of_guests' => $guests,
                'dietary_requirements' => $request->dietary_requirements,
                'menu_notes' => $request->menu_notes,
                'booking_base_price' => $service->base_price,
                'booking_per_unit_price' => $service->per_unit_price,
                'status' => 'Scheduled',
            ]);

        } catch (\Exception $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage(), 'booking' => '']);
        }

        return response()->json(['success' => true, 'message' => 'Service scheduled successfully!', 'booking' => $booking]);
    }


    public function markAsAvailable($id)
    {
        $chef = Chef::findOrFail($id);
        $chef->availability_status = 'Available';
        $chef->save();

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $chef = Chef::findOrFail($id);

        if ($chef->image && file_exists(public_path($chef->image))) {
            unlink(public_path($chef->image));
        }

        $chef->delete();

        return response()->json(['success' => true]);
    }
}
