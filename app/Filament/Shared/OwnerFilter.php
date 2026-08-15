<?php

namespace App\Filament\Shared;

use App\Models\User;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class OwnerFilter extends SelectFilter
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label('Owner')
            ->options(fn () => User::query()->orderBy('name')->pluck('name', 'id'))
            ->searchable()
            ->preload()
            ->visible(fn (): bool => (bool) (auth()->user()?->is_admin))
            ->query(function (Builder $query, array $data): Builder {
                if (! (bool) (auth()->user()?->is_admin) || blank($data['value'] ?? null)) {
                    return $query;
                }

                return $query->where($query->getModel()->getTable().'.user_id', $data['value']);
            });
    }
}
