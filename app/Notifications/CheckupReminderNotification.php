<?php
// app/Notifications/CheckupReminderNotification.php

namespace App\Notifications;

use App\Models\Checkup;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CheckupReminderNotification extends Notification
{
    use Queueable;

    public function __construct(public Checkup $record) {}

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Health Checkup Reminder')
            ->greeting("Hello {$notifiable->name},")
            ->line("Cow **#{$this->record->cow_id}** has a **{$this->record->type}** checkup scheduled for **{$this->record->date->format('d M Y')}**.")
            ->line('Please make sure the checkup is carried out on time.')
            ->action('View Health Checkup', url('/dashboard/checkups'))
            ->line('Thank you for using the Farm Management System.');
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => 'Health checkup reminder',
            'body' => "Cow #{$this->record->cow_id} has a {$this->record->type} checkup scheduled for {$this->record->date->format('d M Y')}.",
            'message' => "Checkup reminder: Cow #{$this->record->cow_id} on {$this->record->date->format('d M Y')}",
            'record_id' => $this->record->id,
        ];
    }
}
