<?php
namespace App\Providers;

use Libs\Kafka\Producer;
class ProducerProvider extends ServiceProvider {
	public function register(){
		$this->app->bind('producer',Producer::class);
	}
    
}
