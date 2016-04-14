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
    $ip = $_SERVER['REMOTE_ADDR'];;

    //all parameter exists
    if ($username == null || $email == null || $password == null) {

        $message = Message::newFromCode("S001", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

    $user = new User(-1, $username, $email, true, $password, "", $ip, time(), new UserPermission(), true, false);
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
                    "email" => $tmpUser->getEmail(), "lastLogin" => timestampToString($tmpUser->getLastLogin()),
                    "permission" => $tmpUser->getPermission()->toString());
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

    $username = $app->request->params('username');
    $email = $app->request->params('email');
    $emailNotification = $app->request->params('emailNotification');
    $accActive = $app->request->params('active');
    $accApproved = $app->request->params('approved');

    //all parameter exists
    if (!($username != null || $email != null || $emailNotification != null || $accActive != null || $accApproved != null)) {

        $message = Message::newFromCode("S001", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

    //id(int) or me
    if ($id == "me") {

        if($username != null) $user->setUsername(strip_tags($username));
        if($email != null) $user->setEmail(strip_tags($email));
        if($emailNotification != null) $user->setEmailNotification(strToBool($emailNotification));

        if ($user->flushDB()) {

            $message = Message::newFromCode("A009", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        } else {

            $message = Message::newFromCode("A010", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        }

    } else {

        $id = (int)$id;

        //user has the permission
        $userPermission = new UserPermission(3);
        if ($userPermission->isAllowed($user)) {

            $requestUser = User::newFromId($id);

            //User exists
            if($requestUser != null) {

                if($username != null)  $requestUser->setUsername(strip_tags($username));
                if($email != null)  $requestUser->setEmail(strip_tags($email));
                if($emailNotification != null)  $requestUser->setEmailNotification(strToBool($emailNotification));
                if($accActive != null) $requestUser->setAccActive(strToBool($accActive));
                if($accApproved != null) $requestUser->setAccApproved(strToBool($accApproved));

                if ($requestUser->flushDB()) {

                    $message = Message::newFromCode("A009", SYSTEM_LANGUAGE);
                    echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
                } else {

                    $message = Message::newFromCode("A010", SYSTEM_LANGUAGE);
                    echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
                    return;
                }

            }
            else {

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

$app->delete('/user/me', function ($id) use ($app) {

    $user = User::newFromCookie();

    //user has to be logged in
    if ($user == null) {

        $message = Message::newFromCode("A005", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

    if($user->delete()) {

        $message = Message::newFromCode("A007", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

    //error if its not possible to delete
    $message = Message::newFromCode("A010", SYSTEM_LANGUAGE);
    echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
    return;

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

            $tmpFilesData = array();

            // @TODO: Paging
            foreach (VideoFile::getAll(999, $user) as $tmpFile) {

                $tmpFilesData[] = array("id" => $tmpFile->getId(), "title" => $tmpFile->getCaption(), "imageUrl" => $tmpFile->getThumbURI(), "fileUrl" => $tmpFile->getURI(),
                    "date" => $tmpFile->getUploadedAt(), "dateStr" => $tmpFile->getUploadedAtStr(), "lat" => $tmpFile->getLat(), "lng" => $tmpFile->getLng(),
                    "length" => $tmpFile->getLength(), "size" => $tmpFile->getSize(), "resolution" => $tmpFile->getResolution());
            }

            $message = Message::newFromCode("A007", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType(), "files" => $tmpFilesData));
    } else {

        $id = (int)$id;

        $tmpFile = VideoFile::newFromId($id);

        //File exists
        if($tmpFile == null) {

            $message = Message::newFromCode("A011", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
            return;
        }

        //user has the permission
        $userPermission = new UserPermission(3);
        if ($userPermission->isAllowed($user) || $user->getId() == $tmpFile->getOwnerId()) {

            $message = Message::newFromCode("A007", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType(),
                "fileData" => array("id" => $tmpFile->getId(), "title" => $tmpFile->getCaption(), "imageUrl" => $tmpFile->getThumbURI(), "fileUrl" => $tmpFile->getURI(),
                    "date" => $tmpFile->getUploadedAt(), "dateStr" => $tmpFile->getUploadedAtStr(), "lat" => $tmpFile->getLat(), "lng" => $tmpFile->getLng(),
                    "length" => $tmpFile->getLength(), "size" => $tmpFile->getSize(), "resolution" => $tmpFile->getResolution())));
        } else {

            $message = Message::newFromCode("A008", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
            return;
        }
    }
});


$app->delete('/file/:id', function ($id) use ($app) {

    $user = User::newFromCookie();

    //user has to be logged in
    if ($user == null) {

        $message = Message::newFromCode("A005", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

    //select file object
    $id = (int)$id;
    $tmpFile = VideoFile::newFromId($id);

    //file exists
    if($tmpFile == null) {

        $message = Message::newFromCode("A011", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

    //user has the permission
    $userPermission = new UserPermission(3);
    if ($userPermission->isAllowed($user) || $user->getId() == $tmpFile->getOwnerId()) {

        if($tmpFile->delete()) {

            $message = Message::newFromCode("A007", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
            return;
        }

        //error if its not possible to delete
        $message = Message::newFromCode("A010", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;

    } else {

        $message = Message::newFromCode("A008", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

});


$app->run();