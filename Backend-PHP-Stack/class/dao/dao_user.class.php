<?php

class UserDAO implements userDAOinterface {

    public function __construct() {

    }

    /**
     * return object from class
     * @param $id
     * @return object
     */
    public function newFromId($id)
    {
        global $dbConn;

        if (is_int($id)) {

            $res = $dbConn->query("SELECT * FROM user WHERE id = '$id'");
            $row = $res->fetch_object();

            //Logg all MySQL errors
            if ($dbConn->error != "") {

                //Log error
                errorLog::newEntry("MySQL error: " . $dbConn->error, 2, __FILE__, __CLASS__, __FUNCTION__);
            }

            if ($row != null) {

                $db_id = (int)$row->id;
                $db_username = utf8_encode($row->username);
                $db_email = $row->email;
                $db_emailNotification = intToBool((int)$row->email_notification_flag);
                $db_password = $row->password;
                $db_token = $row->token;
                $db_lastIP = $row->last_ip;
                $db_lastLogin = (int)$row->last_login;
                $db_permission = new UserPermission((int)$row->permission);
                $db_acc_active = intToBool((int)$row->acc_active);
                $db_acc_approved = intToBool((int)$row->acc_approved);

                return new User($db_id, $db_username, $db_email, $db_emailNotification, $db_password, $db_token, $db_lastIP, $db_lastLogin, $db_permission, $db_acc_active, $db_acc_approved);
            } else {

                return null;
            }

        } else {

            return null;
        }
    }

    /**
     * flushed the object to DB
     * @return boolean
     */
    public function flushDB($user)
    {
        global $dbConn;

        $id = (int)$user->getId();
        $username = utf8_decode(strip_tags($user->getUsername()));
        $email = $user->getEmail();
        $emailNotification = boolToInt($user->isEmailNotification());
        $password = $user->getPassword();
        $token = $user->getToken();
        $lastIP = $user->getLastIP();
        $lastLogin = (int)$user->getLastLogin();
        $permission = $user->getPermission()->getLevel();
        $accActive = boolToInt($user->isAccActive());
        $accApproved = boolToInt($user->isAccApproved());

        //object exists in DB
        if($this->existsInDB($user)) {

            $query = "UPDATE user SET username=?, email=?, email_notification_flag=?, password=?, token=?, last_ip=?, last_login=?, permission=?, acc_active=?, acc_approved=? WHERE id=?";
            $query_stmt = $dbConn->prepare($query);

            $query_stmt->bind_param('ssisssiiiii', $username, $email, $emailNotification, $password, $token, $lastIP, $lastLogin, $permission, $accActive, $accApproved, $id);
            $query_stmt->execute();

            //Logg all MySQL errors
            if ($dbConn->error != "") {

                //Log error
                errorLog::newEntry("MySQL error: " . $dbConn->error, 2, __FILE__, __CLASS__, __FUNCTION__);

                return false;
            }
            else {

                return true;
            }
        }
        else {

            $query = "INSERT INTO user (username, email, email_notification_flag, password, token, last_ip, last_login, permission, acc_active, acc_approved) VALUES (?,?,?,?,?,?,?,?,?,?)";
            $query_stmt = $dbConn->prepare($query);

            $query_stmt->bind_param('ssisssiiii', $username, $email, $emailNotification, $password, $token, $lastIP, $lastLogin, $permission, $accActive, $accApproved);
            $query_stmt->execute();

            //Logg all MySQL errors
            if ($dbConn->error != "") {

                //Log error
                errorLog::newEntry("MySQL error: " . $dbConn->error, 2, __FILE__, __CLASS__, __FUNCTION__);

                return false;
            }

            if ($dbConn->affected_rows > 0) {

                $user->setId((int)$dbConn->insert_id);

                return true;
            }
            else {

                return false;
            }
        }
    }

    /**
     * check if the object exists in DB or if it's a new entry
     * @return boolean
     */
    public function existsInDB($user)
    {
        if($user->getId() > 0) {

            return true;
        }
        else {

            return false;
        }
    }

