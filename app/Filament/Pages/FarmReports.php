<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\FarmReportSummary;
use App\Filament\Widgets\FarmReportTransactions;
use App\Models\User;
use App\Services\FarmReportService;
use App\Support\PeriodFilter;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class FarmReports extends BaseDashboard
{
    use HasFiltersForm;

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    protected static ?string $navigationGroup = 'Finance & Reports';

    protected static ?int $navigationSort = 3;

    protected static string $routePath = '/reports';

    protected static ?string $title = 'Farm Reports';

    public static function canAccess(): bool
    {
        return ! (bool) (auth()->user()?->isEditor());
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
                    ->required(fn (): bool => (bool) (auth()->user()?->isAdmin()))
                    ->visible(fn (): bool => (bool) (auth()->user()?->is_admin)),
                Select::make('period')
                    ->label('Period')
                    ->options(PeriodFilter::presets())
                    ->default('this_month')
                    ->native(false)
                    ->live(),
                DatePicker::make('from')->label('From'),
                DatePicker::make('until')->label('Until'),
            ]),
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('download_pdf')
                ->label('Generate PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(function (): mixed {
                    $user = auth()->user();
                    $farmId = $user?->isAdmin()
                        ? (int) ($this->filters['farm_id'] ?? 0)
                        : (int) ($user?->farmId() ?? 0);

                    if (! $farmId) {
                        Notification::make()
                            ->title('Select a farm to generate a report')
                            ->warning()
                            ->send();

                        return null;
                    }

                    [$from, $until] = PeriodFilter::resolve($this->filters);

                    return FarmReportService::download($farmId, $from, $until);
                }),
        ];
    }

    public function getWidgets(): array
    {
        return [
            FarmReportSummary::class,
            FarmReportTransactions::class,
        ];
    }

    public function getColumns(): int | string | array
    {
        return 4;
    }
}
