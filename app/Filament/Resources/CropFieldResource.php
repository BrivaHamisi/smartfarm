<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CropFieldResource\Pages;
use App\Filament\Shared\OwnerColumn;
use App\Filament\Shared\OwnerField;
use App\Filament\Shared\OwnerFilter;
use App\Models\CropField;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CropFieldResource extends Resource
{
    protected static ?string $model = CropField::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationGroup = 'Crops';

    protected static ?int $navigationSort = 1;

    protected static ?string $pluralModelLabel = 'crop fields';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                OwnerField::make(),
                Forms\Components\TextInput::make('field_name')->label('Field name')->required()->maxLength(255),
                Forms\Components\TextInput::make('crop_planted')->label('Crop planted')->required()->maxLength(255),
                Forms\Components\TextInput::make('acreage')->required()->numeric()->minValue(0)->suffix(' ac'),
                Forms\Components\DatePicker::make('planting_date')->label('Planting date')->required(),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('field_name')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('crop_planted')->label('Crop')->searchable()->badge()->color('success'),
                Tables\Columns\TextColumn::make('acreage')->numeric(2)->suffix(' ac')->sortable(),
                Tables\Columns\TextColumn::make('planting_date')->label('Planted')->date()->sortable(),
                Tables\Columns\TextColumn::make('inputs_count')->label('Inputs')->counts('inputs')->numeric()->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('harvests_count')->label('Harvests')->counts('harvests')->numeric()->sortable()->toggleable(),
                OwnerColumn::make(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                OwnerFilter::make('user_id'),
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
            ->defaultSort('planting_date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCropFields::route('/'),
        ];
    }
}
