<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require_once base_path('routes/console.php');
    }
}
/*  clé sonarcube projet instad Analyze "instad": sqp_5f245ca71b1bd4c0f8f812f1f3f77a3e5ade9d3e */

/* sonar-scanner.bat -D"sonar.projectKey=instad" -D"sonar.sources=." -D"sonar.host.url=http://127.0.0.1:9000" -D"sonar.token=sqp_5f245ca71b1bd4c0f8f812f1f3f77a3e5ade9d3e" */