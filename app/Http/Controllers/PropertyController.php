<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\Booking;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class PropertyController extends Controller
{
    public function toggleBookmark(Property $property)
    {
        $user = auth()->user();
        $isBookmarked = $user->bookmarkedProperties()->where('property_id', $property->id)->exists();

        if ($isBookmarked) {
            $user->bookmarkedProperties()->detach($property->id);
            $action = 'removed';
        } else {
            $user->bookmarkedProperties()->attach($property->id);
            $action = 'added';
        }

        return response()->json([
            'success' => true,
            'action' => $action,
            'is_bookmarked' => !$isBookmarked
        ]);
    }

    public function index(Request $request)
    {
        $query = Property::query();

        // Search Logic
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('address', 'like', "%{$searchTerm}%")
                    ->orWhere('city', 'like', "%{$searchTerm}%")
                    ->orWhere('country', 'like', "%{$searchTerm}%");
            });
        }

        // Base restriction for Admin/Cleaner roles
        if (auth()->user()->hasRole('Admin')) {
            $query->where('user_id', auth()->id());
        } elseif (auth()->user()->hasRole('Cleaner')) {
            $user = auth()->user();
            $adminIds = $user->managingAdmins()->pluck('users.id');
            $assignedIds = $user->assignedProperties()->where('role_type', 'cleaner')->pluck('properties.id');
            
            $query->where(function($q) use ($adminIds, $assignedIds) {
                $q->whereIn('user_id', $adminIds)
                  ->orWhereIn('id', $assignedIds);
            });
        }

        // Filter Logic
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('min_price')) {
            $query->where('price_per_night', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price_per_night', '<=', $request->max_price);
        }

        if ($request->filled('check_in_date') && $request->filled('check_out_date')) {
            $start = $request->check_in_date;
            $end = $request->check_out_date;

            $query->whereDoesntHave('bookings', function ($q) use ($start, $end) {
                $q->where('status', 'Confirmed') // Only check confirmed bookings
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

        $trending_properties = $query->whereIn('status', ['Available', 'Booked', 'Under Maintenance'])
            ->withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->take(20)
            ->get();

        $cities = Property::distinct()->pluck('city');

        $bookmarked_properties = [];
        $bookmarked_ids = [];
        if (auth()->check()) {
            $bookmarked_properties = auth()->user()->bookmarkedProperties()
                ->whereIn('status', ['Available', 'Booked', 'Under Maintenance'])
                ->get();
            $bookmarked_ids = $bookmarked_properties->pluck('id')->toArray();
        }

        return view('properties.index', compact('trending_properties', 'cities', 'bookmarked_properties', 'bookmarked_ids'));
    }

    public function allProperties()
    {
        if (auth()->user()->hasRole('Admin')) {
            $properties = Property::with('images')->where('user_id', auth()->id())->latest()->get();
        } elseif (auth()->user()->hasRole('Cleaner')) {
            $user = auth()->user();
            $adminIds = $user->managingAdmins()->pluck('users.id');
            $assignedIds = $user->assignedProperties()->where('role_type', 'cleaner')->pluck('properties.id');
            
            $properties = Property::with('images')
                ->where(function($q) use ($adminIds, $assignedIds) {
                    $q->whereIn('user_id', $adminIds)
                      ->orWhereIn('id', $assignedIds);
                })
                ->latest()->get();
        } else {
            $properties = Property::with('images')->latest()->get();
        }
        $amenities = Amenity::all();
        return view('properties.all', compact('properties', 'amenities'));
    }

    public function checkIn(Request $request)
    {
        // If no search parameters, just show the form
        if (!$request->has('booking_reference') && !$request->has('last_name')) {
            return view('properties.check-in');
        }

        $request->validate([
            'booking_reference' => 'required|string',
            'last_name' => 'required|string'
        ]);

        $reference = $request->booking_reference;
        $last_name = $request->last_name;

        $booking = Booking::where('reference', $reference)->first();
        if (!$booking) {
            return back()->with('error', 'Booking not found');
        }

        $property = $booking->property;

        // Authorization Check for Admin
        if (auth()->check() && auth()->user()->hasRole('Admin')) {
            if ($property->user_id !== auth()->id()) {
                return back()->with('error', 'Booking not found'); // Generic error for security
            }
        }

        // Authorization Check for Cleaner
        if (auth()->check() && auth()->user()->hasRole('Cleaner')) {
            $user = auth()->user();
            $adminIds = $user->managingAdmins()->pluck('users.id');
            $assignedIds = $user->assignedProperties()->where('role_type', 'cleaner')->pluck('properties.id');
            
            $hasAccess = $adminIds->contains($property->user_id) || $assignedIds->contains($property->id);
            
            if (!$hasAccess) {
                return back()->with('error', 'Booking not found');
            }
        }

        $user = User::where('id', $booking->user_id)->where('last_name', $last_name)->first();
        if (!$user) {
            return back()->with('error', 'User not found for this booking');
        }

        // Determine if booking has already been checked in
        try {
            $isCheckedIn = DB::table('digital_check_ins')
                ->where('booking_id', $booking->id)
                ->where('status', 'Checked In')
                ->exists();
        } catch (\Exception $e) {
            $isCheckedIn = false;
        }

        // Determine if booking has been checked out
        try {
            $isCheckedOut = DB::table('digital_check_ins')
                ->where('booking_id', $booking->id)
                ->where('status', 'Checked Out')
                ->exists();
        } catch (\Exception $e) {
            $isCheckedOut = ($booking->status === 'Completed');
        }

        return view('properties.check-in', compact('booking', 'user', 'property', 'isCheckedIn', 'isCheckedOut'));
    }

    public function create()
    {
        $admins = User::role('Admin')->get();
        return view('properties.create', compact('admins'));
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Keep for single file fallback
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $owner_id = Auth::id();
        if ($request->has('owner_id') && !empty($request->owner_id)) {
            $owner_id = $request->owner_id;
        }

        $property = Property::create([
            'user_id' => $owner_id,
            'name' => $request->name,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
            'max_guests' => $request->max_guests,
            'price_per_night' => $request->price_per_night,
            'status' => $request->status,
            'description' => $request->description,
            // 'image_path' will be set below
        ]);

        // Handle Image Uploads
        $savedImagePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('apartments', 'public');
                $savedImagePaths[] = $path;

                // Save to PropertyImage table
                \App\Models\PropertyImage::create([
                    'property_id' => $property->id,
                    'image_path' => $path
                ]);
            }
        }

        // Fallback for single image input (if someone uses old API or form)
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('apartments', 'public');
            $savedImagePaths[] = $path;
            \App\Models\PropertyImage::create([
                'property_id' => $property->id,
                'image_path' => $path
            ]);
        }

        // Set the main image to the first one uploaded
        if (count($savedImagePaths) > 0) {
            $property->update(['image_path' => $savedImagePaths[0]]);
        }

        return redirect()->route('properties.index')->with('success', 'Property added successfully!');
    }

    public function show(Property $property)
    {
        return view('properties.show', compact('property'));
    }

    public function edit(Property $property)
    {
        // Check if user is authorized to edit
        if (auth()->user()->hasRole('Admin') && !auth()->user()->hasRole('Super Admin') && $property->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $amenities = Amenity::all();
        $admins = User::role('Admin')->get();
        return view('properties.edit', compact('property', 'amenities', 'admins'));
    }

    public function update(Request $request, Property $property)
    {
        // Check if user is authorized to edit
        if (auth()->user()->hasRole('Admin') && !auth()->user()->hasRole('Super Admin') && $property->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $rules = [
            'price_per_night' => 'required|numeric|min:0',
            'status' => 'required|in:Pending,Available,Booked,Under Maintenance',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Fallback
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
        ];

        // If Super Admin, allow editing structural details
        if (auth()->user()->hasRole('Super Admin')) {
            $rules['name'] = 'required|string|max:255';
            $rules['address'] = 'required|string';
            $rules['city'] = 'required|string|max:100';
            $rules['country'] = 'required|string|max:100';
            $rules['max_guests'] = 'required|integer|min:1';
            $rules['owner_id'] = 'nullable|exists:users,id';
        }

        $request->validate($rules);

        $data = [
            'price_per_night' => $request->price_per_night,
            'status' => $request->status,
            'description' => $request->description,
        ];

        if (auth()->user()->hasRole('Super Admin')) {
            $data['name'] = $request->name;
            $data['address'] = $request->address;
            $data['city'] = $request->city;
            $data['country'] = $request->country;
            $data['max_guests'] = $request->max_guests;

            if ($request->filled('owner_id')) {
                $data['user_id'] = $request->owner_id;
            }
        }

        // Handle Single Image Fallback/Replacement
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('apartments', 'public');
            // Also add to property_images for consistency
            \App\Models\PropertyImage::create([
                'property_id' => $property->id,
                'image_path' => $data['image_path']
            ]);
        }

        $property->update($data);

        // Handle Multiple Images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('apartments', 'public');

                // Save to PropertyImage table
                \App\Models\PropertyImage::create([
                    'property_id' => $property->id,
                    'image_path' => $path
                ]);
            }
        }

        // Sync amenities
        if ($request->has('amenities')) {
            $property->amenities()->sync($request->amenities);
        } else {
            $property->amenities()->detach();
        }

        return redirect()->route('properties.all')->with('success', 'Property updated successfully!');
    }

    public function markAsAvailable($id)
    {
        $property = Property::findOrFail($id);

        if ($property->status === 'Pending' || $property->status === 'Under Maintenance') {
            $property->status = 'Available';

            if (auth()->user()->hasRole('Cleaner')) {
                $property->last_cleaned_by = auth()->id();
                $property->last_cleaned_at = now();
            }

            $property->save();

            return response()->json(['success' => true, 'message' => 'Property marked as available.']);
        }

        return response()->json(['success' => false, 'message' => 'Invalid status change.'], 400);
    }


    /*public function checkIn(Request $request){
        $reference = $request->booking_reference;
        $last_name = $request->last_name;
        $booking = Booking::where("reference", $reference)->first();

        $property = $booking->property;
        $user = User::where("id", $booking->user_id)->where("last_name", $last_name)->first();

        return view('properties.check-in', compact('booking', 'user', 'property'));
    }*/

    /*public function checkInBooking(Request $request){
        $booking_id = $request->input('booking_id');

        try {
            DB::table("digital_check_ins")->insert([
                "booking_id"   => $booking_id,
                "check_in_time"=> Carbon::now(),
                "status"       => "Checked In"
            ]);

            return response()->json(["status" => "success"]);
        } catch (\Exception $e) {
            return response()->json([
                "status"  => "error",
                "message" => $e->getMessage()
            ], 500);
        }
    }*/
    public function destroy(Property $property)
    {
        // Strict Authorization: Only Super Admin can delete
        if (!auth()->user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized action. Only Super Admins can delete properties.');
        }

        // Delete associated images
        if ($property->image_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($property->image_path);
        }

        $images = \App\Models\PropertyImage::where('property_id', $property->id)->get();
        foreach ($images as $image) {
            if ($image->image_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($image->image_path);
            }
            $image->delete();
        }

        // Delete property
        $property->delete();

        return response()->json([
            'success' => true,
            'message' => 'Property deleted successfully.'
        ]);
    }

    public function deleteImage(Property $property, \App\Models\PropertyImage $image)
    {
        // Check if user is authorized to edit
        if (auth()->user()->hasRole('Admin') && !auth()->user()->hasRole('Super Admin') && $property->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Ensure the image belongs to the property
        if ($image->property_id !== $property->id) {
            return back()->with('error', 'Unauthorized image deletion.');
        }

        // Delete from storage
        if ($image->image_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($image->image_path);
        }

        // Delete from DB
        $image->delete();

        // If this was the main image_path, clear it or set to another
        if ($property->image_path === $image->image_path) {
            $nextImage = $property->images()->first();
            $property->update(['image_path' => $nextImage ? $nextImage->image_path : null]);
        }

        return back()->with('success', 'Image deleted successfully.');
    }
}
