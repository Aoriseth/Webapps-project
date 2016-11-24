<?php

class Resident_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		
		$this->load->helper('date');
        date_default_timezone_set('Europe/Brussels');
	}

	/*
	 * Increase the session of the resident whith given ID by 1.
	 */
	function incrementSession( $residentID ) {
		$this->db->where('id', $residentID);
		$this->db->set('completed_sessions', 'completed_sessions+1', FALSE);
		$this->db->update('a16_webapps_3.residents');
		
		$this->updateLastCompleted($residentID);
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
	
	/**
	 * Update the last completed field with the current time and date
	 * for a given resident (by ID).
	 */
	private function updateLastCompleted( $residentID ) {
		$this->db->where('id', $residentID);
		$this->db->set('last_completed', date('Y-m-d H:i:s'));
		$this->db->update('a16_webapps_3.residents');
	}
	
	
}