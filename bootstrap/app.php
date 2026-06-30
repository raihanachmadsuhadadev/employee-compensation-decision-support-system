<?php
// bootstrap/app.php
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Tambahkan import middleware bawaan:
use Illuminate\Auth\Middleware\Authenticate;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\RedirectIfAuthenticated;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        // api: __DIR__.'/../routes/api.php', // jika ada
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Aliases
        $middleware->alias([
            'auth'  => Authenticate::class,
            'guest' => RedirectIfAuthenticated::class,
            'role'  => RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
