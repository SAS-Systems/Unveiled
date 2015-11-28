<?php
require '../lib/Slim/Slim.php';
\Slim\Slim::registerAutoloader();


$app = new \Slim\Slim();

$app->get('/hello/:name', function ($name) {

    echo "Hello, " . $name;
});

$app->run();