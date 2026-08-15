<?php

namespace App\Support;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Activity
{
    public static function record(
        string $action,
        ?string $description = null,
        ?User $user = null,
        ?int $farmId = null,
        ?string $subjectType = null,
        ?int $subjectId = null,
    ): ?ActivityLog {
        $user ??= Auth::user();

        try {
            return ActivityLog::create([
                'user_id' => $user?->id,
                'farm_id' => $farmId ?? $user?->farmId(),
                'action' => $action,
                'subject_type' => $subjectType,
                'subject_id' => $subjectId,
                'description' => $description ? substr($description, 0, 500) : null,
                'ip_address' => request()?->ip(),
                'user_agent' => $userAgent = substr((string) request()?->userAgent(), 0, 255) ?: null,
            ]);
        } catch (\Throwable) {
            // Audit logging must never break the request it observes.
            return null;
        }
    }
}
