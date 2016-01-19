<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Contracts\Auth\Guard;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        //dd($request->route('status'));
        $status = $request->route('status');
        Session::put('status',$status );

//dd();

        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
            	if($request->path() == "jobseeker/".$status){

            		 return redirect()->guest('auth/login/jobseeker/'.$status);

            	}else if( $request->path() == "employer") {
            		
	                return redirect()->guest('auth/login/employer');
            	}else if( $request->path() == "admin") {

                    return redirect()->guest('auth/login/employer');
                }

            }
        }

        return $next($request);
    }
}
