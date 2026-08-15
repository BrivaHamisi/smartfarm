<?php

namespace App\Filament\Widgets;

use App\Filament\Widgets\Concerns\AppliesPageFilters;
use App\Services\FarmReportService;
use App\Services\FinanceService;
use App\Support\PeriodFilter;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FarmReportSummary extends BaseWidget
{
    use AppliesPageFilters;
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        [$from, $until] = PeriodFilter::resolve($this->filters ?? []);

        $farmId = $this->resolveFarmId();

        if (! $farmId) {
            $summary = FinanceService::summary(null, $from, $until);

            return [
                Stat::make('Total income', 'KSh '.number_format($summary['income']))
                    ->description('all farms, '.$from.' to '.$until)
                    ->icon('heroicon-o-arrow-trending-up')
                    ->color('success'),
                Stat::make('Total expenses', 'KSh '.number_format($summary['expense']))
                    ->description('all farms, '.$from.' to '.$until)
                    ->icon('heroicon-o-arrow-trending-down')
                    ->color('danger'),
                Stat::make('Net income', 'KSh '.number_format($summary['net']))
                    ->description($summary['net'] >= 0 ? 'profitable' : 'at a loss')
                    ->icon('heroicon-o-scale')
                    ->color($summary['net'] >= 0 ? 'success' : 'danger'),
                Stat::make('Transactions', number_format($summary['count']))
                    ->description('all farms')
                    ->icon('heroicon-o-receipt-percent')
                    ->color('info'),
            ];
        }

        $report = FarmReportService::data($farmId, $from, $until);

        return [
            Stat::make('Total income', 'KSh '.number_format($report['income']))
                ->description($from.' to '.$until)
                ->icon('heroicon-o-arrow-trending-up')
                ->color('success'),
            Stat::make('Total expenses', 'KSh '.number_format($report['expense']))
                ->description($from.' to '.$until)
                ->icon('heroicon-o-arrow-trending-down')
                ->color('danger'),
            Stat::make('Net income', 'KSh '.number_format($report['net']))
                ->description($report['net'] >= 0 ? 'profitable' : 'at a loss')
                ->icon('heroicon-o-scale')
                ->color($report['net'] >= 0 ? 'success' : 'danger'),
            Stat::make('Milk yield', number_format($report['milkYield'], 1).' L')
                ->description(number_format($report['eggs']).' eggs laid')
                ->icon('heroicon-o-beaker')
                ->color('primary'),
        ];
    }
}
