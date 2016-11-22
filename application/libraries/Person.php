<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * An abstract class containing all properties of a person. Inherited by specific
 * person types like residents and caregivers.
 */
abstract class Person {
	
	private $_first_name;
	private $_last_name;
	private $_id;
	private $_gender;
	private $_date_of_birth;
	private $_language;
	private $_type;
	private $_account_created_on;
	
	/**
	 * Constructor, initializing this person with an given:
	 *		- first_name_to_set:			the first name of this person.
	 *		- last_name_to_set:				the last name of this person.
	 *		- id_to_set:					the id of this person.
	 *		- gender_to_set:				the gender of this person.
	 *		- date_of_birth_to_set:			the date of birth of this person.
	 *		- language_to_set:				the language of this person.
	 *		- type_to_set:					the type of this person.
	 *		- account_created_on_to_set:	the date on which the account of this person was created.
	 */
	public function __construct($first_name_to_set, $last_name_to_set, $id_to_set, $gender_to_set, $date_of_birth_to_set,
			$language_to_set, $type_to_set, $account_created_on_to_set) {
		$this->setFirstName($first_name_to_set);
		$this->setLastName($last_name_to_set);
		$this->setId($id_to_set);
		$this->setGender($gender_to_set);
		$this->setDateOfBirth($date_of_birth_to_set);
		$this->setLanguage($language_to_set);
		$this->setType($type_to_set);
		$this->setAccountCreatedOn($account_created_on_to_set);
	}
	
	/**
	 * ========================================================
	 *  Getters/Setters for variables of this person below.
	 * ========================================================
	 */
	function setFirstName($first_name_to_set) {
		$this->_first_name = $first_name_to_set;
	}
	
	function getFirstName() {
		return $this->_first_name;
	}
	
	function setLastName($last_name_to_set) {
		$this->_last_name = $last_name_to_set;
	}
	
	function getLastName() {
		return $this->_last_name;
	}
	
	function setId($id_to_set) {
		$this->_id = $id_to_set;
	}
	
	function getId() {
		return $this->_id;
	}
	
	function setGender($gender_to_set) {
		$this->_gender = $gender_to_set;
	}
	
	function getGender() {
		return $this->_gender;
	}
	
	function setDateOfBirth($date_of_birth_to_set) {
		$this->_date_of_birth = $date_of_birth_to_set;
	}
	
	function getDateOfBirth() {
		return $this->_date_of_birth;
	}
	
	function setLanguage($language_to_set) {
		$this->_language = $language_to_set;
	}
	
	function getLanguage() {
		return $this->_language;
	}
	
	function setType($type_to_set) {
		$this->_type = $type_to_set;
	}
	
	function getType() {
		return $this->_type;
	}
	
	function setAccountCreatedOn($account_created_on_to_set) {
		$this->_account_created_on = $account_created_on_to_set;
	}
	
	function getAccountCreatedOn() {
		return $this->_account_created_on;
	}
}
