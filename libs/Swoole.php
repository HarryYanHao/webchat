<?php
namespace Libs\Swoole;
use Illuminate\Application\Application;
use Swoole\WebSocket\Server;

class Swoole {
	public $ws;
	public function __construct(Application $app){
		$ws = new Server("0.0.0.0",9502);
		$this->ws = $ws;
	}
	public function start(){
		$this->ws->start();
	}
	
	
	
	

}





