<?php

namespace App\Console\Commands;

use App\Models\ActivityLog;
use Illuminate\Console\Command;

class CleanOldActivityLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activity-log:clean {--days=30 : Number of days to keep}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean activity logs older than specified days (default: 30 days)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = (int) $this->option('days');

        $this->info("Cleaning activity logs older than {$days} days...");

        $count = ActivityLog::deleteOlderThan($days);

        if ($count > 0) {
            $this->info("✓ Successfully deleted {$count} old activity log(s).");
        } else {
            $this->info("No old activity logs to delete.");
        }

        return Command::SUCCESS;
    }
}

