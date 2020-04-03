<?php
namespace Illuminate\Application;
use Illuminate\Container\Container;
use Illuminate\Bootstrap\ProviderRepository;
use App\Providers\RouteProvider;
use App\Providers\LogServiceProvider;
use App\Facade\Facade;
class Application extends Container{
	const VERSION = '1.0.1';
	protected $basePath;
	public function __construct(){
		$this->registerBaseBindings();
		
		$this->registerBaseServiceProviders();

		
	}
	protected function registerBaseBindings(){
		static::setInstance($this);
		$this->bind('app',$this);
		$this->alias('app','Illuminate\Application\Application');
	}

	protected function registerBaseServiceProviders(){
		$this->register(new LogServiceProvider($this));
		$this->register(new RouteProvider($this));		
	}
	public function register($provider){
		$provider->register();
	}
	protected function getProvider($provider){
		is_string($provider)?$provider:get_class($provider);
	}
	public function bootstrapWith($bootstrappers){
		foreach ($bootstrappers as $bootstrapper) {
			$this->make($bootstrapper)->bootstrap($this);
		}
	}
	public function make($abstract,$parameters = []){
		$abstract = $this->getAlias($abstract);
		if(!isset($this->binding[$abstract])){
			return $this->build($abstract);
		}
		return parent::make($abstract,$parameters);
	}
	public function registerConfiguredProviders(){
		(new ProviderRepository($this))->load(config('app.providers'));
	}

	public function version(){
		return self::VERSION;
	}
	public function configPath(){
		return $this->basePath.DIRECTORY_SEPARATOR.'config';
	}

	
}