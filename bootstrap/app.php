<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Log para debug
error_log('=== Laravel Application Starting ===');
error_log('APP_ENV: ' . env('APP_ENV', 'not set'));
error_log('APP_KEY: ' . (env('APP_KEY') ? 'SET' : 'NOT SET'));
error_log('APP_DEBUG: ' . env('APP_DEBUG', 'not set'));

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
            \App\Http\Middleware\CheckOAuthConfig::class,
        ]);
        
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->reportable(function (Throwable $e) {
            error_log('Laravel Exception: ' . $e->getMessage());
            error_log('Stack trace: ' . $e->getTraceAsString());
        });
    })->create();
