<?php

namespace App\Containers\Authentication\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class AppServiceProvider
 * @package App\Containers\Authentication\Providers
 */
class ContainerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerProviders();
    }


    /**
     * Register any providers.
     */
    private function registerProviders()
    {
        $this->app->register(\App\Containers\Authentication\Providers\PolicyServiceProvider::class);
        $this->app->register(\App\Containers\Authentication\Providers\RouteServiceProvider::class);
    }
}
