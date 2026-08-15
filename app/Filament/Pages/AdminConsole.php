<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\ActivityLogTable;
use App\Filament\Widgets\ActivityTrendChart;
use App\Filament\Widgets\AdminConsoleStats;
use App\Filament\Widgets\ErrorLogTable;
use App\Filament\Widgets\GlobalFinanceChart;
use App\Filament\Widgets\RecentAuthActivityTable;
use App\Models\ActivityLog;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class AdminConsole extends BaseDashboard
{
    use HasFiltersForm;

    protected static ?string $navigationIcon = 'heroicon-o-server-stack';

    protected static ?string $navigationGroup = 'Super Admin';

    protected static ?int $navigationSort = 1;

    protected static string $routePath = '/admin/console';

    protected static ?string $title = 'Monitoring Console';

    protected static string $view = 'filament.pages.admin-console';

    public static function canAccess(): bool
    {
        return (bool) (auth()->user()?->is_admin);
    }

    public function filtersForm(Form $form): Form
    {
        return $form->schema([
            Section::make()->columns(6)->schema([
                Select::make('farm_id')
                    ->label('Farm')
                    ->options(fn (): array => User::query()->where('role', User::ROLE_OWNER)->orderBy('name')->pluck('name', 'id')->all())
                    ->searchable()
                    ->preload()
                    ->placeholder('All farms'),
                Select::make('user_id')
                    ->label('User')
                    ->options(fn (): array => User::query()->orderBy('name')->pluck('name', 'id')->all())
                    ->searchable()
                    ->preload()
                    ->placeholder('All users'),
                Select::make('action')
                    ->label('Action')
                    ->options(ActivityLog::ACTIONS)
                    ->native(false)
                    ->placeholder('All actions'),
                DatePicker::make('from')->label('From'),
                DatePicker::make('until')->label('Until'),
                Select::make('level')
                    ->label('Error level')
                    ->options([
                        'error' => 'Error',
                        'critical' => 'Critical',
                        'warning' => 'Warning',
                    ])
                    ->native(false)
                    ->placeholder('All levels'),
            ]),
        ]);
    }

    public function getWidgets(): array
    {
        return [
            AdminConsoleStats::class,
            ActivityTrendChart::class,
            GlobalFinanceChart::class,
            ActivityLogTable::class,
            RecentAuthActivityTable::class,
            ErrorLogTable::class,
        ];
    }

    public function getColumns(): int | string | array
    {
        return 4;
    }
}
