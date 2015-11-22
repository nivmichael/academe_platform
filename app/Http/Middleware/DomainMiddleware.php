<?php

namespace App\Http\Middleware;

use Closure;
use Config;
use DB;
use App\Domain;
use HTML;

class DomainMiddleware
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

        $domain = $_SERVER['HTTP_HOST'];
        $Domain = Domain::where('subdomain', $domain)->first();
        $this->Domain =$Domain;

        if(!$Domain){
            return 'NO domain';
            //  throw new NotFoundHttpException;
        }




        Config::set('database.connections'.$Domain->db.'database',$Domain->db);


        DB::setDefaultConnection($Domain->db);





//
        return $next($request);
    }
}
