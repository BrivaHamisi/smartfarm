<?php
// app/Console/Commands/SendFarmingReminders.php

namespace App\Console\Commands;

use App\Models\Checkup;
use App\Models\DorperBreedingRecord;
use App\Models\Insemination;
use App\Models\RabbitBreedingRecord;
use App\Models\User;
use App\Notifications\CheckupReminderNotification;
use App\Notifications\InseminationReminderNotification;
use App\Notifications\KindlingReminderNotification;
use App\Notifications\LambingReminderNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class SendFarmingReminders extends Command
{
    protected $signature = 'farm:send-reminders';

    protected $description = 'Send lambing, kindling, checkup and insemination reminders to the relevant farm accounts';

    public function handle(): void
    {
        $this->sendLambingReminders();
        $this->sendKindlingReminders();
        $this->sendCheckupReminders();
        $this->sendInseminationReminders();

        $this->info('All reminders processed.');
    }

    /**
     * The users that should be notified for a given farm: the farm owner,
     * every editor of that farm, and platform admins. The set is deduplicated.
     */
    protected function recipientsForFarm(int $farmOwnerId): Collection
    {
        $ids = User::query()
            ->where(function ($query) use ($farmOwnerId) {
                $query->where('id', $farmOwnerId)
                    ->orWhere(fn ($q) => $q->where('role', User::ROLE_EDITOR)->where('farm_owner_id', $farmOwnerId))
                    ->orWhere('role', User::ROLE_ADMIN);
            })
            ->pluck('id');

        return User::query()->whereIn('id', $ids)->get();
    }

    protected function sendLambingReminders(): void
    {
        $records = DorperBreedingRecord::withoutGlobalScopes()
            ->where('expected_lambing_date', now()->addDays(14)->toDateString())
            ->where('reminder_sent', false)
            ->whereNull('lambing_date')
            ->get();

        foreach ($records as $record) {
            foreach ($this->recipientsForFarm($record->user_id) as $user) {
                $user->notify(new LambingReminderNotification($record));
            }
            $record->update(['reminder_sent' => true]);
            $this->info("Lambing reminder sent for Ewe {$record->ewe_tag}");
        }
    }

    protected function sendKindlingReminders(): void
    {
        $records = RabbitBreedingRecord::withoutGlobalScopes()
            ->where('expected_kindling_date', now()->addDays(7)->toDateString())
            ->where('reminder_sent', false)
            ->whereNull('litter_size')
            ->get();

        foreach ($records as $record) {
            foreach ($this->recipientsForFarm($record->user_id) as $user) {
                $user->notify(new KindlingReminderNotification($record));
            }
            $record->update(['reminder_sent' => true]);
            $this->info("Kindling reminder sent for Doe {$record->doe_id}");
        }
    }

    protected function sendCheckupReminders(): void
    {
        $records = Checkup::withoutGlobalScopes()
            ->where('is_completed', false)
            ->where('reminder_sent', false)
            ->whereBetween('date', [now()->toDateString(), now()->addDays(3)->toDateString()])
            ->get();

        foreach ($records as $record) {
            foreach ($this->recipientsForFarm($record->user_id) as $user) {
                $user->notify(new CheckupReminderNotification($record));
            }
            $record->update(['reminder_sent' => true]);
            $this->info("Checkup reminder sent for Cow #{$record->cow_id}");
        }
    }

    protected function sendInseminationReminders(): void
    {
        $records = Insemination::withoutGlobalScopes()
            ->whereNotNull('expected_dob')
            ->where('reminder_sent', false)
            ->whereBetween('expected_dob', [now()->toDateString(), now()->addDays(14)->toDateString()])
            ->get();

        foreach ($records as $record) {
            foreach ($this->recipientsForFarm($record->user_id) as $user) {
                $user->notify(new InseminationReminderNotification($record));
            }
            $record->update(['reminder_sent' => true]);
            $this->info("Calving reminder sent for Cow #{$record->cow_id}");
        }
    }
}
