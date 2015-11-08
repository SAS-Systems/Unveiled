<?php

/**
 * Created by PhpStorm.
 * User: Sebastian
 * Date: 06.11.15
 * Time: 17:17
 */
class PictureFile extends File
{
    private $height = 0;
    private $width = 0;

    /**
     * PictureFile constructor.
     * @param int $id
     * @param int $ownerID
     * @param string $caption
     * @param string $filename
     * @param string $mediatype
     * @param int $uploadedAt
     * @param int $size
     * @param float $lat
     * @param float $lng
     * @param bool $public
     * @param bool $verified
     * @param int $height
     * @param int $width
     */
    protected function __construct($id, $ownerID, $caption, $filename, $mediatype, $uploadedAt, $size, $lat, $lng, $public, $verified, $height, $width)
    {
        parent::__construct($id, $ownerID, $caption, $filename, $mediatype, $uploadedAt, $size, $lat, $lng, $public, $verified);

        $this->height = $height;
        $this->width = $width;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }




}