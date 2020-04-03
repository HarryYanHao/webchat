<?php
namespace App\Providers;

use Libs\Kafka\ConsumerKafka;
class ConsumerKafkaProvider extends ServiceProvider {
	public function register(){
		$this->app->bind('consumerKafka',ConsumerKafka::class);
	}
    
}
