<?php

namespace App\Notifications;

use Illuminate\Support\Facades\URL;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    // '?email=' . urlencode($notifiable->getEmailForPasswordReset())
    protected function createResetUrl($notifiable)
    {
        return 'http://192.168.1.226:3000/reset-password?token=' . $this->token . '?email=' .$notifiable->getEmailForPasswordReset();
    }

    public function toMail($notifiable)
    {

        $resetUrl = $this->createResetUrl($notifiable);

        return (new MailMessage)
            ->subject('Reset Password Notification')
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password', $resetUrl)
            ->line('If you did not request a password reset, no further action is required.');
    }
}


