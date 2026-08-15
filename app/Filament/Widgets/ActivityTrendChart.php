<?php

namespace App\Filament\Widgets;

use App\Models\ActivityLog;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class ActivityTrendChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Activity per day';

    protected static ?string $maxHeight = '240px';

    protected function getData(): array
    {
        $farmId = $this->filters['farm_id'] ?? null;
        $action = $this->filters['action'] ?? null;

        $start = $this->filters['from'] ?? now()->subDays(29)->toDateString();
        $end = $this->filters['until'] ?? now()->toDateString();

        $labels = [];
        $cursor = \Illuminate\Support\Carbon::parse($start);
        $endDate = \Illuminate\Support\Carbon::parse($end);
        while ($cursor->lte($endDate)) {
            $labels[] = $cursor->format('d M');
            $cursor->addDay();
        }

        $rows = ActivityLog::query()
            ->when($farmId, fn ($q, $v) => $q->where('farm_id', $v))
            ->when($action, fn ($q, $v) => $q->where('action', $v))
            ->whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->groupBy('day')
            ->pluck('total', 'day')
            ->map(fn ($value): int => (int) $value)
            ->toArray();

        $data = [];
        $dayCursor = \Illuminate\Support\Carbon::parse($start);
        while ($dayCursor->lte($endDate)) {
            $data[] = $rows[$dayCursor->toDateString()] ?? 0;
            $dayCursor->addDay();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Actions',
                    'data' => $data,
                    'backgroundColor' => '#0d8a4e',
                    'borderColor' => '#0d8a4e',
                    'fill' => true,
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
