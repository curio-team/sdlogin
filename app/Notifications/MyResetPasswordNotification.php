<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class MyResetPasswordNotification extends Notification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;
    private $user;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token, $user)
    {
        $this->token = $token;
        $this->user = $user;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Verander je wachtwoord')
            ->greeting('Hoi ' . $this->user->name)
            ->line('Je ontvangt deze e-mail omdat je een wachtwoord-reset hebt aangevraagd voor je AMO-login account.')
            ->action('Reset wachtwoord', url(config('app.url').route('password.reset', $this->token, false)))
            ->line('Als je geen reset hebt aangevraagd, dan hoef je verder niets te doen.')
            ->salutation(' - Amologin');
    }
}
