<?php

class Question_model extends CI_Model {

	/* Returns all categories of the given language.
	 * Members:
	 *	- category		(string)
	 */
    
             function getResidents() {
		$query = $this->db->query(
			"SELECT *"
			. " FROM a16_webapps_3.residents"
		);
		return $query->result();
    }
    
	function getAllCategories( $language ) {
		$query = $this->db->query(
			"SELECT id, category"
			. " FROM a16_webapps_3.categories"
			. " WHERE language='$language'"
		);
		return $query->result();
	}
	
	/* Returns all categories of the given language and within the current session
	 * that are not yet completed.
	 * Members:
	 *	- id		(int)
	 */
	function getAllUnfinishedCategories( $residentID, $language, $currentSession ) {
		$all_categories = $this->db->query(
			"SELECT id"
			. " FROM a16_webapps_3.categories"
			. " WHERE language='$language'"
		);
		$unfinished_categories = array();
		foreach($all_categories->result_array() as $category) {
			if(! $this->isFinishedCategory($residentID, $language, $currentSession, $category['id'])) {
				$unfinished_categories[] = $category['id'];
			}
		}
		return $this->getCategoriesById($unfinished_categories);
	}
	
	/**
	 * Check if a given category (by ID) is completed finished by a
	 * given resident (by ID) with a given session count in a given language.
	 */
	private function isFinishedCategory( $residentID, $language, $currentSession, $categoryID ) {
		$category = $this->db->query(
			"SELECT id, question_count"
			. " FROM a16_webapps_3.categories"
			. " WHERE id='$categoryID' AND language='$language'"
		);
		$nb_of_questions_of_category_answered = $this->db->query(
			"SELECT COUNT(id)"
			. " FROM a16_webapps_3.answers"
			. " WHERE resident_id='$residentID' AND category_id='$categoryID' AND session='$currentSession'"
		);
		$q_count = $category->row()->question_count;
		$nb_of_questions_of_category_answered = $nb_of_questions_of_category_answered->row_array();
		$nb_of_q = $nb_of_questions_of_category_answered['COUNT(id)'];
		
		if($q_count == $nb_of_q) {
			return TRUE;
		}
		return FALSE;
	}
	
	/*
	 * Get the category ID by a given category (string description)
	 * in a given language.
	 */
	function getCategoryIdFrom( $language, $category ) {
		$query = $this->db->query(
			"SELECT id"
			. " FROM a16_webapps_3.categories"
			. " WHERE language='$language' AND category='$category'"
		);
		return $query->row()->id;
	}
	
	/*
	 * Get an array with categories (both ID and name of the category)
	 * given an array with just the category IDs.
	 */
	function getCategoriesById( $array_with_category_ids ) {
		if(count($array_with_category_ids) == 0) {
			return array();
		}
		$query = $this->db->query(
			"SELECT id, category"
			. " FROM a16_webapps_3.categories"
			. " WHERE id IN (".implode(',',$array_with_category_ids).")"
		);
		return $query->result();
	}

	/* Returns all questions of the given language in the given category.
	 * Members:
	 *	- id			(unique number)
	 *	- score_weight	(int)
	 *	- category_id	(value from 0 to ...)
	 *	- question		(string)
	 * 
	 */
	function getAllQuestionsFrom( $language, $categoryID ) {
		$query = $this->db->query(
			"SELECT id, category_id, question, score_weight"
			. " FROM a16_webapps_3.questions"
			. " WHERE language='$language' AND category_id='$categoryID'"
		);
		return $query->result();
	}
	
	/**
	 * Get the question IDs of all questions of a given category (by ID), answered
	 * by a given resident (by ID) with a given session count. 
	 */
	private function getAllAnsweredQuestionsFrom( $residentID, $categoryID, $currentSession ) {
		$query = $this->db->query(
			"SELECT question_id"
			. " FROM a16_webapps_3.answers"
			. " WHERE resident_id='$residentID' AND category_id='$categoryID' AND session='$currentSession'"
		);
		return $query->result();
	}
	
	/**
	 * Get the question IDs of all questions within a given category (by ID) of a
	 * given language that still need to be answered by a resident (by ID) with a
	 * given session count.
	 */
	function getAllUnansweredQuestionsFrom( $residentID, $language, $categoryID, $currentSession ) {
		$all_questions = $this->getAllQuestionsFrom($language, $categoryID);
		$answered_questions = $this->getAllAnsweredQuestionsFrom($residentID, $categoryID, $currentSession);
		
		$stored = array();
		foreach($answered_questions as $question) {
			$stored[] = $question->question_id;
		}
		
		$unanswered_questions = array();
		foreach($all_questions as $question) {
			if(! in_array($question->id, $stored)) {
				$unanswered_questions[] = $question->id;
			}
		}
		return $this->getQuestionsByID($unanswered_questions);
	}
	
	/**
	 * Returns all options for a question with a given ID.
	 */
	function getOptionsFor( $question_id ) {
		$query = $this->db->query(
			"SELECT  options.id, options.option"
			. " FROM a16_webapps_3.options"
			. " JOIN a16_webapps_3.questions_options"
				. " on (a16_webapps_3.options.id = a16_webapps_3.questions_options.option_id)"
			. " JOIN a16_webapps_3.questions"
				. " on (a16_webapps_3.questions_options.question_id = a16_webapps_3.questions.id)"
			. " WHERE question_id='$question_id'"
		);
		return $query->result();
	}
        
        
	
	/**
	 * Get the ID, category ID, question text and score weight of the questions
	 * of which the given array contains all the IDs.
	 */
	function getQuestionsByID( $array_with_question_ids ) {
		if(count($array_with_question_ids) == 0) {
			return array();
		}
		$query = $this->db->query(
			"SELECT id, category_id, question, score_weight"
			. " FROM a16_webapps_3.questions"
			. " WHERE id IN (".implode(',',$array_with_question_ids).")"
		);
		return $query->result();
	}
        
        
}
