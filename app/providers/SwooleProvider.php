<?php
namespace App\Providers;

use Libs\Swoole\Swoole;
class SwooleProvider extends ServiceProvider {
	public function register(){
		$this->app->bind('swoole',Swoole::class);
	}
    
}
