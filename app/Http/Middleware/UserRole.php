<?php

namespace App\Http\Middleware;

use Auth;

use Closure;

class UserRole
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
        if ( Auth::check()) // user logged
        {
            $request_url = $request->getRequestUri();
            if( Auth::user()->user_type == 1 ) // simple user
            {
                if (strpos($request_url, "/profile") === 0)
                {
                    return $next($request);
                }
                else
                {
                    return redirect('/');
                }
            }
            else if( Auth::user()->user_type !== 1 ) // admin
            {
                if (strpos($request_url, "/admin") === 0)
                {
                    return $next($request);
                }
                else
                {
                    return redirect('/');
                }
            }
            else
            {
                return redirect('/');
            }
        }
        return redirect('/');
    }
}
