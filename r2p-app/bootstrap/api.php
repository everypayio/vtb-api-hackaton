<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Middleware\ForceJsonResponse;
use App\Http\Middleware\AuthContextIsValid;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Configuration\Exceptions;

return Application::configure(basePath: dirname(__DIR__))
                  ->withRouting(
                      api:    __DIR__.'/../routes/api.php',
                      //health: '/up',
                  )
                  ->withMiddleware(function (Middleware $middleware) {
                      $middleware->group('api', [
                          ForceJsonResponse::class,
                          \Illuminate\Routing\Middleware\SubstituteBindings::class,
                      ]);
                      $middleware->api(prepend: [AuthContextIsValid::class]);
                      $middleware->statefulApi();
                  })
                  ->withExceptions(function (Exceptions $exceptions) {
                      //
                  })
                  ->create();
