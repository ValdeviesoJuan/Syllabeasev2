<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\SendDeadlineReminders;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // Run the deadline reminder job every day at midnight
        $schedule->command(SendDeadlineReminders::class)->dailyAt('00:00');
        
        // Optional: Log it to verify
        $schedule->call(function () {
            Log::info('Scheduler ran.');
        })->everyMinute();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
