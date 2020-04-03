<?php
namespace App\Providers;
use Sabre\HTTP\Request;

class RouteProvider extends ServiceProvider {
	public function register(){
		$this->app->bind('route',\NoahBuscher\Macaw\Macaw::class);
		$this->app->alias('route','NoahBuscher\Macaw\Macaw');
		
	}

	
    
}
