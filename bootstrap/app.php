<?php
$app = new Illuminate\Application\Application();

$app->bind('kernel','App\Http\Kernel');

return $app;