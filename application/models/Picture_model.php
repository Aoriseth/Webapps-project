<?php

class Picture_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * Store the given picture in the database with the given resident as owner.
	 */
	function storePicture($residentID, $picture) {
		//TODO this does not work! -> WIP
		$imgData =addslashes(file_get_contents($_FILES['userImage']['tmp_name']));
		$imageProperties = getimageSize($_FILES['userImage']['tmp_name']);
		$this->db->query("INSERT INTO pictures(picture)
		VALUES('{$imgData}')");
	}
	
	/**
	 * Get at most n pictures of the given resident, where n is a given
	 * number of choice.
	 */
	function getNPictures($residentID, $n) {
		
	}
}