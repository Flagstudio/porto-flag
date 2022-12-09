<?php

namespace App\Ship\Kernels;

use Illuminate\Foundation\Http\Kernel;

class HttpKernel extends Kernel
{
    protected $middleware = [
        \App\Ship\Captain\Foundation\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Ship\Captain\Foundation\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Ship\Captain\Foundation\Middleware\TrustProxies::class,
        \Spatie\MissingPageRedirector\RedirectsMissingPages::class,
    ];

    protected $middlewareGroups = [
        'web' => [
            \App\Ship\Captain\Foundation\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
             \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Ship\Captain\Foundation\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            'bindings',
        ],
    ];

    protected $routeMiddleware = [
        'auth' => \App\Ship\Captain\Foundation\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Ship\Captain\Foundation\Middleware\RedirectIfAuthenticated::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'auth.push' => \App\Containers\Integrations\PushNotification\Http\Middlewares\PushAuthorization::class,
    ];
}
