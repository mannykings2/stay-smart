<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Handle the contact form submission
     */
    public function send(Request $request)
    {
        // Validate form inputs
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string|min:10',
        ], [
            'message.min' => 'Please fill in the message area (at least 10 characters).',
        ]);

        // Prepare data for email
        $data = [
            'name' => $validated['name'],
            'phone' => $validated['phone'] ?? 'N/A',
            'message' => $validated['message'],
        ];

        // Send email to the configured contact receiver
        $receiver = env('MAIL_CONTACT_RECEIVER');

        if ($receiver) {
            Mail::to($receiver)->send(new ContactMail($data));
        }

        return redirect()->to(url()->previous() . '#contact-form')
            ->with('contact_success', 'Your message has been sent successfully! We will get back to you shortly.');
    }
}
