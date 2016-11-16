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
	
	/**
	 * Constructor, initializing this person with an given:
	 *		- _first_name:			the first name of this person.
	 *		- _last_name:			the last name of this person.
	 *		- _id:					the id of this person.
	 *		- _gender:				the gender of this person.
	 */
	public function __construct($first_name_to_set, $lasst_name_to_set, $id_to_set, $gender_to_set) {
		setFirstName($first_name_to_set);
		setLastName($lasst_name_to_set);
		setId($id_to_set);
		setGender($gender_to_set);
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
}
