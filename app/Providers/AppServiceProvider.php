<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Blade::if('admin', function () {
            if (auth()->user() && auth()->user()->admin) {
                return 1;
            }
            if (auth()->user() && strpos(auth()->user()->email, 'trackmysolutions.us')) {
                return 1;
            }
            return 0;
        });
    }
}
