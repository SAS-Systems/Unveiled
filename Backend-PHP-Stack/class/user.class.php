<?php

class User
{

    private $id;
    private $username;
    private $email;
    private $emailNotification; // Int
    private $mobileNumber;
    private $mobileNumberNotification; // Int
    private $password; //Crypt
    private $token;
    private $lastIP;
    private $lastLogin; //Timestamp
    private $permission;


    private function __construct($id, $email, $emailNotification, $mobileNumber, $mobileNumberNotification, $username, $password, $token, $lastIP, $lastLogin, $permission)
    {

        $this->id = (int)$id;
        $this->username = $username;
        $this->email = $email;
        $this->emailNotification = $emailNotification;
        $this->mobileNumber = $mobileNumber;
        $this->mobileNumberNotification = $mobileNumberNotification;
        $this->password = $password;
        $this->token = $token;
        $this->lastIP = $lastIP;
        $this->lastLogin = $lastLogin;
        $this->permission = $permission;

    }

    public static function NewFromToken($id, $token)
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
                $db_emailNotification = (int)$row->email_notification_flag;
                $db_mobileNumber = $row->mobile_number;
                $db_mobileNumberNotification = (int)$row->mobile_number_notification_flag;
                $db_password = $row->password;
                $db_token = $row->token;
                $db_lastIP = $row->last_ip;
                $db_lastLogin = (int)$row->last_login;
                $db_permission = (int)$row->permission;

