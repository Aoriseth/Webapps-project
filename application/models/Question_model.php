<?php

class Question_model extends CI_Model {

	function getAllCategories( $language ) {
		$query = $this->db->query( "SELECT DISTINCT category FROM a16_webapps_3.questions WHERE language='$language'" );
		return $query->result();
	}

	function getAllQuestionsFrom( $language, $category ) {
		$query = $this->db->query(
			"SELECT * FROM a16_webapps_3.questions WHERE language='$language' AND category='$category' ORDER BY category_order ASC"
		);
		return $query->result();
	}
	
}
