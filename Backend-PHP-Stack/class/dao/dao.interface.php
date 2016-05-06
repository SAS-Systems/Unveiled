<?php

interface DAOinterface {

    /**
     * return object from class
     * @param $id
     * @return object
     */
    public function newFromId($id);

    /**
     * flushed the object to DB
     * @return boolean
     */
    public function flushDB($object);

    /**
     * check if the object exists in DB or if it's a new entry
     * @return boolean
     */
    public function existsInDB($object);
}

?>