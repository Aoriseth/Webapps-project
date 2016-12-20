<?php

class Question_model extends CI_Model {

    public function __construct() {
        parent::__construct();
		
		//require 'lib/password.php';
    }

    /* Returns all categories of the given language.
     * Members:
     * 	- id		(uint)
     */
    function getAllCategories() {
        $query = $this->db->query(
			"SELECT id"
			. " FROM a16_webapps_3.category_sets"

        );
		echo 'Current PHP version: ' . phpversion();
		exit;
		/*
		$pw1 = '$2y$10$h2JKVTtmxVEJ3wAaPf6yxOyGo4dfhKEqZTef0T7Vm2PpBEiE.huHa';
		$pw2 = '$2y$10$h2JKVTtmxVEJ3wAaPf6yxOyGo4dfhKEqZTef0T7Vm2PpBEiE.huHa';
		$condition = password_hashed_verify($pw1, $pw2);
		echo $condition;
		exit;
		*/
		
        return $query->result();
    }
	
	private function getAllCategoriesRandomized() {
		$query = $this->db->query(
			"SELECT id"
			. " FROM a16_webapps_3.category_sets"
			. " ORDER BY RAND()"			
        );
        return $query->result_array();
	}
    
    function getAllCategoryNames( $language ) {
        $query = $this->db->query(
			"SELECT category_set, category"
			. " FROM a16_webapps_3.categories"
			. " WHERE language = '$language'"
        );
        return $query->result();
    }
    
    function getCategoryName( $id, $language ) {
        $query = $this->db->query(
			"SELECT category"
			. " FROM a16_webapps_3.categories"
			. " WHERE category_set = '$id' AND language = '$language'"
        );
        return $query->result();
    }

    /* Returns all categories within the current session
     * that are not yet completed.
     */
    function getAllUnfinishedCategories( $residentID, $limit=3 ) {
        $language = $this->session->language;
        $currentSession = ( $this->Resident_model->getSessionsCompleted( $residentID ) ) + 1;

        $all_category_sets = $this->getAllCategoriesRandomized();
        $unfinished_categories = array();
		
		$counter = 0;
        foreach ( $all_category_sets as $category ) {
            if ( !$this->isFinishedCategory( $residentID, $currentSession, $category[ 'id' ] ) ) {
                $unfinished_categories[] = $category[ 'id' ];
				$counter++;
				if ( $counter >= $limit ) {
					break;
				}
            }
        }
        return $this->getCategoriesById( $unfinished_categories, $language );
    }

    /**
     * Check if a given category (by category_set) is completed finished by a
     * given resident (by ID) with a given session count.
     */
    private function isFinishedCategory( $residentID, $currentSession, $categorySet ) {
        //Get the number of questions in this category (sets)
        $category = $this->db->query(
			"SELECT question_count"
			. " FROM a16_webapps_3.category_sets"
			. " WHERE id='$categorySet'"
        );
        $questions_in_category_set = $category->row()->question_count;

        //Count the number of questions answered by the resident for this session and category set
        $answered = $this->db->query(
                "SELECT COUNT(resident_id)"
                . " FROM a16_webapps_3.answer_view"
                . " WHERE resident_id='$residentID' AND category_set='$categorySet' AND current_session='$currentSession'"
        );
        $nb_of_questions_of_category_set_answered = $answered->row_array();
        $nb_of_q = $nb_of_questions_of_category_set_answered['COUNT(resident_id)'];

        if ( $questions_in_category_set == $nb_of_q ) {
            return TRUE;
        }
        return FALSE;
    }

    function getFinishedCategorySets( $residentID ) {
        $currentSession = ( $this->Resident_model->getSessionsCompleted( $residentID ) ) + 1;

        $all_category_sets = $this->getAllCategories();
		$categories = array();
		
        foreach ( $all_category_sets as $category ) {
            if ( $this->isFinishedCategory( $residentID, $currentSession, $category->id ) ) {
                $categories[] = 1;
            } else {
                $categories[] = 0;
            }
        }
        return $categories;
    }

	/*
	 * Get the category set ID by a given category (string description)
	 * in a given language.
	 */
	function getCategorySetIdFrom( $language, $category ) {
		$query = $this->db->query(
			"SELECT category_set"
			. " FROM a16_webapps_3.categories"
			. " WHERE language='$language' AND category='$category'"
		);
		return $query->row()->category_set;
	}

	/*
	 * Get an array with categories (both ID and name of the category)
	 * given an array with just the category IDs.
	 */
	function getCategoriesById( $array_with_category_sets, $language ) {
		if ( count( $array_with_category_sets ) == 0 ) {
			return array();
		}
		$query = $this->db->query(
			"SELECT id, category"
			. " FROM a16_webapps_3.categories"
			. " WHERE language='$language' AND "
			. "category_set IN (" . implode(',', $array_with_category_sets) . ")"
		);
		return $query->result();
	}

	/**
	 * Get the question IDs of all questions within a given category (by ID) 
	 * that still need to be answered by a resident (by ID) within his
	 * current session.
	 */
	function getAllUnansweredQuestionsFrom( $residentID, $categorySetID ) {
		$language = $this->session->language;
		$currentSession = ( $this->Resident_model->getSessionsCompleted( $residentID ) ) + 1;

		$all_questions = $this->getAllQuestionSetsFrom( $categorySetID );
		$answered_questions = $this->getAllAnsweredQuestionSetsFrom( $residentID, $categorySetID, $currentSession );

		$stored = array();
		foreach ( $answered_questions as $question ) {
			$stored[] = $question->question_set;
		}

		$unanswered_questions = array();
		foreach ( $all_questions as $question ) {
			if ( !in_array( $question->id, $stored ) ) {
				$unanswered_questions[] = $question->id;
			}
		}
		return $this->getQuestionsBySetID( $unanswered_questions, $language );
	}

	/* Returns all question sets of the given category set.
	 * Members:
	 * 	- id			(unique number)
	 */
	function getAllQuestionSetsFrom( $categorySet ) {
		$query = $this->db->query(
			"SELECT id"
			. " FROM a16_webapps_3.question_sets"
			. " WHERE category_set='$categorySet'"
		);
		return $query->result();
    }

    /**
     * Get the question set id of all question sets of a given category (by set-id), answered
     * by a given resident (by ID) with a given session count. 
     */
    private function getAllAnsweredQuestionSetsFrom( $residentID, $categorySetID, $currentSession ) {
        $query = $this->db->query(
			"SELECT question_set"
			. " FROM a16_webapps_3.answer_view"
			. " WHERE resident_id='$residentID' AND category_set='$categorySetID' AND current_session='$currentSession'"
        );
        return $query->result();
    }

    /**
     * Returns all options for a question with a given ID.
     */
    function getOptionsFor( $questionSetID, $language ) {
        $query = $this->db->query(
			"SELECT  option_set, option"
			. " FROM a16_webapps_3.option_view"
			. " WHERE question_set='$questionSetID' AND language='$language'"
        );
        return $query->result();
    }

    /**
     * Get the question_set, question_weight and question text of the questions
     * of which the given array contains all the set IDs.
     */
    function getQuestionsBySetID( $arrayWithQuestionSetIDs, $language ) {
        if ( count( $arrayWithQuestionSetIDs ) == 0 ) {
            return array();
        }
        $query = $this->db->query(
			"SELECT question_set, question_weight, question"
			. " FROM a16_webapps_3.question_view"
			. " WHERE language='$language' AND question_set IN (" . implode(',', $arrayWithQuestionSetIDs) . ")"
        );
        return $query->result();
    }

}
