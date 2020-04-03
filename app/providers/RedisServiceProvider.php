<?php
namespace App\Providers;

use Libs\Redis\MyRedis;
class RedisServiceProvider extends ServiceProvider {
	public function register(){
		$this->app->bind('redis',MyRedis::class);
	}
    
}
