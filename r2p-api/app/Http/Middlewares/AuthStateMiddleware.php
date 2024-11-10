<?php declare(strict_types=1);

namespace App\Http\Middlewares;

use App\State\Facades\AuthState;
use App\State\Facades\State;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthStateMiddleware
{
    /**
     * Handle.
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $stateId =
            $request->header('X-State-Id') ??
            $request->get('state');

        if (!is_string($stateId)) {
            abort(401);
        }

        $state = State::prepare($stateId);

        if (!$state->exists()) {
            abort(401);
        }

        AuthState::setFacadeRoot($state->load());

        return $next($request);
    }
}
