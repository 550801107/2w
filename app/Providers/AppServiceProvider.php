<?php

namespace App\Providers;

use App\Models\HdrsVideo;
use App\Observers\HdrsVideoObserver;
use App\Observers\UserObserver;
use App\User;
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
		\Schema::defaultStringLength(191);
		User::observe(UserObserver::class);
		HdrsVideo::observe(HdrsVideoObserver::class);
		//
    }
}
