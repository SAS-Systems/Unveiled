<?php

interface messageDAOinterface {

    /**
     * @param $code
     * @param $language
     * @return object
     */
    public function newFromCode($code, $language);
}

?>