<?php

namespace App\Containers\Notifications\Providers;


use Illuminate\Support\ServiceProvider;

/**
 * Class UserServiceProvider.
 *
 * The Main Task Provider of this Module.
 * Will be automatically registered in the framework after
 * adding the Module name to containers config file.
 *
 */
class ContainerServiceProvider extends ServiceProvider
{

    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {

    }

    /**
     * Register bindings in the container.
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
        $this->app->register(\App\Containers\Notifications\Providers\RouteServiceProvider::class);

    }
}
