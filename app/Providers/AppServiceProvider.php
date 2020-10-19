<?php

namespace App\Providers;

use DB;
use Illuminate\Support\ServiceProvider;
use Log;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        DB::listen(function($q){
            /*
            Log::info(
                $q->sql,
                $q->bindings,
                $q->time
            );
            */
            //error_log('log::'.$q->sql);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
