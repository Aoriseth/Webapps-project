<?php

class Statistics_model extends CI_Model{
    
    public function __construct() {
		parent::__construct();
	}
        
  
        
    function getResidentAnswersFromCategory( $residentID, $categorySetID) {
		$query = $this->db->query(
			"SELECT option_set, question_weight"
			. " FROM a16_webapps_3.answers"
                        . " INNER JOIN a16_webapps_3.question_sets"
                        . " ON a16_webapps_3.answers.question_set = a16_webapps_3.question_sets.id"
			. " WHERE resident_id = '$residentID' AND category_set = '$categorySetID'"
		);
		return $query->result();
    }
    
    function getScoreCategory($residentID, $categorySetID) {

        $answers = $this->getResidentAnswersFromCategory( $residentID, $categorySetID);
        $categoryScore = 0;
        $categoryAverageScore = 0;

        //for all questions
		foreach ($answers as $answer) {
                        $option = $answer->option_set;
                        $weight = $answer->question_weight;
			$categoryScore += $option/5*100*$weight;
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

    function getTotalScoreResident($resident, $categorySets){
        $totalScore = 0;
        $nonZeroCategories = 0;
        $totalAvarageScore = 0;
        //for all categories
        foreach($categorySets as $categorySet) {
            $scoreCategory = $this->getScoreCategory($resident, $categorySet->id);
            $totalScore += $scoreCategory;
            if($scoreCategory > 0){
                $nonZeroCategories++;
            }
        }
//      
        if($nonZeroCategories > 0){
            $totalAvarageScore = $totalScore/$nonZeroCategories;
        }
        return $totalAvarageScore;
    }
}
