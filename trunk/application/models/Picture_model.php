<?php

class Picture_model extends CI_Model {

    public function __construct() {
        parent::__construct();

        $this->load->helper('date');
        date_default_timezone_set('Europe/Brussels');
    }

    /**
     * Store new puzzle picture in the database:
     * - pictures table is updated
     * - gallery_pictures table is updated
     * 
     * If the resident is NULL or not given (so it is NULL by default), the picture
     * is not assigned to 1 particular resident and it will be available for all residents.
     * ==> This is not recommended! (programmatically safe to do, but might result in
     * undesired side effect with fields like last_completed and about who has ownership of
     * the picture)
     */
    function storeNewPuzzlePicture($picture_dir, $picture_name, $residentID = NULL) {
        $this->db->query("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
        $this->db->query("START TRANSACTION");
        $pictureID = $this->storePicture($picture_dir, $picture_name);
        $this->storeNewGallery($pictureID, $residentID);
        $this->db->query("COMMIT");
    }

    /**
     * Assign a new given profile picture to a given resident.
     */
    function storeNewProfilePicture($picture_dir, $picture_name, $residentID) {
        $this->db->query("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
		$this->db->query("START TRANSACTION");
		$pictureID = $this->storePicture($picture_dir, $picture_name);
        $updateData = array('profile_picture_id' => $pictureID);
        $whereArray = array('id' => $residentID);
        $this->db->where($whereArray);
        $this->db->update('a16_webapps_3.residents', $updateData);
        $this->db->query("COMMIT");
    }

    /**
     * Store the given picture in the database and return the ID.
     * 
     * Do not use this function outside of this model. Use either:
     * - storeNewPuzzlePicture,
     * - storeNewProfilePicture.
     */
    private function storePicture($picture_dir, $picture_name) {
        $array = array(
            'picture_dir' => addslashes($picture_dir),
            'picture_name' => addslashes($picture_name)
        );
        $this->db->insert('a16_webapps_3.pictures', $array);
        return $this->db->insert_id();
    }

    /**
     * Store new gallery_picture with the given ID of a picture that is
     * already in the pictures table.
     * 
     * Do not use this function. Instead, use storeNewPuzzlePicture.
     */
    private function storeNewGallery($pictureID, $residentID = NULL) {
        $array = array(
            'picture_id' => $pictureID,
            'resident_id' => $residentID,
            'in_progress' => 0,
            'times_completed' => 0,
            'added_on' => date('Y-m-d H:i:s')
        );
        $this->db->insert('a16_webapps_3.gallery_pictures', $array);
    }

    /**
     * Return a gallery_picture stored in the database.
     */
    function getGalleryPicture($galleryID) {
        $query = $this->db->query(
                "SELECT *"
                . " FROM a16_webapps_3.gallery_pictures"
                . " WHERE id='$galleryID'"
        );
        return $query->result();
    }

    /**
     * Get all gallery records from a given resident.
     */
    function getGalleryPicturesFrom($residentID) {
        $query = $this->db->query(
                "SELECT *"
                . " FROM a16_webapps_3.gallery_pictures"
                . " WHERE id='$residentID'"
        );
        return $query->result();
    }

    /**
     * Get all gallery records. This won't return the actual pictures, but
     * all information about them, including their id in the pictures table.
     * 
     * Never use this function to get all actual pictures (this will 
     * clog the database for a while if there are many pictures)!
     */
    function getAllGalleryPictures() {
        $query = $this->db->query(
                "SELECT *"
                . " FROM a16_webapps_3.gallery_pictures"
        );
        return $query->result();
    }

    /**
     * Return (at most) n gallery records of the given resident which refer to
     * pictures that are completed at least once.
     * 
     * Do not use this function outside of this model. Instead, use getNPictures.
     */
    private function getNGalleryPictures($residentID, $n) {
        $query = $this->db->query(
                "SELECT picture_id"
                . " FROM a16_webapps_3.gallery_pictures"
                . " WHERE resident_id='$residentID' AND in_progress = 0 AND times_completed > 0"
                . " ORDER BY last_completed DESC"
                . " LIMIT $n"
        );
        return $query;
    }

    /**
     * Return a picture stored in the database. Both the folder where it is
     * stored in (picture_dir) and the picture name are returned.
     * 
     * The full path of the picture can be gotten as follows:
     * $full_path = $picutre_dir . $picture_name
     * 
     */
    function getPicture($pictureID) {
        $query = $this->db->query(
                "SELECT picture_dir, picture_name"
                . " FROM a16_webapps_3.pictures"
                . " WHERE id='$pictureID'"
        );
        return $query->result();
    }

    /**
     * Return the profile picture of the given resident.
     * Returns null if no profile picture is set.
     */
    function getProfilePicture($residentID) {
        $query = $this->db->query(
                "SELECT profile_picture_id "
                . "FROM a16_webapps_3.residents "
                . "WHERE id='$residentID'"
        );
        $pictureID = $query->result()[0]->profile_picture_id;
        if ($pictureID == NULL) {
            return "/assets/imgs/nopropic.png";
        }
        $picture = $this->getPicture($pictureID)[0];
        return ("/" . $picture->picture_dir . $picture->picture_name);
    }

    /**
     * Get (at most) n pictures of the given resident, where n is a given number.
     */
    function getNCompletedPictures($residentID, $n = 5) {
        $galleries = $this->getNGalleryPictures($residentID, $n);

        $array = array();
        foreach ($galleries->result_array() as $row) {
            $array[] = $row['picture_id'];
        }

        if (count($array) != 0) {
            $query = $this->db->query(
                    "SELECT picture_dir, picture_name"
                    . " FROM a16_webapps_3.pictures"
                    . " WHERE id IN (" . implode(',', $array) . ")"
            );
            return $query->result();
        }
        return null;
    }

    private function incrementPuzzleCompleted($residentID) {
        $this->db->where('resident_id', $residentID);
        $this->db->where('in_progress', '1');
        $this->db->set('times_completed', 'times_completed+1', FALSE);
        $this->db->update('a16_webapps_3.gallery_pictures');
    }

    private function deactivatePuzzle($residentID) {
        $this->db->where('resident_id', $residentID);
        $this->db->where('in_progress', '1');
        $this->db->set('in_progress', '0', FALSE);
        $this->db->update('a16_webapps_3.gallery_pictures');
    }

    private function updateLastCompleted($residentID) {
        $date = date('Y-m-d H:i:s');
        $this->db->query(
                "UPDATE `a16_webapps_3`.`gallery_pictures`"
                . " SET `last_completed`='$date'"
                . " WHERE resident_id='$residentID' AND in_progress='1'"
        );
    }

    private function activateNewPuzzle($residentID) {
        $query = $this->db->query(
                "SELECT id"
                . " FROM `a16_webapps_3`.`gallery_pictures`"
                . " WHERE resident_id='$residentID'"
                . " ORDER BY times_completed ASC"
                . " LIMIT 1"
        );

        $result = $query->result();
        $result = $result[0]->id;

        $this->db->query(
                "UPDATE `a16_webapps_3`.`gallery_pictures`"
                . " SET `in_progress`='1'"
                . " WHERE id='$result'"
        );
    }

    /**
     * Delete the given gallery picture, both the record in the database and
     * the image file itself on the server (and the record in the pictures table).
     * 
     * Once this function has been called, deleted data will be gone forever!
     */
    function deleteGalleryPicture($galleryID) {
		$this->db->query("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
        $this->db->query("START TRANSACTION");

        //Get the picture id from the gallery record.
        $query = $this->db->query(
                "SELECT picture_id"
                . " FROM a16_webapps_3.gallery_pictures"
                . " WHERE id='$galleryID'"
        );
        $pictureID = $query->result()->picture_id;

        //Delete the record from the gallery_pictures table.
        $this->db->query(
                "DELETE "
                . "FROM a16_webapps_3.pictures "
                . "WHERE id ='$pictureID'"
        );

        //Delete the picture from the server and database.
        $this->deletePicture($pictureID);

        $this->db->query("COMMIT");
    }

    /**
     * Delete the profile picture of the given resident. The field profile_picture_id
     * of the resident will be set to null and the picture itself will be deleted from
     * the server and the pictures table.
     */
    function deleteProfilePicture($residentID) {
		$this->db->query("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
        $this->db->query("START TRANSACTION");

        //Get the profile picture id.
        $query = $this->db->query(
                "SELECT profile_picture_id"
                . " FROM a16_webapps_3.residents"
                . " WHERE id='$residentID'"
        );
        $pictureID = $query->result()->profile_picture_id;

        //If there was no profile picture set, just return from this function.
        if ($pictureID == NULL) {
            return;
        }

        //First remove the reference to the picture from the resident table (foreign key).
        $updateData = array('profile_picture_id' => NULL);
        $whereArray = array('id' => $residentID);
        $this->db->where($whereArray);
        $this->db->update('a16_webapps_3.residents', $updateData);

        //Then delete the picture from the server and database.
        $this->deletePicture($pictureID);

        $this->db->query("COMMIT");
    }

    /**
     * Delete a picture from the pictures table and from the database.
     * --------
     * | NEVER | CALL THIS FUNCTION FROM OUTSIDE THIS MODEL.
     * --------
     * If you want to delete pictures, use either of the functions:
     * - deleteGalleryPicture
     * - deleteProfilePicture
     */
    private function deletePicture($pictureID) {
        //Get the picture name and location on the server.
        $query = $this->db->query(
                "SELECT picture_dir, picture_name"
                . " FROM a16_webapps_3.pictures"
                . " WHERE id='$pictureID'"
        );
        $query = $query->result();

        //Delete the picture from the server.
        unlink('/' . $query->picture_dir . $query->picture_name);

        //Delete the record from the pictures table.
        $this->db->query(
                "DELETE "
                . "FROM a16_webapps_3.pictures "
                . "WHERE id ='$pictureID'"
        );
    }

    function getPictureTest($residentId) {
        $query = $this->db->query(
                "SELECT picture_dir, picture_name"
                . " FROM a16_webapps_3.pictures"
                . " WHERE id= (SELECT picture_id "
                . "FROM a16_webapps_3.gallery_pictures "
                . "WHERE resident_id = '$residentId' AND in_progress = '1')"
        );
        if($query !== null){
            return $query->result();
        } else {
            return null;
        }
    }

    //Deprecated function. Do not use this anymore, it will be deleted soon.
    //Use getNCompletedPictures( ... ) instead.
    function getFinishedPicture($residentId) {
        $query = $this->db->query(
                "SELECT picture_dir, picture_name"
                . " FROM a16_webapps_3.pictures"
                . " WHERE id="
                . " (SELECT picture_id"
                . " FROM `a16_webapps_3`.`gallery_pictures`"
                . " WHERE resident_id='$residentId' AND in_progress = '0' AND times_completed > '0'"
                . " ORDER BY times_completed DESC"
                . " LIMIT 3)"
        );
        return $query->result();
    }

    function updateAndChangePuzzle($residentID) {
        $this->incrementPuzzleCompleted($residentID);
        $this->updateLastCompleted($residentID);
        $this->deactivatePuzzle($residentID);
        $this->activateNewPuzzle($residentID);
    }

}
