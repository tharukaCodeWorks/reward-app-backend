<?php

namespace App\Http\Middleware;

use Closure;

class isBlocked
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
        if(auth()->user()->blocked){
            Session::flush();
            return ApiWrapper::wrapApiResponse(['message'=>'User has blocked'], 'blocked', 200);
        }
        return $next($request);
    }
}
