<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Administration';

    protected static ?int $navigationSort = 1;

    protected static ?string $pluralModelLabel = 'users';

    protected static ?string $modelLabel = 'user';

    /**
     * Non-admins can only create/manage editor accounts of their own farm,
     * so the role and farm are forced regardless of what the form submits.
     */
    public static function normalizeManagedData(array $data): array
    {
        if (! (bool) (auth()->user()?->isAdmin())) {
            $data['role'] = User::ROLE_EDITOR;
            $data['farm_owner_id'] = auth()->id();
        }

        return $data;
    }

    public static function canViewAny(): bool
    {
        return (bool) (auth()->user()?->isAdmin() || auth()->user()?->isOwner());
    }

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();
        $query = parent::getEloquentQuery();

        if ($user?->isAdmin()) {
            return $query;
        }

        if ($user?->isOwner()) {
            return $query
                ->where('role', User::ROLE_EDITOR)
                ->where('farm_owner_id', $user->id);
        }

        return $query->whereRaw('1 = 0');
    }

    public static function form(Form $form): Form
    {
        $isAdmin = (bool) auth()->user()?->isAdmin();

        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required()->maxLength(255),
                Forms\Components\TextInput::make('email')->email()->required()->maxLength(255)->unique(table: 'users', ignoreRecord: true),
                Forms\Components\Select::make('role')
                    ->options([
                        User::ROLE_OWNER => 'Farm owner',
                        User::ROLE_EDITOR => 'Editor',
                        User::ROLE_ADMIN => 'Admin',
                    ])
                    ->default(fn (): string => $isAdmin ? User::ROLE_OWNER : User::ROLE_EDITOR)
                    ->required()
                    ->native(false)
                    ->disabled(fn (): bool => ! $isAdmin)
                    ->dehydrated()
                    ->visible(fn (): bool => $isAdmin),
                Forms\Components\Select::make('farm_owner_id')
                    ->label('Farm')
                    ->options(fn (): array => User::query()->where('role', User::ROLE_OWNER)->orderBy('name')->pluck('name', 'id')->all())
                    ->searchable()
                    ->preload()
                    ->default(fn (): ?int => auth()->user()?->isOwner() ? auth()->id() : null)
                    ->disabled(fn (): bool => ! $isAdmin)
                    ->dehydrated()
                    ->visible(fn (): bool => $isAdmin),
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
                Tables\Columns\TextColumn::make('email')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->sortable()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->colors([
                        'primary' => fn (string $state): bool => $state === User::ROLE_OWNER,
                        'success' => fn (string $state): bool => $state === User::ROLE_ADMIN,
                        'warning' => fn (string $state): bool => $state === User::ROLE_EDITOR,
                    ]),
                Tables\Columns\TextColumn::make('farmOwner.name')->label('Farm')->placeholder('—')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('Joined')->date()->sortable(),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->options([
                        User::ROLE_OWNER => 'Farm owner',
                        User::ROLE_EDITOR => 'Editor',
                        User::ROLE_ADMIN => 'Admin',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->using(function (array $data, Model $record): Model {
                        $record->update(static::normalizeManagedData($data));

                        return $record;
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