                $u = new User($db_id, $db_email, $db_emailNotification, $db_mobileNumber, $db_mobileNumberNotification, $db_username, $db_password, $db_token, $db_lastIP, $db_lastLogin, $db_permission);
                return $u;
            } else {

                return null;
            }

        } else {

            return null;
        }

    }

    public static function NewFromSession()
    {

        if (isset($_COOKIE["loginID"]) && $_COOKIE["loginID"] != '' && isset($_COOKIE["loginToken"]) && $_COOKIE["loginToken"] != '') {

            $u = self::NewFromToken($_COOKIE["loginID"], $_COOKIE["loginToken"]);
            return $u;
        } else {

            return null;
        }
    }

    public static function NewFromId($id)
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
                $db_emailNotification = (int)$row->email_notification_flag;
                $db_mobileNumber = $row->mobile_number;
                $db_mobileNumberNotification = (int)$row->mobile_number_notification_flag;
                $db_password = $row->password;
                $db_token = $row->token;
                $db_lastIP = $row->last_ip;
                $db_lastLogin = (int)$row->last_login;
                $db_permission = (int)$row->permission;

                $u = new User($db_id, $db_email, $db_emailNotification, $db_mobileNumber, $db_mobileNumberNotification, $db_username, $db_password, $db_token, $db_lastIP, $db_lastLogin, $db_permission);
                return $u;

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
     * @param $email string
     * @param $password string crypted
     * @return User Object or null
     */
    public static function NewFromLogin($email, $password)
    {
        global $dbConn;
        global $gvCryptSalt;

        $email = $dbConn->real_escape_string($email);
        $password = $dbConn->real_escape_string($password);

        $res = $dbConn->query("SELECT * FROM user WHERE email = '$email'");
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
            $db_emailNotification = (int)$row->email_notification_flag;
            $db_mobileNumber = $row->mobile_number;
            $db_mobileNumberNotification = (int)$row->mobile_number_notification_flag;
            $db_password = $row->password;
            $db_token = $row->token;
            $db_lastIP = $row->last_ip;
            $db_lastLogin = (int)$row->last_login;
            $db_permission = (int)$row->permission;

            if (crypt($password, $gvCryptSalt) == $db_password) {

                $u = new User($db_id, $db_email, $db_emailNotification, $db_mobileNumber, $db_mobileNumberNotification, $db_username, $db_password,
                    $db_token, $db_lastIP, $db_lastLogin, $db_permission);

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


    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getMobileNumber()
    {
        return $this->mobileNumber;
    }

    public function setMobileNumber($mobileNumber)
    {
        $this->mobileNumber = (int)$mobileNumber;
    }

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

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    public function getLastIP()
    {
        return $this->lastIP;
    }

    public function setLastIP($lastIP)
    {
        $this->lastIP = $lastIP;
    }

    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    public function setLastLogin($lastLogin)
    {

        $this->lastLogin = (int)$lastLogin;
    }

    public function getEmailNotification()
    {
        return $this->emailNotification;
    }

    public function setEmailNotification($emailNotification)
    {
        $this->emailNotification = (int)$emailNotification;
    }

    public function getPermission()
    {
        return $this->permission;
    }

    public function setPermission($permission)
    {
        $this->permission = (int)$permission;
    }

    public function getMobileNumberNotification()
    {
        return $this->mobileNumberNotification;
    }

    public function setMobileNumberNotification($mobileNumberNotification)
    {
        $this->mobileNumberNotification = (int)$mobileNumberNotification;
    }


    public function flushDB()
    {
        global $dbConn;

        $query = "UPDATE `user` SET `username`=?, `email`=?, `email_notification_flag`=?, `mobile_number`=?, `mobile_number_notification_flag`=?, `password`=?, `token`=?, `last_ip`=?, `last_login`=?, `permission`=? WHERE `id`=? ";
        $query_stmt = $dbConn->prepare($query);

        $id = (int)$this->id;
        $username = utf8_decode(strip_tags($this->username));
        $email = $this->email;
        $emailNotification = (int)$this->emailNotification;
        $mobileNumber = (int)$this->mobileNumber;
        $mobileNumberNotification = (int)$this->mobileNumberNotification;
        $password = $this->password;
        $token = $this->token;
        $lastIP = $this->lastIP;
        $lastLogin = (int)$this->lastLogin;
        $permission = (int)$this->permission;

        $query_stmt->bind_param('ssiiisssiii', $username, $email, $emailNotification, $mobileNumber, $mobileNumberNotification, $password, $token, $lastIP, $lastLogin, $permission, $id);
        $query_stmt->execute();

        //Logg all MySQL errors
        if ($dbConn->error != "") {

            //Log error
            errorLog::newEntry("MySQL error: " . $dbConn->error, 2, __FILE__, __CLASS__, __FUNCTION__);

            return false;
        }

        return true;
    }


    public function setSession()
    {

        if ($this->token != '') {

            setcookie("loginID", $this->id, time() + 86400, "/");
            setcookie("loginToken", $this->token, time() + 86400, "/");
        }
    }

    public static function unsetSession()
    {

        setcookie("loginToken", "", time() - 100, "/");
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


    public static function create($username, $email, $emailNotification, $mobileNumber, $mobileNumberNotification, $permission, $password)
    {
        global $dbConn;
        global $gvCryptSalt;

        $username = utf8_decode(strip_tags($username));
        $password = crypt($dbConn->real_escape_string($password), $gvCryptSalt);

        $query = "INSERT INTO user (username, email, email_notification_flag, mobile_number, mobile_number_notification_flag,
permission, password, last_login, last_ip) VALUES (?,?,?,?,?,?,?,?,?)";
        $query_stmt = $dbConn->prepare($query);

        $ip = $_SERVER['REMOTE_ADDR'];
        $now = time();

        $query_stmt->bind_param('ssiiiisis', $username, $email, $emailNotification, $mobileNumber,
            $mobileNumberNotification, $permission, $password, $now, $ip);
        $query_stmt->execute();

        if ($dbConn->affected_rows > 0) {

            return self::NewFromId($dbConn->insert_id);
        } else {

            return null;
        }

    }


    public static function generatePassword($pwd)
    {
        global $gvCryptSalt;

        return crypt($pwd, $gvCryptSalt);
    }

    /**
     * Check user permission
     * 0 = Read
     * 1 = Read & Write
     * 2 = Mod
     * 3 = Owner
     * 4 = Admin
     * @param $permission
     * @return bool
     */
    public function hasPermission($permission)
    {

        if ($this->permission >= $permission) {

            return true;
        }

        return false;
    }

    public static function convertPerssionCode($code)
    {

        switch ($code) {

            case 0:
                return "Read";
                break;

            case 1:
                return "Read & Write";
                break;

            case 2:
                return "Moderator";
                break;

            case 3:
                return "Owner";
                break;

            case 4:
                return "Admin";
                break;
        }
    }


    public static function listAll($format = false, $limit = 99)
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
            $db_emailNotification = (int)$row->email_notification_flag;
            $db_mobileNumber = $row->mobile_number;
            $db_mobileNumberNotification = (int)$row->mobile_number_notification_flag;
            $db_lastIP = $row->last_ip;


            if ($format) {

                $db_lastLogin = date("H:i:s d.m.Y", $row->last_login);
                $db_permission = User::convertPerssionCode($row->permission);

            } else {

                $db_lastLogin = (int)$row->last_login;
                $db_permission = (int)$row->permission;
            }

            $tmp[] = array("id" => $db_id, "username" => $db_username, "email" => $db_email, "emailNotification" => $db_emailNotification,
                "mobileNumber" => $db_mobileNumber, "mobileNumberNotification" => $db_mobileNumberNotification, "lastIP" => $db_lastIP,
                "lastLogin" => $db_lastLogin, "permission" => $db_permission);
        }

        return $tmp;

    }

}
