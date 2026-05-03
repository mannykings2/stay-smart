<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{

    public function index()
    {
        return view('profile.index');
    }

    /**
     * Update user profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'phone_number' => 'nullable|string|max:255',
            'gender' => 'nullable|string|in:Male,Female,Other',
            'payout_frequency' => 'nullable|string|in:Monthly,Quarterly,Yearly,On Demand',
        ];

        if (!$user->first_name) {
            $rules['first_name'] = 'required|string|max:255';
        }

        if (!$user->last_name) {
            $rules['last_name'] = 'required|string|max:255';
        }

        $request->validate($rules);

        if ($request->has('first_name')) {
            $user->first_name = $request->first_name;
        }
        if ($request->has('last_name')) {
            $user->last_name = $request->last_name;
        }
        $user->phone_number = $request->phone_number;
        $user->gender = $request->gender;
        if ($request->has('payout_frequency')) {
            $user->getOrCreateRevenueConfig()->update([
                'payout_frequency' => $request->payout_frequency,
            ]);
        }
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Change user password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password updated successfully.');
    }

    /**
     * Set password for guest account.
     */
    public function setGuestPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!$user->is_guest) {
            return redirect()->back()->with('error', 'Account is already secured.');
        }

        $user->password = Hash::make($request->password);
        $user->is_guest = false;
        $user->save();

        return redirect()->back()->with('success', 'Password set successfully! Your account is now permanent.');
    }
}
