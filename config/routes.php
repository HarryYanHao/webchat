<?php

use NoahBuscher\Macaw\Macaw;


Macaw::get('(:all)', function($fu) {
  echo '未匹配到路由<br>'.$fu;
});
Macaw::get('/','HomeController@home');
Macaw::get('/index','HomeController@index');
Macaw::post('/send','ChatController@send');
Macaw::post('/addUser','ChatController@addUser');
Macaw::post('/delUser','ChatController@delUser');

