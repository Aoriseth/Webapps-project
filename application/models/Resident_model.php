<?php

class Resident_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	/*
	 * Increase the session of the resident whith given ID by 1.
	 */
	function incrementSession( $residentID ) {
		$this->db->where('id', $residentID);
		$this->db->set('completed_sessions', 'completed_sessions+1', FALSE);
		$this->db->update('a16_webapps_3.residents');
	}
	
	/**
	 * Get all residents that are stored in the database.
	 */
	function getAllResidents() {
		$query = $this->dB->query(
			"SELECT * "
			. "FROM a16_webapps_3.residents"
		);
		return $query->result();
	}
}