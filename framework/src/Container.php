<?php
namespace Illuminate\Container;

use ReflectionClass;

class Container{
	protected $binding = [];
	protected static $instance;
	protected $instances;
	protected $aliases = [];

	public function bind($abstract,$concrete){
		//根据名称创建绑定对象 暂时只支持闭包
		$this->binding[$abstract]['concrete'] = function($container,$parameters) use ($concrete){
			return $container->build($concrete,$parameters);
		};
	}

	public function make($abstract,$parameters=[]){
		//获取别名 有别名用别名 没有别名用本身
		$abstract = $this->getAlias($abstract);
		if(isset($this->instances[$abstract])){
			return $this->instances[$abstract];
		}
		//根据key值获取binding值
		$concrete = $this->binding[$abstract]['concrete'];
		$object = $concrete($this,$parameters);
		$this->instances[$abstract] = $object;
		return $object;
	}
	//利用反射创建对象
	public function build($concrete,$parameters=[]){
		//反射->类
		$reflector = new ReflectionClass($concrete);
		//类->构造方法
		$constructor = $reflector->getConstructor();
		if(is_null($constructor)){
			//没有构造方法 直接创建对象
			return $reflector->newInstance();
		}
		//构造方法->构造方法的参数
		$dependencies = $constructor->getParameters();
		$parameters = $this->keyParametersByArgument($dependencies,$parameters);
		$instances = $this->getDependencies($dependencies,$parameters);
		return $reflector->newInstanceArgs($instances);
	}

	//获取参数依赖(递归获取)
	protected function getDependencies($parmters,$primitives){
		$dependencies = [];
		foreach ($parmters as  $parmter) {
			if(array_key_exists($parmter->name,$primitives)){
				$dependencies[] = $primitives[$parmter->name];
			}else{
				$dependencies[] = $this->make($parmter->getClass()->name);	
			}
		}
		return $dependencies;
	}
	//获取参数值
	protected function keyParametersByArgument($dependencies,$parameters){
		foreach($parameters as $key=>$value){
			if(is_numeric($key)){
				unset($parameters[$key]);

				$parameters[$dependencies[$key]->name] = $value;
			}
		}
		return $parameters;
	}
	public static function setInstance($instance){
		static::$instance = $instance;
	}
	public static function getInstance(){
		return static::$instance;
	}
	public  function getBindings(){
		return $this->binding;
	}
	public function alias($abstract,$alias){
		$this->aliases[$alias] = $abstract;
	}
	public function getAlias($abstract){
		return isset($this->aliases[$abstract]) ? $this->aliases[$abstract] : $abstract;
	}
	

	
}