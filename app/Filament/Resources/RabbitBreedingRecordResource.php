<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RabbitBreedingRecordResource\Pages;
use App\Filament\Shared\OwnerColumn;
use App\Filament\Shared\OwnerField;
use App\Filament\Shared\OwnerFilter;
use App\Models\Rabbit;
use App\Models\RabbitBreedingRecord;
use App\Rules\BelongsToUser;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RabbitBreedingRecordResource extends Resource
{
    protected static ?string $model = RabbitBreedingRecord::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    protected static ?string $navigationGroup = 'Rabbits';

    protected static ?int $navigationSort = 2;

    protected static ?string $pluralModelLabel = 'rabbit breeding records';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                OwnerField::make(),
                Forms\Components\Select::make('doe_id')
                    ->label('Doe')
                    ->options(fn () => Rabbit::query()->where('gender', 'doe')->orderBy('rabbit_id')->pluck('rabbit_id', 'rabbit_id'))
                    ->searchable()
                    ->required()
                    ->rules([new BelongsToUser(Rabbit::class, 'rabbit_id')]),
                Forms\Components\Select::make('buck_id')
                    ->label('Buck')
                    ->options(fn () => Rabbit::query()->where('gender', 'buck')->orderBy('rabbit_id')->pluck('rabbit_id', 'rabbit_id'))
                    ->searchable()
                    ->required()
                    ->rules([new BelongsToUser(Rabbit::class, 'rabbit_id')]),
                Forms\Components\DatePicker::make('mating_date')->label('Mating date')->required()->default(today()),
                Forms\Components\DatePicker::make('expected_kindling_date')->label('Expected kindling date')->required(),
                Forms\Components\TextInput::make('litter_size')->label('Litter size')->numeric()->minValue(0)->integer(),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('doe_id')->label('Doe')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('buck_id')->label('Buck')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('mating_date')->label('Mated')->date()->sortable(),
                Tables\Columns\TextColumn::make('expected_kindling_date')->label('Expected kindling')->date()->sortable(),
                Tables\Columns\TextColumn::make('litter_size')->label('Litter')->numeric()->placeholder('—'),
                Tables\Columns\TextColumn::make('expected_kindling_date')
                    ->label('Status')
                    ->badge()
                    ->state(fn (RabbitBreedingRecord $record): string => filled($record->litter_size) ? 'Kindled' : ($record->expected_kindling_date->isPast() ? 'Overdue' : 'Awaiting'))
                    ->color(fn (string $state): string => match ($state) {
                        'Kindled' => 'success',
                        'Overdue' => 'danger',
                        default => 'warning',
                    }),
                OwnerColumn::make(),
            ])
            ->filters([
                OwnerFilter::make('user_id'),
                Tables\Filters\SelectFilter::make('doe_id')->label('Doe')->options(fn () => Rabbit::query()->where('gender', 'doe')->orderBy('rabbit_id')->pluck('rabbit_id', 'rabbit_id'))->searchable(),
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
            ->defaultSort('mating_date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageRabbitBreedingRecords::route('/'),
        ];
    }
}
