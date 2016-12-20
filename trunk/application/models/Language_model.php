<?php

class Language_model extends CI_Model {

    public function __construct() {
        parent::__construct();
	}
	
	/**
	 * Translate the given language to a different language. This function
	 * works like a dictionary.
	 * 
	 * - Example 1:
	 * translate(English, francais) returns anglais
	 * - Example 2:
	 * translate(Nederlands, English) returns Dutch
	 * - Example 3:
	 * translate(English, English) returns English
	 */
	function translate( $word_to_translate, $translate_to ) {
		if($word_to_translate == $translate_to) {
			return $word_to_translate;
		}
		$query = $this->db->query(
			"SELECT translation "
			. "FROM a16_webapps_3.languages "
			. "WHERE language_set='$word_to_translate' AND translate_to='$translate_to'"
		);
		return $query->result()[0]->translation;
	}
	
}