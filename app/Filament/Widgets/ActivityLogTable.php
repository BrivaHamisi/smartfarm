<?php

namespace App\Filament\Widgets;

use App\Models\ActivityLog;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\TableWidget;

class ActivityLogTable extends TableWidget
{
    use InteractsWithPageFilters;

    protected function getTableHeading(): string
    {
        return 'Recent activity';
    }

    protected function getTableColumnSpan(): int | string | array
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
            )
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->badge()
                    ->color('gray')
                    ->placeholder('Guest / system'),
                Tables\Columns\TextColumn::make('action')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'deleted' => 'danger',
                        'failed_login' => 'warning',
                        'login', 'registered', 'invoice_generated' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ActivityLog::ACTIONS[$state] ?? ucfirst($state))
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->limit(60)
                    ->tooltip(fn (Tables\Columns\TextColumn $column): ?string => $column->getState()),
                Tables\Columns\TextColumn::make('farm.name')
                    ->label('Farm')
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP')
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('action')
                    ->options(ActivityLog::ACTIONS),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50]);
    }
}
