<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('users:delete-old-guests')->dailyAt('00:00')->onSuccess(function () {
            Log::info('users:delete-old-guests command ran successfully.');
        })->onFailure(function () {
            Log::error('users:delete-old-guests command failed.');
        });
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
