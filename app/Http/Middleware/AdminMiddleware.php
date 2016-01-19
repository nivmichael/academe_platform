<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class AdminMiddleware
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
    	if (!in_array(Auth::user()->type,['tech-admin','system-admin','system-manager']))
        {

            return response('401', 401);
        }

        return $next($request);
    }
}
