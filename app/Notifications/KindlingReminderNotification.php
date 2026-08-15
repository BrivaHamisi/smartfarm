<?php
// app/Notifications/KindlingReminderNotification.php

namespace App\Notifications;

use App\Models\RabbitBreedingRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class KindlingReminderNotification extends Notification
{
    use Queueable;

    public function __construct(public RabbitBreedingRecord $record) {}

    public function via($notifiable): array { return ['mail', 'database']; }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('🐇 Kindling Reminder — 1 Week Away')
            ->greeting("Hello {$notifiable->name},")
            ->line("Doe **{$this->record->doe_id}** is expected to kindle on **{$this->record->expected_kindling_date->format('d M Y')}**.")
            ->line('That is in approximately 1 week. Please prepare the nest box and ensure the doe has plenty of nesting material.')
            ->action('View Rabbit Breeding Records', url('/rabbits/breeding'))
            ->line('Thank you for using the Farm Management System.');
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => "Kindling reminder: Doe {$this->record->doe_id} expected to kindle on {$this->record->expected_kindling_date->format('d M Y')}",
            'record_id' => $this->record->id,
        ];
    }
}