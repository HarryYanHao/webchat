<?php
namespace App\Facade;
class Facade{
    protected static $app;
    public function __construct($app){
       
    }
    public static function setFacadeApplication($app){
    	static::$app = $app;
    }
    public static function __callStatic($method,$args){
    	$instance = static::$app->make(static::getFacadeAccessor());
    	return $instance->$method(...$args);
    }
    public static function getFacadeAccessor(){

    }

    
}
