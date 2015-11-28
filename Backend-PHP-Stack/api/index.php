<?php

///////////////////////////////////////////////////////////////////////////
//Webstart
require_once('../webstart.inc.php');
///////////////////////////////////////////////////////////////////////////

$app = new \Slim\Slim();


$app->post('/user', function () use($app) {

    $userData = json_decode($app->request->post('data'));

    var_dump($userData);

    /*$username = $userData->username;
    $email = $userData->email;
    $password = User::generatePassword($userData->password);
    $ip = $_SERVER['REMOTE_ADDR'];;

    $user = new User(-1, $username, $email, true, $password, "", $ip, time(), new UserPermission());
    if($user->flushDB()) {

        $message = Message::newFromCode("A001", SYSTEM_LANGUAGE);

        echo json_encode(array ("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
    }*/
});




$app->run();