<?php

class Tip_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
	
	/**
	 * Get one randomly chosen tip belonging to the given category set.
	 */
	function getTipFromCategorySet( $categorySetID ) {
		$language = $this->session->language;
		$query = $this->db->query(
				"SELECT tip "
				. "FROM a16_webapps_3.tip_view "
				. "WHERE category_set='$categorySetID' AND language='$language' "
				. "ORDER BY RAND() "
				. "LIMIT 1"
		);
		return $query->result()[0];
	}
}