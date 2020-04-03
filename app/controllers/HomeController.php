<?php

/**
* \HomeController
*/

use App\Facade\Log;
use App\Facade\Redis;
use Sabre\HTTP\Request;


class HomeController extends BaseController
{
  public function home(){
    echo 'Hi HF framework';
   
   
  }
  public function index(Request $request){
    echo 'index Page';

  }

  public function test(){
    $log = $app->make('log');
    $log->write('contract','harry test Log contract log');
    // Log::write('harry test facade');
    $redis = $app->make('redis');
    $redis->write('contract','harry test Redis contract log');
    Redis::set('facade','harry test redis facade');

    $request_params = Request::getConstructParams($_SERVER);
    $request = $app->make('request',$request_params);
    dump($request->getQueryParameters());
  }
  

}
  

