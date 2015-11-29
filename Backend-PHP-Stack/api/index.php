<?php

///////////////////////////////////////////////////////////////////////////
//Webstart
require_once('../webstart.inc.php');
///////////////////////////////////////////////////////////////////////////

$app = new \Slim\Slim();


$app->post('/user', function () use ($app) {

    $userData = json_decode($app->request->post('data'));

    //catch JSON errors
    if ($message = JSONerrorCatch() != null) {

        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

    //all parameter exists
    if (!(isset($userData->username) && isset($userData->email) && isset($userData->password))) {

        $message = Message::newFromCode("S001", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

    $username = $userData->username;
    $email = $userData->email;
    $password = User::generatePassword($userData->password);
    $ip = $_SERVER['REMOTE_ADDR'];;

    $user = new User(-1, $username, $email, true, $password, "", $ip, time(), new UserPermission());
    if ($user->flushDB()) {

        $message = Message::newFromCode("A001", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
    } else {

        $message = Message::newFromCode("A002", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
    }
});


$app->post('/user/login', function () use ($app) {

    $userData = json_decode($app->request->post('data'));

    //catch JSON errors
    if ($message = JSONerrorCatch() != null) {

        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

    //all parameter exists
    if (!(isset($userData->username) && isset($userData->password))) {

        $message = Message::newFromCode("S001", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

    $username = $userData->username;
    $password = $userData->password;

    $user = User::newFromLogin($username, $password);

    if ($user != null) {

        $user->setCookie();
        $message = Message::newFromCode("A003", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
    } else {

        $message = Message::newFromCode("A004", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
    }
});


$app->post('/user/logout', function () use ($app) {

    $user = User::newFromCookie();

    if ($user != null) {

        $user->unsetCookie();
        $message = Message::newFromCode("A006", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
    } else {

        $message = Message::newFromCode("A005", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
    }
});


$app->get('/user/:id', function ($id) use ($app) {

    $user = User::newFromCookie();

    //user has to be logged in
    if ($user == null) {

        $message = Message::newFromCode("A005", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }


    if (is_int($id)) {




    } else {

        $message = Message::newFromCode("A007", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType(),
            "userData" => array("id" => $user->getId(), "username" => $user->getUsername(), "email" => $user->getEmail(),
                "emailNotification" => $user->isEmailNotification())));
    }


});


$app->run();