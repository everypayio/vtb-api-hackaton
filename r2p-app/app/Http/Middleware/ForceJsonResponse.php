<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceJsonResponse
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set('Accept', 'application/json');
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
