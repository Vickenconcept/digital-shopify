<?php

namespace App\Console\Commands;

use App\Models\ActivityLog;
use App\Models\SiteSetting;
use Illuminate\Console\Command;

class PruneActivityLogsCommand extends Command
{
    protected $signature = 'activity-logs:prune {--days= : Days to retain (overrides site setting)}';

    protected $description = 'Delete activity log entries older than the retention period';

    public function handle(): int
    {
        $days = (int) ($this->option('days')
            ?? SiteSetting::first()?->audit_log_retention_days
            ?? config('shop.audit_log_retention_days', 90));

        if ($days <= 0) {
            $this->info('Activity log retention is disabled (0 days). Nothing pruned.');

            return self::SUCCESS;
        }

        $cutoff = now()->subDays($days);
        $deleted = ActivityLog::where('created_at', '<', $cutoff)->delete();

        $this->info("Pruned {$deleted} activity log entries older than {$days} days (before {$cutoff->toDateString()}).");

        return self::SUCCESS;
    }
}
