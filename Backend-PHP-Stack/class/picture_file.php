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
     * creates a new object of this class using id
     * @param int $id
     */
    public function newFromId($id)
    {
        global $dbConn;

        if (is_int($id)) {

            $res = $dbConn->query("SELECT * FROM file WHERE id = '$id'");
            $row = $res->fetch_object();

            //Logg all MySQL errors
            if ($dbConn->error != "") {

                //Log error
                errorLog::newEntry("MySQL error: " . $dbConn->error, 2, __FILE__, __CLASS__, __FUNCTION__);
            }

            if ($row != null) {

                $db_id = (int)$row->id;
                $db_ownerId = (int)$row->owner_id;
                $db_caption = utf8_encode($row->caption);
                $db_filename = utf8_encode($row->filename);
                $db_mediatype = utf8_encode($row->mediatype);
                $db_uploadedAt = (int)$row->uploaded_at;
                $db_size = (int)$row->size;
                $db_lat = (float)$row->lat;
                $db_lng = (float)$row->lng;
                $db_public = intToBool((int)$row->public);
                $db_verified = intToBool((int)$row->verified);
                $db_height = (int)$row->height;
                $db_width = (int)$row->width;

                return new PictureFile($db_id, $db_ownerId, $db_caption, $db_filename, $db_mediatype, $db_uploadedAt, $db_size, $db_lat, $db_lng, $db_public, $db_verified, $db_height, $db_width);

            } else {

                return null;
            }

        } else {

            return null;
        }
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