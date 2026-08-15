<?php

namespace App\Filament\Widgets;

use App\Models\Checkup;
use App\Models\DorperBreedingRecord;
use App\Models\Insemination;
use App\Models\RabbitBreedingRecord;
use Filament\Widgets\Widget;

class UpcomingTasks extends Widget
{
    protected static string $view = 'filament.widgets.upcoming-tasks';

    protected int | string | array $columnSpan = 1;

    /**
     * @return array<int, array{title: string, date: \Carbon\CarbonImmutable, kind: string, color: string}>
     */
    public function getTasks(): array
    {
        $tasks = [];
        $today = today();

        foreach (Checkup::query()->with('cow')->where('is_completed', false)->whereDate('date', '>=', $today)->get() as $checkup) {
            $tasks[] = [
                'title' => ucfirst(str_replace('_', ' ', $checkup->type)).' — '.($checkup->cow?->name ?? 'cow'),
                'date' => $checkup->date,
                'kind' => 'Checkup',
                'color' => 'primary',
            ];
        }

        foreach (Insemination::query()->with('cow')->whereNull('successful')->whereDate('date', '>=', $today)->get() as $insemination) {
            $tasks[] = [
                'title' => 'Confirm insemination — '.($insemination->cow?->name ?? 'cow'),
                'date' => $insemination->date,
                'kind' => 'Insemination',
                'color' => 'warning',
            ];
        }

        foreach (DorperBreedingRecord::query()->whereNull('lambing_date')->whereDate('expected_lambing_date', '>=', $today)->get() as $record) {
            $tasks[] = [
                'title' => 'Expected lambing — ewe '.$record->ewe_tag,
                'date' => $record->expected_lambing_date,
                'kind' => 'Lambing',
                'color' => 'info',
            ];
        }

        foreach (RabbitBreedingRecord::query()->whereNull('litter_size')->whereDate('expected_kindling_date', '>=', $today)->get() as $record) {
            $tasks[] = [
                'title' => 'Expected kindling — doe '.$record->doe_id,
                'date' => $record->expected_kindling_date,
                'kind' => 'Kindling',
                'color' => 'success',
            ];
        }

        usort($tasks, fn (array $a, array $b): int => $a['date'] <=> $b['date']);

        return array_slice($tasks, 0, 10);
    }
}
