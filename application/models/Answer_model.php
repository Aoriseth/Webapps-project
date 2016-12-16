<?php

class Answer_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        
        $this->load->helper( 'date' );
        date_default_timezone_set( 'Europe/Brussels' );
    }
    
    /**
     * Adds the given answer of the resident to the database.
     * 
     * Members:
     *      - residentID        (string)    The id of the resident that has entered the answer.
     *      - questionID        (int)       The id of the question answered.
     *      - answer            (int)       The entered answer.
     *      - currentSession    (int)       The number of the session in progress, meaning that (currentSession-1) questionnaires are completed by the given resident.
     */
    function storeAnswer( $residentID, $questionSetID, $chosenOptionSet ) {
		$currentSession = ( $this->Resident_model->getSessionsCompleted( $residentID ) ) + 1;
		$language = $this->session->language;
		
		//Ready the array with the answers
		$answerData = array(
			'resident_id' => $residentID,
			'question_set' => $questionSetID,
			'option_set' => $chosenOptionSet,
			'session' => $currentSession,
			'answered_on' => date( 'Y-m-d H:i:s' ),
			'answered_in' => $language
		);
		
		//Check if the resident already answered this question (needed when going back to the previous question).
		if( ! $this->hasQuestionAlreadyBeenAnswered( $residentID, $questionSetID, $currentSession ) ) {
			$this->db->insert( 'a16_webapps_3.answers', $answerData );
		} else {
			$whereArray = array(
				'resident_id' => $residentID,
				'question_set' => $questionSetID,
				'session' => $currentSession);
			$this->db->where( $whereArray );
			$this->db->update( 'a16_webapps_3.answers', $answerData );
		}
		
		$this->updateLastActivity( $residentID );
    }
	
	/**
	 * Check if a record with an answer from a given resident in a given session exists
	 * for a given question.
	 * 
	 * Members:
     *      - residentID        (string)    The id of the resident that has entered the answer.
     *      - questionID        (int)       The id of the question answered.
     *      - currentSession    (int)       The number of the session in progress, meaning that (currentSession-1) questionnaires are completed by the given resident.
	 */
	private function hasQuestionAlreadyBeenAnswered( $residentID, $questionSetID, $currentSession ) {
		$query_answers = $this->db->query(
				"SELECT id "
				. "FROM a16_webapps_3.answers "
				. "WHERE resident_id='$residentID' AND question_set='$questionSetID' AND session='$currentSession'");
		if( $query_answers->num_rows() == 0 ) {
			return FALSE;
		}
		return TRUE;
	}
	
	/**
	 * Update the last activity field with the current time and date
	 * for a given resident (by ID).
	 */
	private function updateLastActivity( $residentID ) {
		$this->db->where( 'id', $residentID );
		$this->db->set( 'last_activity', date( 'Y-m-d H:i:s' ) );
		$this->db->update( 'a16_webapps_3.residents' );
	}
}
