<?php

class Login_model extends CI_Model {

	public function __construct() {
		parent::__construct();

		require 'lib/password.php';
		$this->load->library('Resident');
	}
	
	/* Returns an array with
	 * - succeeded = bool
	 * 
	 * if ( succeeded )
	 *	- type = 'resident' or 'caregiver'
	 *	- first_name = string
	 * else
	 *	- error = string
	 */
	function login( $username, $password ) {
		//Get all possible persons with the given username
		$query = $this->db->query("SELECT id,type FROM a16_webapps_3.person_view WHERE id='$username'");
		$data[ 'succeeded' ] = false;
		
		//No matches
		if ( $query->num_rows() == 0 ) {
			$data[ 'error' ] = 'The username you\'ve entered does not exist in the system.';
			return $data;
		}

		//Too many matches
		if ( $query->num_rows() > 1 ) {
			$data[ 'error' ] = 'Found multiple entries with this username. Please contact support.';
			return $data;
		}
		
		//Get this person's data from the database
		$person = $query->row();
		$data[ 'type' ] = $person->type;
		$person = $this->db->query("SELECT * FROM a16_webapps_3."
				. "$person->type"
				. "s WHERE id='$username'")->row();
		
		//Verify password
		if ( password_verify( $password, $person->password ) ) {
			$data[ 'succeeded' ] = true;
			$data[ 'name' ] = $person->first_name;

			if ( $data[ 'type' ] == 'resident' ) {
				$this->session->id = $person->id;
				$this->session->completedSessions = $person->completed_sessions;
				$this->session->language = strtolower( $person->language );
			}
		} else {
			$data[ 'error' ] = 'Incorrect password.';
		}
		return $data;
	}
}
