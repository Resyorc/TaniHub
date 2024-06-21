<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// $schedule->command('sensor:fetch')->hourly();

$schedule = app(Schedule::class);
$schedule->command('sensor:process')->everyThreeMinutes()->withoutOverlapping()->appendOutputTo(storage_path('logs/scheduler.log'));
;
