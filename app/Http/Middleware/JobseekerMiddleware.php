<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class JobseekerMiddleware
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
        if ($request->user()->subtype != 'jobseeker')
        {
            return redirect('employer/');
            //    return response('Unauthorized.', 401);
        }
        return $next($request);

    }
}