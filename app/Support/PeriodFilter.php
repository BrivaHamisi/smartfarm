<?php

namespace App\Support;

class PeriodFilter
{
    public static function presets(): array
    {
        return [
            'this_month' => 'This month',
            'last_month' => 'Last month',
            'this_year' => 'This year',
            'last_year' => 'Last year',
        ];
    }

    /**
     * @param  array<string, mixed>  $filters
     * @return array{0: string, 1: string} [from, until]
     */
    public static function resolve(array $filters): array
    {
        $preset = $filters['period'] ?? 'this_month';
        $from = $filters['from'] ?? null;
        $to = $filters['until'] ?? null;

        if (! $from || ! $to) {
            $now = now();

            match ($preset) {
                'last_month' => $from ??= $now->copy()->subMonth()->startOfMonth()->toDateString(),
                'this_year' => $from ??= $now->copy()->startOfYear()->toDateString(),
                'last_year' => $from ??= $now->copy()->subYear()->startOfYear()->toDateString(),
                default => $from ??= $now->copy()->startOfMonth()->toDateString(),
            };

            $to ??= match ($preset) {
                'last_month' => $now->copy()->subMonth()->endOfMonth()->toDateString(),
                'this_year' => $now->copy()->endOfYear()->toDateString(),
                'last_year' => $now->copy()->subYear()->endOfYear()->toDateString(),
                default => $now->copy()->endOfMonth()->toDateString(),
            };
        }

        return [$from, $to];
    }
}
