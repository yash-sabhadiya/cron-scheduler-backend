<?php

namespace App\Console;

use App\Models\CronJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

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

        $intervals = config('scheduler.interval_options');

        foreach (DB::table('cron_jobs')->whereNull('deleted_at')->get() as $cron)
        {
            $func = collect($intervals)->where('value',$cron->interval)->first();

            $schedule->call(function () use($cron){
                try{
                    Http::get($cron->url);
                    DB::table('cron_jobs')->where('id',$cron->id)->update(['last_run' => now()]);
                }catch (\Exception $e){
                    app('log')->error($e->getMessage());
                }
            })->{$func['function']}();
        }
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
