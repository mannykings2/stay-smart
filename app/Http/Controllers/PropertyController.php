<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    public function index()
    {
        $trending_properties = Property::where('status', 'Available')->withCount('bookings')
                        ->orderBy('bookings_count', 'desc')
                        ->take(20)
                        ->get();

        return view('apartments.index', compact('trending_properties'));
    }

    public function allApartments()
    {
        $apartments = Property::latest()->get();

        return view('apartments.all', compact('apartments'));
    }

    public function checkIn()
    {

        return view('apartments.check-in' );
    }

    public function create()
    {
        return view('apartments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'max_guests' => 'required|integer|min:1',
            'price_per_night' => 'required|numeric|min:0',
            'status' => 'required|in:Pending,Available,Booked,Under Maintenance',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('apartments', 'public');
        }

        Property::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
            'max_guests' => $request->max_guests,
            'price_per_night' => $request->price_per_night,
            'status' => $request->status,
            'description' => $request->description,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('apartments.index')->with('success', 'Apartment added successfully!');
    }

    public function markAsAvailable($id)
    {
        $apartment = Property::findOrFail($id);

        if ($apartment->status === 'Pending') {
            $apartment->status = 'Available';
            $apartment->save();

            return response()->json(['success' => true, 'message' => 'Apartment marked as available.']);
        }

        return response()->json(['success' => false, 'message' => 'Invalid status change.'], 400);
    }
}
