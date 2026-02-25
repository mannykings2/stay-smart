<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * The user has been registered.
     */
    protected function registered(\Illuminate\Http\Request $request, $user)
    {
        if (session()->has('pending_invite_token')) {
            return redirect()->route('invite.accept', session('pending_invite_token'));
        }

        return redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Extract first name from email (before @)
        $emailParts = explode('@', $data['email']);
        $defaultFirstName = ucfirst($emailParts[0]);

        $user = User::create([
            'first_name' => $defaultFirstName,
            'last_name' => null,
            'email' => $data['email'],
            'phone_number' => null,
            'gender' => null,
            'password' => Hash::make($data['password']),
            'email_verified_at' => session()->has('pending_invite_token') ? now() : null,
        ]);

        // Assign default "User" role (only if user has no existing role AND is not accepting an invite)
        // If they are accepting an invite, the role will be assigned in InvitationController@accept
        if (!$user->roles()->exists() && !session()->has('pending_invite_token')) {
            $user->assignRole('User');
        }

        // Send welcome email - Removed to prevent duplicate emails (VerifyEmailNotification covers this)
        // $user->notify(new \App\Notifications\WelcomeNotification());

        // Only send verification email if not registering via invitation
        if (!session()->has('pending_invite_token')) {
            $user->sendEmailVerificationNotification();
        }

        return $user;
    }
}
