<?php

/**
 * Created by PhpStorm.
 * User: Sebastian
 * Date: 06.11.15
 * Time: 18:07
 */
class Message
{

    private $id = 0;
    private $code = "";
    private $type = "";
    private $msg = "";
    private $language= "";

    /**
     * message constructor.
     * @param int $id
     * @param string $code
     * @param string $type
     * @param string $msg
     * @param string $language
     */
    private function __construct($id, $code, $type, $msg, $language)
    {
        $this->id = $id;
        $this->code = $code;
        $this->type = $type;
        $this->msg = $msg;
        $this->language = $language;
    }

    public function newFromCode($code, $language) {
        global $dbConn;

        $code = $dbConn->real_escape_string( $code );
        $language = $dbConn->real_escape_string( $language );


        $res = $dbConn->query( "SELECT * FROM message WHERE code = '$code' AND language = '$language'" );
        $row = $res->fetch_object();

        //Logg all MySQL errors
        if( $dbConn->error != "" ) {

            //Log error
            errorLog::newEntry( "MySQL error: ".$dbConn->error , 2, __FILE__, __CLASS__, __FUNCTION__ );
        }

        if( $row != null ) {

            $db_id = (int) $row->id;
            $db_code = utf8_encode( $row->code );
            $db_type = utf8_encode( $row->type );
            $db_msg = utf8_encode( $row->msg );
            $db_language = utf8_encode( $row->language );

            return new Message($db_id, $db_code, $db_type, $db_msg, $db_language);
        }
        else {

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
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * converts the message to an HTML statment
     * @return string
     */
    public function toHTML() {

        return '<div class="message>"'+$this->getMsg()+'</div>';
    }

}