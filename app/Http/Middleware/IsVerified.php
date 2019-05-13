<?php


namespace App\Http\Middleware;


use App\Util\ApiWrapper;
use Closure;
use Session;


class IsVerified
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
        if(!auth()->user()->verified){
            Session::flush();
            return ApiWrapper::wrapApiResponse(['message'=>'User not verified'], 'not-verified', 200);
            //return redirect('login')->withAlert('Please verify your email before login.');
        }
        return $next($request);
    }
}
