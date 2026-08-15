<?php

namespace App\Filament\Widgets;

use App\Models\MilkProduction;
use Filament\Widgets\ChartWidget;

class MilkTrendChart extends ChartWidget
{
    protected static ?string $heading = 'Milk production — last 14 days';

    protected int | string | array $columnSpan = 2;

    protected function getData(): array
    {
        $labels = [];
        $values = [];

        for ($i = 13; $i >= 0; $i--) {
            $day = today()->subDays($i);

            $labels[] = $day->format('j M');
            $values[] = round((float) MilkProduction::query()
                ->whereDate('date', $day)
                ->get()
                ->sum(fn ($record) => $record->morning + $record->afternoon + $record->evening), 2);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total yield (L)',
                    'data' => $values,
                    'borderColor' => 'rgb(13, 138, 78)',
                    'backgroundColor' => 'rgba(13, 138, 78, 0.12)',
                    'fill' => true,
                    'tension' => 0.35,
                    'pointRadius' => 3,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
