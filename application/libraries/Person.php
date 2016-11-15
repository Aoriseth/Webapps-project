<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * An abstract class containing all properties of a person. Inherited by specific
 * person types like residents and caregivers.
 */
abstract class Person {
	
	private $first_name;
	private $last_name;
	private $id;
	private $gender;
	
	/**
	 * Constructor, initializing this person with an given:
	 *		- first_name:			the first name of this person.
	 *		- last_name:			the last name of this person.
	 *		- id:					the id of this person.
	 *		- gender:				the gender of this person.
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
		$this->first_name = $first_name_to_set;
	}
	
	function getFirstName() {
		return $this->first_name;
	}
	
	function setLastName($last_name_to_set) {
		$this->last_name = $last_name_to_set;
	}
	
	function getLastName() {
		return $this->last_name;
	}
	
	function setId($id_to_set) {
		$this->id = $id_to_set;
	}
	
	function getId() {
		return $this->id;
	}
	
	function setGender($gender_to_set) {
		$this->gender = $gender_to_set;
	}
	
	function getGender() {
		return $this->gender;
	}
}
