<?php

///////////////////////////////////////////////////////////////////////////
//Webstart
require_once('../webstart.inc.php');
///////////////////////////////////////////////////////////////////////////

$app = new \Slim\Slim();


$app->post('/user', function () use ($app) {

    //creating DAOs
    $messageDAO = new MessageDAO();
    $userDAO = new UserDAO();
    
    $username = strip_tags($app->request->post('username'));
    $email = strip_tags($app->request->post('email'));
    $password = User::generatePassword($app->request->post('password'));
    $ip = $_SERVER['REMOTE_ADDR'];;

    //all parameter exists
    if ($username == null || $email == null || $password == null) {

        //Fehlende Parameter.
        $message = $messageDAO->newFromCode("S001", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

    $user = new User(-1, $username, $email, true, $password, "", $ip, time(), new UserPermission(), true, false, "");
    if ($userDAO->flushDB($user)) {

        //Nutzer wurde erfolgreich angelegt.
        $message = $messageDAO->newFromCode("A001", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
    } else {

        //Der angegbene Nutzer existiert bereits.
        $message = $messageDAO->newFromCode("A002", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
    }
});


$app->post('/user/login', function () use ($app) {

    //creating DAOs
    $messageDAO = new MessageDAO();
    $userDAO = new UserDAO();

    $username = $app->request->post('username');
    $password = $app->request->post('password');

    //all parameter exists
    if ($username == null || $password == null) {

        //fehlende Parameter.
        $message = $messageDAO->newFromCode("S001", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

    $user = $userDAO->newFromLogin($username, $password);

    if ($user != null) {

        $user->setCookie();

        //Nutzer erfolgreich eingeloggt.
        $message = $messageDAO->newFromCode("A003", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
    } else {

        //Email oder Passwort falsch.
        $message = $messageDAO->newFromCode("A004", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
    }
});

$app->post('/user/login/app', function () use ($app) {

    //creating DAOs
    $messageDAO = new MessageDAO();
    $userDAO = new UserDAO();

    $username = $app->request->post('username');
    $password = $app->request->post('password');

    //all parameter exists
    if ($username == null || $password == null) {

        //fehlende Parameter.
        $message = $messageDAO->newFromCode("S001", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

    $user = $userDAO->newFromLoginApp($username, $password);

    if ($user != null) {

        $user->setCookie();

        //Nutzer erfolgreich eingeloggt.
        $message = $messageDAO->newFromCode("A003", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
    } else {

        //Email oder Passwort falsch.
        $message = $messageDAO->newFromCode("A004", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
    }
});


$app->post('/user/logout', function () use ($app) {

    //creating DAOs
    $messageDAO = new MessageDAO();
    $userDAO = new UserDAO();

    $user = $userDAO->newFromCookie();

    if ($user != null) {

        $user->unsetCookie();

        //Nutzer wurde erfolgreich ausgeloggt.
        $message = $messageDAO->newFromCode("A006", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
    } else {

        //Sie müssen eingeloggt sein um diese Aktion durchzuführen.
        $message = $messageDAO->newFromCode("A005", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
    }
});


$app->get('/user/:id', function ($id) use ($app) {

    //creating DAOs
    $messageDAO = new MessageDAO();
    $userDAO = new UserDAO();

    $user = $userDAO->newFromCookie();

    //user has to be logged in
    if ($user == null) {

        //Sie müssen eingeloggt sein um diese Aktion durchzuführen.
        $message = $messageDAO->newFromCode("A005", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

    //id(int) or me
    if ($id == "me") {

        //Aktion wurde erfolgreich durchgeführt.
        $message = $messageDAO->newFromCode("A007", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType(),
            "userData" => array("id" => $user->getId(), "username" => $user->getUsername(), "email" => $user->getEmail(),
                "emailNotification" => $user->isEmailNotification(), "uploadToken" => $user->getUploadToken())));

    } elseif ($id == "all") {

        //user has the permission
        $userPermission = new UserPermission(3);
        if ($userPermission->isAllowed($user)) {

            $tmpUserData = array();

            // @TODO: Paging
            foreach ($userDAO->getAll(999) as $tmpUser) {

                $tmpUserData[] = array("id" => $tmpUser->getId(), "username" => $tmpUser->getUsername(),
                    "email" => $tmpUser->getEmail(), "lastLogin" => timestampToString($tmpUser->getLastLogin()),
                    "permission" => $tmpUser->getPermission()->toString(), "isActive" => $tmpUser->isAccActive(), "isApproved" => $tmpUser->isAccApproved());
            }

            //Aktion wurde erfolgreich durchgeführt.
            $message = $messageDAO->newFromCode("A007", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType(), "users" => $tmpUserData));
        } else {

            //Sie haben nicht die Berechtigung diese Aktion durchzuführen.
            $message = $messageDAO->newFromCode("A008", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
            return;
        }
    } else {

        $id = (int)$id;

        //user has the permission
        $userPermission = new UserPermission(3);
        if ($userPermission->isAllowed($user)) {

            $requestUser = $userDAO->newFromId($id);

            //Aktion wurde erfolgreich durchgeführt.
            $message = $messageDAO->newFromCode("A007", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType(),
                "userData" => array("id" => $requestUser->getId(), "username" => $requestUser->getUsername(),
                    "email" => $requestUser->getEmail(), "emailNotification" => $requestUser->isEmailNotification())));
        } else {

            //Sie haben nicht die Berechtigung diese Aktion durchzuführen.
            $message = $messageDAO->newFromCode("A008", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
            return;
        }

    }


});

$app->put('/user/:id', function ($id) use ($app) {

    //creating DAOs
    $messageDAO = new MessageDAO();
    $userDAO = new UserDAO();

    $user = $userDAO->newFromCookie();

    //user has to be logged in
    if ($user == null) {

        //Sie müssen eingeloggt sein um diese Aktion durchzuführen.
        $message = $messageDAO->newFromCode("A005", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

    $username = $app->request->params('username');
    $email = $app->request->params('email');
    $emailNotification = $app->request->params('emailNotification');
    $accActive = $app->request->params('active');
    $accApproved = $app->request->params('approved');
    $permission = $app->request->params('permission');

    //all parameter exists
    if (!($username != null || $email != null || $emailNotification != null || $accActive != null || $accApproved != null || $permission != null)) {

        //Fehlende Parameter.
        $message = $messageDAO->newFromCode("S001", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

    //id(int) or me
    if ($id == "me") {

        if($username != null) $user->setUsername(strip_tags($username));
        if($email != null) $user->setEmail(strip_tags($email));
        if($emailNotification != null) $user->setEmailNotification(strToBool($emailNotification));

        if ($userDAO->flushDB($user)) {

            //Daten wurden erfolgreich gespeichert.
            $message = $messageDAO->newFromCode("A009", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        } else {

            //Fehler beim Speichern der Daten.
            $message = $messageDAO->newFromCode("A010", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        }

    } else {

        $id = (int)$id;

        //user has the permission
        $userPermission = new UserPermission(3);
        if ($userPermission->isAllowed($user)) {

            $requestUser = $userDAO->newFromId($id);

            //User exists
            if($requestUser != null) {

                if($username != null)  $requestUser->setUsername(strip_tags($username));
                if($email != null)  $requestUser->setEmail(strip_tags($email));
                if($emailNotification != null)  $requestUser->setEmailNotification(strToBool($emailNotification));
                if($accActive != null) $requestUser->setAccActive(strToBool($accActive));
                if($accApproved != null) $requestUser->setAccApproved(strToBool($accApproved));
                if($permission != null) $requestUser->setPermission(new UserPermission((int)$permission));

                if ($userDAO->flushDB($requestUser)) {

                    //Daten wurden erfolgreich gespeichert.
                    $message = $messageDAO->newFromCode("A009", SYSTEM_LANGUAGE);
                    echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
                } else {

                    //Fehler beim Speichern der Daten.
                    $message = $messageDAO->newFromCode("A010", SYSTEM_LANGUAGE);
                    echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
                    return;
                }

            }
            else {

                //Der angeforderte Nutzer existiert nicht.
                $message = $messageDAO->newFromCode("A011", SYSTEM_LANGUAGE);
                echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
                return;
            }

        } else {

            //Sie haben nicht die Berechtigung diese Aktion durchzuführen.
            $message = $messageDAO->newFromCode("A008", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
            return;
        }

    }

});

$app->put('/user/me/password', function () use ($app) {

    //creating DAOs
    $messageDAO = new MessageDAO();
    $userDAO = new UserDAO();

    $user = $userDAO->newFromCookie();

    //user has to be logged in
    if ($user == null) {

        //Sie müssen eingeloggt sein um diese Aktion durchzuführen.
        $message = $messageDAO->newFromCode("A005", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

    $oldPassword = $app->request->params('oldpwd');
    $newPassword = $app->request->params('newpwd');

    //all parameter exists
    if ($oldPassword == null || $newPassword == null ) {

        //Fehlende Parameter.
        $message = $messageDAO->newFromCode("S001", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

    //crypt passwords
    $oldPassword = User::generatePassword($oldPassword);
    $newPassword = User::generatePassword($newPassword);

    //set new password
    //is old password correct?
    if($user->setPassword($oldPassword, $newPassword)) {

        //Das alte Passwort ist nicht korrekt.
        $message = $messageDAO->newFromCode("A012", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

    if ($userDAO->flushDB($user)) {

        //Daten wurden erfolgreich gespeichert.
        $message = $messageDAO->newFromCode("A009", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

    //Fehler beim Speichern der Daten.
    $message = $messageDAO->newFromCode("A010", SYSTEM_LANGUAGE);
    echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
    return;

});

/**
 * !!!only for functional tests!!!
 */
$app->delete('/user/me', function () use ($app) {

    //creating DAOs
    $messageDAO = new MessageDAO();
    $userDAO = new UserDAO();
    
    $user = $userDAO->newFromCookie();

    //user has to be logged in
    if ($user == null) {

        //Sie müssen eingeloggt sein um diese Aktion durchzuführen.
        $message = $messageDAO->newFromCode("A005", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

    if($userDAO->delete($user)) {

        //Aktion wurde erfolgreich durchgeführt.
        $message = $messageDAO->newFromCode("A007", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

    //error if its not possible to delete
    $message = $messageDAO->newFromCode("A010", SYSTEM_LANGUAGE);
    echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
    return;

});

$app->get('/file/:id', function ($id) use ($app) {

    //creating DAOs
    $messageDAO = new MessageDAO();
    $userDAO = new UserDAO();
    $videoDAO = new VideoDAO();
    
    $user = $userDAO->newFromCookie();

    //user has to be logged in
    if ($user == null) {

        //Sie müssen eingeloggt sein um diese Aktion durchzuführen.
        $message = $messageDAO->newFromCode("A005", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }


    if ($id == "all") {

            $tmpFilesData = array();

            // @TODO: Paging
            foreach ($videoDAO->getAll(999, $user) as $tmpFile) {

                $tmpFilesData[] = array("id" => $tmpFile->getId(), "title" => $tmpFile->getCaption(), "thumbnailUrl" => $tmpFile->getThumbURI(), "fileUrl" => $tmpFile->getURI(),
                    "date" => $tmpFile->getUploadedAt(), "dateStr" => $tmpFile->getUploadedAtStr(), "lat" => $tmpFile->getLat(), "lng" => $tmpFile->getLng(),
                    "length" => $tmpFile->getLength(), "size" => $tmpFile->getSize(), "resolution" => $tmpFile->getResolution());
            }

            //Aktion wurde erfolgreich durchgeführt.
            $message = $messageDAO->newFromCode("A007", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType(), "files" => $tmpFilesData));
    } else {

        $id = (int)$id;

        $tmpFile = $videoDAO->newFromId($id);

        //File exists
        if($tmpFile == null) {

            //Der angeforderte Nutzer existiert nicht.
            $message = $messageDAO->newFromCode("A011", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
            return;
        }

        //user has the permission
        $userPermission = new UserPermission(3);
        if ($userPermission->isAllowed($user) || $user->getId() == $tmpFile->getOwnerId()) {

            //Aktion wurde erfolgreich durchgeführt.
            $message = $messageDAO->newFromCode("A007", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType(),
                "fileData" => array("id" => $tmpFile->getId(), "title" => $tmpFile->getCaption(), "thumbnailUrl" => $tmpFile->getThumbURI(), "fileUrl" => $tmpFile->getURI(),
                    "date" => $tmpFile->getUploadedAt(), "dateStr" => $tmpFile->getUploadedAtStr(), "lat" => $tmpFile->getLat(), "lng" => $tmpFile->getLng(),
                    "length" => $tmpFile->getLength(), "size" => $tmpFile->getSize(), "resolution" => $tmpFile->getResolution())));
        } else {

            //Sie haben keine Berechtigung diese Aktion durchzuführen.
            $message = $messageDAO->newFromCode("A008", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
            return;
        }
    }
});


$app->delete('/file/:id', function ($id) use ($app) {

    //creating DAOs
    $messageDAO = new MessageDAO();
    $userDAO = new UserDAO();
    $videoDAO = new VideoDAO();
    
    $user = $userDAO->newFromCookie();

    //user has to be logged in
    if ($user == null) {

        //Sie müssen eingeloggt sein um diese Aktion durchzuführen.
        $message = $messageDAO->newFromCode("A005", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

    //select file object
    $id = (int)$id;
    $tmpFile = $videoDAO->newFromId($id);

    //file exists
    if($tmpFile == null) {

        //Der angeforderte Nutzer existiert nicht.
        $message = $messageDAO->newFromCode("A011", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

    //user has the permission
    $userPermission = new UserPermission(3);
    if ($userPermission->isAllowed($user) || $user->getId() == $tmpFile->getOwnerId()) {

        if($videoDAO->delete($tmpFile)) {

            //Aktion wurde erfolgreich durchgeführt.
            $message = $messageDAO->newFromCode("A007", SYSTEM_LANGUAGE);
            echo json_encode(array("error" => 0, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
            return;
        }

        //error if its not possible to delete
        $message = $messageDAO->newFromCode("A010", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;

    } else {

        //Sie haben keine Berechtigung diese Aktion durchzuführen.
        $message = $messageDAO->newFromCode("A008", SYSTEM_LANGUAGE);
        echo json_encode(array("error" => 1, "errorMsg" => $message->getMsg(), "errorType" => $message->getType()));
        return;
    }

});


$app->run();