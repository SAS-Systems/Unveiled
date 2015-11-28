<?php

///////////////////////////////////////////////////////////////////////////
//Webstart
require_once('../webstart.inc.php');
///////////////////////////////////////////////////////////////////////////

$app = new \Slim\Slim();


$app->get('/hello/:name', function ($name) {

    echo "Hello, " . $name;
});


$app->get('/test', function () {

    echo "Hello, ";
});

$app->run();