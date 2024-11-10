<?php declare(strict_types=1);

use App\Http\Middlewares\AuthStateMiddleware;
use App\Http\Middlewares\StateCheckMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application
    ::configure(
        basePath: dirname(__DIR__),
    )
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->group('web', []);

        $middleware->alias([
            'auth.state'  => AuthStateMiddleware::class,
            'state.check' => StateCheckMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
