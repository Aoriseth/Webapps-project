<?php

class Answer_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
        
        $this->load->helper('date');
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
    function storeAnswer($residentID, $questionID, $answer, $currentSession) {
        $answerData = array(
            'elderly_id' => $residentID,
            'question_id' => $questionID,
            'answer' => $answer,
            'session' => $currentSession,
            'datetime_answered' => now()
        );
        $this->db->insert('a16_webapps_3.answers', $answerData);
    }
}
