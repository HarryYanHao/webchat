<?php
use Illuminate\Database\Capsule\Manager as Capsule;

use Symfony\Component\HttpKernel\HttpCache\Store;
use App\Facade\Log;
use App\Facade\Redis;
use App\Facade\Route;
use Sabre\HTTP\Request;
use Illuminate\Container\Container;

header("Content-type:text/html;charset=utf-8");
// Autoload 自动载入
require '../vendor/autoload.php';


$app = require_once __DIR__.'/../bootstrap/app.php';


$kernel = $app->make('kernel');
$app = $kernel->handle();
//kafka消费端
$consumer_obj = $app->make('consumer');
$consumer_kafka_obj = $app->make('consumerKafka');


if (PHP_SAPI === 'cli'){
	//redis连接信息key
	$key = "webchat:set:socket_list";
	//swoole服务器端
	$swoole_obj = $app->make('swoole');
	$redis = $app->make('redis');
	$server = $swoole_obj->ws;
	//$server->set(['heartbeat_check_interval' => 60,
    //    'heartbeat_idle_time' => 600]);
	

	//websocket主动推送消息
	$newprocess = new Swoole\Process(function($process) use ($server,$redis,$consumer_obj,$key){
            while (true) {
            	$consumer_msg = $consumer_obj->recive();
            	$consumer_msg = json_decode($consumer_msg,true);
            	var_dump($consumer_msg);
                $user_list = $redis->smembers($key);
                if ($user_list) {
                	$push_message = [];
                	if($consumer_msg){
                		$push_message = ['message' => $consumer_msg['message'],'type' => 'chat','send_id'=>$consumer_msg['send_id'],'nickname'=>$consumer_msg['nickname']];
                	}else{
                		$push_message = ['type' => 'keepalive'];
                	}
                    //把消息推给所有用户
                    foreach ($user_list as $k => $user_fd) {
                        //查找用户的fd   检查用户是否在线
                        if ($server->exist($user_fd)) {
                            $server->push($user_fd,json_encode($push_message));
                        }
                    }
                }
            }
            //$consumer_kafka_obj->start();
        });
	$server->addProcess($newprocess);



	$swoole_obj->ws->on('open',function($ws,$request) use ($redis,$key,$server){
		//将连接的信息 写入redis set
		$redis->sadd($key,$request->fd);
		$server->push($request->fd,json_encode(['socket_id' => $request->fd,'type' => 'socket']));
		
	});
	$swoole_obj->ws->on('message',function($ws,$frame) {
		
	});
	$swoole_obj->ws->on('request',function($request, $response) use ($server,$redis,$consumer_obj,$key){
		$param = $request->post;
		$user_key = 'webchat:hash:user_list';
		$socket_user_info = [];
		
		switch ($param['type']) {
			case 'user_list':
			{
			$user_list = $redis->smembers($key);
			$user_list_info = $redis->hgetall($user_key);
			foreach ($user_list as $user_fd) {
				if ($server->exist($user_fd)) {
					//获取在线用户信息
					$user_info = isset($user_list_info[$user_fd]) ? $user_list_info[$user_fd]: [];
					if(!empty($user_info)){
						$socket_user_info[] = $user_info;
					}
					
				}
			}
			$push_data = ['type'=>'user_list','user_list'=>$socket_user_info];
			var_dump($push_data);
			foreach ($user_list as $user_fd){
			 	if($server->exist($user_fd)){
			 		$server->push($user_fd,json_encode($push_data));
				}
			 }
			}
			break;

			
			default:
				# code...
				break;
		}

	});
	$swoole_obj->ws->on('close',function($ws,$fd) use ($redis,$key){
		$redis->srem($key.$fd);

	});
	$server->start();  

}else{
    echo "请在cli下执行该脚本";
}