<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Planification des tâches
Schedule::command('tasks:assign-daily')
    ->everyMinute() // Changé pour tester plus facilement
    ->timezone('UTC')
    ->onOneServer()
    ->appendOutputTo(storage_path('logs/tasks-assignment.log'))
    ->onFailure(function () {
        logger()->error('Échec de l\'attribution des tâches quotidiennes');
    });
// Pour ExpireUncompletedTasks, vous pouvez également utiliser everyMinute pour tester
Schedule::command('tasks:expire-uncompleted')
    ->dailyAt('23:59')
    ->timezone('UTC')
    ->onOneServer()
    ->withoutOverlapping()
    ->appendOutputTo(storage_path('logs/tasks-expiration.log'))
    ->onFailure(function () {
        logger()->error('Échec de l\'expiration des tâches non complétées');
    });