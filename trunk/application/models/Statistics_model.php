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
			. " FROM a16_webapps_3.answer_view"
			. " WHERE resident_id='$residentID' AND category_id='$categoryID'"
		);
		return $query->result();
    }
    
    function getScoreCategory($residentID, $categoryID, $language) {

        $answers = $this->getResidentAnswersFromCategory( $residentID, $categoryID);
        $categoryScore = 0;
        $categoryAverageScore = 0;

        //for all questions
		foreach ($answers as $answer) {
                    if($language == "English"){
				$categoryScore += $answer->option_id/5*100*$this->getWeightFor($answer->question_id);
                    }
                    elseif ($language == "Nederlands") {
                                $categoryScore += ($answer->option_id - 4)/5*100*$this->getWeightFor($answer->question_id);
                    
                    }
		}
        if(count($answers) > 0) {
			$categoryAverageScore = $categoryScore/count($answers);
		}
        return $categoryAverageScore;
    }

    function getAvarageScoreCategory($category) {
        $totalScore = 0;
        $residents = $this->Resident_model->getAllResidents();
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
