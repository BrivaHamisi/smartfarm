<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ErrorLog extends Model
{
    use HasFactory;

    public const CREATED_AT = 'created_at';

    public const UPDATED_AT = null;

    protected $fillable = [
        'level',
        'type',
        'message',
        'file',
        'line',
        'url',
        'method',
        'user_id',
        'farm_id',
        'ip_address',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function farm(): BelongsTo
    {
        return $this->belongsTo(User::class, 'farm_id');
    }

    public function scopeFiltered(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['farm_id'] ?? null, fn (Builder $q, $v): Builder => $q->where('farm_id', $v))
            ->when($filters['level'] ?? null, fn (Builder $q, $v): Builder => $q->where('level', $v))
            ->when($filters['from'] ?? null, fn (Builder $q, $v): Builder => $q->whereDate('created_at', '>=', $v))
            ->when($filters['until'] ?? null, fn (Builder $q, $v): Builder => $q->whereDate('created_at', '<=', $v));
    }
}
