<?php

class Statistics_model extends CI_Model{
    
    public function __construct() {
		parent::__construct();
	}
        
    function getWeightFor( $questionSetID ) {
		return $this->Question_model->getQuestionsBySetID([$questionSetID])[0]->question_weight;
    }  
        
    function getResidentAnswersFromCategory( $residentID, $categorySetID) {
		$query = $this->db->query(
			"SELECT option_set, question_set"
			. " FROM a16_webapps_3.answer_view"
			. " WHERE resident_id='$residentID' AND category_set='$categorySetID'"
		);
		return $query->result();
    }
    
    function getScoreCategory($residentID, $categorySetID, $language) {

        $answers = $this->getResidentAnswersFromCategory( $residentID, $categorySetID);
        $categoryScore = 0;
        $categoryAverageScore = 0;

        //for all questions
		foreach ($answers as $answer) {
			$categoryScore += $answer->option_set/5*100*$this->getWeightFor($answer->question_set);
		}
        if(count($answers) > 0) {
			$categoryAverageScore = $categoryScore/count($answers); //Change count($answers) to sum of weights
		}
        return $categoryAverageScore;
    }

    function getAvarageScoreCategory($categorySetID) {
        $totalScore = 0;
        $residents = $this->Resident_model->getAllResidents();
        //for all residents
        foreach($residents as $resident) {
            $totalScore += $this->getScoreCategory($resident->id, $categorySetID);
        }

        $avarageScore = $totalScore/count($residents);
        return $avarageScore;
    }

    function getTotalScoreResident($resident, $categorieSets){
        $totalScore = 0;
        //for all categories
        foreach($categorieSets as $categorySet) {
            $totalScore += getScoreCategory($resident, $categorySet);
        }
        return $totalScore;
    }
}
