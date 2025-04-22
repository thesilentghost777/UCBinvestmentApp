<?php

namespace App\Console\Commands;

use App\Models\Investissement;
use App\Models\Tache;
use App\Models\TacheJournaliere;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AssignDailyTasks extends Command
{
    protected $signature = 'tasks:assign-daily';
    protected $description = 'Assigns daily tasks to users based on their investments';

    public function handle()
    {
        $today = Carbon::today();
        Log::info('Cron: GrantDailyPoints a été commencer à ' . now());
        $this->info("Starting daily task assignment for {$today->format('Y-m-d')}");

         // Skip task assignment on weekends
         if ($today->isWeekend()) {
            $this->info("Skipping task assignment - Weekend ({$today->format('l')})");
            return 0;
        }
        // Get users with active investments
        $users = User::whereHas('investissements', function($query) {
            $query->where('statut', 'valide');
        })->get();

        foreach ($users as $user) {
            // Get the earliest investment time for this user
            $firstInvestment = $user->investissements()
                ->where('statut', 'valide')
                ->orderBy('date_initiation', 'asc')
                ->first();

            if (!$firstInvestment) continue;

            // Get current time and first investment creation time
            $currentTime = Carbon::now()->format('H:i:s');
            $investmentTime = Carbon::parse($firstInvestment->date_initiation)->format('H:i:s');

            // Skip if current time is before investment time
            if ($currentTime < $investmentTime) {
                $this->info("Skipping user {$user->id} - current time {$currentTime} is before investment time {$investmentTime}");
                continue;
            }

            // Check for existing tasks today - MODIFICATION ICI
            $existingTasks = TacheJournaliere::where('user_id', $user->id)
                ->whereDate('date_attribution', $today->toDateString())
                ->exists();


            if ($existingTasks) {
                $this->info("Skipping user {$user->id} - tasks already assigned today");
                continue;
            }

            $this->assignTasksForUser($user);
        }

        Log::info('Cron: GrantDailyPoints a été exécutée à ' . now());
        $this->info('Daily task assignment completed');
        return 0;
    }

    /**
     * Assign tasks for a specific user based on their investments
     */
    private function assignTasksForUser(User $user)
{
    $totalTasksAssigned = 0;

    // Récupérer les investissements valides de l'utilisateur
    $investments = $user->investissements()
        ->where('statut', 'valide')
        ->get();

    foreach ($investments as $investment) {
        $package = $investment->package;
        if (!$package) {
            continue;
        }

        // Calculate number of tasks to assign for this investment
        $tasksToAssign = floor($package->gain_journalier / $package->valeur_par_tache);

        if ($tasksToAssign <= 0) {
            continue;
        }

        $this->info("Investment {$investment->id}: Assigning {$tasksToAssign} tasks (gain: {$package->gain_journalier}, value per task: {$package->valeur_par_tache})");
        $assignedForInvestment = $this->assignTasksForInvestment($user, $investment, $tasksToAssign);
        $totalTasksAssigned += $assignedForInvestment;
    }

    return $totalTasksAssigned;
}

    /**
     * Assign a specific number of tasks for an investment
     */
    private function assignTasksForInvestment(User $user, Investissement $investment, int $tasksCount)
    {
        $assignedCount = 0;
        $taskTypes = ['youtube', 'tiktok', 'facebook', 'instagram', 'autre'];
        $assignedTypes = [];

        // First try to assign tasks with valid links (not "a_remplacer")
        $validTasks = Tache::where('statut', true)
            ->where('lien', '!=', 'a_remplacer')
            ->get();

        // Fallback to tasks with "a_remplacer" links if needed
        $fallbackTasks = Tache::where('statut', true)
            ->where('lien', 'a_remplacer')
            ->get();

        // Combine task pools but prioritize valid links
        $taskPool = $validTasks->isNotEmpty() ? $validTasks : $fallbackTasks;

        if ($taskPool->isEmpty()) {
            $this->error("No tasks available in the system!");
            return 0;
        }

        // Group tasks by type for balanced distribution
        $tasksByType = [];
        foreach ($taskTypes as $type) {
            $tasksByType[$type] = $taskPool->where('type', $type)->values();
        }

        // Assign tasks
        while ($assignedCount < $tasksCount) {
            // Determine which type to assign next (prefer types that have been assigned less)
            $nextType = $this->getNextTaskType($assignedTypes, $taskTypes);

            // If there are tasks of this type available
            if (isset($tasksByType[$nextType]) && $tasksByType[$nextType]->isNotEmpty()) {
                // Get a random task of this type
                $taskIndex = rand(0, $tasksByType[$nextType]->count() - 1);
                $task = $tasksByType[$nextType][$taskIndex];

                // Create task assignment
                TacheJournaliere::create([
                    'user_id' => $user->id,
                    'investissement_id' => $investment->id,
                    'tache_id' => $task->id,
                    'date_attribution' => Carbon::today(),
                    'statut' => 'a_faire',
                    'remuneration' => $investment->package->valeur_par_tache
                ]);

                $assignedCount++;
                $assignedTypes[] = $nextType;
                $this->info("Assigned task {$task->id} (type: {$task->type}) to user {$user->id}");
            } else {
                // If no tasks of preferred type, use any available task
                $anyTask = $taskPool->random();
                if ($anyTask) {
                    TacheJournaliere::create([
                        'user_id' => $user->id,
                        'investissement_id' => $investment->id,
                        'tache_id' => $anyTask->id,
                        'date_attribution' => Carbon::today(),
                        'statut' => 'a_faire',
                        'remuneration' => $investment->package->valeur_par_tache
                    ]);

                    $assignedCount++;
                    $assignedTypes[] = $anyTask->type;
                    $this->info("Assigned task {$anyTask->id} (type: {$anyTask->type}) to user {$user->id} (fallback)");
                } else {
                    $this->error("No more tasks available to assign!");
                    break;
                }
            }
        }

        return $assignedCount;
    }

    /**
     * Determine the next task type to assign for balanced distribution
     */
    private function getNextTaskType(array $assignedTypes, array $availableTypes)
    {
        if (empty($assignedTypes)) {
            // If no tasks assigned yet, pick a random type
            return $availableTypes[array_rand($availableTypes)];
        }

        // Count occurrences of each type
        $typeCounts = array_count_values($assignedTypes);

        // Find types that have been used less often
        $minCount = PHP_INT_MAX;
        $candidateTypes = [];

        foreach ($availableTypes as $type) {
            $count = isset($typeCounts[$type]) ? $typeCounts[$type] : 0;

            if ($count < $minCount) {
                $minCount = $count;
                $candidateTypes = [$type];
            } else if ($count === $minCount) {
                $candidateTypes[] = $type;
            }
        }

        // Pick a random type from the candidates
        return $candidateTypes[array_rand($candidateTypes)];
    }
}
