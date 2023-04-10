<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Support\Scheduler\Actions\XRPLCreateBlockAction;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Support\Scheduler\Actions\XRPLGetBlockStatusAction;
use App\Support\Scheduler\Actions\XRPLCreateClientKeyAction;
use App\Support\Scheduler\Actions\DeleteExpiredShareLinksAction;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        
        $schedule->call(
            fn () => resolve(DeleteExpiredShareLinksAction::class)()
        )->everyMinute();

        $schedule->call(
            fn () => resolve(XRPLCreateClientKeyAction::class)()
        )->everyMinute();

//        $schedule->call(
//            fn () => resolve(XRPLCreateBlockAction::class)()
//        )->everyMinute();

        $schedule->call(
            fn () => resolve(XRPLGetBlockStatusAction::class)()
        )->everyMinute();

        // Run queue jobs every minute
        $schedule->command('queue:work --queue=high,default --max-time=300')
            ->everyFiveMinutes()
            ->withoutOverlapping();

        
        $schedule->command('optimize:clear')
            ->daily();
        
        $schedule->command('config:cache')
            ->daily();
        
        $schedule->command('config:clear')
            ->daily();

        $schedule->call(fn () => cache()->set('latest_cron_update', now()->toString()))
            ->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
