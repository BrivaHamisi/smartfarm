<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Support\Activity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuditObserver
{
    public function created(Model $model): void
    {
        $this->log($model, ActivityLog::ACTION_CREATED);
    }

    public function updated(Model $model): void
    {
        $this->log($model, ActivityLog::ACTION_UPDATED);
    }

    public function deleted(Model $model): void
    {
        $this->log($model, ActivityLog::ACTION_DELETED);
    }

    protected function log(Model $model, string $action): void
    {
        $user = Auth::user();

        if (! $user) {
            return;
        }

        Activity::record(
            $action,
            sprintf(
                '%s %s',
                Str::headline(Str::snake(class_basename($model))),
                '#'.$model->getKey()
            ),
            $user,
            (int) ($model->user_id ?? $user->farmId() ?? $user->id),
            $model::class,
            $model->getKey(),
        );
    }
}
