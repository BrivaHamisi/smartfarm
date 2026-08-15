<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CheckupResource\Pages;
use App\Filament\Shared\OwnerColumn;
use App\Filament\Shared\OwnerField;
use App\Filament\Shared\OwnerFilter;
use App\Models\Cattle;
use App\Models\Checkup;
use App\Rules\BelongsToUser;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CheckupResource extends Resource
{
    protected static ?string $model = Checkup::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationGroup = 'Livestock';

    protected static ?int $navigationSort = 5;

    protected static ?string $pluralModelLabel = 'checkups';

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
                Forms\Components\Select::make('type')
                    ->required()
                    ->options(['deworming' => 'Deworming', 'health_check' => 'Health check'])
                    ->native(false),
                Forms\Components\Toggle::make('is_completed')->label('Completed')->inline(false)->default(false),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')->date()->sortable(),
                Tables\Columns\TextColumn::make('cow.name')->label('Cow')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'deworming' ? 'warning' : 'info')
                    ->formatStateUsing(fn (string $state): string => $state === 'deworming' ? 'Deworming' : 'Health check'),
                Tables\Columns\IconColumn::make('is_completed')
                    ->label('Completed')
                    ->boolean()
                    ->sortable(),
                OwnerColumn::make(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                OwnerFilter::make('user_id'),
                Tables\Filters\SelectFilter::make('type')->options(['deworming' => 'Deworming', 'health_check' => 'Health check']),
                Tables\Filters\TernaryFilter::make('is_completed')
                    ->label('Completed')
                    ->trueLabel('Completed')
                    ->falseLabel('Open'),
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
            'index' => Pages\ManageCheckups::route('/'),
        ];
    }
}
