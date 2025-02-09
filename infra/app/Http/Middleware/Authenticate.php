<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, \Closure $next, ...$guards)
    {

        if(empty($this->auth->user())) {
            return response()->json([
                'code' => 401,
                'message' => 'You are not authenticated',
                'data' => [],
                'status' => 'error'
            ],401);
        }

        return $next($request);
    }
}
