<?php
// app/Console/Commands/SendFarmingReminders.php

namespace App\Console\Commands;

use App\Models\DorperBreedingRecord;
use App\Models\RabbitBreedingRecord;
use App\Models\User;
use App\Notifications\KindlingReminderNotification;
use App\Notifications\LambingReminderNotification;
use Illuminate\Console\Command;

class SendFarmingReminders extends Command
{
    protected $signature = 'farm:send-reminders';
    protected $description = 'Send lambing and kindling reminders to farmers';

    public function handle(): void
    {
        // Lambing reminders — 2 weeks before (14 days)
        $lambingRecords = DorperBreedingRecord::withoutGlobalScopes()
            ->where('expected_lambing_date', now()->addDays(14)->toDateString())
            ->where('reminder_sent', false)
            ->whereNull('lambing_date')
            ->get();

        foreach ($lambingRecords as $record) {
            $user = User::find($record->user_id);
            if ($user) {
                $user->notify(new LambingReminderNotification($record));
                $record->update(['reminder_sent' => true]);
                $this->info("Lambing reminder sent to {$user->name} for Ewe {$record->ewe_tag}");
            }
        }

        // Kindling reminders — 1 week before (7 days)
        $kindlingRecords = RabbitBreedingRecord::withoutGlobalScopes()
            ->where('expected_kindling_date', now()->addDays(7)->toDateString())
            ->where('reminder_sent', false)
            ->whereNull('litter_size')
            ->get();

        foreach ($kindlingRecords as $record) {
            $user = User::find($record->user_id);
            if ($user) {
                $user->notify(new KindlingReminderNotification($record));
                $record->update(['reminder_sent' => true]);
                $this->info("Kindling reminder sent to {$user->name} for Doe {$record->doe_id}");
            }
        }

        $this->info('All reminders processed.');
    }
}