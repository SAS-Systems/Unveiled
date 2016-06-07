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
    private $accActive = true;
    private $accApproved = false;
    private $uploadToken = "";
    private $email_token  = "";
    private $email_approved = false;

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
     * @param $permission
     * @param bool $accActive
     * @param bool $accApproved
     * @param string $uploadToken
     * @param string $email_token
     * @param bool $email_approved
     */
    public function __construct($id, $username, $email, $emailNotification, $password, $token, $lastIP, $lastLogin, $permission, $accActive, $accApproved, $uploadToken, $email_token, $email_approved)
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
        $this->accActive = $accActive;
        $this->accApproved = $accApproved;
        $this->uploadToken = $uploadToken;
        $this->email_token = $email_token;
        $this->email_approved = $email_approved;
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

        //new approve required
        $this->email_token = User::generateToken(-1);
        $this->email_approved = false;
        EmailService::sendEmailVerification($this->username, $email, $this->email_token);
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
     * @return boolean
     */
    public function isAccActive()
    {
        return $this->accActive;
    }

    /**
     * @param boolean $accActive
     */
    public function setAccActive($accActive)
    {
        $this->accActive = $accActive;
    }

    /**
     * @return boolean
     */
    public function isAccApproved()
    {
        return $this->accApproved;
    }

    /**
     * @param boolean $accApproved
     */
    public function setAccApproved($accApproved)
    {
        $this->accApproved = $accApproved;
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

    /**
     * @return string
     */
    public function getUploadToken()
    {
        return $this->uploadToken;
    }

    /**
     * @param string $uploadToken
     */
    public function setUploadToken($uploadToken)
    {
        $this->uploadToken = $uploadToken;
    }

    /**
     * @return string
     */
    public function getEmailToken()
    {
        return $this->email_token;
    }

    /**
     * @param string $email_token
     */
    public function setEmailToken($email_token)
    {
        $this->email_token = $email_token;
    }

    /**
     * @return bool|string
     */
    public function isEmailApproved()
    {
        return $this->email_approved;
    }

    /**
     * @param bool|string $email_approved
     */
    public function setEmailApproved($email_approved)
    {
        $this->email_approved = $email_approved;
    }

    public function setCookie()
    {

        $p = new UserPermission(3);

        setcookie("loginID", $this->id, time() + 86400, "/");
        setcookie("loginToken", $this->token, time() + 86400, "/");
        setcookie("loginUsername", $this->username, time() + 86400, "/");
        setcookie("loginAdmin", boolToStr($p->isAllowed($this)), time() + 86400, "/");
        
    }

    public function setAppCookie()
    {

        if ($this->uploadToken != '') {

            $p = new UserPermission(3);

            setcookie("uploadID", $this->id, time() + 999999, "/");
            setcookie("uploadToken", $this->uploadToken, time() + 999999, "/");
            setcookie("uploadUsername", $this->username, time() + 999999, "/");
            setcookie("uploadAdmin", boolToStr($p->isAllowed($this)), time() + 999999, "/");
        }
    }

    public static function unsetCookie()
    {

        setcookie("loginID", "", time() - 100, "/");
        setcookie("loginToken", "", time() - 100, "/");
        setcookie("loginUsername", "", time() - 100, "/");
        setcookie("loginAdmin", "", time() - 100, "/");
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

}
