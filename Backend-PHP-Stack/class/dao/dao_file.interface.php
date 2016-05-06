<?php

interface fileDAOinterface extends DAOinterface {

    /**
     * get Array with all VideoFiles from the current user
     * @param int $limit
     * @return array User
     */
    public static function getAll($limit = 99, User $user);

    /**
     * @return boolean
     */
    public function delete($object);
}