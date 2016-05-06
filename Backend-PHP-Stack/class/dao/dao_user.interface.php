<?php

interface userDAOinterface extends DAOinterface {

    /**
     * @param $id
     * @param $token
     * @return object
     */
    public function newFromToken($id, $token);

    /**
     * @return object
     */
    public function newFromCookie();

    /**
     * @param $username
     * @param $password
     * @return object
     */
    public function newFromLogin($username, $password);

    /**
     * @param int $limit
     * @return array[object]
     */
    public function getAll($limit = 99);

    /**
     * @return boolean
     */
    public function delete();
}

?>