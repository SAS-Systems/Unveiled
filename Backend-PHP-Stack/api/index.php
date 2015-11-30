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

    $username = strip_tags($userData->username);
    $email = strip_tags($userData->email);
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

    //id(int) or me
    if ($id != "me") {

        $id = (int)$id;

        //user has the permission
        $userPermission = new UserPermission(3);
        if($userPermission->isAllowed($user)) {

            $requestUser = User::newFromId($id);

            $message = Message::newFromCode("A007", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType(),
                "userData" => array("id" => $requestUser->getId(), "username" => $requestUser->getUsername(),
                    "email" => $requestUser->getEmail(), "emailNotification" => $requestUser->isEmailNotification())));
        }
        else {

            $message = Message::newFromCode("A008", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
            return;
        }

    } else {

        $message = Message::newFromCode("A007", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType(),
            "userData" => array("id" => $user->getId(), "username" => $user->getUsername(), "email" => $user->getEmail(),
                "emailNotification" => $user->isEmailNotification())));
    }


});

$app->put('/user/:id', function ($id) use ($app) {

    $user = User::newFromCookie();

    //user has to be logged in
    if ($user == null) {

        $message = Message::newFromCode("A005", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

    $userData = json_decode($app->request->post('data'));

    //catch JSON errors
    if ($message = JSONerrorCatch() != null) {

        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

    //all parameter exists
    if(!(isset($userData->username) && isset($userData->email) && isset($userData->emailNotification))) {

        $message = Message::newFromCode("S001", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

    $username = strip_tags($userData->username);
    $email = strip_tags($userData->email);
    $emailNotification = (bool)$userData->emailNotification;

    //id(int) or me
    if ($id != "me") {

        $id = (int)$id;

        //user has the permission
        $userPermission = new UserPermission(3);
        if($userPermission->isAllowed($user)) {

            $requestUser = User::newFromId($id);

            $requestUser->setUsername($username);
            $requestUser->setEmail($email);
            $requestUser->setEmailNotification($emailNotification);

            if($requestUser->flushDB()) {

                $message = Message::newFromCode("A009", SYSTEM_LANGUAGE);
                echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
            }
            else {

                $message = Message::newFromCode("A010", SYSTEM_LANGUAGE);
                echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
            }

        }
        else {

            $message = Message::newFromCode("A008", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
            return;
        }

    }
    else {

        $user->setUsername($username);
        $user->setEmail($email);
        $user->setEmailNotification($emailNotification);

        if($user->flushDB()) {

            $message = Message::newFromCode("A009", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        }
        else {

            $message = Message::newFromCode("A010", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        }
    }

});

$app->get('/allUser', function () use ($app) {

    $user = User::newFromCookie();

    //user has to be logged in
    if ($user == null) {

        $message = Message::newFromCode("A005", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

    //user has the permission
    $userPermission = new UserPermission(3);
    if($userPermission->isAllowed($user)) {

        $tmpUserData = array();

        // @TODO: Paging
        foreach (User::getAll(999) as $tmpUser) {

            $tmpUserData[] = array ("id" => $tmpUser->getId(), "username" => $tmpUser->getUsername(),
                "email" => $tmpUser->getEmail(), "lastLogin" => timestampToString($tmpUser->getLastLogin()),
                "permission" => $tmpUser->getPermission()->toString());
        }

        $message = Message::newFromCode("A007", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType(), "users" => $tmpUserData));
    }
    else {

        $message = Message::newFromCode("A008", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

});


$app->run();