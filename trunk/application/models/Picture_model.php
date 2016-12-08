<?php

class Picture_model extends CI_Model {

    public function __construct() {
        parent::__construct();

        $this->load->helper( 'date' );
        date_default_timezone_set( 'Europe/Brussels' );
    }

    /**
     * Store new puzzle picture in the database:
     * - pictures table is updated
     * - gallery_pictures table is updated
     * 
     * If the resident is NULL or not given (so it is NULL by default), the picture
     * is not assigned to 1 particular resident and it will be available for all residents.
     * ==> This is not recommended! (programmatically safe to do, but might result in
	 * undesired side effect with fields like last_completed,...)
     */
    function storeNewPuzzlePicture( $picture_dir, $picture_name, $residentID = NULL ) {
        //TODO: use transaction to be sure id isn't changed during the execution of this function.
        $pictureID = $this->storePicture( $picture_dir, $picture_name );
        $this->storeNewGallery( $pictureID, $residentID );
    }

    /**
     * Assign a new given profile picture to a given resident.
     */
    function storeNewProfilePicture( $picture_dir, $picture_name, $residentID ) {
        $pictureID = $this->storePicture( $picture_dir, $picture_name );
        $updateData = array( 'profile_picture_id' => $pictureID );
        $whereArray = array( 'id' => $residentID );
        $this->db->where( $whereArray );
        $this->db->update( 'a16_webapps_3.residents', $updateData );
    }

    /**
     * Store the given picture in the database and return the ID.
     */
    function storePicture( $picture_dir, $picture_name ) {
        $array = array(
            'picture_dir' => addslashes( $picture_dir ),
            'picture_name' => addslashes( $picture_name )
        );
        $this->db->insert( 'a16_webapps_3.pictures', $array );
        return $this->db->insert_id();
    }

    /**
     * Store new gallery_picture with the given ID of a picture that is
     * already in the pictures table.
     */
    function storeNewGallery( $pictureID, $residentID = NULL ) {
        $array = array(
            'picture_id' => $pictureID,
            'resident_id' => $residentID,
            'in_progress' => 0,
            'times_completed' => 0,
            'pieces_collected' => 0,
            'added_on' => date( 'Y-m-d H:i:s' )
        );
        $this->db->insert( 'a16_webapps_3.gallery_pictures', $array );
    }

    /**
     * Return a gallery_picture stored in the database.
     */
    function getGalleryPicture( $galleryID ) {
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
    function getGalleryPicturesFrom( $residentID ) {
        $query = $this->db->query(
                "SELECT *"
                . " FROM a16_webapps_3.gallery_pictures"
                . " WHERE id='$residentID'"
        );
        return $query->result();
    }

    /**
     * Get all gallery records.
     * Not recommended because of privacy issues!
     */
    function getAllGalleryPictures() {
        $query = $this->db->query(
                "SELECT *"
                . " FROM a16_webapps_3.gallery_pictures"
        );
        return $query->result();
    }

    /**
     * Return a picture stored in the database. Both the folder where it is
     * stored in (picture_dir) and the picture name are returned.
     * 
     * The full path of the picture can be get as follows:
     * $full_path = $picutre_dir . $picture_name
     * 
     */
    function getPicture( $pictureID ) {
        $query = $this->db->query(
                "SELECT picture_dir, picture_name"
                . " FROM a16_webapps_3.pictures"
                . " WHERE id='$pictureID'"
        );
        return $query->result();
    }

    /**
     * Get at most n pictures of the given resident, where n is a given number.
     */
    function getNPictures( $residentID, $n ) {
        //TODO
    }
	
	/**
	 * Delete the given gallery picture, both the record in the database and
	 * the image file itself on the server (and the record in the pictures table).
	 * 
	 * Once this function has been called, deleted data will be gone forever!
	 */
	//TODO transactions?
	function deleteGalleryPicture( $galleryID ) {
		//Get the picture id from the gallery record.
		$query = $this->db->query(
                "SELECT picture_id"
                . " FROM a16_webapps_3.gallery_pictures"
                . " WHERE id='$galleryID')"
        );
		$pictureID = $query->result()->picture_id;
		
		//Delete the record from the gallery_pictures table.
		$this->db->query(
			"DELETE "
			. "FROM a16_webapps_3.pictures "
			. "WHERE id ='$pictureID'" 
		);
		
		//Delete the picture from the server and database.
		$this->deletePicture( $pictureID );
	}
	
	/**
	 * Delete the profile picture of the given resident. The field profile_picture_id
	 * of the resident will be set to null and the picture itself will be deleted from
	 * the server and the pictures table.
	 */
	//TODO transactions?
	function deleteProfilePicture( $residentID ) {
		//Get the profile picture id.
		$query = $this->db->query(
                "SELECT profile_picture_id"
                . " FROM a16_webapps_3.residents"
                . " WHERE id='$residentID')"
        );
		$pictureID = $query->result()->profile_picture_id;
		
		//If there was no profile picture set, just return from this function.
		if($pictureID == NULL) {
			return;
		}
		
		//First remove the reference to the picture from the resident table (foreign key).
		$updateData = array( 'profile_picture_id' => NULL );
        $whereArray = array( 'id' => $residentID );
        $this->db->where( $whereArray );
        $this->db->update( 'a16_webapps_3.residents', $updateData );
		
		//Then delete the picture from the server and database.
		$this->deletePicture( $pictureID );
	}
	
	/**
	 * Delete a picture from the pictures table and from the database.
	 * --------
	 * | NEVER | CALL THIS FUNCTION FROM OUTSIDE THIS MODEL.
	 * --------
	 * This function should remain private. If you want to delete pictures,
	 * either use the functions:
	 * 
	 * - deleteGalleryPicture
	 * - deleteProfilePicture
	 */
	private function deletePicture( $pictureID ) {
		//Get the picture name and location on the server.
		$query = $this->db->query(
                "SELECT picture_dir, picture_name"
                . " FROM a16_webapps_3.pictures"
                . " WHERE id='$pictureID')"
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
	
	//Deprecated function. Do not use this anymore, it will be deleted soon.
    function getPictureTest( $residentId ) {
        $query = $this->db->query(
                "SELECT picture_dir, picture_name"
                . " FROM a16_webapps_3.pictures"
                . " WHERE id= (SELECT picture_id "
                . "FROM a16_webapps_3.gallery_pictures "
                . "WHERE resident_id = '$residentId' AND in_progress = '1')"
        );
        return $query->result();
    }

	//Deprecated function. Do not use this anymore, it will be deleted soon.
    function incrementPiecesCollected( $residentID ) {
		$this->db->where( 'resident_id', $residentID );
		$this->db->where( 'in_progress', 1 );
		$this->db->set( 'pieces_collected', 'pieces_collected+1', FALSE );
		$this->db->update( 'a16_webapps_3.gallery_pictures' );
    }
	
	//Deprecated function. Do not use this anymore, it will be deleted soon.
    function getNrCompleted( $Id ) {
        $query = $this->db->query(
                "SELECT pieces_collected"
                . " FROM a16_webapps_3.gallery_pictures"
                . " WHERE resident_id='$Id' AND in_progress = 1"
        );

        return $query->result();
    }
}
