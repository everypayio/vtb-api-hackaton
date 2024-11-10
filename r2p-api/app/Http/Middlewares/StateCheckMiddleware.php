<?php declare(strict_types=1);

namespace App\Http\Middlewares;

use App\State\Facades\AuthState;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StateCheckMiddleware
{
    /**
     * Handle.
     *
     * @param Request $request
     * @param Closure $next
     * @param array<int, string> $checks
     * @return Response
     */
    public function handle(Request $request, Closure $next, ...$checks): Response
    {
        foreach ($checks as $check) {
            if ($check === 'authContext' && is_null(AuthState::get('authContext'))) {
                abort(401);
            }
        }

        return $next($request);
    }
}
