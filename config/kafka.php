<?php

return [

  'producer'    => [
  	'host' => '127.0.0.1',
  	'port' => '9092',
  	'version' => '1.0.0',
  	'interval' => 500,
  	'refreshInterval' => 10000
  ],

  'consumer'      => [
    'host' => '127.0.0.1',
    'port' => '9092',
    'version' => '1.0.0',
    'interval' => 500,
    'refreshInterval' => 10000

  ],
  'topic' => 'webchat',
  'group' => 'group_webchat'

  ];