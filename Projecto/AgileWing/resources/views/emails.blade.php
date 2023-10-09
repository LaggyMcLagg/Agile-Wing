public function toMail($notifiable)
{
    return (new MailMessage)
        ->markdown('emails.blocked-time', ['url' => url('/planeamento')]);
}
