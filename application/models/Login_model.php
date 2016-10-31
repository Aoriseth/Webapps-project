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
		$query_eldery = $this->db->query( "SELECT * FROM `a16_webapps_3`.`elderly` WHERE id='$username'" );
		$query_caregivers = $this->db->query( "SELECT * FROM `a16_webapps_3`.`caregivers` WHERE id='$username'" );

		$data[ 'succeeded' ] = false;

		// no matches
		if ( $query_eldery->num_rows() == 0 && $query_caregivers->num_rows() == 0 ) {
			$data[ 'error' ] = 'The username you\'ve entered does not exist in the system.';
			return $data;
		}

		// too many matches?
		if ( $query_eldery->num_rows() + $query_caregivers->num_rows() > 1 ) {
			$data[ 'error' ] = 'Found multiple entries with this username. Contact support please.';
			return $data;
		}

		// get type of person
		if ( $query_eldery->num_rows() == 1 ) {
			$data[ 'type' ] = 'resident';
			$person = $query_eldery->row();
		} else {
			$data[ 'type' ] = 'caregiver';
			$person = $query_caregivers->row();
		}

		// and as last verify password
		if ( password_verify( $password, $person->password ) ) {
			$data[ 'succeeded' ] = true;
			$data[ 'name' ] = $person->first_name;
		} else {
			$data[ 'error' ] = 'Incorrect password.';
		}
		return $data;
	}
}
