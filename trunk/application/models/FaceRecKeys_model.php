<?php

class FaceRecKeys_model extends CI_Model {

	function getKeys() {
		$query = $this->db->query(
			"SELECT mashapeKey, albumname, albumKey"
			. " FROM a16_webapps_3.basic_info_API_faceRecog"
		);
		return $query->row();	// grab first row, doesn't check for extra's
	}
}
