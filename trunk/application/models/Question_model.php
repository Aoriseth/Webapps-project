<?php

class Question_model extends CI_Model {

	/* Returns all categories of the given language.
	 * Members:
	 *	- category		(string)
	 */
	function getAllCategories( $language ) {
		$query = $this->db->query(
			"SELECT DISTINCT category"
			. " FROM a16_webapps_3.questions"
			. " WHERE language='$language'"
		);
		return $query->result();
	}
	
	/* Returns all categories of the given language and within the current session
	 * that are not yet completed.
	 * Members:
	 *	- language		(string)
	 *	- session		(value from 0 to ..)
	 */
	function getAllUnfinishedCategories($language, $session) {
		//TODO
	}

	/* Returns all questions of the given language in the given category.
	 * Members:
	 *	- id			(unique number)
	 *	- category		(string)
	 *	- category_id	(value from 0 to ...)
	 *	- question		(string)
	 * 
	 */
	function getAllQuestionsFrom( $language, $category ) {
		$query = $this->db->query(
			"SELECT id, category, category_order, question"
			. " FROM a16_webapps_3.questions"
			. " WHERE language='$language' AND category='$category'"
			. " ORDER BY category_order ASC"
		);
		return $query->result();
	}
	
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
