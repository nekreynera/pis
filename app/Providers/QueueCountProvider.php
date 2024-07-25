<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use Auth;

class QueueCountProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('OPDMS.reception.queue.header_status', function($view)
        {
            $view->with('queue_count', DB::select("
                                    SELECT COUNT(*) as total, assignations.status FROM queues
                                    LEFT JOIN assignations
                                        ON assignations.patients_id = queues.patients_id
                                        AND assignations.clinic_code = ".Auth::user()->clinic."
                                        AND DATE(assignations.created_at) = CURDATE()
                                    WHERE queues.clinic_code = ".Auth::user()->clinic."
                                    AND DATE(queues.created_at) = CURDATE()
                                    GROUP BY assignations.status
                                "));

        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
