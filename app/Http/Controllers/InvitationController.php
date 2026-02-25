<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitation;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvitationMail;

class InvitationController extends Controller
{
    /**
     * Generate a new invitation link.
     */
    /**
     * Generate a new invitation link.
     */
    public function generate(Request $request)
    {
        $request->validate([
            'email' => 'nullable|email',
            'role' => 'required|in:Cleaner,Admin'
        ]);

        // Security check: Only Super Admins can create Admin invitations
        if ($request->role === 'Admin' && !auth()->user()->hasRole('Super Admin')) {
            return back()->with('error', 'You do not have permission to create Admin invitations.');
        }

        $invitation = Invitation::create([
            'token' => \Illuminate\Support\Str::random(32),
            'inviter_id' => auth()->id(),
            'role' => $request->role,
            'email' => $request->email, // Store the email
            'expires_at' => now()->addHours(48),
        ]);

        // Append email to link if available
        $link = route('invite.accept', $invitation->token);
        if ($request->email) {
            $link .= '?email=' . urlencode($request->email);
        }

        if ($request->email) {
            \Illuminate\Support\Facades\Log::info('Attempting to send invitation email to: ' . $request->email);
            try {
                Mail::to($request->email)->send(new InvitationMail($link, $request->role));
                \Illuminate\Support\Facades\Log::info('Invitation email sent successfully to: ' . $request->email);
            } catch (\Exception $e) {
                // Log error but continue to show link
                \Illuminate\Support\Facades\Log::error('Failed to send invitation email: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Invitation link generated' . ($request->email ? ' and sent!' : '!'))
            ->with('invite_link', $link);
    }

    /**
     * Handle the invitation acceptance.
     */
    public function accept($token, Request $request)
    {
        $invitation = Invitation::where('token', $token)->first();

        if (!$invitation || !$invitation->isValid()) {
            return redirect()->route('welcome')->with('error', 'Invitation link is invalid, expired, or revoked.');
        }

        // If user is already logged in
        if (auth()->check()) {
            // Security Check: If invitation is email-bound, enforce match
            if ($invitation->email && strtolower(auth()->user()->email) !== strtolower($invitation->email)) {
                return redirect()->route('home')->with('error', 'This invitation is not for your email address.');
            }
            return $this->claim($invitation, auth()->user());
        }

        // Store token in session for post-auth processing
        session(['pending_invite_token' => $token]);

        // Pass email to view for prefilling
        $email = $request->query('email') ?? $invitation->email;

        // If invitation has a strictly bound email, tell the register/login page to lock it
        if ($invitation->email) {
            session(['invite_email' => $invitation->email]);
        }

        return redirect()->route('register')->with('info', 'Please create an account to accept the invitation.');
    }

    /**
     * Finalize the invitation (assign role).
     */
    protected function claim(Invitation $invitation, $user)
    {
        if ($invitation->isClaimed()) {
            return redirect()->route('home')->with('error', 'This invitation has already been claimed.');
        }

        // Check if user already has a role
        if ($user->roles()->exists()) {
            return redirect()->route('home')->with('error', 'You already have a role assigned and cannot accept this invitation.');
        }

        // Final Security Check
        if ($invitation->email && strtolower($user->email) !== strtolower($invitation->email)) {
            return redirect()->route('home')->with('error', 'This invitation is bound to a different email address.');
        }

        $user->assignRole($invitation->role);

        // Sync role to database column
        if (in_array($invitation->role, ['Admin', 'Cleaner'])) {
            $user->role = 'Admin';

            // If inviter is Admin, attach relationship
            if ($invitation->role === 'Cleaner') {
                $user->role = 'Admin'; // Force Admin for DB column

                // If inviter is Admin, attach relationship
                if ($invitation->inviter && $invitation->inviter->hasRole('Admin')) {
                    $invitation->inviter->managedCleaners()->syncWithoutDetaching([$user->id]);
                }
            }

            $user->save();
        }

        $invitation->update([
            'claimed_at' => now(),
            'claimed_by' => $user->id,
        ]);

        session()->forget('pending_invite_token');

        return redirect()->route('home')->with('success', 'You have successfully joined as a ' . $invitation->role . '!');
    }

    /**
     * Delete/Revoke an invitation.
     */
    public function destroy(Invitation $invitation)
    {
        // Only the inviter or Super Admin can delete
        if ($invitation->inviter_id !== auth()->id() && !auth()->user()->hasRole('Super Admin')) {
            abort(403);
        }

        $invitation->delete();

        return back()->with('success', 'Invitation has been revoked.');
    }
}
