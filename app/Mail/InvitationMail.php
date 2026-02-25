<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $link;
    public $role;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($link, $role = 'Cleaner')
    {
        $this->link = $link;
        $this->role = $role;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('Admin@staysmartbookings.com', 'Stay Smart Admin')
            ->subject("Invitation to join stay-smart as a {$this->role}")
            ->html("
                        <h2>Hello!</h2>
                        <p>You have been invited to join the stay-smart platform as a {$this->role}.</p>
                        <p>Click the link below to accept the invitation and set up your account:</p>
                        <p><a href='{$this->link}' style='padding: 10px 20px; background: #000; color: #fff; text-decoration: none; border-radius: 5px;'>Accept Invitation</a></p>
                        <p>Or copy and paste this link into your browser:</p>
                        <p>{$this->link}</p>
                        <p>This link will expire in 48 hours.</p>
                    ");
    }
}
