<?php

namespace App\Filament\Shared;

use App\Models\User;
use Filament\Forms\Components\Select;

class OwnerField
{
    public static function make(): Select
    {
        return Select::make('user_id')
            ->label('Owner')
            ->options(fn () => User::query()->orderBy('name')->pluck('name', 'id'))
            ->searchable()
            ->preload()
            ->default(fn () => auth()->user()?->is_admin ? auth()->id() : null)
            ->disabled(fn (): bool => ! (bool) (auth()->user()?->is_admin))
            ->visible(fn (): bool => (bool) (auth()->user()?->is_admin));
    }
}
