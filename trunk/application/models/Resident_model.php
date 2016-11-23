<?php

class Resident_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	function incrementSession( $residentID ) {
		$this->db->where('id', $residentID);
		$this->db->set('completed_sessions', 'completed_sessions+1', FALSE);
		$this->db->update('a16_webapps_3.residents');
	}
	
}