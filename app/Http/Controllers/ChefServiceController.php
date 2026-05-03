<?php

namespace App\Http\Controllers;

use App\Models\Chef;
use App\Models\ChefService;
use Illuminate\Http\Request;

class ChefServiceController extends Controller
{
    //Index Page
    public function index()
    {
        $services = ChefService::latest()->get();
        return view('chefs.services', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:chef_services,name',
        ]);

        ChefService::create($validated);

        return redirect()->back()->with('success', 'Service created successfully!');
    }

    public function assignService(Request $request)
    {
        $request->validate([
            'chef_id' => 'required|exists:chefs,id',
            'services' => 'required|array',
        ]);

        $chef = Chef::find($request->chef_id);
        $syncData = [];

        foreach ($request->services as $serviceId => $data) {
            if (isset($data['selected'])) {
                // Determine legacy 'price' (for old code compatibility) or use base_price
                $price = $data['base_price'] ?: 0;

                $syncData[$serviceId] = [
                    'price' => $price,
                    'base_price' => $data['base_price'],
                    'per_unit_price' => $data['per_unit_price'],
                ];
            }
        }

        if (!empty($syncData)) {
            $chef->chefServices()->syncWithoutDetaching($syncData);
        }

        return response()->json(['success' => true]);
    }

    public function update(Request $request, ChefService $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:chef_services,name,' . $service->id,
        ]);

        $service->update($validated);

        return redirect()->back()->with('success', 'Service updated successfully!');
    }

    public function destroy(ChefService $service)
    {
        $service->delete();

        return redirect()->back()->with('success', 'Service deleted successfully!');
    }
}
