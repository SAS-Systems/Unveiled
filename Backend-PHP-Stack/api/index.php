<?php

use Phalcon\Mvc\Micro;

$app = new Micro();

// Retrieves all robots
$app->get('/test', function () {



    echo "test erfolgreich";
});

$app->handle();