<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\DriverBooking;
use App\Models\DriverService;
use App\Models\DriverServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    /**
     * Display a listing of the drivers.
     */
    public function index()
    {
        $drivers = Driver::all();
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
            // 'specialty' => 'nullable|string|max:255',
            'phone_number' => 'required|string|unique:drivers,phone_number',
            'vehicle_details' => 'required|string|max:255',
            'license_number' => 'required|string|unique:drivers,license_number',
            'availability_status' => 'required|in:Available,Busy',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/drivers'), $imageName);
            $validated['image'] = 'uploads/drivers/' . $imageName;
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
        return response()->json($services);
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

             // Generate booking ID
             $bookingId = 'DRIVER-' . strtoupper(fake()->bothify('????-#####'));

             $booking = DriverBooking::create([
                 'user_id' => Auth::id(),
                 'driver_id' => $request->driver_id,
                 'driver_service_type_id' => $request->driver_service,
                 'price' => $service->price,
                 'booking_id' => $bookingId,
                 'service_date' => $request->service_date,
                 'service_time' => $request->service_time,
                 'status' => 'Scheduled',
             ]);

         } catch (\Exception $th) {
             return response()->json(['error' => true, 'message' => $th->getMessage(), 'booking' => '']);
         }

         return response()->json(['success' => true, 'message' => 'Booking successful!', 'booking' => $booking]);
     }


    public function markAsAvailable($id)
    {
        $driver = Driver::findOrFail($id);
        $driver->availability_status = 'Available';
        $driver->save();

        return response()->json(['success' => true]);
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
