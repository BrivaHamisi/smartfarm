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

            if (! $user) {
                return;
            }

            // Admins without an active "view as farm" keep the farm they
            // selected in the form; otherwise the farm is resolved.
            if ($user->isAdmin() && ! session('farm_owner_id')) {
                return;
            }

            $model->user_id = static::resolveFarmOwnerId();
        });

        static::addGlobalScope('user', function (Builder $builder) {
            $user = Auth::user();

            if (! $user) {
                return;
            }

            // Admins see every farm unless they are viewing as a specific farm.
            if ($user->isAdmin()) {
                $farmOwnerId = session('farm_owner_id');

                if ($farmOwnerId) {
                    $builder->where($builder->getModel()->getTable().'.user_id', (int) $farmOwnerId);
                }

                return;
            }

            $builder->where(
                $builder->getModel()->getTable().'.user_id',
                static::resolveFarmOwnerId()
            );
        });
    }

    protected static function resolveFarmOwnerId(): int
    {
        $user = Auth::user();

        if (! $user) {
            return 0;
        }

        if ($user->isAdmin()) {
            return (int) session('farm_owner_id', $user->id);
        }

        return (int) ($user->farmId() ?? $user->id);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
