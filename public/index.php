<?php
use Illuminate\Database\Capsule\Manager as Capsule;

use Symfony\Component\HttpKernel\HttpCache\Store;
use App\Facade\Log;
use App\Facade\Redis;
use App\Facade\Route;
use Sabre\HTTP\Request;
use Illuminate\Container\Container;

header("Content-type:text/html;charset=utf-8");
header("Access-Control-Allow-Origin:*");
// Autoload 自动载入
require '../vendor/autoload.php';


$app = require_once __DIR__.'/../bootstrap/app.php';


$kernel = $app->make('kernel');
$kernel->handle();
//dump(Container::getInstance());






// $route = $app->make('route');
// Route::get('/test','HomeController@test');



// 路由配置
//require '../config/routes.php';





