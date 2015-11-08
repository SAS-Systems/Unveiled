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
     * write the data into DB
     */
    public function flushDB()
    {
        global $dbConn;

        $query = "UPDATE file SET owner_id=?, caption=?, filename=?, mediatype=?, uploaded_at=?, size=?, lat=?, lng=?,
                  public=?, verified=?, height=?, width=? WHERE id=? ";
        $query_stmt = $dbConn->prepare($query);

        $id = (int)$this->getId();
        $ownerId = (int)$this->getOwnerID();
        $caption = utf8_decode(strip_tags($this->getCaption()));
        $filename = utf8_decode(strip_tags($this->getFilename()));
        $mediatype = utf8_decode(strip_tags($this->getMediatype()));
        $uploadedAt = (int)$this->getUploadedAt();
        $size = (int)$this->getSize();
        $lat = (double)$this->getLat();
        $lng = (double)$this->getLng();
        $public = (int)$this->isPublic();
        $verified = (int)$this->isVerified();
        $height = (int)$this->getHeight();
        $width = (int)$this->getWidth();

        $query_stmt->bind_param('isssiiddiiiii', $ownerId, $caption, $filename, $mediatype, $uploadedAt, $size, $lat, $lng, $public, $verified, $height, $width, $id);
        $query_stmt->execute();

        //Logg all MySQL errors
        if ($dbConn->error != "") {

            //Log error
            errorLog::newEntry("MySQL error: " . $dbConn->error, 2, __FILE__, __CLASS__, __FUNCTION__);

            return false;
        }

        return true;
    }

    /**
     * create a ne entry in DB
     */
    public function create($user, $caption, $filename, $mediatype, $size=0, $lat=0.0, $lng=0.0, $public=false, $verified=false, $height=0, $width=0)
    {
        global $dbConn;

        $query = "INSERT INTO user (owner_id, caption, filename, mediatype, size, lat, lng, public, verified, height, width) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        $query_stmt = $dbConn->prepare($query);

        $caption = utf8_decode(strip_tags($caption));
        $filename = utf8_decode(strip_tags($filename));
        $mediatype = utf8_decode(strip_tags($mediatype));
        $size = (int)$size;
        $lat = (double)$lat;
        $lng = (double)$lng;
        $public = boolToInt($public);
        $verified = boolToInt($verified);
        $height = (int)$height;
        $width = (int)$width;

        $query_stmt->bind_param('ssssiddiiii', $user->getId(), $caption, $filename, $mediatype, $size, $lat, $lng, $public, $verified, $height, $width);
        $query_stmt->execute();

        if ($dbConn->affected_rows > 0) {

            return self::NewFromId($dbConn->insert_id);
        } else {

            return null;
        }
    }

    /**
     * return all files from user
     * @param $user
     */
    public function getAllFilesFromUser($user)
    {
        // TODO: Implement getAllFilesFromUser() method.
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