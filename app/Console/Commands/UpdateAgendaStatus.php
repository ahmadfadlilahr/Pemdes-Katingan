<?php

namespace App\Console\Commands;

use App\Models\Agenda;
use Illuminate\Console\Command;

class UpdateAgendaStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'agenda:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update agenda status automatically based on current date and time';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating agenda statuses...');

        // Update statuses
        Agenda::updateStatuses();

        // Get statistics
        $ongoing = Agenda::where('status', 'ongoing')->count();
        $completed = Agenda::where('status', 'completed')->count();
        $scheduled = Agenda::where('status', 'scheduled')->count();

        $this->info("Status updated successfully!");
        $this->info("- Ongoing: {$ongoing}");
        $this->info("- Completed: {$completed}");
        $this->info("- Scheduled: {$scheduled}");

        return Command::SUCCESS;
    }
}
