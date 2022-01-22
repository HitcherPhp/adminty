<?php

namespace App\Http\Middleware;

use App\Facades\Auth;
use App\Facades\Message;
use Closure;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (!session()->has('api_token')) {
            return response()->json(Auth::LOGIN_ERROR,200);
        }

        return $next($request);
    }
}
