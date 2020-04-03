<?php
namespace App\Http\Middleware;




class Authenticate{
	public static function handle($request,\Closure $next){
		if(empty($request->getPostData())){
			$request->setPostData(['harry'=>'test']);
		}
		return $next($request);
	}
	
}