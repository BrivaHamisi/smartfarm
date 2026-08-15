<?php

namespace App\Support;

use App\Models\ErrorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class ErrorLogRecorder
{
    public static function record(Throwable $e, ?Request $request = null): ?ErrorLog
    {
        try {
            $request ??= request();
            $user = Auth::user();

            return ErrorLog::create([
                'level' => 'error',
                'type' => class_basename($e),
                'message' => substr($e->getMessage() ?: get_class($e), 0, 1000),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'url' => $request?->fullUrl(),
                'method' => $request?->method(),
                'user_id' => $user?->id,
                'farm_id' => $user?->farmId(),
                'ip_address' => $request?->ip(),
            ]);
        } catch (Throwable) {
            return null;
        }
    }
}
