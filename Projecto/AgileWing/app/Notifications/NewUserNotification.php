<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;

class NewUserNotification extends Notification
{
    public function toMail($notifiable)
    {
        $url = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $notifiable->getKey()]
        );

        return (new MailMessage)
            ->line('Bem-vindo ao nosso sistema!')
            ->line('Clique no botão abaixo para verificar seu endereço de email.')
            ->action('Verificar Email', $url)
            ->line('Obrigado por usar nosso sistema!');
    }


}


