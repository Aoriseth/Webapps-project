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
	 * Add the total score of this session to the database.
	 */
	function addSessionScore( $residentID ) {
		$currentSession = ( $this->Resident_model->getSessionsCompleted( $residentID ) ) + 1;
		$array = array(
			'resident_id' => $residentID,
			'session' => $currentSession,
			'score' => $this->computeTotalScore( $residentID, $currentSession ),
			'completed_on' => date( 'Y-m-d H:i:s' )
		);
		$this->db->insert( 'a16_webapps_3.session_scores', $array );
	}
	
	/**
	 * Get the completed sessions of the given resident and the date on which
	 * these sessions were completed.
	 */
	function getAllCompletedSessionDates( $residentID ) {
		$query = $this->db->query(
			"SELECT session, completed_on "
			. "FROM a16_webapps_3.session_scores "
			. "WHERE resident_id='$residentID' "
			. "ORDER BY session ASC"
		);
		return $query->result();
	}
	
	/**
	 * Get the completed sessions of the given resident and the score of each
	 * completed session.
	 */
	function getAllCompletedSessionScores( $residentID ) {
		$query = $this->db->query(
			"SELECT session, score "
			. "FROM a16_webapps_3.session_scores "
			. "WHERE resident_id='$residentID' "
			. "ORDER BY session ASC"
		);
		return $query->result();
	}
	
	/**
	 * Get the completed sessions of the given resident and the score of each
	 * completed session.
	 * 
	 * Use this function only if you need both the scores and the dates
	 * of the completed sessions.
	 */
	function getAllCompletedSessionScoresAndDates( $residentID ) {
		$query = $this->db->query(
			"SELECT session, score, completed_on "
			. "FROM a16_webapps_3.session_scores "
			. "WHERE resident_id='$residentID' "
			. "ORDER BY session ASC"
		);
		return $query->result();
	}
	
	/**
	 * Get the most recently completed session and date
	 * of all residents.
	 */
	function getLastCompletedSessionDatesOfAllResidents() {
		$query = $this->db->query(
			"SELECT session, completed_on "
			. "FROM ( "
				. "SELECT a16_webapps_3.session_scores.*, row_number() OVER "
				. "(PARTITION BY resident_id ORDER BY completed_on DESC) AS rn "
				. "FROM a16_webapps_3.session_scores "
				. ") nested_table "
			. "WHERE nested_table.rn = 1"
		);
		return $query->result();
	}
	
	/**
	 * Get the most recently completed session and score
	 * of all residents.
	 */
	function getLastCompletedSessionScoresOfAllResidents() {
		$query = $this->db->query(
			"SELECT session, score "
			. "FROM ( "
				. "SELECT a16_webapps_3.session_scores.*, row_number() OVER "
				. "(PARTITION BY resident_id ORDER BY completed_on DESC) AS rn "
				. "FROM a16_webapps_3.session_scores "
				. ") nested_table "
			. "WHERE nested_table.rn = 1"
		);
		return $query->result();
	}
	
	/**
	 * Get the most recently completed session and score
	 * of all residents.
	 * 
	 * Use this function only if you really need both the score of
	 * the session and the date on which it was finished.
	 */
	function getLastCompletedSessionScoresAndDatesOfAllResidents() {
		$query = $this->db->query(
			"SELECT session, score, completed_on "
			. "FROM ( "
				. "SELECT a16_webapps_3.session_scores.*, row_number() OVER "
				. "(PARTITION BY resident_id ORDER BY completed_on DESC) AS rn "
				. "FROM a16_webapps_3.session_scores "
				. ") nested_table "
			. "WHERE nested_table.rn = 1"
		);
		return $query->result();
	}
        
	/**
	 * Compute the total score of the current session for the given resident.
	 */
	private function computeTotalScore( $residentID, $currentSession ) {
		$query = $this->db->query(
			"SELECT "
				. "SUM(score*category_weight) AS sum_weighted_category_scores, "
				. "SUM(100*category_weight) AS sum_weighted_total "
			. "FROM a16_webapps_3.category_score_view "
			. "WHERE resident_id='$residentID' AND session='$currentSession'"
		);
		$result = $query->result();
		return 100 * ( $result[0]->sum_weighted_category_scores ) / ( $result[0]->sum_weighted_total );
	}
	
	
	/**
	 * ----------------------------------------------
	 * Functions involving category scores and dates.
	 * ----------------------------------------------
	 */
	
	/**
	 * Add the total score of the completed category to the database.
	 */
	function addCategoryScore( $residentID, $categorySet ) {
		$currentSession = ( $this->Resident_model->getSessionsCompleted( $residentID ) ) + 1;
		$array = array(
			'resident_id' => $residentID,
			'category_set' => $categorySet,
			'session' => $currentSession,
			'score' => $this->computeCategoryScore( $residentID, $categorySet, $currentSession ),
			'completed_on' => date( 'Y-m-d H:i:s' )
		);
		$this->db->insert( 'a16_webapps_3.category_scores', $array );
	}
	
	/**
	 * Compute the score of the given category set answered by the resident
	 * within the current session.
	 */
	private function computeCategoryScore( $residentID, $categorySet, $currentSession ) {
		$query = $this->db->query(
			"SELECT "
				. "SUM(option_score*question_weight) AS sum_weighted_answers, "
				. "SUM(max_score*question_weight) AS sum_weighted_total "
			. "FROM a16_webapps_3.answer_view "
			. "WHERE resident_id='$residentID' AND category_set='$categorySet' "
				. "AND current_session='$currentSession'"
		);
		$result = $query->result();
		return 100 * ( $result[0]->sum_weighted_answers ) / ( $result[0]->sum_weighted_total );
	}
}