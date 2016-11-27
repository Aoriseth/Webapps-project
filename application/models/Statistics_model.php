<?php

class Statistics_model extends CI_Model{
    
    public function __construct() {
		parent::__construct();
		
		
	}

        
    function getWeightFor( $question_id ) {
	return $this->Question_model->getQuestionsByID([$question_id])[0]->score_weight;
    }  
        
    function getResidentAnswersFromCategory( $residentID, $categoryID) {
		$query = $this->db->query(
			"SELECT option_id, question_id"
			. " FROM a16_webapps_3.answers"
			. " WHERE resident_id='$residentID' AND category_id='$categoryID'"
		);
		return $query->result();
    }
    

    
    function getScoreCategory($residentID, $categoryID) {

        $answers = $this->getResidentAnswersFromCategory( $residentID, $categoryID);
        $categoryScore = 0;
        $categoryAverageScore = 1;

        //for all questions
            foreach ($answers as $answer) {
                    $categoryScore += $answer->option_id/5*100*$this->getWeightFor($answer->question_id);
            }
         if(count($answers) > 0) $categoryAverageScore = $categoryScore/count($answers);
        return $categoryAverageScore;
    }

    function getAvarageScoreCategory($category) {
        $totalScore = 0;
        $residents = $this->Question_model->getResidents();
        //for all residents
        foreach($residents as $resident){
            $totalScore += $this->getScoreCategory($resident->id, $category);
        }

        $avarageScore = $totalScore/count($residents);
        return $avarageScore;


    }

    function getTotalScoreResident($resident, $categories){
        $totalScore = 0;
        //for all categories
        foreach($categories as $category) {
            $totalScore += getScoreCategory($resident, $category);
        }

        return $totalScore;
    }
}
