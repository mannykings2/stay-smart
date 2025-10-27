<?php

namespace App\Http\Controllers;

use App\Models\Chef;
use App\Models\ChefService;
use Illuminate\Http\Request;

class ChefServiceController extends Controller
{
    //Index Page
    public function index(){
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
            'chef_service_id' => 'required|exists:chef_services,id',
            'price' => 'required|numeric|min:0',
        ]);

        $chef = Chef::find($request->chef_id);
        $chef->chefServices()->syncWithoutDetaching([
            $request->chef_service_id => ['price' => $request->price]
        ]);

        return response()->json(['success' => true]);
    }
}
