<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DorperBreedingRecordResource\Pages;
use App\Filament\Shared\OwnerColumn;
use App\Filament\Shared\OwnerField;
use App\Filament\Shared\OwnerFilter;
use App\Models\DorperAnimal;
use App\Models\DorperBreedingRecord;
use App\Rules\BelongsToUser;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DorperBreedingRecordResource extends Resource
{
    protected static ?string $model = DorperBreedingRecord::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = 'Dorper';

    protected static ?int $navigationSort = 2;

    protected static ?string $pluralModelLabel = 'dorper breeding records';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                OwnerField::make(),
                Forms\Components\Select::make('ewe_tag')
                    ->label('Ewe tag')
                    ->options(fn () => DorperAnimal::query()->where('gender', 'ewe')->orderBy('tag_number')->pluck('tag_number', 'tag_number'))
                    ->searchable()
                    ->required()
                    ->rules([new BelongsToUser(DorperAnimal::class, 'tag_number')]),
                Forms\Components\Select::make('ram_tag')
                    ->label('Ram tag')
                    ->options(fn () => DorperAnimal::query()->where('gender', 'ram')->orderBy('tag_number')->pluck('tag_number', 'tag_number'))
                    ->searchable()
                    ->required()
                    ->rules([new BelongsToUser(DorperAnimal::class, 'tag_number')]),
                Forms\Components\DatePicker::make('mating_date')->label('Mating date')->required()->default(today()),
                Forms\Components\DatePicker::make('expected_lambing_date')->label('Expected lambing date')->required(),
                Forms\Components\DatePicker::make('lambing_date')->label('Lambing date'),
                Forms\Components\TextInput::make('lambs_born')->label('Lambs born')->numeric()->minValue(0)->integer(),
                Forms\Components\Textarea::make('remarks')->rows(3),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ewe_tag')->label('Ewe')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('ram_tag')->label('Ram')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('mating_date')->label('Mated')->date()->sortable(),
                Tables\Columns\TextColumn::make('expected_lambing_date')->label('Expected lambing')->date()->sortable(),
                Tables\Columns\TextColumn::make('lambing_date')->label('Lambed')->date()->sortable()->placeholder('—'),
                Tables\Columns\TextColumn::make('lambs_born')->label('Born')->numeric()->placeholder('—'),
                Tables\Columns\TextColumn::make('lambing_date')
                    ->label('Status')
                    ->badge()
                    ->state(fn (DorperBreedingRecord $record): string => $record->lambing_date ? 'Lambed' : ($record->expected_lambing_date->isPast() ? 'Overdue' : 'Awaiting'))
                    ->color(fn (string $state): string => match ($state) {
                        'Lambed' => 'success',
                        'Overdue' => 'danger',
                        default => 'warning',
                    }),
                OwnerColumn::make(),
            ])
            ->filters([
                OwnerFilter::make('user_id'),
                Tables\Filters\SelectFilter::make('ewe_tag')->label('Ewe')->options(fn () => DorperAnimal::query()->where('gender', 'ewe')->orderBy('tag_number')->pluck('tag_number', 'tag_number'))->searchable(),
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
            'index' => Pages\ManageDorperBreedingRecords::route('/'),
        ];
    }
}
