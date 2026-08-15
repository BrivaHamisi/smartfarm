<?php

namespace App\Filament\Widgets;

use App\Models\Cattle;
use App\Models\DorperBreedingRecord;
use App\Models\Finances;
use App\Models\MilkProduction;
use App\Models\Poultry;
use App\Models\RabbitBreedingRecord;
use App\Models\User;
use App\Models\Workers;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $today = today();

        $milkToday = $this->milkYieldFor($today);
        $milkYesterday = $this->milkYieldFor($today->copy()->subDay());
        $milkDelta = $milkYesterday > 0
            ? round((($milkToday - $milkYesterday) / $milkYesterday) * 100, 1)
            : null;

        $eggsToday = (int) Poultry::query()->whereDate('date', $today)->sum('eggs_produced');
        $eggsYesterday = (int) Poultry::query()->whereDate('date', $today->copy()->subDay())->sum('eggs_produced');
        $eggsDelta = $eggsYesterday > 0
            ? round((($eggsToday - $eggsYesterday) / $eggsYesterday) * 100, 1)
            : null;

        $stats = [
            Stat::make('Milk today', number_format($milkToday, 1).' L')
                ->description($milkDelta === null ? 'No record from yesterday' : sprintf('%s%0.1f%% vs yesterday', $milkDelta > 0 ? '+' : '', $milkDelta))
                ->descriptionIcon($milkDelta === null ? 'heroicon-o-minus' : ($milkDelta >= 0 ? 'heroicon-o-arrow-trending-up' : 'heroicon-o-arrow-trending-down'))
                ->color($milkDelta === null ? 'gray' : ($milkDelta >= 0 ? 'success' : 'danger'))
                ->icon('heroicon-o-beaker')
                ->chart($this->lastSevenDaysMilk()),
            Stat::make('Eggs today', number_format($eggsToday))
                ->description($eggsDelta === null ? 'No record from yesterday' : sprintf('%s%0.1f%% vs yesterday', $eggsDelta > 0 ? '+' : '', $eggsDelta))
                ->descriptionIcon($eggsDelta === null ? 'heroicon-o-minus' : ($eggsDelta >= 0 ? 'heroicon-o-arrow-trending-up' : 'heroicon-o-arrow-trending-down'))
                ->color($eggsDelta === null ? 'gray' : ($eggsDelta >= 0 ? 'success' : 'danger'))
                ->icon('heroicon-o-circle-stack'),
            Stat::make('Active cows', number_format(Cattle::query()->count()))
                ->description('on record')
                ->icon('heroicon-o-identification')
                ->color('primary'),
            Stat::make('Upcoming lambings', number_format(DorperBreedingRecord::query()
                ->whereDate('expected_lambing_date', '>=', $today)
                ->whereNull('lambing_date')
                ->count()))
                ->description('in the Dorper flock')
                ->icon('heroicon-o-cube')
                ->color('warning'),
            Stat::make('Upcoming kindlings', number_format(RabbitBreedingRecord::query()
                ->whereDate('expected_kindling_date', '>=', $today)
                ->whereNull('litter_size')
                ->count()))
                ->description('across the rabbitry')
                ->icon('heroicon-o-heart')
                ->color('warning'),
        ];

        if (! (bool) auth()->user()?->isEditor()) {
            $stats[] = Stat::make('Workers', number_format(Workers::query()->count()))
                ->description('on the farm team')
                ->icon('heroicon-o-user-group')
                ->color('info');

            $monthStart = today()->startOfMonth();
            $cashIn = (float) Finances::query()->where('type', 'income')->whereDate('date', '>=', $monthStart)->sum('amount');
            $cashOut = (float) Finances::query()->where('type', 'expense')->whereDate('date', '>=', $monthStart)->sum('amount');
            $stats[] = Stat::make('Cash flow (this month)', 'KSh '.number_format($cashIn - $cashOut))
                ->description(sprintf('+%s in / −%s out', number_format($cashIn), number_format($cashOut)))
                ->icon('heroicon-o-banknotes')
                ->color('info');
        }

        if ((bool) auth()->user()?->isAdmin()) {
            $stats[] = Stat::make('Farm owners', number_format(User::query()->where('role', User::ROLE_OWNER)->count()))
                ->description('accounts on the platform')
                ->icon('heroicon-o-users')
                ->color('gray');
        }

        return $stats;
    }

    protected function milkYieldFor($date): float
    {
        return (float) MilkProduction::query()
            ->whereDate('date', $date)
            ->get()
            ->sum(fn ($record) => $record->morning + $record->afternoon + $record->evening);
    }

    /**
     * @return array<int, float>
     */
    protected function lastSevenDaysMilk(): array
    {
        $points = [];

        for ($i = 6; $i >= 0; $i--) {
            $points[] = $this->milkYieldFor(today()->subDays($i));
        }

        return $points;
    }
}
