<?php
namespace Libs\Redis;
use \Redis;
use App\Contract\Log;
class MyRedis extends Redis implements Log{
	public function __construct(){
		$redisConfig = config('redis');
		$this->connect($redisConfig['host'],$redisConfig['port']);
	}
	public function write($key,$msg){
		$this->set($key,$msg);
	}
	

}





