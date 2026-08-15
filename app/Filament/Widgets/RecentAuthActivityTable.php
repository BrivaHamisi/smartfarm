<?php

namespace App\Filament\Widgets;

use App\Models\ActivityLog;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\TableWidget;
use Illuminate\Contracts\View\View;

class RecentAuthActivityTable extends TableWidget
{
    use InteractsWithPageFilters;

    protected function getTableHeading(): string
    {
        return 'Sign-ins and failed attempts';
    }

    public function getColumnSpan(): int | string | array
    {
        return 'full';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ActivityLog::query()
                    ->with(['user', 'farm'])
                    ->filtered($this->filters ?? [])
                    ->whereIn('action', [ActivityLog::ACTION_LOGIN, ActivityLog::ACTION_LOGOUT, ActivityLog::ACTION_FAILED_LOGIN])
            )
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M d, H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('action')
                    ->label('Action')
                    ->sortable(),
            ])
            ->content(fn (): View => view('filament.widgets.console.security'))
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25]);
    }
}
