<?php

namespace App\Filament\Widgets;

use App\Filament\Shared\OwnerColumn;
use App\Filament\Widgets\Concerns\AppliesPageFilters;
use App\Models\Finances;
use App\Support\PeriodFilter;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\TableWidget;

class FarmReportTransactions extends TableWidget
{
    use AppliesPageFilters;
    use InteractsWithPageFilters;

    protected function getTableHeading(): string
    {
        return 'Transactions in period';
    }

    public function table(Table $table): Table
    {
        [$from, $until] = PeriodFilter::resolve($this->filters ?? []);

        return $table
            ->query(
                Finances::query()
                    ->with('user')
                    ->when($this->resolveFarmId(), fn ($query, $farmId) => $query->where('user_id', $farmId))
                    ->whereDate('date', '>=', $from)
                    ->whereDate('date', '<=', $until)
            )
            ->columns([
                Tables\Columns\TextColumn::make('date')->date()->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'income' ? 'success' : 'danger')
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(fn (string $state): string => str_replace('_', ' ', ucfirst($state))),
                Tables\Columns\TextColumn::make('amount')
                    ->money('KES')
                    ->weight('bold')
                    ->color(fn (Finances $record): string => $record->type === 'income' ? 'success' : 'danger')
                    ->sortable(),
                Tables\Columns\TextColumn::make('source')->label('Source / paid to')->searchable()->placeholder('—'),
                OwnerColumn::make(),
            ])
            ->defaultSort('date', 'desc')
            ->paginated([10, 25, 50]);
    }
}
