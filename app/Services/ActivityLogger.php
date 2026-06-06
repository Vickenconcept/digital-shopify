<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    public function log(
        string $logName,
        string $event,
        string $description,
        ?Model $subject = null,
        ?Model $causer = null,
        array $properties = [],
    ): ?ActivityLog {
        if ($this->shouldSkip()) {
            return null;
        }

        $causer ??= auth()->user();

        return ActivityLog::create([
            'log_name' => $logName,
            'event' => $event,
            'description' => $description,
            'subject_type' => $subject?->getMorphClass(),
            'subject_id' => $subject?->getKey(),
            'causer_type' => $causer?->getMorphClass(),
            'causer_id' => $causer?->getKey(),
            'properties' => $properties ?: null,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent() ? substr(Request::userAgent(), 0, 500) : null,
            'created_at' => now(),
        ]);
    }

    private function shouldSkip(): bool
    {
        return app()->runningInConsole() && !app()->runningUnitTests();
    }
}
