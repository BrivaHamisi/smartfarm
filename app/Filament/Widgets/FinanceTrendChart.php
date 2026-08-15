<?php

namespace App\Filament\Widgets;

use App\Filament\Widgets\Concerns\AppliesPageFilters;
use App\Services\FinanceService;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class FinanceTrendChart extends ChartWidget
{
    use AppliesPageFilters;
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Monthly cash flow';

    protected static ?string $maxHeight = '260px';

    protected function getData(): array
    {
        $trend = FinanceService::monthlyTrend(
            $this->resolveFarmId(),
            $this->filterFrom(),
            $this->filterUntil(),
        );

        return [
            'datasets' => [
                [
                    'label' => 'Income',
                    'data' => $trend['income'],
                    'backgroundColor' => '#16a34a',
                    'borderColor' => '#16a34a',
                    'borderRadius' => 3,
                ],
                [
                    'label' => 'Expenses',
                    'data' => $trend['expense'],
                    'backgroundColor' => '#dc2626',
                    'borderColor' => '#dc2626',
                    'borderRadius' => 3,
                ],
            ],
            'labels' => $trend['labels'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
