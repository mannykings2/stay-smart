<?php

namespace App\Http\Controllers;

use App\Mail\LeaseApplicationMail;
use App\Mail\LeaseApplicationConfirmation;
use App\Models\Amenity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class LeaseToStaySmartController extends Controller
{
    /**
     * Display the lease application form
     */
    public function showForm()
    {
        $amenities = Amenity::orderBy('name')->get();
        return view('lease-to-staysmart', compact('amenities'));
    }

    /**
     * Handle the lease application form submission
     */
    public function submitForm(Request $request)
    {
        // 1. Validate form inputs
        $validated = $request->validate([
            // Owner Info
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',

            // Location
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:20',

            // Property Details
            'property_type' => 'required|string|max:50',
            'bedrooms' => 'required|string|max:20',
            'bathrooms' => 'required|string|max:20',
            'size' => 'nullable|string|max:50',
            'furnishing' => 'required|string|in:Fully Furnished,Partially Furnished,Unfurnished',
            'description' => 'required|string|min:50',
            'amenities' => 'required|array|min:1',
            'amenities.*' => 'exists:amenities,id',

            // Ownership & Legal
            'ownership_status' => 'required|string|in:I own this property,I have landlord permission to lease',
            'title_deed_available' => 'required|string|in:Yes,No',
            'tenancy_status' => 'required|string|in:Vacant,Currently Occupied',
            'vacancy_date' => 'nullable|date',

            // Lease Terms
            'lease_duration' => 'required|string',
            'expected_rent' => 'nullable|numeric',
            'start_date' => 'required|date',

            // Condition
            'condition' => 'required|string|in:Excellent,Good,Fair,Needs Renovation',
            'renovations' => 'nullable|array',
            'issues' => 'nullable|string',

            // Images
            'images' => 'required|array|min:1|max:10',
            'images.*' => 'image|mimes:jpeg,jpg,png|max:5120',

            // Additional
            'reason' => 'nullable|string',
            'special_requirements' => 'nullable|string',
        ], [
            'description.min' => 'Please provide a detailed description (at least 50 characters)',
            'amenities.required' => 'Please select at least one amenity',
            'images.required' => 'Please upload at least one image of your property',
        ]);

        // 2. Store images temporarily
        $imagePaths = [];
        $timestamp = now()->format('Y-m-d_His');
        $folderPath = "lease-applications/{$timestamp}";

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store($folderPath, 'local');
                $imagePaths[] = storage_path("app/{$path}");
            }
        }

        // 3. Get selected amenities names
        $selectedAmenities = Amenity::whereIn('id', $validated['amenities'])->pluck('name')->toArray();

        // 4. Prepare data for emails
        // Merge helper generated data into validated array or create new data array
        $data = $validated;
        $data['amenities'] = $selectedAmenities; // Replace IDs with names
        $data['images'] = $imagePaths;
        // Ensure array fields are handled if null
        $data['renovations'] = $data['renovations'] ?? [];

        // 5. Send email to Admin
        $adminEmail = env('MAIL_ADMIN_RECEIVER');
        if ($adminEmail) {
            Mail::to($adminEmail)->send(new LeaseApplicationMail($data));
        }

        // 6. Send confirmation email to applicant
        Mail::to($validated['email'])->send(new LeaseApplicationConfirmation($data));

        // 7. Clean up temporary images
        Storage::disk('local')->deleteDirectory($folderPath);

        return back()->with('success', 'Your Lease to Stay Smart application has been submitted successfully! We will review your property and contact you within 3-5 business days.');
    }
}
