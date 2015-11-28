<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
set_time_limit ( 999 );

require '../lib/Slim/Slim.php';
\Slim\Slim::registerAutoloader();


echo "test";

$app = new \Slim\Slim();

$app->get('/hello/:name', function ($name) {

    echo "Hello, " . $name;
});

$app->get('/test', function () {

    echo "Hello, ";
});

$app->run();