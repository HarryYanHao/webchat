<?php
namespace Libs\Kafka;
use Illuminate\Application\Application;
use RdKafka\Conf;
use RdKafka\TopicConf;
use RdKafka\Consumer as KafkaConsumer;
class Consumer {
	public $rk;
	public $topic;
	public $topicConf;
	private $conf;
	public function __construct(Application $app){
		$config_group = config('kafka.group');
		$this->conf = new Conf();
		$this->conf->set('group.id', $config_group);
		$this->topicConf = new TopicConf();
		$this->topicConf->set('auto.commit.interval.ms', 100);
		$this->topicConf->set('offset.store.method', 'file');
		$this->topicConf->set('offset.store.path', sys_get_temp_dir());
		$this->topicConf->set('auto.offset.reset', 'smallest');

		

	}
	public function recive(){
		//kafka低级消费者
		
		$this->rk = new KafkaConsumer($this->conf);
		
		$config_kafka = config('kafka.consumer');
		
		$this->rk->addBrokers($config_kafka['host'].':'.$config_kafka['port']);

		
		$config_topic = config('kafka.topic');
		$this->topic = $this->rk->newTopic($config_topic, $this->topicConf);
		$this->topic->consumeStart(0, RD_KAFKA_OFFSET_STORED);
		$message = $this->topic->consume(0, 10000);
		if($message){
			return $message->payload;
		}
		return '';
	}
	
	
	
	

}





