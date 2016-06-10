<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
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
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
        ],

        'api' => [
            'throttle:60,1',
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
        //'auth' => \App\Http\Middleware\Authenticate::class,
        'auth' => \App\Http\Middleware\SentinelAuthenticate::class,
        'laravel.auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        //'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'guest' => \App\Http\Middleware\SentinelRedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'user' => \App\Http\Middleware\SentinelUser::class,
        'admin' => \App\Http\Middleware\SentinelAdminUser::class,
        'owner' => \App\Http\Middleware\SentinelOwnerUser::class,
        'company' => \App\Http\Middleware\SentinelCompanyUser::class,
        'coordinator' => \App\Http\Middleware\SentinelCoordinatorUser::class,
        'csr' => \App\Http\Middleware\SentinelCSRUser::class,
        'notCurrentUser' => \App\Http\Middleware\SentinelNotCurrentUser::class,
        'redirectUser' => \App\Http\Middleware\SentinelRedirectUser::class,

    ];
}
