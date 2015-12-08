<?php

///////////////////////////////////////////////////////////////////////////
//Webstart
require_once('../webstart.inc.php');
///////////////////////////////////////////////////////////////////////////

$app = new \Slim\Slim();


$app->post('/user', function () use ($app) {

    $username = strip_tags($app->request->post('username'));
    $email = strip_tags($app->request->post('email'));
    $password = User::generatePassword($app->request->post('password'));
    $ip = $_SERVER['REMOTE_ADDR'];

    //all parameter exists
    if ($username == null || $email == null || $password == null) {

        $message = Message::newFromCode("S001", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

    $user = new User(-1, $username, $email, true, false, "", $password, "", $ip, time(), new UserPermission(), true);
    if ($user->flushDB()) {

        $message = Message::newFromCode("A001", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
    } else {

        $message = Message::newFromCode("A002", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
    }
});


$app->post('/user/login', function () use ($app) {

    $username = $app->request->post('username');
    $password = $app->request->post('password');

    //all parameter exists
    if ($username == null || $password == null) {

        $message = Message::newFromCode("S001", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

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
        $user->setToken("");
        $user->flushDB();

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
    if ($id == "me") {

        $message = Message::newFromCode("A007", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType(),
            "userData" => array("id" => $user->getId(), "username" => $user->getUsername(), "email" => $user->getEmail(),
                "emailNotification" => $user->isEmailNotification())));

    } elseif ($id == "all") {

        //user has the permission
        $userPermission = new UserPermission(3);
        if ($userPermission->isAllowed($user)) {

            $tmpUserData = array();

            // @TODO: Paging
            foreach (User::getAll(999) as $tmpUser) {

                $tmpUserData[] = array("id" => $tmpUser->getId(), "username" => $tmpUser->getUsername(),
                    "email" => $tmpUser->getEmail(), "emailVerified" => $tmpUser->isEmailVerified(), "lastLogin" => timestampToString($tmpUser->getLastLogin()),
                    "permission" => $tmpUser->getPermission()->toString(), "active" => $tmpUser->isActive());
            }

            $message = Message::newFromCode("A007", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType(), "users" => $tmpUserData));
        } else {

            $message = Message::newFromCode("A008", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
            return;
        }
    } else {

        $id = (int)$id;

        //user has the permission
        $userPermission = new UserPermission(3);
        if ($userPermission->isAllowed($user)) {

            $requestUser = User::newFromId($id);

            $message = Message::newFromCode("A007", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType(),
                "userData" => array("id" => $requestUser->getId(), "username" => $requestUser->getUsername(),
                    "email" => $requestUser->getEmail(), "emailNotification" => $requestUser->isEmailNotification())));
        } else {

            $message = Message::newFromCode("A008", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
            return;
        }

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

    $username = strip_tags($app->request->post('username'));
    $email = strip_tags($app->request->post('email'));
    $emailNotification = strToBool($app->request->post('emailNotification'));
    $permission = (int)$app->request->post('permission');

    //all parameter exists
    if (!($username != null || $email != null || $emailNotification != null || $permission != null)) {

        $message = Message::newFromCode("S001", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

    //id(int) or me
    if ($id == "me") {

        if ($username != null) $user->setUsername($username);
        if ($email != null) $user->setEmail($email);
        if ($emailNotification != null) $user->setEmailNotification($emailNotification);

        if ($user->flushDB()) {

            $message = Message::newFromCode("A009", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        } else {

            $message = Message::newFromCode("A002", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        }

    } else {

        $id = (int)$id;

        //user has the permission
        $userPermission = new UserPermission(3);
        if ($userPermission->isAllowed($user)) {

            $requestUser = User::newFromId($id);

            //User exists
            if ($requestUser != null) {

                if ($username != null) $user->setUsername($username);
                if ($email != null) $user->setEmail($email);
                if ($emailNotification != null) $user->setEmailNotification($emailNotification);

                //if isset permission
                if ($permission != null) {

                    $newPermission = new UserPermission($permission);
                    $requestUser->setPermission($newPermission);
                }

                if ($requestUser->flushDB()) {

                    $message = Message::newFromCode("A009", SYSTEM_LANGUAGE);
                    echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
                } else {

                    $message = Message::newFromCode("A010", SYSTEM_LANGUAGE);
                    echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
                    return;
                }

            } else {

                $message = Message::newFromCode("A011", SYSTEM_LANGUAGE);
                echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
                return;
            }

        } else {

            $message = Message::newFromCode("A008", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
            return;
        }

    }

});

$app->put('/user/me/changepassword', function () use ($app) {

    $user = User::newFromCookie();

    //user has to be logged in
    if ($user == null) {

        $message = Message::newFromCode("A005", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

    $oldPassword = strip_tags($app->request->put('oldpassword'));
    $newPassword = strip_tags($app->request->put('newpassword'));

    //all parameter exists
    if ($oldPassword == null || $newPassword == null) {

        $message = Message::newFromCode("S001", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

    $oldPassword = User::generatePassword($oldPassword);
    $newPassword = User::generatePassword($newPassword);

    //old password ist correct
    if ($user->setPassword($oldPassword, $newPassword)) {

        $user->flushDB();

        $message = Message::newFromCode("A009", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));

    } else {
        $message = Message::newFromCode("A012", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
    }
});


$app->get('/file/:id', function ($id) use ($app) {

    $user = User::newFromCookie();

    //user has to be logged in
    if ($user == null) {

        $message = Message::newFromCode("A005", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }


    if ($id == "all") {

        //user has the permission
        $userPermission = new UserPermission(3);
        if ($userPermission->isAllowed($user)) {

            $tmpFilesData = array();

            // @TODO: Paging
            foreach (VideoFile::getAll(999, $user) as $tmpFile) {

                $tmpFilesData[] = array("id" => $tmpFile->getId(), "title" => $tmpFile->getId(), "imageUrl" => $tmpFile->getThumbURI(),
                    "date" => $tmpFile->getUploadedAt(), "lat" => $tmpFile->getLat(), "lng" => $tmpFile->getLng(),
                    "length" => $tmpFile->getLength(), "size" => $tmpFile->getSize());
            }

            $message = Message::newFromCode("A007", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType(), "files" => $tmpFilesData));
        } else {

            $message = Message::newFromCode("A008", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
            return;
        }
    } else {

        $id = (int)$id;

        $tmpFile = VideoFile::newFromId($id);

        //File exists
        if ($tmpFile != null) {

            $message = Message::newFromCode("A007", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType(),
                "fileData" => array("id" => $tmpFile->getId(), "title" => $tmpFile->getId(), "imageUrl" => $tmpFile->getThumbURI(),
                    "date" => $tmpFile->getUploadedAt(), "lat" => $tmpFile->getLat(), "lng" => $tmpFile->getLng(),
                    "length" => $tmpFile->getLength(), "size" => $tmpFile->getSize())));

        } else {

            $message = Message::newFromCode("A011", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
            return;
        }
    }


});

$app->run();