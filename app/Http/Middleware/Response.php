<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Response
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
        /** @var \Illuminate\Http\Response $response */
        $response = $next($request);

        if ($response->getStatusCode() !== \Illuminate\Http\Response::HTTP_OK) {
            return $response;
        }

        return response()->json([
            'status' => 'success',
            'code' => \Illuminate\Http\Response::HTTP_OK,
            'data' => $response->getOriginalContent(),
        ]);
    }
}
