<?php
namespace Illuminate\Bootstrap;

use  Illuminate\Application\Application;
class ProviderRepository{
	protected $app;

	public function __construct(Application $app){
		$this->app = $app;
	}

	public function load(array $providers){
		foreach($providers as $provider){
			$this->app->register($this->createProvider($provider));
		}
	}

	public function createProvider($provider){
		return new $provider($this->app);
	}

	
}