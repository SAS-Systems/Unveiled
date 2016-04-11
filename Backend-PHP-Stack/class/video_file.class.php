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
     * creates a new object of this class using id
     * @param int $id
     */
    public static function newFromId($id)
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
                $db_owner = (int)$row->owner_id;
                $db_caption = utf8_encode($row->caption);
                $db_filename = utf8_encode($row->filename);
                $db_file_url = utf8_encode($row->file_url);
                $db_thumbnail_url = utf8_encode($row->thumbnail_url);
                $db_mediatype = utf8_encode($row->mediatype);
                $db_uploadedAt = (int)$row->uploaded_at;
                $db_size = (int)$row->size;
                $db_lat = (float)$row->lat;
                $db_lng = (float)$row->lng;
                $db_public = intToBool((int)$row->public);
                $db_verified = intToBool((int)$row->verified);
                $db_length = (int)$row->length;
                $db_resolution = utf8_encode($row->resolution);

                return new VideoFile($db_id, $db_owner, $db_caption, $db_filename, $db_file_url, $db_thumbnail_url, $db_mediatype, $db_uploadedAt, $db_size, $db_lat, $db_lng, $db_public, $db_verified, $db_length, $db_resolution);

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

        $id = (int)$this->getId();
        //int object
        if(is_int($this->owner)) {
            $ownerId = (int)$this->owner;
        }
        else {
            $ownerId = (int)$this->getOwner()->getId();
        }
        $caption = utf8_decode(strip_tags($this->getCaption()));
        $filename = utf8_decode(strip_tags($this->getFilename()));
        $fileURL = utf8_decode(strip_tags($this->getFileURL()));
        $thumbnailURL = utf8_decode(strip_tags($this->getThumbnailURL()));
        $mediatype = utf8_decode(strip_tags($this->getMediatype()));
        $uploadedAt = (int)$this->getUploadedAt();
        $size = (int)$this->getSize();
        $lat = (double)$this->getLat();
        $lng = (double)$this->getLng();
        $public = boolToInt($this->isPublic());
        $verified = boolToInt($this->isVerified());
        $length = (int)$this->getLength();
        $resolution = utf8_decode(strip_tags($this->getResolution()));

        //object exists in DB
        if ($this->existsInDB()) {

            $query = "UPDATE file SET owner_id=?, caption=?, filename=?, file_url=?, thumbnail_url=?, mediatype=?, uploaded_at=?, size=?, lat=?, lng=?,
                      public=?, verified=?, length=?, resolution=? WHERE id=? ";
            $query_stmt = $dbConn->prepare($query);

            $query_stmt->bind_param('isssssiiddiiisi', $ownerId, $caption, $filename, $fileURL, $thumbnailURL, $mediatype, $uploadedAt, $size, $lat, $lng, $public, $verified, $length, $resolution, $id);
            $query_stmt->execute();

            //Logg all MySQL errors
            if ($dbConn->error != "") {

                //Log error
                errorLog::newEntry("MySQL error: " . $dbConn->error, 2, __FILE__, __CLASS__, __FUNCTION__);

                return false;
            }
            else {

                return true;
            }

        }
        else {

            $query = "INSERT INTO user (owner_id, caption, filename, file_url, thumbnail_url, mediatype, size, lat, lng, public, verified, length, resolution) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $query_stmt = $dbConn->prepare($query);

            $query_stmt->bind_param('isssssiddiiis', $ownerId, $caption, $filename, $fileURL, $thumbnailURL, $mediatype, $size, $lat, $lng, $public, $verified, $length, $resolution);
            $query_stmt->execute();

            if ($dbConn->affected_rows > 0) {

                $this->id = $dbConn->insert_id;

                return true;
            } else {

                return false;
            }
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

    public function existsInDB() {

        if($this->id > 0) {

            return true;
        }
        else {

            return false;
        }
    }

    /**
     * get Array with all VideoFiles from the current user
     * @param int $limit
     * @return array User
     */
    public static function getAll($limit = 99, User $user)
    {
        global $dbConn;

        $userId = (int)$user->getId();

        $limit = (int)$limit;
        $res = $dbConn->query("SELECT * FROM file WHERE owner_id = ".$userId." LIMIT 0, " . $limit);

        //Logg all MySQL errors
        if ($dbConn->error != "") {

            //Log error
            errorLog::newEntry("MySQL error: " . $dbConn->error, 2, __FILE__, __CLASS__, __FUNCTION__);
        }

        $tmp = array();

        while ($row = $res->fetch_object()) {

            $db_id = (int)$row->id;
            $db_owner = (int)$row->owner_id;
            $db_caption = utf8_encode($row->caption);
            $db_filename = utf8_encode($row->filename);
            $db_file_url = utf8_encode($row->file_url);
            $db_thumbnail_url = utf8_encode($row->thumbnail_url);
            $db_mediatype = utf8_encode($row->mediatype);
            $db_uploadedAt = (int)$row->uploaded_at;
            $db_size = (int)$row->size;
            $db_lat = (float)$row->lat;
            $db_lng = (float)$row->lng;
            $db_public = intToBool((int)$row->public);
            $db_verified = intToBool((int)$row->verified);
            $db_length = (int)$row->length;
            $db_resolution = utf8_encode($row->resolution);

            $video = new VideoFile($db_id, $db_owner, $db_caption, $db_filename, $db_file_url, $db_thumbnail_url, $db_mediatype, $db_uploadedAt, $db_size, $db_lat, $db_lng, $db_public, $db_verified, $db_length, $db_resolution);

            $tmp[] = $video;
        }

        return $tmp;
    }

    /**
     * delte this object and delete the db entry
     */
    public function delete() {
        global $dbConn;

        $id = (int)$this->getId();

        $res = $dbConn->query("DELETE FROM file WHERE id=$id");

        //Logg all MySQL errors
        if ($dbConn->error != "") {

            //Log error
            errorLog::newEntry("MySQL error: " . $dbConn->error, 2, __FILE__, __CLASS__, __FUNCTION__);
        }


        if ($dbConn->affected_rows > 0) {

            return true;
        }

        return false;
    }

}
