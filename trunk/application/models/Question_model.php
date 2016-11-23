<?php

class Question_model extends CI_Model {

	/* Returns all categories of the given language.
	 * Members:
	 *	- category		(string)
	 */
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
		echo $nb_of_q;
		echo '/';
		echo $q_count;
		echo ' & ';
		if($q_count == $nb_of_q) {
			return TRUE;
		}
		return FALSE;
	}
	
	function getCategoryIdFrom( $language, $category ) {
		$query = $this->db->query(
			"SELECT id"
			. " FROM a16_webapps_3.categories"
			. " WHERE language='$language' AND category='$category'"
		);
		return $query->row()->id;
	}
	
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
	
	private function getAllAnsweredQuestionsFrom( $residentID, $categoryID, $currentSession ) {
		$query = $this->db->query(
			"SELECT question_id"
			. " FROM a16_webapps_3.answers"
			. " WHERE resident_id='$residentID' AND category_id='$categoryID' AND session='$currentSession'"
		);
		return $query->result();
	}
	
	function getAllUnansweredQuestionsFrom( $residentID, $language, $categoryID, $currentSession ) {
		echo $categoryID;
		echo '<- id --- ';
		$all_questions = $this->getAllQuestionsFrom($language, $categoryID);
		$answered_questions = $this->getAllAnsweredQuestionsFrom($residentID, $categoryID, $currentSession);
		$unanswered_questions = array();
		
		foreach($all_questions as $question) {
			echo $question->id;
			echo ' ';
		}
		echo ' --- ';
		
		foreach($answered_questions as $question) {
			echo $question->question_id;
			echo ' ';
		}
		
		$stored = array();
		foreach($answered_questions as $question) {
			$stored[] = $question->question_id;
		}
		foreach($all_questions as $question) {
			if(! in_array($question->id, $stored)) {
				$unanswered_questions[] = $question->id;
			}
		}
		
		echo ' === ';
		foreach($unanswered_questions as $question) {
			echo $question;
			echo ' ';
		}
		
		
		return $this->getQuestionsByID($unanswered_questions);
	}
	
	/**
	 * Returns all options for a question with a given id.
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
