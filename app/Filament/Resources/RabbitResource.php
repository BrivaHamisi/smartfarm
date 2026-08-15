<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RabbitResource\Pages;
use App\Filament\Shared\OwnerColumn;
use App\Filament\Shared\OwnerField;
use App\Filament\Shared\OwnerFilter;
use App\Models\Rabbit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RabbitResource extends Resource
{
    protected static ?string $model = Rabbit::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-trending-up';

    protected static ?string $navigationGroup = 'Rabbits';

    protected static ?int $navigationSort = 1;

    protected static ?string $pluralModelLabel = 'rabbits';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                OwnerField::make(),
                Forms\Components\TextInput::make('rabbit_id')->label('Rabbit ID')->required()->unique(table: 'rabbits', ignoreRecord: true)->maxLength(255),
                Forms\Components\TextInput::make('breed')->required()->maxLength(255),
                Forms\Components\Select::make('gender')
                    ->required()
                    ->options(['doe' => 'Doe', 'buck' => 'Buck'])
                    ->native(false),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('rabbit_id')->label('Rabbit ID')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('breed')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('gender')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'doe' ? 'success' : 'info')
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                OwnerColumn::make(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                OwnerFilter::make('user_id'),
                Tables\Filters\SelectFilter::make('gender')->options(['doe' => 'Doe', 'buck' => 'Buck']),
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
            ->defaultSort('rabbit_id');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageRabbits::route('/'),
        ];
    }
}
