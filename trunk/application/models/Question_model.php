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
	 *	- category		(string)
	 */
	function getAllUnfinishedCategories( $residentID, $language, $currentSession ) {
		

		//TODO

		$query = $this->db->query(
			"SELECT id, category"
			. " FROM a16_webapps_3.categories"
			. " WHERE language='$language'"
		);
		return $query->result();
	}

	/* Returns all questions of the given language in the given category.
	 * Members:
	 *	- id			(unique number)
	 *	- category		(string)
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
	
	function getAllUnansweredQuestionsFrom( $residentID, $language, $categoryID, $currentSession ) {
		$all_questions = array_column('id', $this->getAllQuestionsFrom($language, $categoryID));
		$answered_questions = array_column('id', $this->getAllAnsweredQuestionsFrom($residentID, $categoryID, $currentSession));
		$unanswered_questions = array();
		foreach($all_questions as $question) {
			if(! in_array($question, $answered_questions)) {
				$unanswered_questions[] = $question;
			}
		}
		return $unanswered_questions->result();
	}
	
	//TODO: database!!!
	private function getAllAnsweredQuestionsFrom( $residentID, $categoryID, $currentSession ) {
		$query = $this->db->query(
			"SELECT id"
			. " FROM a16_webapps_3.answers"
			. " WHERE resident_id='$residentID' AND category_id='$categoryID' AND session='$currentSession'"
		);
		return $query->result();
	}
	
	function getCategoryIdFrom( $language, $category ) {
		$query = $this->db->query(
			"SELECT id"
			. " FROM a16_webapps_3.categories"
			. " WHERE language='$language' AND category='$category'"
		);
		return $query->row()->id;
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
}
