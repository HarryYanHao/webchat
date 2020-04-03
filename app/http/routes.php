<?php
use App\Facade\Route;



 Route::get('(:all)', function($fu) {
   echo '未匹配到路由<br>'.$fu;
 });
Route::get('/','HomeController@home');
Route::get('/index','HomeController@index');