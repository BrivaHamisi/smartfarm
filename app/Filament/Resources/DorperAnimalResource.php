<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DorperAnimalResource\Pages;
use App\Filament\Shared\OwnerColumn;
use App\Filament\Shared\OwnerField;
use App\Filament\Shared\OwnerFilter;
use App\Models\DorperAnimal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DorperAnimalResource extends Resource
{
    protected static ?string $model = DorperAnimal::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Dorper';

    protected static ?int $navigationSort = 1;

    protected static ?string $pluralModelLabel = 'dorper animals';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                OwnerField::make(),
                Forms\Components\TextInput::make('tag_number')->label('Tag number')->required()->unique(table: 'dorper_animals', ignoreRecord: true)->maxLength(255),
                Forms\Components\DatePicker::make('date_of_birth')->label('Date of birth')->required(),
                Forms\Components\TextInput::make('breed_lineage')->label('Breed lineage')->required()->maxLength(255),
                Forms\Components\Select::make('gender')
                    ->required()
                    ->options(['ewe' => 'Ewe', 'ram' => 'Ram', 'lamb' => 'Lamb'])
                    ->native(false),
                Forms\Components\TextInput::make('weight_kg')->label('Weight (kg)')->required()->numeric()->minValue(0),
                Forms\Components\Textarea::make('notes')->rows(3),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tag_number')->label('Tag')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('breed_lineage')->label('Lineage')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('gender')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'ewe' => 'success',
                        'ram' => 'info',
                        'lamb' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                Tables\Columns\TextColumn::make('date_of_birth')->label('Born')->date()->sortable(),
                Tables\Columns\TextColumn::make('weight_kg')->label('Weight')->numeric(2)->suffix(' kg')->sortable(),
                OwnerColumn::make(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                OwnerFilter::make('user_id'),
                Tables\Filters\SelectFilter::make('gender')->options(['ewe' => 'Ewe', 'ram' => 'Ram', 'lamb' => 'Lamb']),
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
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageDorperAnimals::route('/'),
        ];
    }
}
