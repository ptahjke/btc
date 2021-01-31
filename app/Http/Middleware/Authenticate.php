<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $this->validateToken($request);

        return $next($request);
    }

    private function validateToken(Request $request): void
    {
        $authToken = $request->bearerToken();
        if (empty($authToken)) {
            throw new AccessDeniedHttpException('Invalid Token');
        }

        if (1 !== preg_match('/[a-zA-Z0-9\-\_]{64}/', $authToken)) {
            throw new AccessDeniedHttpException('Invalid Token');
        }
    }
}
