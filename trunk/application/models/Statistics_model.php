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
    
    function getResidentAnswersFromCategoryOfSession( $residentID, $categorySetID, $session) {
		$query = $this->db->query(
			"SELECT option_set, question_weight"
			. " FROM a16_webapps_3.answers"
                        . " INNER JOIN a16_webapps_3.question_sets"
                        . " ON a16_webapps_3.answers.question_set = a16_webapps_3.question_sets.id"
			. " WHERE resident_id = '$residentID' AND category_set = '$categorySetID' AND session = '$session'"
		);
		return $query->result();
    }
    
    function getScoresCategoryofSession( $residentID, $categorySetID, $session) {
        
                $resident = $this->Resident_model->getResidentById($residentID);
                $answers = $this->getResidentAnswersFromCategoryOfSession( $residentID, $categorySetID, $session);
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
    
    function getAllCategoriesBelow($residentID, $score){
        $categories = $this->Question_model->getAllCategories();
        $returnCategories = [];
        foreach($categories as $category){
            $categoryScore = $this->getScoreCategory($residentID, $category->id);
            if($categoryScore < $score && $categoryScore > 0){
                $categoryName = $this->Question_model->getCategoryName($category->id, $this->session->language);
                array_push($returnCategories, $categoryName[0]->category);
            }
        }
        return $returnCategories;
    }
    
    function generateResidentComment($resident){
        $categories = $this->Question_model->getAllCategories();
        $comment = "Comment about the scores of the resident.";
        $averageScore = 50;
        $goodScore = 70;
        $good = [];
        $bad = [];
        $average = [];
        foreach($categories as $category){
            $categoryScore = $this->getScoreCategory($resident, $category->id);
            if($categoryScore < $averageScore && $categoryScore > 0){
                $categoryName = $this->Question_model->getCategoryName($category->id, $this->session->language);
                array_push($bad, $categoryName[0]->category);
            }
            elseif($categoryScore >= $averageScore && $categoryScore < $goodScore){
                $categoryName = $this->Question_model->getCategoryName($category->id, $this->session->language);
                array_push($average, $categoryName[0]->category);
            }
            elseif($categoryScore >= $goodScore){
                $categoryName = $this->Question_model->getCategoryName($category->id, $this->session->language);
                array_push($good, $categoryName[0]->category);
            }
        }
        $total = count($bad)+count($average)+count($good);
        if(count($bad)/$total < 0.2){
            if(count($good)/$total > 0.2){
                $comment = "is doing very well, she scores very good on";
                foreach($good as $goodCat){   
                    $comment .= ", " . $goodCat;
                }
                $comment .= ". ";
                if(count($bad) > 0){
                    $comment .= "There is however room for improvement on";
                    foreach($bad as $badCat){
                        $comment .= ", " . $badCat;
                    }
                    $comment .= ". ";
                }
            }
            else{
                $comment = "is generally doing well";
            }
        }
        else{
            $comment = "is not doing well, she scores bad on";
            if(count($bad) > 0){
                    foreach($bad as $badCat){
                        $comment .= ", " . $badCat;
                    }
                    $comment .= ". ";
            }
        }
        return $comment;
        
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
