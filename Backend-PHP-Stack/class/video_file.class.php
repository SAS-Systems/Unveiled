<?php

class VideoFile extends File
{

    private $length = 0;


    /**
     * VideoFile constructor.
     * @param int $id
     * @param int $ownerID
     * @param string $caption
     * @param string $filename
     * @param string $mediatype
     * @param int $uploadedAt
     * @param int $size
     * @param float $lat
     * @param float $lng
     * @param bool $public
     * @param bool $verified
     * @param int $lenth
     */
    protected function __construct($id, $ownerID, $caption, $filename, $mediatype, $uploadedAt, $size, $lat, $lng, $public, $verified, $length)
    {

        parent::__construct($id, $ownerID, $caption, $filename, $mediatype, $uploadedAt, $size, $lat, $lng, $public, $verified);

        $this->length = $length;
    }

    /**
     * creates a new object of this class using id
     * @param int $id
     */
    public function newFromId($id)
    {
        global $dbConn;

        if (is_int($id)) {

            $res = $dbConn->query("SELECT * FROM file WHERE id = '$id'");
            $row = $res->fetch_object();

            //Logg all MySQL errors
            if ($dbConn->error != "") {

                //Log error
                errorLog::newEntry("MySQL error: " . $dbConn->error, 2, __FILE__, __CLASS__, __FUNCTION__);
            }

            if ($row != null) {

                $db_id = (int)$row->id;
                $db_username = utf8_encode($row->username);


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
     * write the data into DB
     */
    public function flushDB()
    {
        global $dbConn;

        $query = "UPDATE `user` SET `username`=?, `email`=?, `email_notification_flag`=?, `mobile_number`=?, `mobile_number_notification_flag`=?, `password`=?, `token`=?, `last_ip`=?, `last_login`=?, `permission`=? WHERE `id`=? ";
        $query_stmt = $dbConn->prepare($query);

        $ip = $_SERVER['REMOTE_ADDR'];
        $now = time();

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


    public function create()
    {

        global $dbConn;

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


    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param int $length
     */
    public function setLength($length)
    {
        $this->length = $length;
    }


}

?>