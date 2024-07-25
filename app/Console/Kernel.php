<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('email:daily-post-summary')
            ->timezone("Asia/Rangoon")
            ->everyMinute();
    }
//    protected function schedule(Schedule $schedule): void
//{
//    $schedule->command('email:daily-post-summary')
//        ->timezone("Asia/Rangoon")
//        ->weeklyOn(4); // 4 represents Thursday (0 = Sunday, 1 = Monday, ..., 6 = Saturday)
//}
//    /**
//     * Register the commands for the application.
//     */
//    protected function commands(): void
//    {
//        $this->load(__DIR__ . '/Commands');
//
//        require base_path('routes/console.php');
//    }


   

}
