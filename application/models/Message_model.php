<?php

class Message_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
	
	/**
	 * Return all unread messages posted by the given resident.
	 */
	function getMessagesFrom( $residentID ) {
		
	}
	
	/**
	 * Return the n last posted unread messages.
	 */
	function getNLastMessages( $n ) {
		$language = 'English';
		$query = $this->db->query(
			"SELECT resident_id, first_name, last_name, message, posted_on"
			. " FROM a16_webapps_3.message_view"
        );
        return $query->result();
	}
	
}