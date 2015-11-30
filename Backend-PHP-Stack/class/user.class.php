<?php

class User
{

    private $id = -1;
    private $username = "";
    private $email = "";
    private $emailNotification = false; // Int
    private $password = ""; //Crypt
    private $token = "";
    private $lastIP = "";
    private $lastLogin = 0; //Timestamp
    private $permission;

    /**
     * User constructor.
     * @param int $id
     * @param string $username
     * @param string $email
     * @param bool $emailNotification
     * @param string $password
     * @param string $token
     * @param string $lastIP
     * @param int $lastLogin
     * @param UserPermission $permission
     */
    public function __construct($id, $username, $email, $emailNotification, $password, $token, $lastIP, $lastLogin, UserPermission $permission)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->emailNotification = $emailNotification;
        $this->password = $password;
        $this->token = $token;
        $this->lastIP = $lastIP;
        $this->lastLogin = $lastLogin;
        $this->permission = $permission;
    }


    public static function newFromToken($id, $token)
    {
        global $dbConn;

        $id = (int)$id;
        $token = $dbConn->real_escape_string($token);

        if (self::isTokenValid($token, $id)) {

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

                return new User($db_id, $db_username, $db_email, $db_emailNotification, $db_password, $db_token, $db_lastIP, $db_lastLogin, $db_permission);
            } else {

                return null;
            }

        } else {

            return null;
        }

    }

    public static function newFromCookie()
    {

        if (isset($_COOKIE["loginID"]) && $_COOKIE["loginID"] != '' && isset($_COOKIE["loginToken"]) && $_COOKIE["loginToken"] != '') {

            $u = self::NewFromToken($_COOKIE["loginID"], $_COOKIE["loginToken"]);
            return $u;
        } else {

            return null;
        }
    }

    public static function newFromId($id)
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

                return new User($db_id, $db_username, $db_email, $db_emailNotification, $db_password, $db_token, $db_lastIP, $db_lastLogin, $db_permission);
            } else {

                return null;
            }

        } else {

            return null;
        }

    }


    /**
     *Login the User with email and password.
     *!!Session not will be set!!!
     * @param $username string
     * @param $password string uncrypted
     * @return User Object or null
     */
    public static function newFromLogin($username, $password)
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

            if (crypt($password, $gvCryptSalt) == $db_password) {

                $u = new User($db_id, $db_username, $db_email, $db_emailNotification, $db_password, $db_token, $db_lastIP, $db_lastLogin, $db_permission);

                $u->setToken(self::generateToken($db_id));
                $u->setLastLogin(time());
                $u->setLastIP($_SERVER['REMOTE_ADDR']);

                $u->flushDB();

                return $u;

            } else {

                return null;
            }

        } else {

            return null;
        }

    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return boolean
     */
    public function isEmailNotification()
    {
        return $this->emailNotification;
    }

    /**
     * @param boolean $emailNotification
     */
    public function setEmailNotification($emailNotification)
    {
        $this->emailNotification = $emailNotification;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getLastIP()
    {
        return $this->lastIP;
    }

    /**
     * @param string $lastIP
     */
    public function setLastIP($lastIP)
    {
        $this->lastIP = $lastIP;
    }

    /**
     * @return int
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * @param int $lastLogin
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
    }

    /**
     * @return UserPermission
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * @param UserPermission $permission
     */
    public function setPermission($permission)
    {
        $this->permission = $permission;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     *Set the password attribut
     * @param $passwordOld has to be crypted!
     * @param $passwordNew has to be crypted!
     */
    public function setPassword($passwordOld, $passwordNew)
    {

        if ($passwordOld == $this->password) {

            $this->password = $passwordNew;
            return true;
        }

        return false;
    }



    public function existsInDB() {

        if($this->id > 0) {

            return true;
        }
        else {

            return false;
        }
    }


    public function flushDB()
    {
        global $dbConn;

        $id = (int)$this->id;
        $username = utf8_decode(strip_tags($this->username));
        $email = $this->email;
        $emailNotification = boolToInt($this->emailNotification);
        $password = $this->password;
        $token = $this->token;
        $lastIP = $this->lastIP;
        $lastLogin = (int)$this->lastLogin;
        $permission = $this->permission->getLevel();

        //object exists in DB
        if($this->existsInDB()) {

            $query = "UPDATE `user` SET `username`=?, `email`=?, `email_notification_flag`=?, `password`=?, `token`=?, `last_ip`=?, `last_login`=?, `permission`=? WHERE `id`=? ";
            $query_stmt = $dbConn->prepare($query);

            $query_stmt->bind_param('ssisssiii', $username, $email, $emailNotification, $password, $token, $lastIP, $lastLogin, $permission, $id);
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

            $query = "INSERT INTO user (username, email, email_notification_flag, password, token, last_ip, last_login, permission) VALUES (?,?,?,?,?,?,?,?)";
            $query_stmt = $dbConn->prepare($query);

            $query_stmt->bind_param('ssisssii', $username, $email, $emailNotification, $password, $token, $lastIP, $lastLogin, $permission);
            $query_stmt->execute();

            //Logg all MySQL errors
            if ($dbConn->error != "") {

                //Log error
                errorLog::newEntry("MySQL error: " . $dbConn->error, 2, __FILE__, __CLASS__, __FUNCTION__);

                return false;
            }

            if ($dbConn->affected_rows > 0) {

                $this->setId((int)$dbConn->insert_id);

                return true;
            }
            else {

                return false;
            }
        }


    }

    public function setCookie()
    {

        if ($this->token != '') {

            setcookie("loginID", $this->id, time() + 86400, "/");
            setcookie("loginToken", $this->token, time() + 86400, "/");
        }
    }

    public static function unsetCookie()
    {

        setcookie("loginID", "", time() - 100, "/");
        setcookie("loginToken", "", time() - 100, "/");
    }

    public static function isTokenValid($token, $id)
    {

        $hash_id = md5($id);

        if ($hash_id == substr($token, 0, 32)) {

            return true;
        } else {

            return false;
        }
    }

    public static function generateToken($id)
    {

        $hash_id = md5($id);

        $hash_str = microtime(true) . rand(0, 99999);
        $hash = md5($hash_str);

        $token = $hash_id . $hash;

        return $token;
    }

    public static function generatePassword($pwd)
    {
        global $gvCryptSalt;

        return crypt($pwd, $gvCryptSalt);
    }

    /**
     * get Array with all User
     * @param int $limit
     * @return array User
     */
    public static function getAll($limit = 99)
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

            $user = new User($db_id, $db_username, $db_email, $db_emailNotification, $db_password, $db_token, $db_lastIP, $db_lastLogin, $db_permission);

            $tmp[] = $user;
        }

        return $tmp;
    }

}
