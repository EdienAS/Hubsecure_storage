<?php

namespace App\Containers\Browse\Providers;


use Illuminate\Support\ServiceProvider;

/**
 * Class AuthorizationServiceProvider.
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
        $this->app->register(\App\Containers\Browse\Providers\RouteServiceProvider::class);

    }
}
