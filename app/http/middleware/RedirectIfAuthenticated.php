<?php
namespace App\Http\Middleware;




class RedirectIfAuthenticated{
	public static function handle($request,\Closure $next){
		return $next($request);
	}
	
}