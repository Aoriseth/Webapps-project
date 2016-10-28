<?php

class Login_model extends CI_Model {

	function get_password_all( $username ) {
		$query_eldery = $this->db->query( "SELECT * FROM `a16_webapps_3`.`elderly` WHERE id='$username'" );
		$query_caregivers= $this->db->query( "SELECT * FROM `a16_webapps_3`.`caregivers` WHERE id='$username'" );
		return array_merge( $query_eldery->result(), $query_caregivers->result() );
	}
}
