<?php
// app/Notifications/LambingReminderNotification.php

namespace App\Notifications;

use App\Models\DorperBreedingRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class LambingReminderNotification extends Notification
{
    use Queueable;

    public function __construct(public DorperBreedingRecord $record) {}

    public function via($notifiable): array { return ['mail', 'database']; }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('🐑 Lambing Reminder — 2 Weeks Away')
            ->greeting("Hello {$notifiable->name},")
            ->line("Ewe **{$this->record->ewe_tag}** (bred with Ram **{$this->record->ram_tag}**) is expected to lamb on **{$this->record->expected_lambing_date->format('d M Y')}**.")
            ->line('That is in approximately 2 weeks. Please prepare the lambing pen and ensure the ewe is in good health.')
            ->action('View Breeding Record', url('/dashboard/dorper-breeding-records'))
            ->line('Thank you for using the Farm Management System.');
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => 'Lambing reminder',
            'body' => "Ewe {$this->record->ewe_tag} is expected to lamb on {$this->record->expected_lambing_date->format('d M Y')}.",
            'message' => "Lambing reminder: Ewe {$this->record->ewe_tag} expected to lamb on {$this->record->expected_lambing_date->format('d M Y')}",
            'record_id' => $this->record->id,
        ];
    }
}