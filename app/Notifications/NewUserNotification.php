<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewUserNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private string $password)
    {
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Vos identifiants INSTAD')
            ->greeting("Bonjour {$notifiable->name} !")
            ->line('Votre compte administrateur a été créé avec succès.')
            ->line("**Identifiant :** `{$notifiable->email}`")
            ->line("**Mot de passe temporaire :** `{$this->password}`")
            ->action('Se connecter', route('login'))
            ->line('Ce mot de passe est valable 24h. Veuillez le changer dès votre première connexion.')
            ->salutation("L'équipe INSTAD");
    }
}