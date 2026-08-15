<?php

namespace App\Filament\Shared;

use Filament\Tables\Columns\TextColumn;

class OwnerColumn
{
    public static function make(): TextColumn
    {
        return TextColumn::make('user.name')
            ->label('Owner')
            ->badge()
            ->color('gray')
            ->sortable()
            ->toggleable()
            ->visible(fn (): bool => (bool) (auth()->user()?->is_admin));
    }
}
