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
            'services' => 'required|array',
        ]);

        $driver = Driver::find($request->driver_id);
        $syncData = [];

        foreach ($request->services as $serviceId => $data) {
            if (isset($data['selected'])) {
                $syncData[$serviceId] = [
                    'price' => 0,
                    'base_price' => 0,
                    'per_unit_price' => 0
                ];
            }
        }

        if (!empty($syncData)) {
            $driver->driverServices()->syncWithoutDetaching($syncData);
        }

        return response()->json(['success' => true]);
    }

    public function update(Request $request, DriverService $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:driver_services,name,' . $service->id,
        ]);

        $service->update($validated);

        return redirect()->back()->with('success', 'Service updated successfully!');
    }

    public function destroy(DriverService $service)
    {
        $service->delete();

        return redirect()->back()->with('success', 'Service deleted successfully!');
    }
}
