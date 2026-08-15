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
            $user = Auth::user();

            if ($user && ! $user->is_admin) {
                $model->user_id = static::resolveFarmOwnerId();
            }
        });

        static::addGlobalScope('user', function (Builder $builder) {
            $user = Auth::user();

            if ($user && ! $user->is_admin) {
                $builder->where(
                    $builder->getModel()->getTable().'.user_id',
                    static::resolveFarmOwnerId()
                );
            }
        });
    }

    protected static function resolveFarmOwnerId(): int
    {
        return session('farm_owner_id', Auth::id());
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
