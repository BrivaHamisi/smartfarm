<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CropInputResource\Pages;
use App\Filament\Shared\OwnerColumn;
use App\Filament\Shared\OwnerField;
use App\Filament\Shared\OwnerFilter;
use App\Models\CropField;
use App\Models\CropInput;
use App\Rules\BelongsToUser;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CropInputResource extends Resource
{
    protected static ?string $model = CropInput::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';

    protected static ?string $navigationGroup = 'Crops';

    protected static ?int $navigationSort = 2;

    protected static ?string $pluralModelLabel = 'crop inputs';

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
                Forms\Components\Select::make('type')
                    ->required()
                    ->options(['fertilizer' => 'Fertilizer', 'pesticide' => 'Pesticide', 'herbicide' => 'Herbicide', 'other' => 'Other'])
                    ->native(false),
                Forms\Components\TextInput::make('brand_name')->label('Brand / product')->required()->maxLength(255),
                Forms\Components\TextInput::make('quantity')->required()->numeric()->minValue(0),
                Forms\Components\TextInput::make('unit')->required()->maxLength(50)->default('kg'),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')->date()->sortable(),
                Tables\Columns\TextColumn::make('field.field_name')->label('Field')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'fertilizer' => 'success',
                        'pesticide' => 'danger',
                        'herbicide' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                Tables\Columns\TextColumn::make('brand_name')->label('Product')->searchable(),
                Tables\Columns\TextColumn::make('quantity')->numeric(2)->sortable(),
                Tables\Columns\TextColumn::make('unit'),
                OwnerColumn::make(),
            ])
            ->filters([
                OwnerFilter::make('user_id'),
                Tables\Filters\SelectFilter::make('crop_field_id')
                    ->label('Field')
                    ->relationship('field', 'field_name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('type')->options(['fertilizer' => 'Fertilizer', 'pesticide' => 'Pesticide', 'herbicide' => 'Herbicide', 'other' => 'Other']),
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
            'index' => Pages\ManageCropInputs::route('/'),
        ];
    }
}
