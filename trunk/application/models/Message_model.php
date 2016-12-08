<?php

class Message_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
	
	/**
	 * Return all unread messages posted by the given resident.
	 */
	function getMessagesFrom( $residentID ) {
		$language = $this->session->language;
		$query = $this->db->query(
			"SELECT from_resident, first_name, last_name, posted_on, message"
			. " FROM a16_webapps_3.message_view"
			. " WHERE language='$language' AND message_read='0' AND from_resident='$residentID'"
			. " ORDER BY posted_on DESC"
        );
        return $query->result();
	}
	
	/**
	 * Return the n last posted unread messages.
	 * 
	 * If n is not given, it will return at most 10 results.
	 */
	function getNLastMessages( $n=10 ) {
		$language = $this->session->language;
		$query = $this->db->query(
			"SELECT from_resident, first_name, last_name, posted_on, message"
			. " FROM a16_webapps_3.message_view"
			. " WHERE language='$language' AND message_read='0'"
			. " ORDER BY posted_on DESC"
			. " LIMIT '$n'"
        );
        return $query->result();
	}
	
}