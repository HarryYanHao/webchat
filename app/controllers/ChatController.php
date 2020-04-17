<?php

/**
* \HomeController
*/

use App\Facade\Log;
use App\Facade\Redis;
use Sabre\HTTP\Request;


class ChatController extends BaseController
{ 
  const Socket_List_Key = "webchat:set:socket_list";
  const User_List_key = "webchat:hash:user_list";
  public function send(){
    //获取前端参数写入kafka
    $request = $this->app->make('request');
    $input = $request->getPostData();
    $kafka_config= config('kafka');
    $kafka_topic = $kafka_config['topic'];
    $message = $input['message'];
    $send_id = $input['send_id'];
    $redis = $this->app->make('redis');
    $info = $redis->hget(self::User_List_key,$send_id);
    $info = json_decode($info,true);
    $send_data = ['message'=>$message,'send_id'=>$send_id,'nickname'=>$info['nickname']];
    $this->app->make('producer')->send($kafka_topic,json_encode($send_data));   
  }
  public function addUser(){
    $host = config('websocket.host');
    $port = config('websocket.port');
    $request = $this->app->make('request');
    $input  = $request->getPostData();
    $send_id = $input['send_id'];
    $nick_name = $input['nickname'];
    $info = ['type' => 'user_list',
    'send_id' => $send_id,'nickname' => $nick_name];
    //redis缓存
    if(empty($send_id) || is_null($send_id)) return;
    $redis = $this->app->make('redis');
    $key = self::User_List_key;
    $socket_key = self::Socket_List_Key;
    $redis->hset($key,$send_id,json_encode($info));
    if(!$redis->sismember($socket_key,$send_id)){
        $redis->sadd($socket_key,$send_id);
    }
    $param = ['type' => 'user_list'];
    curl($host,$port,$param);
    
  }
  public function delUser(){
    $host = config('websocket.host');
    $port = config('websocket.port');
    $request = $this->app->make('request');
    $input  = $request->getPostData();
    $redis = $this->app->make('redis');
    $send_id = $input['send_id'];
    //删除redis登录的用户信息
    $redis->hdel(self::User_List_key,$send_id);
    $redis->srem(self::Socket_List_Key,$send_id);
    $param = ['type' => 'user_list'];
    curl($host,$port,$param);


  }
  
  

}
  

