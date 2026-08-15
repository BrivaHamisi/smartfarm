<?php

namespace App\Listeners;

use App\Models\ActivityLog;
use App\Support\Activity;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;

class RecordAuthActivity
{
    public function onLogin(Login $event): void
    {
        Activity::record(
            ActivityLog::ACTION_LOGIN,
            'Signed in',
            $event->user,
            $event->user->farmId(),
            $event->user::class,
            $event->user->id,
        );
    }

    public function onLogout(Logout $event): void
    {
        Activity::record(
            ActivityLog::ACTION_LOGOUT,
            'Signed out',
            $event->user,
            $event->user->farmId(),
            $event->user::class,
            $event->user->id,
        );
    }

    public function onFailed(Failed $event): void
    {
        $email = data_get($event->credentials, 'email');

        Activity::record(
            ActivityLog::ACTION_FAILED_LOGIN,
            $email ? "Failed sign-in attempt for {$email}" : 'Failed sign-in attempt',
            null,
            null,
            null,
            null,
        );
    }

    public function onRegistered(Registered $event): void
    {
        Activity::record(
            ActivityLog::ACTION_REGISTERED,
            'Created an account',
            $event->user,
            $event->user->farmId(),
            $event->user::class,
            $event->user->id,
        );
    }

    public function onPasswordReset(PasswordReset $event): void
    {
        Activity::record(
            ActivityLog::ACTION_PASSWORD_RESET,
            'Reset password',
            $event->user,
            $event->user->farmId(),
            $event->user::class,
            $event->user->id,
        );
    }
}
