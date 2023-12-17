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
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

	/**
	 * Report out-of-memory exceptions.
	 *
	 * BugSnag can increase the PHP memory limit when your app runs out of memory to ensure events can be delivered.
	 * To do this, a “bootstrapper” class must be registered.
	 *
	 * @return array|\Bugsnag\BugsnagLaravel\OomBootstrapper[]|string[]
	 * @link https://docs.bugsnag.com/platforms/php/laravel/ BugSnag documentation
	 */
	protected function bootstrappers()
	{
		return array_merge(
			[\Bugsnag\BugsnagLaravel\OomBootstrapper::class],
			parent::bootstrappers(),
		);
	}
}
