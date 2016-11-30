<?php

class Picture_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * Store new puzzle picture in the database:
	 * - pictures table is updated
	 * - gallery_pictures table is updated
	 */
	function storeNewPuzzlePicture($picture_dir, $picture_name, $residentID) {
		
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
		echo $this->db->insert_id();
		exit;
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