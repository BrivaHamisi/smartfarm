<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    use HasFactory;

    public const ACTION_CREATED = 'created';

    public const ACTION_UPDATED = 'updated';

    public const ACTION_DELETED = 'deleted';

    public const ACTION_LOGIN = 'login';

    public const ACTION_LOGOUT = 'logout';

    public const ACTION_FAILED_LOGIN = 'failed_login';

    public const ACTION_REGISTERED = 'registered';

    public const ACTION_PASSWORD_RESET = 'password_reset';

    public const ACTION_INVOICE_GENERATED = 'invoice_generated';

    public const ACTION_REPORT_GENERATED = 'report_generated';

    public const ACTIONS = [
        'login' => 'Login',
        'logout' => 'Logout',
        'failed_login' => 'Failed login',
        'registered' => 'Registration',
        'password_reset' => 'Password reset',
        'created' => 'Created',
        'updated' => 'Updated',
        'deleted' => 'Deleted',
        'invoice_generated' => 'Invoice generated',
        'report_generated' => 'Report generated',
    ];

    public const CREATED_AT = 'created_at';

    public const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'farm_id',
        'action',
        'subject_type',
        'subject_id',
        'description',
        'ip_address',
        'user_agent',
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
            ->when($filters['user_id'] ?? null, fn (Builder $q, $v): Builder => $q->where('user_id', $v))
            ->when($filters['action'] ?? null, fn (Builder $q, $v): Builder => $q->where('action', $v))
            ->when($filters['from'] ?? null, fn (Builder $q, $v): Builder => $q->whereDate('created_at', '>=', $v))
            ->when($filters['until'] ?? null, fn (Builder $q, $v): Builder => $q->whereDate('created_at', '<=', $v));
    }
}
