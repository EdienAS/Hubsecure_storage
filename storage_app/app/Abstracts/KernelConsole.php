<?php

namespace App\Abstracts;

use App\Containers\User\UI\CLI\Commands\PlanExpireNotification;
use App\Containers\User\UI\CLI\Commands\TipNotifications;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class KernelConsole extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        TipNotifications::class,
        PlanExpireNotification::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('user:tipNotifications')
            ->everyFiveMinutes()
            ->sendOutputTo(storage_path('logs').'/schedule.log');

        $schedule->command('user:planExpireNotifications')
            ->dailyAt('13:00')
            ->sendOutputTo(storage_path('logs').'/expiration.log');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require app_path('Console/routes.php');
    }
}
