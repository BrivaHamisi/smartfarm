<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PoultryResource\Pages;
use App\Filament\Shared\OwnerColumn;
use App\Filament\Shared\OwnerField;
use App\Filament\Shared\OwnerFilter;
use App\Models\Poultry;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PoultryResource extends Resource
{
    protected static ?string $model = Poultry::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    protected static ?string $navigationGroup = 'Poultry';

    protected static ?string $slug = 'poultry';

    protected static ?string $pluralModelLabel = 'poultry records';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                OwnerField::make(),
                Forms\Components\DatePicker::make('date')->required()->default(today()),
                Forms\Components\TextInput::make('chicken_count')->label('Chicken count')->required()->numeric()->minValue(0)->integer(),
                Forms\Components\TextInput::make('mortalities')->required()->numeric()->minValue(0)->integer()->default(0),
                Forms\Components\TextInput::make('eggs_produced')->label('Eggs produced')->required()->numeric()->minValue(0)->integer(),
                Forms\Components\TextInput::make('eggs_sold')->label('Eggs sold')->required()->numeric()->minValue(0)->integer(),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')->date()->sortable(),
                Tables\Columns\TextColumn::make('chicken_count')->label('Chickens')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('mortalities')
                    ->numeric()
                    ->color(fn (int $state): ?string => $state > 0 ? 'danger' : null),
                Tables\Columns\TextColumn::make('eggs_produced')->label('Eggs produced')->numeric()->sortable()->color('warning'),
                Tables\Columns\TextColumn::make('eggs_sold')->label('Eggs sold')->numeric()->sortable(),
                OwnerColumn::make(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                OwnerFilter::make('user_id'),
                Tables\Filters\Filter::make('date')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('From'),
                        Forms\Components\DatePicker::make('until')->label('Until'),
                    ])
                    ->query(function (Table $table, array $data): \Illuminate\Database\Eloquent\Builder {
                        return $table->getQuery()
                            ->when($data['from'], fn ($query, $date) => $query->whereDate('date', '>=', $date))
                            ->when($data['until'], fn ($query, $date) => $query->whereDate('date', '<=', $date));
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePoultryRecords::route('/'),
        ];
    }
}
