<?php

namespace App\Services;

use App\Models\Finances;
use Illuminate\Support\Carbon;

class FinanceService
{
    /**
     * @return array{income: float, expense: float, net: float, count: int}
     */
    public static function summary(?int $farmId = null, string|Carbon|null $from = null, string|Carbon|null $to = null): array
    {
        $row = static::baseQuery($farmId, $from, $to)
            ->toBase()
            ->first([
                \Illuminate\Support\Facades\DB::raw('COALESCE(SUM(CASE WHEN type = "income" THEN amount END), 0) as income'),
                \Illuminate\Support\Facades\DB::raw('COALESCE(SUM(CASE WHEN type = "expense" THEN amount END), 0) as expense'),
                \Illuminate\Support\Facades\DB::raw('COUNT(*) as count'),
            ]);

        $income = (float) $row->income;
        $expense = (float) $row->expense;

        return [
            'income' => $income,
            'expense' => $expense,
            'net' => $income - $expense,
            'count' => (int) $row->count,
        ];
    }

    /**
     * @return array{labels: array<int, string>, income: array<int, float>, expense: array<int, float>}
     */
    public static function monthlyTrend(?int $farmId = null, string|Carbon|null $from = null, string|Carbon|null $to = null, int $maxMonths = 24): array
    {
        $to = Carbon::parse($to ?: today())->endOfMonth();
        $from = $from ? Carbon::parse($from)->startOfMonth() : $to->copy()->subMonths(11)->startOfMonth();

        $span = (($to->year - $from->year) * 12) + ($to->month - $from->month) + 1;

        if ($span > $maxMonths) {
            $from = $to->copy()->subMonths($maxMonths - 1)->startOfMonth();
            $span = $maxMonths;
        }

        $rows = static::baseQuery($farmId, $from, $to)
            ->toBase()
            ->selectRaw('DATE_FORMAT(date, "%Y-%m") as month')
            ->selectRaw('COALESCE(SUM(CASE WHEN type = "income" THEN amount END), 0) as income')
            ->selectRaw('COALESCE(SUM(CASE WHEN type = "expense" THEN amount END), 0) as expense')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $labels = [];
        $income = [];
        $expense = [];

        for ($i = 0; $i < $span; $i++) {
            $month = $from->copy()->addMonths($i);
            $key = $month->format('Y-m');
            $labels[] = $month->format('M y');
            $income[] = round((float) ($rows[$key]->income ?? 0), 2);
            $expense[] = round((float) ($rows[$key]->expense ?? 0), 2);
        }

        return compact('labels', 'income', 'expense');
    }

    protected static function baseQuery(?int $farmId = null, string|Carbon|null $from = null, string|Carbon|null $to = null)
    {
        return Finances::query()
            ->when($farmId, fn ($query) => $query->where('user_id', $farmId))
            ->when($from, fn ($query, $date) => $query->whereDate('date', '>=', Carbon::parse($date)))
            ->when($to, fn ($query, $date) => $query->whereDate('date', '<=', Carbon::parse($date)));
    }
}
