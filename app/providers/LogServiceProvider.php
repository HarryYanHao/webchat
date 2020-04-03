<?php
namespace App\Providers;

use Libs\Log\MyLog;
class LogServiceProvider extends ServiceProvider {
	public function register(){
		$this->app->bind('log',MyLog::class);
		$this->app->alias('log','Libs\Log\MyLog');
	}
    
}
