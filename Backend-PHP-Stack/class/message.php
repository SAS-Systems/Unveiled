<?php

/**
 * Created by PhpStorm.
 * User: Sebastian
 * Date: 06.11.15
 * Time: 18:07
 */
class message
{

    private $id = 0;
    private $type = "";
    private $msg = "";
    private $language= "";

    /**
     * message constructor.
     * @param int $id
     * @param string $type
     * @param string $msg
     * @param string $language
     */
    public function __construct($id, $type, $msg, $language)
    {
        $this->id = $id;
        $this->type = $type;
        $this->msg = $msg;
        $this->language = $language;
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * @param string $msg
     */
    public function setMsg($msg)
    {
        $this->msg = $msg;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

}