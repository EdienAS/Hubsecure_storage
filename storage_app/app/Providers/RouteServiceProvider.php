<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();
        
        $this->registerProviders();
    }


    /**
     * Register any providers.
     */
    private function registerProviders()
    {
        
        $this->app->register(\App\Containers\Authentication\Providers\ContainerServiceProvider::class);

        $this->app->register(\App\Containers\User\Providers\ContainerServiceProvider::class);

        $this->app->register(\App\Containers\Authorization\Providers\ContainerServiceProvider::class);
        
        $this->app->register(\App\Containers\Folders\Providers\ContainerServiceProvider::class);
        
        $this->app->register(\App\Containers\Files\Providers\ContainerServiceProvider::class);
        
        $this->app->register(\App\Containers\Zip\Providers\ContainerServiceProvider::class);
        
        $this->app->register(\App\Containers\Share\Providers\ContainerServiceProvider::class);
        
        $this->app->register(\App\Containers\UserSettings\Providers\ContainerServiceProvider::class);
        
        $this->app->register(\App\Containers\Traffic\Providers\ContainerServiceProvider::class);
        
        $this->app->register(\App\Containers\Teams\Providers\ContainerServiceProvider::class);
        
        $this->app->register(\App\Containers\Browse\Providers\ContainerServiceProvider::class);
        
        $this->app->register(\App\Containers\Notifications\Providers\ContainerServiceProvider::class);
        
        $this->app->register(\App\Containers\Search\Providers\ContainerServiceProvider::class);
        
    }
}
