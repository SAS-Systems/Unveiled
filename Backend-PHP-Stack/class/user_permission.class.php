<?php

/**
 * Created by PhpStorm.
 * User: Sebastian
 * Date: 09.11.15
 * Time: 09:36
 */
class UserPermission
{
    /**
     * 0 = Read
     * 1 = Read & Write
     * 2 = Mod
     * 3 = Owner
     * 4 = Admin
     */
    private $level = 0;

    /**
     * UserPermission constructor.
     * @param int $level
     */
    public function __construct($level=0)
    {
        $this->level = $level;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param int $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    public function toInt() {

        return $this->level;
    }

    public function isAllowed($user) {

        if($user->getPermission()->getLevel() >= $this->level) {

            return true;
        }
        return false;
    }


    public static function convertPerssionCode($level)
    {

        switch ($level) {

            case 0:
                return "Read";
                break;

            case 1:
                return "Read & Write";
                break;

            case 2:
                return "Moderator";
                break;

            case 3:
                return "Owner";
                break;

            case 4:
                return "Admin";
                break;
        }
    }


}