<?php

namespace App\Filament\Widgets;

use App\Models\ActivityLog;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\TableWidget;

class RecentAuthActivityTable extends TableWidget
{
    use InteractsWithPageFilters;

    protected function getTableHeading(): string
    {
        return 'Sign-ins and failed attempts';
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
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('action')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'failed_login' => 'danger',
                        'login' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ActivityLog::ACTIONS[$state] ?? ucfirst($state)),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->badge()
                    ->color('gray')
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('farm.name')
                    ->label('Farm')
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('description')->limit(60),
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP')
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25]);
    }
}
