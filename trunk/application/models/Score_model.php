<?php

class Score_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		
		$this->load->helper( 'date' );
        date_default_timezone_set( 'Europe/Brussels' );
	}
	
	/**
	 * ---------------------------------------------
	 * Functions involving session scores and dates.
	 * ---------------------------------------------
	 */
	
	/**
	 * 
	 */
	function addSessionScore( $residentID ) {
		$currentSession = ( $this->Resident_model->getSessionsCompleted( $residentID ) ) + 1;
		$array = array(
			'resident_id' => $residentID,
			'session' => $currentSession,
			'score' => 80,
			'completed_on' => date( 'Y-m-d H:i:s' )
		);
		$this->db->insert( 'a16_webapps_3.session_scores', $array );
	}
	
	function getAllCompletedSessionDates() {
		
	}
	
	function getAllCompletedSessionScores() {
		
	}
	
	/**
	 * ----------------------------------------------
	 * Functions involving category scores and dates.
	 * ----------------------------------------------
	 */
	
}