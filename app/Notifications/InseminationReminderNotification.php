<?php
// app/Notifications/InseminationReminderNotification.php

namespace App\Notifications;

use App\Models\Insemination;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InseminationReminderNotification extends Notification
{
    use Queueable;

    public function __construct(public Insemination $record) {}

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Calving Reminder — 2 Weeks Away')
            ->greeting("Hello {$notifiable->name},")
            ->line("Cow **#{$this->record->cow_id}** (inseminated on **{$this->record->date->format('d M Y')}**) is expected to calve around **{$this->record->expected_dob->format('d M Y')}**.")
            ->line('That is in approximately 2 weeks. Please prepare the calving pen and monitor the cow closely.')
            ->action('View Insemination Record', url('/dashboard/inseminations'))
            ->line('Thank you for using the Farm Management System.');
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => 'Calving reminder',
            'body' => "Cow #{$this->record->cow_id} is expected to calve around {$this->record->expected_dob->format('d M Y')}.",
            'message' => "Calving reminder: Cow #{$this->record->cow_id} expected around {$this->record->expected_dob->format('d M Y')}",
            'record_id' => $this->record->id,
        ];
    }
}
