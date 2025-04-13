<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TemporaryPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $tempPassword;

    public function __construct($tempPassword)
    {
        $this->tempPassword = $tempPassword;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Votre compte a été créé - Mot de passe temporaire')
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line('Un compte a été créé pour vous sur notre plateforme.')
            ->line('**Voici votre mot de passe temporaire :**')
            ->line('## ' . $this->tempPassword)
            ->line('Vous serez obligé de changer ce mot de passe lors de votre première connexion.')
            ->action('Se connecter maintenant', url('/login'))
            ->line('Ce mot de passe est valable une seule fois.')
            ->salutation('Cordialement,<br>L\'équipe technique');
    }
}