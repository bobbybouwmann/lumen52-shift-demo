<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Http\Response;

class ApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('API_TOKEN', $request->get('api_token', null));

        if (! $token) {
            return response('Unauthorized. An API token is required.', Response::HTTP_UNAUTHORIZED);
        }

        $user = User::where('api_token', $token)->first();

        if (! $user) {
            return response('Unauthorized. Invalid API token.', Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}