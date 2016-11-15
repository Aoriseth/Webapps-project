<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * A class containing all properties of a caregiver, inlcuding the functions to get/set them.
 */
class Caregiver extends Person {
	
	private $email;
	private $phone_number;
	
	/**
	 * Constructor, initializing this new caregiver with an given db record of this caregiver containing:
	 *		- first_name:			the first name of this caregiver.
	 *		- last_name:			the last name of this caregiver.
	 *		- id:					the id of this caregiver.
	 *		- gender:				the gender of this caregiver.
	 *		- email:				the email address of this caregiver.
	 *		- phone_number:			the phone number of this caregiver.
	 */
	public function __construct($caregiver_db_record) {
		parent::__construct(
				$caregiver_db_record->first_name,
				$caregiver_db_record->lasst_name,
				$caregiver_db_record->id,
				$caregiver_db_record->gender);
		setEmail($caregiver_db_record->email);
		setPhoneNumber($caregiver_db_record->phone_number);
	}
	
	/**
	 * ========================================================
	 *  Getters/Setters for all variables of this caregiver below.
	 * ========================================================
	 */
	
	function setEmail($email_to_set) {
		$this->email = $email_to_set;
	}
	
	function getEmail() {
		return $this->email;
	}
	
	function setPhoneNumber($phone_number_to_set) {
		$this->phone_number = $phone_number_to_set;
	}
	
	function getPhoneNumber() {
		return $this->phone_number;
	}
}
