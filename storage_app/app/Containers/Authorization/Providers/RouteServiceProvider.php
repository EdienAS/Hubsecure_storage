<?php

namespace App\Containers\Authorization\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = null;

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        //
    }
    
    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        $router = $this->app['Illuminate\Contracts\Routing\BindingRegistrar'];

            $router->group([
                'prefix' => 'api/v1',
                'namespace' => 'App\Containers\Authorization\UI\Api\Controllers',
                'middleware' => 'api',
            ], function ($router) {
                require app_path('Containers/Authorization/UI/Api/routes.php');
            });
    }

}
