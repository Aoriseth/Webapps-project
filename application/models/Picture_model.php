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
	 * is not assigned to 1 particular and it will be available for all residents.
	 * ==> This is NOT recommended! (might give problems with fields like last_completed, pieces_collected,...)
	 */
	function storeNewPuzzlePicture($picture_dir, $picture_name, $residentID = NULL) {
		//TODO: use transaction to be sure id isn't changed during the execution of this function.
		$pictureID = $this->storePicture($picture_dir, $picture_name);
		$this->storeNewGallery($pictureID, $residentID);
	}
	
	/**
	 * Assign a new given profile picture to a given resident.
	 */
	function storeNewProfilePicture($picture_dir, $picture_name, $residentID) {
		$pictureID = $this->storePicture($picture_dir, $picture_name);
		$updateData = array('profile_picture_id' => $pictureID);
		$whereArray = array('id' => $residentID);
		$this->db->where($whereArray);
		$this->db->update('a16_webapps_3.answers', $updateData);
	}
	
	/**
	 * Store the given picture in the database and return the ID.
	 */
	function storePicture($picture_dir, $picture_name) {
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
	 */
	function storeNewGallery($pictureID, $residentID = NULL) {
		$array = array(
			'picture_id' => $pictureID,
			'resident_id' => $residentID,
			'in_progress' => 0,
			'times_completed' => 0,
			'pieces_collected' => 0,
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
			. " WHERE resident_id='$residentID'"
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
	function getPicture($pictureID) {
		$query = $this->db->query(
			"SELECT picture_dir, picture_name"
			. " FROM a16_webapps_3.pictures"
			. " WHERE id='$pictureID'"
		);
		return $query->result();
	}
	
	/**
	 * Get at most n pictures of the given resident, where n is a given
	 * number of choice.
	 */
	function getNPictures($residentID, $n) {
		
	}
}