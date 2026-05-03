<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\DriverBooking;
use App\Models\DriverService;
use App\Models\DriverServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DriverController extends Controller
{
    /**
     * Display a listing of the drivers.
     */
    public function index()
    {
        $drivers = Driver::with('driverServices')->get();
        $servicesList = DriverService::all();
        return view('drivers.index', compact('drivers', 'servicesList'));
    }

    /**
     * Show the form for creating a new driver.
     */
    public function create()
    {
        return view('drivers.create');
    }

    /**
     * Store a newly created driver in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|unique:drivers,phone_number',
            'vehicle_details' => 'required|string|max:255',
            'license_number' => 'required|string|unique:drivers,license_number',
            'availability_status' => 'required|in:Available,Busy',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'max_occupants' => 'required|integer|min:1',
            'hourly_rate' => 'required|numeric|min:0',
            'extra_person_charge' => 'required|numeric|min:0',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/drivers'), $imageName);
            $validated['image'] = 'uploads/drivers/' . $imageName;


            // Debug: log the path
            \Log::info('Driver image saved to: ' . $validated['image']);
            \Log::info('Full URL would be: ' . asset($validated['image']));
        }

        Driver::create($validated);

        return redirect()->route('drivers.index')->with('success', 'Driver added successfully!');
    }

    public function book()
    {
        $drivers = Driver::where('availability_status', 'Available')->get();
        return view('drivers.book', compact('drivers'));
    }

    /**
     * Show services for the selected driver
     */

    public function getServices($driverId)
    {
        $driver = Driver::findOrFail($driverId);
        $services = $driver->driverServices;
        // dd($services);
        return response()->json([
            'services' => $services,
            'hourly_rate' => $driver->hourly_rate,
            'extra_person_charge' => $driver->extra_person_charge
        ]);
    }

    /**
     * Book a driver.
     */

    public function storeBooking(Request $request)
    {
        try {
            $service = DriverServiceType::where('id', $request->driver_service)->first();

            if (!$service) {
                return response()->json(['error' => true, 'message' => 'Service not found', 'booking' => '']);
            }

            $driver = Driver::findOrFail($request->driver_id);

            // 1. Capacity Validation
            $occupants = (int) ($request->occupants ?: 1);
            if ($occupants > $driver->max_occupants) {
                return response()->json([
                    'error' => true,
                    'message' => "This vehicle can only accommodate up to {$driver->max_occupants} passengers."
                ]);
            }

            // 2. Availability Check (with buffer based on duration)
            $requestedTime = \Carbon\Carbon::parse($request->ride_date . ' ' . $request->ride_time);
            $durationHours = (int) ($request->ride_duration_hours ?: 1);
            $durationMins = $durationHours * 60;

            $startTime = $requestedTime->copy()->subMinutes(30); // 30 mins buffer before
            $endTime = $requestedTime->copy()->addMinutes($durationMins + 30); // duration + 30 mins buffer after

            $overlap = DriverBooking::where('driver_id', $request->driver_id)
                ->where('status', '!=', 'Cancelled')
                ->where('ride_date', $request->ride_date)
                ->whereBetween('ride_time', [
                    $startTime->format('H:i:s'),
                    $endTime->format('H:i:s')
                ])
                ->exists();

            if ($overlap) {
                return response()->json([
                    'error' => true,
                    'message' => 'This driver is already booked for a ride around this time.'
                ]);
            }

            // 3. Pricing Calculation
            $baseTotal = $driver->hourly_rate * $durationHours;
            $extraTotal = $occupants > 1 ? ($occupants - 1) * $driver->extra_person_charge : 0;
            $grandTotal = $baseTotal + $extraTotal; // Corrected variable name from extraTotal to $extraTotal

            // Generate booking ID
            $reference = 'DRIVER-' . Str::upper(Str::random(4)) . '-' . rand(10000, 99999);

            $booking = DriverBooking::create([
                'user_id' => Auth::id(),
                'driver_id' => $request->driver_id,
                'driver_service_type_id' => $request->driver_service,
                'price' => $grandTotal,
                'booking_id' => $request->booking_id ?: null,
                'reference' => $reference,
                'pickup_location' => $request->pickup_location,
                'dropoff_location' => $request->dropoff_location,
                'ride_date' => $request->ride_date,
                'ride_time' => $request->ride_time,
                'luggage_count' => $request->luggage_count,
                'special_instructions' => $request->special_instructions,
                'ride_duration_mins' => $durationMins,
                'booking_base_price' => $driver->hourly_rate,
                'booking_per_unit_price' => $driver->extra_person_charge,
                'occupants' => $occupants,
                'status' => 'Scheduled',
            ]);

        } catch (\Exception $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage(), 'booking' => '']);
        }

        return response()->json(['success' => true, 'message' => 'Ride scheduled successfully!', 'booking' => $booking]);
    }


    public function markAsAvailable($id)
    {
        $driver = Driver::findOrFail($id);
        $driver->availability_status = 'Available';
        $driver->save();

        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        $driver = Driver::findOrFail($id);
        return view('drivers.edit', compact('driver'));
    }

    public function update(Request $request, $id)
    {
        $driver = Driver::findOrFail($id);
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|unique:drivers,phone_number,' . $id,
            'vehicle_details' => 'required|string|max:255',
            'license_number' => 'required|string|unique:drivers,license_number,' . $id,
            'availability_status' => 'required|in:Available,Busy',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'max_occupants' => 'required|integer|min:1',
            'hourly_rate' => 'required|numeric|min:0',
            'extra_person_charge' => 'required|numeric|min:0',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($driver->image && file_exists(public_path($driver->image))) {
                unlink(public_path($driver->image));
            }

            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/drivers'), $imageName);
            $validated['image'] = 'uploads/drivers/' . $imageName;
        }

        $driver->update($validated);

        return redirect()->route('drivers.index')->with('success', 'Driver updated successfully!');
    }

    public function destroy($id)
    {
        $driver = Driver::findOrFail($id);

        if ($driver->image && file_exists(public_path($driver->image))) {
            unlink(public_path($driver->image));
        }

        $driver->delete();

        return response()->json(['success' => true]);
    }


    public function assignService(Request $request, $driverId)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:driver_services,id',
            'price' => 'required|numeric|min:0',
        ]);

        $driver = \App\Models\Driver::findOrFail($driverId);

        // Attach or update pivot record
        $driver->driverServices()->syncWithoutDetaching([
            $validated['service_id'] => ['price' => $validated['price']],
        ]);

        $service = $driver->driverServices()->find($validated['service_id']);

        return response()->json([
            'success' => true,
            'message' => 'Service assigned successfully!',
            'driver_id' => $driver->id,
            'service' => $service ? $service->name : null,
            'price' => $validated['price'],
        ]);
    }
}
