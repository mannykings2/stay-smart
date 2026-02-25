<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Amenity;
use Illuminate\Http\Request;

class AmenityController extends Controller
{
    //Index Page
    public function index()
    {
        $amenities = Amenity::latest()->get();
        return view('properties.amenities', compact('amenities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:amenities,name',
        ]);

        Amenity::create($validated);

        return redirect()->back()->with('success', 'Amenity created successfully!');
    }

    public function assignAmenity(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'amenity_id' => 'required|exists:amenities,id',
        ]);

        $property = Property::find($request->property_id);
        $attached = $property->amenities()->syncWithoutDetaching([$request->amenity_id]);

        $property->amenities()->syncWithoutDetaching([
            $request->amenity_id
        ]);

        return response()->json(['success' => true, 'result' => $attached]);
    }
    public function update(Request $request, Amenity $amenity)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:amenities,name,' . $amenity->id,
        ]);

        $amenity->update($validated);

        return redirect()->back()->with('success', 'Amenity updated successfully!');
    }

    public function destroy(Amenity $amenity)
    {
        // Detach from all properties (Eloquent handles this if defined, but pivot table might need explicit cleanup if not using cascades)
        $amenity->properties()->detach();

        $amenity->delete();

        return redirect()->back()->with('success', 'Amenity deleted successfully!');
    }
}
