<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InseminationResource\Pages;
use App\Filament\Shared\OwnerColumn;
use App\Filament\Shared\OwnerField;
use App\Filament\Shared\OwnerFilter;
use App\Models\Cattle;
use App\Models\Insemination;
use App\Rules\BelongsToUser;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InseminationResource extends Resource
{
    protected static ?string $model = Insemination::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    protected static ?string $navigationGroup = 'Livestock';

    protected static ?int $navigationSort = 4;

    protected static ?string $pluralModelLabel = 'inseminations';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                OwnerField::make(),
                Forms\Components\Select::make('cow_id')
                    ->label('Cow')
                    ->relationship('cow', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->rules([new BelongsToUser(Cattle::class)]),
                Forms\Components\DatePicker::make('date')->required()->default(today()),
                Forms\Components\TextInput::make('bull_number')->label('Bull / semen tag')->required()->maxLength(255),
                Forms\Components\Toggle::make('successful')->label('Successful')->inline(false),
                Forms\Components\DatePicker::make('expected_dob')->label('Expected calving date'),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')->date()->sortable(),
                Tables\Columns\TextColumn::make('cow.name')->label('Cow')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('bull_number')->label('Bull / semen tag')->searchable(),
                Tables\Columns\TextColumn::make('successful')
                    ->label('Result')
                    ->badge()
                    ->color(fn (?bool $state): string => match ($state) {
                        true => 'success',
                        false => 'danger',
                        null => 'warning',
                    })
                    ->formatStateUsing(fn (?bool $state): string => match ($state) {
                        true => 'Successful',
                        false => 'Failed',
                        null => 'Pending',
                    }),
                Tables\Columns\TextColumn::make('expected_dob')->label('Expected calving')->date()->sortable()->placeholder('—'),
                OwnerColumn::make(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                OwnerFilter::make('user_id'),
                Tables\Filters\SelectFilter::make('cow_id')
                    ->label('Cow')
                    ->relationship('cow', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\TernaryFilter::make('result')
                    ->attribute('successful')
                    ->label('Result')
                    ->trueLabel('Pending')
                    ->falseLabel('Has result')
                    ->queries(
                        true: fn ($query) => $query->whereNull('successful'),
                        false: fn ($query) => $query->whereNotNull('successful'),
                    ),
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
            'index' => Pages\ManageInseminations::route('/'),
        ];
    }
}
