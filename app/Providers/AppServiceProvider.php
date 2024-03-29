<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
          Schema::defaultStringLength(191);
          \Carbon\Carbon::setLocale('zh');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
		$this->app->singleton('zcjy', 'App\Repositories\ZcjyRepository');
        $this->app->singleton('setting', 'App\Repositories\SettingRepository');
    }
}
