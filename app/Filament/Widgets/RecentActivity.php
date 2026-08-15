<?php

namespace App\Filament\Widgets;

use App\Models\Checkup;
use App\Models\Finances;
use App\Models\Insemination;
use App\Models\MilkProduction;
use App\Models\Poultry;
use Filament\Widgets\Widget;

class RecentActivity extends Widget
{
    protected static string $view = 'filament.widgets.recent-activity';

    protected int | string | array $columnSpan = 2;

    /**
     * @return array<int, array{icon: string, color: string, title: string, detail: string, date: \Carbon\CarbonImmutable}>
     */
    public function getActivity(): array
    {
        $activities = [];

        foreach (MilkProduction::query()->with('cow')->latest('date')->limit(5)->get() as $milk) {
            $activities[] = [
                'icon' => 'heroicon-o-beaker',
                'color' => 'primary',
                'title' => 'Milk recorded — '.($milk->cow?->name ?? 'cow'),
                'detail' => number_format($milk->total_yield, 1).' L',
                'date' => $milk->date,
            ];
        }

        foreach (Finances::query()->latest('date')->limit(5)->get() as $finance) {
            $isIncome = $finance->type === 'income';
            $activities[] = [
                'icon' => $isIncome ? 'heroicon-o-arrow-trending-up' : 'heroicon-o-arrow-trending-down',
                'color' => $isIncome ? 'success' : 'danger',
                'title' => ucfirst($finance->type).' — '.str_replace('_', ' ', $finance->category),
                'detail' => 'KSh '.number_format($finance->amount, 2),
                'date' => $finance->date,
            ];
        }

        foreach (Checkup::query()->with('cow')->latest('date')->limit(5)->get() as $checkup) {
            $activities[] = [
                'icon' => 'heroicon-o-clipboard-document-check',
                'color' => $checkup->is_completed ? 'success' : 'warning',
                'title' => ucfirst(str_replace('_', ' ', $checkup->type)).' — '.($checkup->cow?->name ?? 'cow'),
                'detail' => $checkup->is_completed ? 'Completed' : 'Pending',
                'date' => $checkup->date,
            ];
        }

        foreach (Insemination::query()->with('cow')->latest('date')->limit(5)->get() as $insemination) {
            $activities[] = [
                'icon' => 'heroicon-o-heart',
                'color' => $insemination->successful === null ? 'warning' : ($insemination->successful ? 'success' : 'danger'),
                'title' => 'Insemination — '.($insemination->cow?->name ?? 'cow'),
                'detail' => $insemination->successful === null ? 'Awaiting result' : ($insemination->successful ? 'Successful' : 'Failed'),
                'date' => $insemination->date,
            ];
        }

        foreach (Poultry::query()->latest('date')->limit(5)->get() as $poultry) {
            $activities[] = [
                'icon' => 'heroicon-o-circle-stack',
                'color' => 'warning',
                'title' => 'Poultry record',
                'detail' => $poultry->eggs_produced.' eggs, '.$poultry->chicken_count.' chickens',
                'date' => $poultry->date,
            ];
        }

        usort($activities, fn (array $a, array $b): int => $b['date'] <=> $a['date']);

        return array_slice($activities, 0, 8);
    }
}
