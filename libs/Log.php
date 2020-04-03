<?php
namespace Libs\Log;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use App\Contract\Log;
class MyLog extends Logger implements Log{
	public function __construct(){
		return parent::__construct('controller',[new StreamHandler('../storage/log/' . date('Y-m-d') . '.log', Logger::WARNING)]);
	}
	public function write($key,$param){
		dump("[{$key}]:"."[{$param}]");
	}

}