    /**
     * @param $id
     * @param $token
     * @return object
     */
    public function newFromToken($id, $token)
    {
        global $dbConn;

        $id = (int)$id;
        $token = $dbConn->real_escape_string($token);

        if (User::isTokenValid($token, $id)) {

            $res = $dbConn->query("SELECT * FROM user WHERE token = '$token'");
            $row = $res->fetch_object();

            //Logg all MySQL errors
            if ($dbConn->error != "") {

                //Log error
                errorLog::newEntry("MySQL error: " . $dbConn->error, 2, __FILE__, __CLASS__, __FUNCTION__);
            }

            if ($row != null) {

                $db_id = (int)$row->id;
                $db_username = utf8_encode($row->username);
                $db_email = $row->email;
                $db_emailNotification = intToBool((int)$row->email_notification_flag);
                $db_password = $row->password;
                $db_token = $row->token;
                $db_lastIP = $row->last_ip;
                $db_lastLogin = (int)$row->last_login;
                $db_permission = new UserPermission((int)$row->permission);
                $db_acc_active = intToBool((int)$row->acc_active);
                $db_acc_approved = intToBool((int)$row->acc_approved);

                return new User($db_id, $db_username, $db_email, $db_emailNotification, $db_password, $db_token, $db_lastIP, $db_lastLogin, $db_permission, $db_acc_active, $db_acc_approved);
            } else {

                return null;
            }

        } else {

            return null;
        }
    }

    /**
     * @return object
     */
    public function newFromCookie()
    {
        if (isset($_COOKIE["loginID"]) && $_COOKIE["loginID"] != '' && isset($_COOKIE["loginToken"]) && $_COOKIE["loginToken"] != '') {

            $u = $this->newFromToken($_COOKIE["loginID"], $_COOKIE["loginToken"]);
            return $u;
        } else {

            return null;
        }
    }

    /**
     * @param $username
     * @param $password
     * @return object
     */
    public function newFromLogin($username, $password)
    {
        global $dbConn;
        global $gvCryptSalt;

        $username = $dbConn->real_escape_string($username);
        $password = $dbConn->real_escape_string($password);

        $res = $dbConn->query("SELECT * FROM user WHERE username = '$username'");
        $row = $res->fetch_object();

        //Logg all MySQL errors
        if ($dbConn->error != "") {

            //Log error
            errorLog::newEntry("MySQL error: " . $dbConn->error, 2, __FILE__, __CLASS__, __FUNCTION__);
        }

        if ($row != null) {

            $db_id = (int)$row->id;
            $db_username = utf8_encode($row->username);
            $db_email = $row->email;
            $db_emailNotification = intToBool((int)$row->email_notification_flag);
            $db_password = $row->password;
            $db_token = $row->token;
            $db_lastIP = $row->last_ip;
            $db_lastLogin = (int)$row->last_login;
            $db_permission = new UserPermission((int)$row->permission);
            $db_acc_active = intToBool((int)$row->acc_active);
            $db_acc_approved = intToBool((int)$row->acc_approved);

            if (crypt($password, $gvCryptSalt) == $db_password) {

                $u = new User($db_id, $db_username, $db_email, $db_emailNotification, $db_password, $db_token, $db_lastIP, $db_lastLogin, $db_permission, $db_acc_active, $db_acc_approved);

                $u->setToken(User::generateToken($db_id));
                $u->setLastLogin(time());
                $u->setLastIP($_SERVER['REMOTE_ADDR']);

                $this->flushDB($u);

                return $u;

            } else {

                return null;
            }

        } else {

            return null;
        }
    }

    /**
     * @param int $limit
     * @return array[object]
     */
    public function getAll($limit = 99)
    {
        global $dbConn;

        $limit = (int)$limit;
        $res = $dbConn->query("SELECT * FROM user LIMIT 0, " . $limit);

        //Logg all MySQL errors
        if ($dbConn->error != "") {

            //Log error
            errorLog::newEntry("MySQL error: " . $dbConn->error, 2, __FILE__, __CLASS__, __FUNCTION__);
        }

        $tmp = array();

        while ($row = $res->fetch_object()) {

            $db_id = (int)$row->id;
            $db_username = utf8_encode($row->username);
            $db_email = $row->email;
            $db_emailNotification = intToBool((int)$row->email_notification_flag);
            $db_password = $row->password;
            $db_token = $row->token;
            $db_lastIP = $row->last_ip;
            $db_lastLogin = (int)$row->last_login;
            $db_permission = new UserPermission((int)$row->permission);
            $db_acc_active = intToBool((int)$row->acc_active);
            $db_acc_approved = intToBool((int)$row->acc_approved);

            $user = new User($db_id, $db_username, $db_email, $db_emailNotification, $db_password, $db_token, $db_lastIP, $db_lastLogin, $db_permission, $db_acc_active, $db_acc_approved);

            $tmp[] = $user;
        }

        return $tmp;
    }

    /**
     * @return boolean
     */
    public function delete($user)
    {
        global $dbConn;

        $id = (int)$user->getId();

        $res = $dbConn->query("DELETE FROM user WHERE id=$id");

        //Logg all MySQL errors
        if ($dbConn->error != "") {

            //Log error
            errorLog::newEntry("MySQL error: " . $dbConn->error, 2, __FILE__, __CLASS__, __FUNCTION__);
        }


        if ($dbConn->affected_rows > 0) {

            return true;
        }

        return false;
    }
}