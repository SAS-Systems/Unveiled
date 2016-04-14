<?php

abstract class File
{

    protected $id = -1;
    protected $owner = -1; //ID or object!!!
    protected $caption = "";
    protected $filename = "";
    protected $fileURL= "";
    protected $thumbnailURL = "";
    protected $mediatype = "";
    protected $uploadedAt = 0; //timestamp
    protected $size = 0; //byte
    protected $lat = 0.0;
    protected $lng = 0.0;
    protected $public = false;
    protected $verified = false;

    /**
     * File constructor.
     * @param int $id
     * @param int $owner
     * @param string $caption
     * @param string $filename
     * @param string $fileURL
     * @param string $thumbnailURL
     * @param string $mediatype
     * @param int $uploadedAt
     * @param int $size
     * @param float $lat
     * @param float $lng
     * @param bool $public
     * @param bool $verified
     */
    public function __construct($id, $owner, $caption, $filename, $fileURL, $thumbnailURL, $mediatype, $uploadedAt, $size, $lat, $lng, $public, $verified)
    {
        $this->id = $id;
        $this->owner = $owner;
        $this->caption = $caption;
        $this->filename = $filename;
        $this->fileURL = $fileURL;
        $this->thumbnailURL = $thumbnailURL;
        $this->mediatype = $mediatype;
        $this->uploadedAt = $uploadedAt;
        $this->size = $size;
        $this->lat = $lat;
        $this->lng = $lng;
        $this->public = $public;
        $this->verified = $verified;
    }


    /*
     * write the data into DB
     */
    abstract public function flushDB();


    abstract public function getAllFilesFromUser($user);

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
    public function getOwnerId() {

        if (is_int($this->owner)) {

            return $this->owner;            
        } else {

            return $this->owner->getId();
        }
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        if (is_int($this->owner)) {

            return User::newFromId($this->owner);
        } else {

            return $this->owner;
        }
    }

    /**
     * @param User $owner
     */
    public function setOwner(User $owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return string
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @param string $caption
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return string
     */
    public function getFileURL()
    {
        return $this->fileURL;
    }

    /**
     * @param string $fileURL
     */
    public function setFileURL($fileURL)
    {
        $this->fileURL = $fileURL;
    }

    /**
     * @return string
     */
    public function getThumbnailURL()
    {
        return $this->thumbnailURL;
    }

    /**
     * @param string $thumbnailURL
     */
    public function setThumbnailURL($thumbnailURL)
    {
        $this->thumbnailURL = $thumbnailURL;
    }

    /**
     * @return string
     */
    public function getMediatype()
    {
        return $this->mediatype;
    }

    /**
     * @param string $mediatype
     */
    public function setMediatype($mediatype)
    {
        $this->mediatype = $mediatype;
    }

    /**
     * @return int
     */
    public function getUploadedAt()
    {
        return $this->uploadedAt;
    }

    /**
     * @param int $uploadedAt
     */
    public function setUploadedAt($uploadedAt)
    {
        $this->uploadedAt = $uploadedAt;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return float
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param float $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * @return float
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @param float $lng
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
    }

    /**
     * @return boolean
     */
    public function isPublic()
    {
        return $this->public;
    }

    /**
     * @param boolean $public
     */
    public function setPublic($public)
    {
        $this->public = $public;
    }

    /**
     * @return boolean
     */
    public function isVerified()
    {
        return $this->verified;
    }

    /**
     * @param boolean $verified
     */
    public function setVerified($verified)
    {
        $this->verified = $verified;
    }

    /**
     * @return string
     */
    public function getThumbURI()
    {
        /*global $gvFileThumbPath;

        $filename = explode(".", $this->filename);

        return $gvFileThumbPath . $filename[0] . ".jpg";*/

        return $this->getThumbnailURL();
    }

    /**
     * @return string
     */
    public function getURI()
    {
        /*global $gvFilePath;

        return $gvFilePath . $this->filename;*/

        return $this->getFileURL();
    }

}
