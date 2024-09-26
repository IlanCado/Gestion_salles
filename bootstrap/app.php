<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Laissez cette section vide ou ajoutez d'autres middlewares globaux si nécessaire
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Gestion des exceptions si besoin
    })
    ->create();

return $app;
