<?php
namespace Illuminate\ProviderRepository;

use  Illuminate\Application\Application;

class RegisterProviders{
	
	public function bootstrap(Application $app)
	{
		$app->registerConfiguredProviders();
	}

	
}