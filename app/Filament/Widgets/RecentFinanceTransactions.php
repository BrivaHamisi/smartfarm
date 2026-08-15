<?php

namespace App\Filament\Widgets;

use App\Filament\Shared\OwnerColumn;
use App\Filament\Widgets\Concerns\AppliesPageFilters;
use App\Models\Finances;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\TableWidget;

class RecentFinanceTransactions extends TableWidget
{
    use AppliesPageFilters;
    use InteractsWithPageFilters;

    protected function getTableHeading(): string
    {
        return 'Transactions';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Finances::query()
                    ->with('user')
                    ->when($this->resolveFarmId(), fn ($query, $farmId) => $query->where('user_id', $farmId))
                    ->when($this->filterFrom(), fn ($query, $date) => $query->whereDate('date', '>=', $date))
                    ->when($this->filterUntil(), fn ($query, $date) => $query->whereDate('date', '<=', $date))
                    ->when($this->filters['type'] ?? null, fn ($query, $type) => $query->where('type', $type))
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
                Tables\Columns\TextColumn::make('description')->searchable()->placeholder('—')->toggleable(),
                OwnerColumn::make(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')->options(['income' => 'Income', 'expense' => 'Expense']),
                Tables\Filters\SelectFilter::make('category')->options([
                    'feeds' => 'Feeds',
                    'medication' => 'Medication',
                    'human_resource' => 'Human resource',
                    'sales' => 'Sales',
                    'dorper' => 'Dorper',
                    'crops' => 'Crops',
                    'rabbits' => 'Rabbits',
                    'other' => 'Other',
                ]),
            ])
            ->defaultSort('date', 'desc')
            ->paginated([10, 25, 50]);
    }
}
