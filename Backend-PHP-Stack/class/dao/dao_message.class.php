<?php

class messageDAO implements messageDAOinterface
{

    /**
     * messageDAO constructor.
     */
    public function __construct()
    {

        super();
    }

    /**
     * @param $code
     * @param $language
     * @return object
     */
    public function newFromCode($code, $language)
    {
        global $dbConn;

        $code = $dbConn->real_escape_string($code);
        $language = $dbConn->real_escape_string($language);


        $res = $dbConn->query("SELECT * FROM messages WHERE code = '$code' AND language = '$language'");
        $row = $res->fetch_object();

        //Logg all MySQL errors
        if ($dbConn->error != "") {

            //Log error
            errorLog::newEntry("MySQL error: " . $dbConn->error, 2, __FILE__, __CLASS__, __FUNCTION__);
        }

        if ($row != null) {

            $db_id = (int)$row->id;
            $db_code = utf8_encode($row->code);
            $db_type = utf8_encode($row->type);
            $db_msg = utf8_encode($row->msg);
            $db_language = utf8_encode($row->language);

            return new Message($db_id, $db_code, $db_type, $db_msg, $db_language);
        } else {

            return null;
        }
    }
}

?>