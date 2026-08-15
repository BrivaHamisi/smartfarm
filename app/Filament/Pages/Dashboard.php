<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\FarmOverviewTable;
use App\Filament\Widgets\MilkTrendChart;
use App\Filament\Widgets\RecentActivity;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\UpcomingTasks;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getHeading(): string
    {
        $hour = now()->hour;
        $greeting = match (true) {
            $hour < 12 => 'Good morning',
            $hour < 18 => 'Good afternoon',
            default => 'Good evening',
        };

        return $greeting.', '.auth()->user()?->name;
    }

    public function getSubheading(): ?string
    {
        return now()->format('l, j F Y');
    }

    public function getWidgets(): array
    {
        return [
            StatsOverview::class,
            MilkTrendChart::class,
            UpcomingTasks::class,
            RecentActivity::class,
            FarmOverviewTable::class,
        ];
    }

    public function getColumns(): int | string | array
    {
        return 3;
    }
}
