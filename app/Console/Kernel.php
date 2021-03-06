<?php

namespace App\Console;

use Log;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        Log::info('Cron job is execute at ' . Carbon::now('Asia/Karachi'));
        // $schedule->command('hourly:update')->everyMinute();
        $schedule->command('hourly:update')->hourly();
        $schedule->command('daily:delete')->dailyAt('23:30');
        $schedule->command('monthly:update')->monthlyOn(5, '22:30'); // Run the task every month on the 5th at 22:30
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
