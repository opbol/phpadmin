<?php

namespace App\Console;

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
        // Commands\Inspire::class,
        // Commands\MysqlBackup::class
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
        // $schedule->command('backup:mysql --gzip')->dailyAt('02:00');
        $schedule->command('backup:clean')->daily()->timezone('Asia/Shanghai')->at('01:00');
        $schedule->command('backup:run')->daily()->timezone('Asia/Shanghai')->at('03:00');
    }
}
