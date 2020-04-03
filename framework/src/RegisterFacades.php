<?php
namespace Illuminate\ProviderRepository;

use  Illuminate\Application\Application;
use  App\Facade\Facade;

class RegisterFacades{
	
	public function bootstrap(Application $app)
	{
		Facade::setFacadeApplication($app);
	}

	
}