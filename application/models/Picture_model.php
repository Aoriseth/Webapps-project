<?php

class Picture_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * Store the given picture in the database with the given resident as owner.
	 */
	function storePicture($residentID, $picture_path) {
		$this->db->insert('a16_webapps_3.pictures', $picture_path);
	}
	
	/**
	 * Get at most n pictures of the given resident, where n is a given
	 * number of choice.
	 */
	function getNPictures($residentID, $n) {
		
	}
}