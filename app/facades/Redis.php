<?php
namespace App\Facade;
class Redis extends Facade{
	public static function getFacadeAccessor(){
		return 'redis';
	}

    
}
