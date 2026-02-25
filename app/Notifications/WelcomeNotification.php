<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Welcome to Stay Smart!')
            ->greeting("Hi {$notifiable->first_name}!")
            ->line('Thank you for joining Stay Smart. Your account has been created successfully.')
            ->action('View Your Dashboard', url('/home'))
            ->line('If you haven\'t verified your email yet, please check your inbox for the verification link.')
            ->salutation('Best regards, The Stay Smart Team');
    }
}