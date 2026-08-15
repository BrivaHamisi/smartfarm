<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * @mixin Model
 */
trait BelongsToUser
{
    protected static function bootBelongsToUser(): void
    {
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->user_id = static::resolveFarmOwnerId();
            }
        });

        static::addGlobalScope('user', function (Builder $builder) {
            if (Auth::check()) {
                $builder->where(
                    $builder->getModel()->getTable() . '.user_id',
                    static::resolveFarmOwnerId()
                );
            }
        });
    }

    protected static function resolveFarmOwnerId(): int
    {
        return session('farm_owner_id', Auth::id());
    }
}