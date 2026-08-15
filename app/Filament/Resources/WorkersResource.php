<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkersResource\Pages;
use App\Filament\Shared\OwnerColumn;
use App\Filament\Shared\OwnerField;
use App\Filament\Shared\OwnerFilter;
use App\Models\Workers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WorkersResource extends Resource
{
    protected static ?string $model = Workers::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Farm Operations';

    protected static ?int $navigationSort = 1;

    protected static ?string $pluralModelLabel = 'workers';

    public static function canViewAny(): bool
    {
        return ! (bool) (auth()->user()?->isEditor());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                OwnerField::make(),
                Forms\Components\TextInput::make('name')->required()->maxLength(255),
                Forms\Components\TextInput::make('position')->required()->maxLength(255),
                Forms\Components\TextInput::make('email')->email()->required()->maxLength(255)->unique(table: 'workers', ignoreRecord: true),
                Forms\Components\TextInput::make('phone')->tel()->maxLength(255),
                Forms\Components\TextInput::make('salary')->numeric()->minValue(0)->prefix('KSh '),
                Forms\Components\DatePicker::make('employment_date')->label('Employment date')->required(),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->maxLength(255)
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->mutateDehydratedStateUsing(fn (string $state): string => bcrypt($state)),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('position')->searchable()->badge()->color('gray'),
                Tables\Columns\TextColumn::make('phone')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('salary')->money('KES')->sortable(),
                Tables\Columns\TextColumn::make('employment_date')->label('Employed')->date()->sortable(),
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
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageWorkers::route('/'),
        ];
    }
}
