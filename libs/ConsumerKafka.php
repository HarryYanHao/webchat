<?php
namespace Libs\Kafka;
use Illuminate\Application\Application;
use RdKafka\Conf;
use RdKafka\TopicConf;
use Kafka\Consumer as KafkaConsumer;
use Kafka\ConsumerConfig;

class ConsumerKafka {
	public $consumer;
	public function __construct(Application $app){
		$logger = $app->make('log');
		// Now add some handlers
		$config = ConsumerConfig::getInstance();
		$config->setMetadataRefreshIntervalMs(10000);
		$config->setMetadataBrokerList('127.0.0.1:9092');
		$config->setGroupId('group_webchat');
		$config->setBrokerVersion('1.0.0');
		$config->setTopics(['webchat']);
		//$config->setOffsetReset('earliest');
		$this->consumer = new KafkaConsumer();
		$this->consumer->setLogger($logger);
		

		

	}
	public function start(){
		return $this->consumer->start(function($topic, $part, $message) {
			return $message;
		});
	}
	
	
	
	

}





