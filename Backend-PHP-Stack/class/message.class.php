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
    private $language = "";

    /**
     * message constructor.
     * @param int $id
     * @param string $code
     * @param string $type
     * @param string $msg
     * @param string $language
     */
    function __construct($id, $code, $type, $msg, $language)
    {
        $this->id = $id;
        $this->code = $code;
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
    public function toHTML()
    {

        return '<div class="message>"' . $this->getMsg() . '</div>';
    }

}