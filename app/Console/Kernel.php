<?php
namespace App\Console;

use Illuminate\Console\Kernel as ConsoleKernel;
use Illuminate\Contracts\Console\Schedule;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\ProcessScheduledEmails::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('emails:process-scheduled')
             ->everyMinute()
             ->withoutOverlapping();
    }
}