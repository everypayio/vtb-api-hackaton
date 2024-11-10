<?php declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthContextIsValid
{
    /**
     * Checks if valid auth context for API.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->header('x-auth-token', 'empty') === env('API_X_AUTH_CONTEXT')) {
            return $next($request);
        }
        abort(403,"Sorry - you got 403");
    }
}
