<?php

class Login_model extends CI_Model {

	public function __construct() {
		parent::__construct();

		require 'lib/password.php';
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
		/*
		 * I think this can be optimized. We'll need an extra type 'field' in the database though.
		 * 
		 * SELECT id, password, first_name, type
		 * FROM a16_webapps_3.residents FULL a16_webapps_3.caregivers
		 * WHERE id=$username
		 */
		$query_residents = $this->db->query( "SELECT * FROM a16_webapps_3.residents WHERE id='$username'" );
		$query_caregivers = $this->db->query( "SELECT * FROM a16_webapps_3.caregivers WHERE id='$username'" );
		//$query = $this->db->query("SELECT id FROM a16_webapps_3.person_view WHERE id='$username'");
		
		$data[ 'succeeded' ] = false;
		
		//Alternative
/*
		//No matches
		if ( $query->num_rows() == 0 ) {
			$data[ 'error' ] = 'The username you\'ve entered does not exist in the system.';
			return $data;
		}

		//Too many matches
		if ( $query->num_rows() > 1 ) {
			$data[ 'error' ] = 'Found multiple entries with this username. Contact support please.';
			return $data;
		}
		
		//Get type of person
		$person = $query->row();
		$data[ 'type' ] = $person->type;
*/
		// no matches
		if ( $query_residents->num_rows() == 0 && $query_caregivers->num_rows() == 0 ) {
			$data[ 'error' ] = 'The username you\'ve entered does not exist in the system.';
			return $data;
		}

		// too many matches?
		if ( $query_residents->num_rows() + $query_caregivers->num_rows() > 1 ) {
			$data[ 'error' ] = 'Found multiple entries with this username. Contact support please.';
			return $data;
		}

		// get type of person
		if ( $query_residents->num_rows() == 1 ) {
			$data[ 'type' ] = 'resident';
			$person = $query_residents->row();
		} else {
			$data[ 'type' ] = 'caregiver';
			$person = $query_caregivers->row();
		}

		// and as last verify password
		if ( password_verify( $password, $person->password ) ) {
			$data[ 'succeeded' ] = true;
			$data[ 'name' ] = $person->first_name;

			if ( $data[ 'type' ] == 'resident' ) {
				// TODO replace storing everything in session by using a Person class with all relevant data
				$this->session->id = $person->id;
				$this->session->completedSessions = $person->completed_sessions;
			}
		} else {
			$data[ 'error' ] = 'Incorrect password.';
		}
		return $data;
 
	}
}
