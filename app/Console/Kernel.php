<?php

namespace App\Console;

use App\Models\Job;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        'App\Console\Commands\SendMailReportCron'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $this->sendReports($schedule);
    }

    public function sendReports(Schedule $schedule)
    {
        $jobs = Job::all();

        $jobs->each(function ($job) use ($schedule) {
            $schedule
                ->command('mail:report ' . $job->report_id . ' ' . $job->email)
                ->cron($job->cron)
                ->appendOutputTo(storage_path('logs/cron.log'));
        });
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
