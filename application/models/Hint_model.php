<?php

class Hint_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
	
	/**
	 * Get hints belonging to the given category set.
	 */
	//TODO Variable language
	function getHintFromCategorySet( $categorySetID ) {
		$language = $this->session->language;
		$query = $this->db->query(
				"SELECT hint "
				. "FROM a16_webapps_3.hint_view "
				. "WHERE category_set='$categorySetID' AND language='$language'"
		);
		return $query->result()[0];
	}
}