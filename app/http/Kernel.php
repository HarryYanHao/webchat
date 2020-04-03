<?php
namespace App\Http;


use Illuminate\Http\Kernel as HttpKernel;
use NoahBuscher\Macaw\Macaw;
use Illuminate\Application\Application;

class Kernel extends HttpKernel{
	// protected $routeMiddleware=['auth'=>'App\Http\Middleware\Authenticate','guest' => 'App\Http\Middleware\RedirectIfAuthenticated'];
	protected $routeMiddleware=[];
	public function __construct(Application $app,Macaw $route){
		parent::__construct($app,$route);
	}
}