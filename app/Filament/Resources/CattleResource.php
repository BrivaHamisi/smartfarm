<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CattleResource\Pages;
use App\Filament\Shared\OwnerColumn;
use App\Filament\Shared\OwnerField;
use App\Filament\Shared\OwnerFilter;
use App\Models\Cattle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CattleResource extends Resource
{
    protected static ?string $model = Cattle::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationGroup = 'Livestock';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'cow';

    protected static ?string $pluralModelLabel = 'cattle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                OwnerField::make(),
                Forms\Components\TextInput::make('name')->required()->maxLength(255),
                Forms\Components\TextInput::make('age')->required()->numeric()->minValue(0)->integer(),
                Forms\Components\TextInput::make('weight_kg')->required()->numeric()->minValue(0)->label('Weight (kg)'),
                Forms\Components\TextInput::make('breed')->required()->maxLength(255),
                Forms\Components\Select::make('gender')
                    ->required()
                    ->options(['male' => 'Male', 'female' => 'Female'])
                    ->native(false),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->weight('bold')
                    ->description(fn (Cattle $record): string => $record->breed),
                Tables\Columns\TextColumn::make('gender')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'male' ? 'info' : 'success')
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                Tables\Columns\TextColumn::make('age')
                    ->sortable()
                    ->suffix(' yrs'),
                Tables\Columns\TextColumn::make('weight_kg')
                    ->label('Weight')
                    ->numeric(2)
                    ->suffix(' kg')
                    ->sortable(),
                OwnerColumn::make(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                OwnerFilter::make('user_id'),
                Tables\Filters\SelectFilter::make('gender')->options(['male' => 'Male', 'female' => 'Female']),
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
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCattle::route('/'),
        ];
    }
}
