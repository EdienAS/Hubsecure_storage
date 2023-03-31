<?php

namespace App\Abstracts;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class KernelHttp extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Middleware\Web\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Middleware\Web\TrustProxies::class,
        \Illuminate\Session\Middleware\StartSession::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Middleware\Web\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            //\Illuminate\Session\Middleware\StartSession::class,
            //\Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Middleware\Web\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:200,1',
            'bindings',
            \App\Middleware\Api\ApiHeaders::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        //'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Middleware\Web\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,

        // Entrust Package middleware's
        'role' => \Zizaco\Entrust\Middleware\EntrustRole::class,
        'permission' => \Zizaco\Entrust\Middleware\EntrustPermission::class,
        'ability' => \Zizaco\Entrust\Middleware\EntrustAbility::class,

        'web.auth' => \App\Middleware\Web\WebAuthentication::class,
        'role.web' => \App\Middleware\Web\WebEntrustRole::class,
    ];
}
