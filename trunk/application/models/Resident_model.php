<?php

class Resident_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		
		require 'lib/password.php';
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
		$query = $this->db->query(
			"SELECT * "
			. "FROM a16_webapps_3.residents"
		);
		return $query->result();
	}
	
	/**
	 * Get the resident with the given ID.
	 */
	function getResidentById( $residentID ) {
		$query = $this->db->query(
			"SELECT * "
			. "FROM a16_webapps_3.residents "
			. "WHERE id='$residentID'"
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
	
	/**
	 * Insert a new resident into the database.
	 */
	function addResident( $residentID, $firstName, $lastName, $gender,
			$password, $dateOfBirth, $language, $floorNumber,
			$roomNumber, $lastDomicile, $caregiverID ) {
		$array = array(
			'id' => $residentID,
			'first_name' => $firstName,
			'last_name' => $lastName,
			'gender' => $gender,
			'password' => password_hash($password, PASSWORD_DEFAULT),
			'date_of_birth' => $dateOfBirth,
			'language' => $language,
			'floor_number' => $floorNumber,
			'room_number' => $roomNumber,
			'last_domicile' => $lastDomicile,
			'type' => 'resident',
			'account_created_by' => $caregiverID,
			'account_created_on' => date('Y-m-d H:i:s')
		);
		$this->db->insert('a16_webapps_3.residents', $array);
	}
	
	/**
	 * Get all residents that fit the requirements given in an array.
	 * 
	 * Example 1:
	 * $array_requirements = array('floor_number' => 3)
	 * 
	 * Example 2:
	 * $array_requirements = array('floor_number' => 3, 'gender' => 'Female')
	 */
	function getResidentsWith( $array_requirements ) {
		$query = $this->db->get_where(
				'a16_webapps_3.residents',
				$array_requirements				
		);
		return $query->result();
	}
	
	/*
	 * Get all residents born before the given datetime.
	 */
	function getAllResidentsBornBefore( $datetime ) {
		$query = $this->db->query(
			"SELECT * "
			. "FROM a16_webapps_3.residents "
			. "WHERE date_of_birth < '$datetime'"
		);
		return $query->result();
	}
	
	/*
	 * Get all residents born after the given datetime.
	 */
	function getAllResidentsBornAfter( $datetime ) {
		$query = $this->db->query(
			"SELECT * "
			. "FROM a16_webapps_3.residents "
			. "WHERE date_of_birth > '$datetime'"
		);
		return $query->result();
	}
	
	/*
	 * Get all residents that were last active before the given datetime.
	 */
	function getAllResidentsLastActiveBefore( $datetime ) {
		$query = $this->db->query(
			"SELECT * "
			. "FROM a16_webapps_3.residents "
			. "WHERE last_activity < '$datetime'"
		);
		return $query->result();
	}
	
	/**
	 * Get the language of the given resident.
	 */
	function getResidentLanguage( $residentID ) {
		$query = $this->db->query(
			"SELECT language "
			. "FROM a16_webapps_3.residents "
			. "WHERE id='$residentID'"
		);
		return $query->row()->language;
	}
	
	/**
	 * Return the number of sessions that are completed by the resident with
	 * the given ID.
	 */
	function getSessionsCompleted( $residentID ) {
		$query = $this->db->query(
			"SELECT completed_sessions "
			. "FROM a16_webapps_3.residents "
			. "WHERE id='$residentID'"
		);
		return $query->row()->completed_sessions;
	}
}