<?php

namespace App\Http\Middleware;

use Closure;

class EmployerMiddleware
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
    	if ($request->user()->subtype != 'employer')
        {
            return redirect('jobseeker#/');
        //    return response('Unauthorized.', 401);
        }
        return $next($request);
    }
}
