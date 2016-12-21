<?php

class Caregiver_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		
		$this->load->helper('date');
        date_default_timezone_set('Europe/Brussels');
	}
	
	/**
	 * Update the last activity field with the current time and date
	 * for a given caregiver (by ID).
	 */
	function updateLastActivity($caregiverID) {
		$this->db->where('id', $caregiverID);
		$this->db->set('last_activity', date('Y-m-d H:i:s'));
		$this->db->update('a16_webapps_3.caregivers');
	}
	
}