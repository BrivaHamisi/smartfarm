<?php

namespace App\Filament\Widgets;

use App\Filament\Widgets\Concerns\AppliesPageFilters;
use App\Services\FinanceService;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FinanceSummaryStats extends BaseWidget
{
    use AppliesPageFilters;
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        $summary = FinanceService::summary(
            $this->resolveFarmId(),
            $this->filterFrom(),
            $this->filterUntil(),
        );

        return [
            Stat::make('Total income', $this->money($summary['income']))
                ->description('in the selected period')
                ->icon('heroicon-o-arrow-trending-up')
                ->color('success'),
            Stat::make('Total expenses', $this->money($summary['expense']))
                ->description('in the selected period')
                ->icon('heroicon-o-arrow-trending-down')
                ->color('danger'),
            Stat::make('Net income', $this->money($summary['net']))
                ->description($summary['net'] >= 0 ? 'profitable' : 'at a loss')
                ->icon('heroicon-o-scale')
                ->color($summary['net'] >= 0 ? 'success' : 'danger'),
            Stat::make('Transactions', number_format($summary['count']))
                ->description('records in the selected period')
                ->icon('heroicon-o-receipt-percent')
                ->color('info'),
        ];
    }

    protected function money(float $value): string
    {
        return 'KSh '.number_format($value, $value == (int) $value ? 0 : 2);
    }
}
