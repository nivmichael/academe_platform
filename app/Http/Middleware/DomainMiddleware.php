<?php

namespace App\Http\Middleware;

use Closure;
use Config;
use DB;
use App\Domain;


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
            return 'This is The Main Site. Please Go to One Of Our Sub Domains. for example: nyu, ucla or ucsd';
        }






        Config::set('database.connections'.$Domain->db.'database',$Domain->db);
        DB::setDefaultConnection($Domain->db);


        $css =  DB::table('css')->get();
//        $css = '';
//        $cssArr = [];
//        foreach($css as $properties) {
//
//            var_dump($properties);
//
//        }
        $cssArr = [];
        foreach($css as $key => $properties) {
            $cssArr[$properties->property] = $properties->value;

        }





//
        return $next($request);
    }
}
