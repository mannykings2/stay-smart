<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleAuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle(): \Illuminate\Http\RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback(): \Illuminate\Http\RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('google_id', $googleUser->id)
                ->orWhere('email', $googleUser->email)
                ->first();

            if ($user) {
                // Update user with google_id and avatar if not set
                $user->update([
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                ]);

                Auth::login($user);
            } else {
                // Create a new user
                // Split name into first and last name
                $nameParts = explode(' ', $googleUser->name, 2);
                $firstName = $nameParts[0] ?? 'Google';
                $lastName = $nameParts[1] ?? 'User';

                $newUser = User::create([
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'password' => null, // Password is not required for Google login
                    'email_verified_at' => now(),
                    'role' => 'User', // Default role
                ]);

                Auth::login($newUser);
            }

            return redirect('/');

        } catch (Exception $e) {
            // Log the error for debugging
            \Log::error('Google Auth Error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());

            return redirect('/login')->with('message', 'Google Login failed. Error: ' . $e->getMessage());
        }
    }
}
