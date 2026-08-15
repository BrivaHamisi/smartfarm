<?php

namespace App\Filament\Widgets;

use App\Models\ErrorLog;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\TableWidget;
use Illuminate\Contracts\View\View;

class ErrorLogTable extends TableWidget
{
    use InteractsWithPageFilters;

    protected function getTableHeading(): string
    {
        return 'Error log';
    }

    public function getColumnSpan(): int | string | array
    {
        return 'full';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ErrorLog::query()
                    ->with(['user', 'farm'])
                    ->filtered($this->filters ?? [])
            )
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M d, H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('level')
                    ->label('Level')
                    ->sortable(),
            ])
            ->content(fn (): View => view('filament.widgets.console.error-log'))
            ->filters([
                Tables\Filters\SelectFilter::make('level')
                    ->options([
                        'error' => 'Error',
                        'critical' => 'Critical',
                        'warning' => 'Warning',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50]);
    }
}
