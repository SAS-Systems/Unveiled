<?php

class File
{

    private $id = -1;
    private $ownerID = -1;
    private $caption = "";
    private $filename = "";
    private $mediatype "";
	private $uploadedAt = 0; //timestamp
	private $size = 0; //byte
	private $lat = 0.0;
	private $lng = 0.0;
	private $public = false;
	private $verified = false;

    /**
     * File constructor.
     * @param int $id
     * @param int $ownerID
     * @param string $caption
     * @param string $filename
     * @param $mediatype
     * @param int $uploadedAt
     * @param int $size
     * @param float $lat
     * @param float $lng
     * @param bool $public
     * @param bool $verified
     */
    public function __construct($id, $ownerID, $caption, $filename, $mediatype, $uploadedAt, $size, $lat, $lng, $public, $verified)
    {
        $this->id = $id;
        $this->ownerID = $ownerID;
        $this->caption = $caption;
        $this->filename = $filename;
        $this->mediatype = $mediatype;
        $this->uploadedAt = $uploadedAt;
        $this->size = $size;
        $this->lat = $lat;
        $this->lng = $lng;
        $this->public = $public;
        $this->verified = $verified;
    }


    /*
     * creates a new object of this class using id
     * @param int $id
     */
    public function newFromId($id)
    {

    }

    /*
     * write the data into DB
     */
    public function flushDB()
    {

    }

    /*
     *
     */
    public function create(){

    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getOwnerID()
    {
        return $this->ownerID;
    }/**
 * @param int $ownerID
 */
    public function setOwnerID($ownerID)
    {
        $this->ownerID = $ownerID;
    }/**
 * @return string
 */
    public function getCaption()
    {
        return $this->caption;
    }/**
 * @param string $caption
 */
    public function setCaption($caption)
    {
        $this->caption = $caption;
    }/**
 * @return string
 */
    public function getFilename()
    {
        return $this->filename;
    }/**
 * @param string $filename
 */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }/**
 * @return mixed
 */
    public function getMediatype()
    {
        return $this->mediatype;
    }/**
 * @param mixed $mediatype
 */
    public function setMediatype($mediatype)
    {
        $this->mediatype = $mediatype;
    }/**
 * @return int
 */
    public function getUploadedAt()
    {
        return $this->uploadedAt;
    }/**
 * @param int $uploadedAt
 */
    public function setUploadedAt($uploadedAt)
    {
        $this->uploadedAt = $uploadedAt;
    }/**
 * @return int
 */
    public function getSize()
    {
        return $this->size;
    }/**
 * @param int $size
 */
    public function setSize($size)
    {
        $this->size = $size;
    }/**
 * @return float
 */
    public function getLat()
    {
        return $this->lat;
    }/**
 * @param float $lat
 */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }/**
 * @return float
 */
    public function getLng()
    {
        return $this->lng;
    }/**
 * @param float $lng
 */
    public function setLng($lng)
    {
        $this->lng = $lng;
    }/**
 * @return boolean
 */
    public function isPublic()
    {
        return $this->public;
    }/**
 * @param boolean $public
 */
    public function setPublic($public)
    {
        $this->public = $public;
    }/**
 * @return boolean
 */
    public function isVerified()
    {
        return $this->verified;
    }/**
 * @param boolean $verified
 */
    public function setVerified($verified)
    {
        $this->verified = $verified;
    }


}

?>