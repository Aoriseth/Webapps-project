<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'Person.php';

/**
 * A class containing all properties of a caregiver, inlcuding the functions to get/set them.
 */
class Caregiver extends Person {
	
	private $_email;
	private $_phone_number;
	
	/**
	 * Constructor, initializing this new caregiver with an given db record of this caregiver containing:
	 *		- _first_name:			the first name of this caregiver.
	 *		- _last_name:			the last name of this caregiver.
	 *		- _id:					the id of this caregiver.
	 *		- _gender:				the gender of this caregiver.
	 *		- _email:				the email address of this caregiver.
	 *		- _phone_number:			the phone number of this caregiver.
	 */
	public function __construct($caregiver_db_record = null) {
		if($caregiver_db_record != null) {
			parent::__construct(
					$caregiver_db_record->first_name,
					$caregiver_db_record->last_name,
					$caregiver_db_record->id,
					$caregiver_db_record->gender,
					$caregiver_db_record->date_of_birth,
					$caregiver_db_record->language,
					$caregiver_db_record->type,
					$caregiver_db_record->account_created_on);
			$this->setEmail($caregiver_db_record->email);
			$this->setPhoneNumber($caregiver_db_record->phone_number);
		}
	}
	
	/**
	 * ========================================================
	 *  Getters/Setters for all variables of this caregiver below.
	 * ========================================================
	 */
	
	function setEmail($email_to_set) {
		$this->_email = $email_to_set;
	}
	
	function getEmail() {
		return $this->_email;
	}
	
	function setPhoneNumber($phone_number_to_set) {
		$this->_phone_number = $phone_number_to_set;
	}
	
	function getPhoneNumber() {
		return $this->_phone_number;
	}
}
