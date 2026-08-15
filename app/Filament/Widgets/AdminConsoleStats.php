<?php

namespace App\Filament\Widgets;

use App\Models\ActivityLog;
use App\Models\ErrorLog;
use App\Models\Invoice;
use App\Models\User;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminConsoleStats extends BaseWidget
{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        $farmId = $this->filters['farm_id'] ?? null;
        $today = now()->toDateString();
        $sevenDaysAgo = now()->subDays(7)->toDateString();

        return [
            Stat::make('Farms', number_format(User::query()->where('role', User::ROLE_OWNER)->count()))
                ->description('registered owner farms')
                ->icon('heroicon-o-building-library')
                ->color('primary'),
            Stat::make('Registered users', number_format(User::query()->count()))
                ->description('owners, editors and admins')
                ->icon('heroicon-o-users')
                ->color('info'),
            Stat::make('Logins today', number_format(ActivityLog::query()
                ->when($farmId, fn ($q, $v) => $q->where('farm_id', $v))
                ->where('action', ActivityLog::ACTION_LOGIN)
                ->whereDate('created_at', $today)
                ->count()))
                ->description($today)
                ->icon('heroicon-o-key')
                ->color('success'),
            Stat::make('Failed logins', number_format(ActivityLog::query()
                ->when($farmId, fn ($q, $v) => $q->where('farm_id', $v))
                ->where('action', ActivityLog::ACTION_FAILED_LOGIN)
                ->whereDate('created_at', '>=', $sevenDaysAgo)
                ->count()))
                ->description('last 7 days')
                ->icon('heroicon-o-exclamation-triangle')
                ->color('warning'),
            Stat::make('Invoices', number_format(Invoice::query()->count()))
                ->description(number_format(Invoice::query()->where('status', Invoice::STATUS_PAID)->count()).' paid')
                ->icon('heroicon-o-receipt-percent')
                ->color('gray'),
            Stat::make('Errors', number_format(ErrorLog::query()
                ->when($farmId, fn ($q, $v) => $q->where('farm_id', $v))
                ->whereDate('created_at', '>=', $sevenDaysAgo)
                ->count()))
                ->description('last 7 days')
                ->icon('heroicon-o-exclamation-circle')
                ->color('danger'),
        ];
    }
}
