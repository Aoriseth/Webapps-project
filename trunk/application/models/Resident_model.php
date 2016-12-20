<?php

class Resident_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		
		$this->load->helper( 'date' );
        date_default_timezone_set( 'Europe/Brussels' );
		$this->load->model( 'Score_model' );
	}

	/*
	 * Increase the session of the resident whith given ID by 1.
	 */
	function incrementSession( $residentID ) {
		$this->db->where( 'id', $residentID );
		$this->db->set( 'completed_sessions', 'completed_sessions+1', FALSE );
		$this->db->update( 'a16_webapps_3.residents' );
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
	 * Get all floors that are stored in the database.
	 */
	function getAllFloors() {
		$query = $this->db->query(
				"SELECT DISTINCT floor_number "
				. "FROM a16_webapps_3.residents "
				. "ORDER BY floor_number"
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
	 * Return all the residents that have the given language set as their
	 * display language.
	 */
	function getAllResidentsByLanguage( $language ) {
		$query = $this->db->query(
			"SELECT * "
			. "FROM a16_webapps_3.residents "
			. "WHERE language='$language'"
		);
		return $query->result();
	}
	
	/**
	 * Insert a new resident into the database.
	 */
	function addResident( $residentID, $firstName, $lastName, $gender,
			$password, $dateOfBirth, $language, $floorNumber,
			$roomNumber, $lastDomicile ) {
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
			'account_created_by' => $this->session->id,
			'account_created_on' => date( 'Y-m-d H:i:s' )
		);
		$this->db->insert( 'a16_webapps_3.residents', $array );
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
	 * Get all residents born between the given datetimes.
	 */
	function getAllResidentsBornBetween( $dateAfter, $dateBefore ) {
		$query = $this->db->query(
			"SELECT * "
			. "FROM a16_webapps_3.residents "
			. "WHERE date_of_birth > '$dateAfter'"
			. "AND date_of_birth < '$dateBefore'"
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
	
	/**
	 * Return a list of n residents that have finished a questionnaire recently.
	 * List ordered from newest to oldest. Returns less than n if there aren't that
	 * many residents in the database.
	 * 
	 * If n is not given, it will return at most 10 results.
	 */
	function getNMostRecentCompletedResidents( $n=10 ) {
		$query = $this->db->query(
			"SELECT id, first_name, last_name, last_completed "
			. "FROM a16_webapps_3.residents "
			. "ORDER BY last_completed DESC "
			. "LIMIT $n"
		);
		return $query->result();
	}
	
	/**
	 * Return a list of n residents that have finished a questionnaire the longest time ago.
	 * List ordered from longest ago to more recently. Returns less than n if there aren't that
	 * many residents in the database.
	 * 
	 * If n is not given, it will return at most 10 results.
	 */
	function getNLongestAgoCompletedResidents( $n=10 ) {
		$query = $this->db->query(
			"SELECT id, first_name, last_name, last_completed "
			. "FROM a16_webapps_3.residents "
			. "ORDER BY last_completed ASC"
			. "LIMIT $n"
		);
		return $query->result();
	}
	
	/**
	 * Return n or less residents that haven't completed the questionnaire in
	 * over a given amount of days.
	 * 
	 * If no number of days is given, 30 is chosen by default.
	 * If no number of wanted records is given, 10 or less results will be returned.
	 * 
	 * Note about default values:
	 * If you call this function with a given n, days should also be given.
	 */
	function getNResidentsNotCompletedIn( $days=30, $n=10 ) {
		$query = $this->db->query(
			"SELECT id, first_name, last_name, last_completed "
			. "FROM a16_webapps_3.residents "
			. "WHERE last_completed > NOW() - INTERVAL '$days' DAY"
			. "ORDER BY last_completed ASC"
			. "LIMIT $n"
		);
		return $query->result();
	}
	
}