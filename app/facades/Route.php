<?php
namespace App\Facade;
use Sabre\HTTP\Request;
class Route extends Facade{
	public static function getFacadeAccessor(){
		return 'route';
	}
	public static function __callStatic($method,$args){
    	$instance = static::$app->make(static::getFacadeAccessor());
    	return $instance::$method(...$args);
    }
    
}
