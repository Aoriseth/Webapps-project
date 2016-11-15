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
        if(! hasQuestionAlreadyBeenAnswered($residentID, $questionID, $currentSession)) {
			$answerData = array(
				'elderly_id' => $residentID,
				'question_id' => $questionID,
				'answer' => $chosenOption,
				'session' => $currentSession,
				'datetime_answered' => date('Y-m-d H:i:s')
			);
			$this->db->insert('a16_webapps_3.answers', $answerData);
		} else {
			
		}
    }
	
	private function hasQuestionAlreadyBeenAnswered($residentID, $questionID, $currentSession) {
		
		return FALSE;
	}
}
