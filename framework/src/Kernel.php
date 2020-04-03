<?php
namespace Illuminate\Http;



use \NoahBuscher\Macaw\Macaw;
use Illuminate\Application\Application;
use Sabre\HTTP\Request;


class Kernel{
	protected $app;

	protected $router;

	protected $bootstrappers = ['Illuminate\ProviderRepository\RegisterProviders','Illuminate\ProviderRepository\RegisterFacades'];

	protected $middleware = [];

	protected $routeMiddleware = [];

	public function __construct(Application $app,Macaw $router){
		$this->app = $app;
		$this->router = $router;
		foreach ($this->routeMiddleware as $key=>$middleware){
			$router::middleware($key,$middleware);
		}
	}

	public function handle(){
		if (PHP_SAPI === 'cli'){
			$this->bootstrap();
			return $this->app;

		}else{
			require '../config/routes.php';
			$this->app->bind('request','Sabre\HTTP\Request');
			$request_params = Request::getConstructParams($_SERVER);
    		$request = $this->app->make('request',$request_params);
    		$route = $this->app->make('route');
			//$route->map();
			$this->bootstrap();
			$route::dispatch($this->app);
		}
	
	}

	public function bootstrap(){
		$this->app->bootstrapWith($this->bootstrappers());
	}

	protected function bootstrappers(){
		return $this->bootstrappers;
	}

		

	
}