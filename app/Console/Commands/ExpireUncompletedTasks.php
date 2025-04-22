<?php

namespace App\Console\Commands;

use App\Models\TacheJournaliere;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ExpireUncompletedTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:expire-uncompleted';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire uncompleted tasks from previous days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $yesterday = Carbon::yesterday();

        $this->info("Expiring uncompleted tasks from {$yesterday->format('Y-m-d')}");

        // Find all uncompleted tasks from yesterday
        $tasks = TacheJournaliere::whereDate('date_attribution', $yesterday)
            ->where('statut', 'a_faire')
            ->get();

        $count = $tasks->count();
        $this->info("Found {$count} uncompleted tasks to expire");

        foreach ($tasks as $task) {
            $task->update(['statut' => 'expiree']);
        }

        $this->info("Successfully expired {$count} tasks");

        return 0;
    }
}
