<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\DriverService;
use App\Models\DriverServiceType;
use Illuminate\Http\Request;

class DriverServiceController extends Controller
{
    /**
     * Display a listing of driver services.
     */
    public function index()
    {
        $services = DriverService::all();
        return view('driver-services.index', compact('services'));
    }

    /**
     * Store a newly created driver service.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:driver_services,name',
        ]);

        DriverService::create($validated);

         return redirect()->back()->with('success', 'Service created successfully!');
    }

    public function assignService(Request $request)
    {
        $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            'driver_service_id' => 'required|exists:driver_services,id',
            'price' => 'required|numeric|min:0',
        ]);

        $driver = Driver::find($request->driver_id);
        $driver->driverServices()->syncWithoutDetaching([
            $request->driver_service_id => ['price' => $request->price]
        ]);

        return response()->json(['success' => true]);
    }
}
