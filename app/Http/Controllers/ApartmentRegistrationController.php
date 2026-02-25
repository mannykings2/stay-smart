<?php

namespace App\Http\Controllers;

use App\Mail\ApartmentRegistrationMail;
use App\Mail\ApartmentRegistrationConfirmation;
use App\Models\Amenity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ApartmentRegistrationController extends Controller
{
    /**
     * Display the apartment registration form
     */
    public function showForm()
    {
        $amenities = Amenity::orderBy('name')->get();
        return view('register-apartment', compact('amenities'));
    }

    /**
     * Handle the apartment registration form submission
     */
    public function submitForm(Request $request)
    {
        // Validate form inputs
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'description' => 'required|string|min:50',
            'amenities' => 'required|array|min:1',
            'amenities.*' => 'exists:amenities,id',
            'images' => 'required|array|min:1|max:10',
            'images.*' => 'image|mimes:jpeg,jpg,png|max:5120', // 5MB max
        ], [
            'description.min' => 'Please provide a detailed description (at least 50 characters)',
            'amenities.required' => 'Please select at least one amenity',
            'images.required' => 'Please upload at least one image of your apartment',
            'images.max' => 'You can upload a maximum of 10 images',
            'images.*.max' => 'Each image must be less than 5MB',
        ]);

        // Store images temporarily
        $imagePaths = [];
        $timestamp = now()->format('Y-m-d_His');
        $folderPath = "apartment-registrations/{$timestamp}";

        foreach ($request->file('images') as $image) {
            $path = $image->store($folderPath, 'local');
            $imagePaths[] = storage_path("app/{$path}");
        }

        // Get selected amenities names
        $selectedAmenities = Amenity::whereIn('id', $validated['amenities'])->pluck('name')->toArray();

        // Prepare data for emails
        $data = [
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'postal_code' => $validated['postal_code'] ?? 'N/A',
            'description' => $validated['description'],
            'amenities' => $selectedAmenities,
            'images' => $imagePaths,
        ];

        // Send email to Admin
        $adminEmail = env('MAIL_ADMIN_RECEIVER');
        if ($adminEmail) {
            Mail::to($adminEmail)->send(new ApartmentRegistrationMail($data));
        }

        // Send confirmation email to applicant
        Mail::to($validated['email'])->send(new ApartmentRegistrationConfirmation($data));

        // Clean up temporary images after emails are sent
        Storage::disk('local')->deleteDirectory($folderPath);

        return back()->with('success', 'Thank you for your interest! Your apartment registration has been submitted successfully. You will receive a confirmation email shortly, and our team will review your application within 24-48 hours.');
    }
}
