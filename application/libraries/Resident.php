<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'Person.php';

/**
 * A class containing all properties of a resident, inlcuding the functions to get/set them.
 */
class Resident extends Person {
	
	private $_floor_number;
	private $_room_number;
	private $_last_domicile;
	private $_last_activity;
	private $_last_completed;
	private $_completed_sessions;
	private $_session_in_progress;
	private $_account_created_by;
	
	/**
	 * Constructor, initializing this new resident with an given db record of this resident containing:
	 *		- _first_name:			the first name of this resident.
	 *		- _last_name:			the last name of this resident.
	 *		- _id:					the id of this resident.
	 *		- _gender:				the gender of this resident.
	 *		- _date_of_birth:		the date of birth of this resident.
	 *		- _language:			the language the pages should be displayed in.
	 *		- _floor_number:		the floor of this resident.
	 *		- _room_number:			the room number of this resident.
	 *		- _last_domicile:		the city this resident lived in before moving to a residence.
	 *		- _last_activity:		the moment this resident was last active.
	 *		- _last_completed:		the most recent moment this resident fully completed the questionnaire.
	 *		- _completed_sessions:	the number of session this resident has completed.
	 *		- _session_in_progress:	the number of the session that is in progress.
	 *		- _type:				the type of this resident.
	 *		- _account_created_by:	the resident that created the account of this resident.
	 *		- _account_created_on:	the moment the account of this resident was created on.
	 */
	public function __construct($resident_db_record = null) {
		if($resident_db_record != null) {
			parent::__construct(
					$resident_db_record->first_name,
					$resident_db_record->last_name,
					$resident_db_record->id,
					$resident_db_record->gender,
					$resident_db_record->date_of_birth,
					$resident_db_record->language,
					$resident_db_record->type,
					$resident_db_record->account_created_on);
			$this->setFloorNumber($resident_db_record->floor_number);
			$this->setRoomNumber($resident_db_record->room_number);
			$this->setLastDomicile($resident_db_record->last_domicile);
			$this->setLastActivity($resident_db_record->last_activity);
			$this->setLastCompleted($resident_db_record->last_completed);
			$this->setCompletedSessions($resident_db_record->completed_sessions);
			$this->setSessionInProgress($resident_db_record->session_in_progress);
			$this->setAccountCreatedBy($resident_db_record->account_created_by);
		}
	}
	
	/**
	 * ========================================================
	 *  Getters/Setters for all variables of this resident below.
	 * ========================================================
	 */
	
	function setFloorNumber($floor_number_to_set) {
		$this->_floor_number;
	}
	
	function getFloorNumber() {
		return $this->_floor_number;
	}
	
	function setRoomNumber($room_number_to_set) {
		$this->_room_number = $room_number_to_set;
	}
	
	function getRoomNumber() {
		return $this->_room_number;
	}
	
	function setLastDomicile($last_domicile_to_set) {
		$this->_last_domicile = $last_domicile_to_set;
	}
	
	function getLastDomicile() {
		return $this->_last_domicile;
	}
	
	function setLastActivity($last_activity_to_set) {
		$this->_last_activity = $last_activity_to_set;
	}
	
	function getLastActivity(){
		return $this->_last_activity;
	}
	
	function setLastCompleted($last_completed_to_set) {
		$this->_last_completed = $last_completed_to_set;
	}
	
	function getLastCompleted() {
		return $this->_last_completed;
	}

	function setCompletedSessions($completed_sessions_to_set) {
		$this->_completed_sessions = $completed_sessions_to_set;
	}
	
	function getCompletedSessions() {
		return $this->_completed_sessions;
	}
	
	function setSessionInProgress($session_in_progress_to_set) {
		$this->_session_in_progress = $session_in_progress_to_set;
	}
	
	function getSessionInProgress() {
		return $this->_session_in_progress;
	}
	
	function setAccountCreatedBy($account_created_by_to_set) {
		$this->_account_created_by = $account_created_by_to_set;
	}
	
	function getAccountCreatedBy() {
		return $this->_account_created_by;
	}
}
