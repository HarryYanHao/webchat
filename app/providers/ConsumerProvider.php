<?php
namespace App\Providers;

use Libs\Kafka\Consumer;
class ConsumerProvider extends ServiceProvider {
	public function register(){
		$this->app->bind('consumer',Consumer::class);
	}
    
}
