<?php
namespace App\Facade;
use Sabre\HTTP\Request as BaseRequest;
class Request extends Facade{
	public static function getFacadeAccessor(){
		return 'request';
	}
	public static function __callStatic($method,$args){
    	$instance = static::$app->make(static::getFacadeAccessor(),BaseRequest::getConstructParams($_SERVER));
    	return $instance->$method(...$args);
    }

    
}
