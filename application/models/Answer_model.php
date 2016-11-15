<?php

class Answer_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        
        $this->load->helper('date');
        date_default_timezone_set('Europe/Brussels');
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
    function storeAnswer($residentID, $questionID, $chosenOption, $currentSession) {
		//Ready the array with the answers
		$answerData = array(
			'elderly_id' => $residentID,
			'question_id' => $questionID,
			'answer' => $chosenOption,
			'session' => $currentSession,
			'datetime_answered' => date('Y-m-d H:i:s'));
		
		//Check if the resident already answered this question (for instance by going back to the previous question).
		$query_answers = $this->db->query("SELECT id FROM a16_webapps_3.answers WHERE elderly_id='$residentID' AND question_id='$questionID' AND session='$currentSession'");
		if($query_answers->num_rows() == 0) {
			$this->db->insert('a16_webapps_3.answers', $answerData);
		} else {
			$whereArray = array(
				'elderly_id' => $residentID,
				'question_id' => $questionID,
				'session' => $currentSession);
			$this->db->where($whereArray);
			$this->db->update('a16_webapps_3.answers', $answerData);
		}
    }
	
	/**
	 * Check if a record with an answer from a given resident in a given session exists
	 * for a given question.
	 */
	private function hasQuestionAlreadyBeenAnswered($residentID, $questionID, $currentSession) {
		$query_answers = $this->db->query("SELECT id FROM a16_webapps_3.answers WHERE elderly_id='$residentID' AND question_id='$questionID' AND session='$currentSession'");
		if($query_answers->num_rows() == 0) {
			return FALSE;
		}
		return TRUE;
	}
}
