<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CropHarvestResource\Pages;
use App\Filament\Shared\OwnerColumn;
use App\Filament\Shared\OwnerField;
use App\Filament\Shared\OwnerFilter;
use App\Models\CropField;
use App\Models\CropHarvest;
use App\Rules\BelongsToUser;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CropHarvestResource extends Resource
{
    protected static ?string $model = CropHarvest::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $navigationGroup = 'Crops';

    protected static ?int $navigationSort = 3;

    protected static ?string $pluralModelLabel = 'crop harvests';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                OwnerField::make(),
                Forms\Components\Select::make('crop_field_id')
                    ->label('Field')
                    ->relationship('field', 'field_name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->rules([new BelongsToUser(CropField::class)]),
                Forms\Components\DatePicker::make('date')->required()->default(today()),
                Forms\Components\TextInput::make('crop')->required()->maxLength(255),
                Forms\Components\TextInput::make('quantity_harvested')->label('Quantity harvested')->required()->numeric()->minValue(0),
                Forms\Components\TextInput::make('unit')->required()->maxLength(50),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')->date()->sortable(),
                Tables\Columns\TextColumn::make('field.field_name')->label('Field')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('crop')->searchable()->badge()->color('success'),
                Tables\Columns\TextColumn::make('quantity_harvested')->label('Quantity')->numeric(2)->weight('bold')->sortable(),
                Tables\Columns\TextColumn::make('unit'),
                OwnerColumn::make(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                OwnerFilter::make('user_id'),
                Tables\Filters\SelectFilter::make('crop_field_id')
                    ->label('Field')
                    ->relationship('field', 'field_name')
                    ->searchable()
                    ->preload(),
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
            'index' => Pages\ManageCropHarvests::route('/'),
        ];
    }
}
