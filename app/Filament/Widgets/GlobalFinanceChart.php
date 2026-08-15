<?php

namespace App\Filament\Widgets;

use App\Services\FinanceService;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class GlobalFinanceChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Income vs expenses across all farms';

    protected static ?string $maxHeight = '240px';

    protected function getData(): array
    {
        $trend = FinanceService::monthlyTrend(
            null,
            $this->filters['from'] ?? null,
            $this->filters['until'] ?? null,
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
