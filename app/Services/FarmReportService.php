<?php

namespace App\Services;

use App\Models\Calf;
use App\Models\Cattle;
use App\Models\Checkup;
use App\Models\CropField;
use App\Models\CropHarvest;
use App\Models\CropInput;
use App\Models\DorperAnimal;
use App\Models\DorperBreedingRecord;
use App\Models\Finances;
use App\Models\Insemination;
use App\Models\MilkProduction;
use App\Models\Poultry;
use App\Models\Rabbit;
use App\Models\RabbitBreedingRecord;
use App\Models\User;
use App\Models\Workers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;

class FarmReportService
{
    public static function data(int $farmId, string|Carbon $from, string|Carbon $to): array
    {
        $from = Carbon::parse($from)->startOfDay();
        $to = Carbon::parse($to)->endOfDay();

        $farm = User::query()->find($farmId);

        $finance = Finances::query()
            ->where('user_id', $farmId)
            ->whereBetween('date', [$from->toDateString(), $to->toDateString()]);

        $income = (float) (clone $finance)->where('type', 'income')->sum('amount');
        $expense = (float) (clone $finance)->where('type', 'expense')->sum('amount');

        $incomeByCategory = (clone $finance)
            ->where('type', 'income')
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->pluck('total', 'category')
            ->map(fn ($value): float => (float) $value)
            ->toArray();

        $expenseByCategory = (clone $finance)
            ->where('type', 'expense')
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->pluck('total', 'category')
            ->map(fn ($value): float => (float) $value)
            ->toArray();

        $recentTransactions = (clone $finance)
            ->with('user')
            ->orderByDesc('date')
            ->limit(50)
            ->get();

        $counts = [
            'cattle' => static::count(Cattle::class, 'created_at', $farmId, $from, $to),
            'calves' => static::count(Calf::class, 'dob', $farmId, $from, $to),
            'milk_records' => static::count(MilkProduction::class, 'date', $farmId, $from, $to),
            'inseminations' => static::count(Insemination::class, 'date', $farmId, $from, $to),
            'checkups' => static::count(Checkup::class, 'date', $farmId, $from, $to),
            'poultry_records' => static::count(Poultry::class, 'date', $farmId, $from, $to),
            'dorper_animals' => static::count(DorperAnimal::class, 'date_of_birth', $farmId, $from, $to),
            'dorper_breedings' => static::count(DorperBreedingRecord::class, 'mating_date', $farmId, $from, $to),
            'crop_fields' => static::count(CropField::class, 'planting_date', $farmId, $from, $to),
            'crop_inputs' => static::count(CropInput::class, 'date', $farmId, $from, $to),
            'crop_harvests' => static::count(CropHarvest::class, 'date', $farmId, $from, $to),
            'rabbits' => static::count(Rabbit::class, 'created_at', $farmId, $from, $to),
            'rabbit_breedings' => static::count(RabbitBreedingRecord::class, 'mating_date', $farmId, $from, $to),
            'workers' => static::count(Workers::class, 'created_at', $farmId, $from, $to),
        ];

        $milkYield = (float) MilkProduction::query()
            ->where('user_id', $farmId)
            ->whereBetween('date', [$from->toDateString(), $to->toDateString()])
            ->get()
            ->sum(fn ($record): float => (float) ($record->morning + $record->afternoon + $record->evening));

        $eggs = (int) Poultry::query()
            ->where('user_id', $farmId)
            ->whereBetween('date', [$from->toDateString(), $to->toDateString()])
            ->sum('eggs_produced');

        return [
            'farm' => $farm,
            'from' => $from,
            'to' => $to,
            'income' => $income,
            'expense' => $expense,
            'net' => $income - $expense,
            'incomeByCategory' => $incomeByCategory,
            'expenseByCategory' => $expenseByCategory,
            'recentTransactions' => $recentTransactions,
            'counts' => $counts,
            'milkYield' => $milkYield,
            'eggs' => $eggs,
        ];
    }

    public static function download(int $farmId, string|Carbon $from, string|Carbon $to): mixed
    {
        $report = static::data($farmId, $from, $to);

        return Pdf::loadView('pdf.farm-report', ['report' => $report])
            ->setPaper('a4')
            ->stream('farm-report-'.($report['farm']?->id ?? $farmId).'-'.Carbon::parse($from)->format('Y-m-d').'.pdf');
    }

    protected static function count(string $model, string $column, int $farmId, Carbon $from, Carbon $to): int
    {
        return $model::query()
            ->where('user_id', $farmId)
            ->whereBetween($column, [$from->toDateString(), $to->toDateString()])
            ->count();
    }
}
