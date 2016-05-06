<?php

class VideoFile extends File
{

    private $length = 0;
    private $resolution = "";


    /**
     * VideoFile constructor.
     * @param int $id
     * @param User $ownerID
     * @param string $caption
     * @param string $filename
     * @param string $mediatype
     * @param int $uploadedAt
     * @param int $size
     * @param float $lat
     * @param float $lng
     * @param bool $public
     * @param bool $verified
     * @param int $lenth
     */
    public function __construct($id, $owner, $caption, $filename, $fileURL, $thumbnailURL, $mediatype, $uploadedAt, $size, $lat, $lng, $public, $verified, $length, $resolution)
    {

        parent::__construct($id, $owner, $caption, $filename, $fileURL, $thumbnailURL, $mediatype, $uploadedAt, $size, $lat, $lng, $public, $verified);

        $this->length = $length;
        $this->resolution = $resolution;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param int $length
     */
    public function setLength($length)
    {
        $this->length = $length;
    }

    /**
     * @return string
     */
    public function getResolution()
    {
        return $this->resolution;
    }

    /**
     * @param string $resolution
     */
    public function setResolution($resolution)
    {
        $this->resolution = $resolution;
    }
}
