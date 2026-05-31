<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'onboarded' => \App\Http\Middleware\EnsureOnboarded::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Illuminate\Routing\Exceptions\InvalidSignatureException $e, \Illuminate\Http\Request $request) {
            return response()->view('auth.email-confirmed', ['status' => 'invalid'], 403);
        });
    })->create();
