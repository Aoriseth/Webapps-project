<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * A class containing all properties of a resident, inlcuding the functions to get/set them.
 */
class Resident extends Person {
	
	private $date_of_birth;
	private $language;
	private $floor_number;
	private $room_number;
	private $last_domicile;
	private $last_activity;
	private $last_completed;
	private $completed_sessions;
	private $session_in_progress;
	private $account_created_by;
	private $account_created_on;
	
	/**
	 * Constructor, initializing this new resident with an given db record of this resident containing:
	 *		- first_name:			the first name of this resident.
	 *		- last_name:			the last name of this resident.
	 *		- id:					the id of this resident.
	 *		- gender:				the gender of this resident.
	 *		- date_of_birth:		the date of birth of this resident.
	 *		- language:				the language the pages should be displayed in.
	 *		- floor_number:			the floor of this resident.
	 *		- room_number:			the room number of this resident.
	 *		- last_domicile:		the city this resident lived in before moving to a residence.
	 *		- last_activity:		the moment this resident was last active.
	 *		- last_completed:		the most recent moment this resident fully completed the questionnaire.
	 *		- completed_sessions:	the number of session this resident has completed.
	 *		- session_in_progress:	the number of the session that is in progress.
	 *		- account_created_by:	the resident that created the account of this resident.
	 *		- account_created_on:	the moment the account of this resident was created on.
	 */
	public function __construct($resident_db_record) {
		parent::__construct(
				$resident_db_record->first_name,
				$resident_db_record->lasst_name,
				$resident_db_record->id,
				$resident_db_record->gender);
		setDateOfBirth($resident_db_record->date_of_birth);
		setLanguage($resident_db_record->language);
		setFloorNumber($resident_db_record->floor_number);
		setRoomNumber($resident_db_record->room_number);
		setLastDomicile($resident_db_record->last_domicile);
		setLastActivity($resident_db_record->last_activity);
		setLastCompleted($resident_db_record->last_completed);
		setCompletedSessions($resident_db_record->completed_sessions);
		setSessionInProgress($resident_db_record->session_in_progress);
		setAccountCreatedBy($resident_db_record->account_created_by);
		setAccountCreatedOn($resident_db_record->account_created_on);
	}
	
	/**
	 * ========================================================
	 *  Getters/Setters for all variables of this resident below.
	 * ========================================================
	 */
	
	function setDateOfBirth($date_of_birth_to_set) {
		$this->date_of_birth = $date_of_birth_to_set;
	}
	
	function getDateOfBirth() {
		return $this->date_of_birth;
	}
	
	function setLanguage($language_to_set) {
		$this->language = $language_to_set;
	}
	
	function getLanguage() {
		return $this->language;
	}
	
	function setFloorNumber($floor_number_to_set) {
		$this->floor_number;
	}
	
	function getFloorNumber() {
		return $this->floor_number;
	}
	
	function setRoomNumber($room_number_to_set) {
		$this->room_number = $room_number_to_set;
	}
	
	function getRoomNumber() {
		return $this->room_number;
	}
	
	function setLastDomicile($last_domicile_to_set) {
		$this->last_domicile = $last_domicile_to_set;
	}
	
	function getLastDomicile() {
		return $this->last_domicile;
	}
	
	function setLastActivity($last_activity_to_set) {
		$this->last_activity = $last_activity_to_set;
	}
	
	function getLastActivity(){
		return $this->last_activity;
	}
	
	function setLastCompleted($last_completed_to_set) {
		$this->last_completed = $last_completed_to_set;
	}
	
	function getLastCompleted() {
		return $this->last_completed;
	}

	function setCompletedSessions($completed_sessions_to_set) {
		$this->completed_sessions = $completed_sessions_to_set;
	}
	
	function getCompletedSessions() {
		return $this->completed_sessions;
	}
	
	function setSessionInProgress($session_in_progress_to_set) {
		$this->session_in_progress = $session_in_progress_to_set;
	}
	
	function getSessionInProgress() {
		return $this->session_in_progress;
	}
	
	function setAccountCreatedBy($account_created_by_to_set) {
		$this->account_created_by = $account_created_by_to_set;
	}
	
	function getAccountCreatedBy() {
		return $this->account_created_by;
	}
	
	function setAccountCreatedOn($account_created_on_to_set) {
		$this->account_created_on = $account_created_on_to_set;
	}
	
	function getAccountCreatedOn() {
		return $this->account_created_on;
	}
}
