<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaseApplicationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $email = $this->subject('New Lease Application - ' . $this->data['first_name'] . ' ' . $this->data['last_name'])
            ->view('emails.lease-application-admin');

        // Attach all uploaded images
        foreach ($this->data['images'] as $imagePath) {
            if (file_exists($imagePath)) {
                $email->attach($imagePath);
            }
        }

        return $email;
    }
}
