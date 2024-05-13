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
        //schedule to sync order from woo-commerce every day at 12 am.
        /* This code snippet is setting up a scheduled task in a Laravel application. */
        $schedule->command('app:sync-woo-order')
            ->dailyAt('12:00');

        $schedule->command('app:delete-unused-orders')
            ->dailyAt('01:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    protected function commandFailed($command, $exitCode, $output)
    {
        logger()->error("Command '{$command} failed with exit code {$exitCode}: {$output} ");
        //TODO: Send email notification if command fails for better logging
    }
}
