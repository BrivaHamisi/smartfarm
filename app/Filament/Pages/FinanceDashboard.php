<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\FinanceSummaryStats;
use App\Filament\Widgets\FinanceTrendChart;
use App\Filament\Widgets\RecentFinanceTransactions;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class FinanceDashboard extends BaseDashboard
{
    use HasFiltersForm;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationGroup = 'Finance & Reports';

    protected static ?int $navigationSort = 1;

    protected static string $routePath = '/finance';

    protected static ?string $title = 'Finance Dashboard';

    public static function canAccess(): bool
    {
        return ! (bool) (auth()->user()?->isEditor());
    }

    public function getSubheading(): ?string
    {
        return 'Financial position across the selected period';
    }

    public function filtersForm(Form $form): Form
    {
        return $form->schema([
            Section::make()->columns(4)->schema([
                Select::make('farm_id')
                    ->label('Farm')
                    ->options(fn (): array => User::query()->where('role', User::ROLE_OWNER)->orderBy('name')->pluck('name', 'id')->all())
                    ->searchable()
                    ->preload()
                    ->placeholder('All farms')
                    ->visible(fn (): bool => (bool) (auth()->user()?->is_admin)),
                DatePicker::make('from')->label('From'),
                DatePicker::make('until')->label('Until'),
                Select::make('type')
                    ->label('Type')
                    ->options(['income' => 'Income', 'expense' => 'Expense'])
                    ->native(false)
                    ->placeholder('All types'),
            ]),
        ]);
    }

    public function getWidgets(): array
    {
        return [
            FinanceSummaryStats::class,
            FinanceTrendChart::class,
            RecentFinanceTransactions::class,
        ];
    }

    public function getColumns(): int | string | array
    {
        return 4;
    }
}
