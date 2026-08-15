<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CalfResource\Pages;
use App\Filament\Shared\OwnerColumn;
use App\Filament\Shared\OwnerField;
use App\Filament\Shared\OwnerFilter;
use App\Models\Calf;
use App\Models\Cattle;
use App\Rules\BelongsToUser;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CalfResource extends Resource
{
    protected static ?string $model = Calf::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';

    protected static ?string $navigationGroup = 'Livestock';

    protected static ?int $navigationSort = 2;

    protected static ?string $pluralModelLabel = 'calves';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                OwnerField::make(),
                Forms\Components\Select::make('cow_id')
                    ->label('Mother cow')
                    ->relationship('cattle', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->rules([new BelongsToUser(Cattle::class)]),
                Forms\Components\TextInput::make('name')->required()->maxLength(255),
                Forms\Components\DatePicker::make('dob')->label('Date of birth')->required(),
                Forms\Components\TextInput::make('weight_kg')->label('Weight (kg)')->required()->numeric()->minValue(0),
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
                    ->description(fn (Calf $record): string => $record->breed),
                Tables\Columns\TextColumn::make('cattle.name')->label('Mother cow')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('dob')->label('Born')->date()->sortable(),
                Tables\Columns\TextColumn::make('gender')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'male' ? 'info' : 'success')
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                Tables\Columns\TextColumn::make('weight_kg')->label('Weight')->numeric(2)->suffix(' kg')->sortable(),
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
            ->defaultSort('dob', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCalves::route('/'),
        ];
    }
}
