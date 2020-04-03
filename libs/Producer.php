<?php
namespace Libs\Kafka;
use Illuminate\Application\Application;
use RdKafka\Producer as KafkaProducer;
class Producer {
	public $rk;
	public $topic;
	public function __construct(Application $app){
		$config_kafka = config('kafka.producer');
		$config_topic = config('kafka.topic');
		$this->rk = new KafkaProducer();
		$this->rk->setLogLevel(LOG_DEBUG);
		$this->rk->addBrokers($config_kafka['host'].':'.$config_kafka['port']);
		$this->topic = $this->rk->newTopic($config_topic);

	}
	public function send($topic='testkafka',$message='hello'){
		$this->topic->produce(RD_KAFKA_PARTITION_UA, 0, $message);
		$this->rk->poll(0);
	}
	

}





