<?php

use App\Http\Middleware\EnsureTenantContext;
use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        App\Providers\AuthServiceProvider::class,
    ])
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Global
        $middleware->append(SetLocale::class);

        // Aliases for route-level use: Route::middleware('tenant')
        $middleware->alias([
            'tenant' => EnsureTenantContext::class,
        ]);

        // Apply tenant context to all authenticated web requests
        $middleware->web(append: [
            EnsureTenantContext::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
