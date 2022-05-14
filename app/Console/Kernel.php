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
        //
        'App\Console\Commands\DocumentNotification',
        'App\Console\Commands\OtpStatus',
        'App\Console\Commands\PackageExpiry',
        'App\Console\Commands\InvestorOpportunity',
        'App\Console\Commands\SendReview',
        'App\Console\Commands\PaymentTransfer',
        'App\Console\Commands\TestCron',
        'App\Console\Commands\RenewNotification',
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
        $schedule->command('package:status')->everyMinute(); // In Warranty to Out of Warranty after 48 hours
        $schedule->command('test:cronjob')->everyMinute();
        $schedule->command('renew:notification')->everyMinute();
        $schedule->command('investor:opportunities')->everyMinute(); // In Warranty to Out of Warranty after 48 hours
        $schedule->command('otp:status')->everyMinute(); // In Warranty to Out of Warranty after 48 hours
        
        $schedule->command('document:verify')->everyMinute(); // Check documents every day if expire than send mail to provider
        
        $schedule->command('send:review')->everyMinute();   // Send Review 5 STAR if user not send review and Out of warranty after 24 hours
        $schedule->command('payment:transfer')->everyMinute(); // Transfer Money to provider after 72 hours
        
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
