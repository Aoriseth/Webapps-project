<?php

class Login_model extends CI_Model {

    public function __construct() {
        parent::__construct();

        require 'lib/password.php';
        $this->load->library('Caregiver');
        $this->load->library('Resident');
    }

    /* Returns an array with
     * - succeeded = bool
     * 
     * if ( succeeded )
     * 	- type = 'resident' or 'caregiver'
     * 	- first_name = string
     * else
     * 	- error = string
     */

    function login($username, $password, $video) {
        //Get all possible persons with the given username
        $query = $this->db->query("SELECT id,type FROM a16_webapps_3.person_view WHERE id='$username'");
        $data['succeeded'] = false;

        //No matches
        if ($query->num_rows() == 0) {
            $data['error'] = 'The username you\'ve entered does not exist in the system.';
            return $data;
        }

        //Too many matches
        if ($query->num_rows() > 1) {
            $data['error'] = 'Found multiple entries with this username. Please contact support.';
            return $data;
        }

        //Get this person's data from the database
        $person = $query->row();
        $person = $this->db->query("SELECT * FROM a16_webapps_3."
                        . "$person->type"
                        . "s WHERE id='$username'")->row();

        //Verify password
        if ($video == 'false') {
            $condition = password_verify($password, $person->password);
        } if ($video == 'true') {
            //            $condition = password_verify($password, $person->password);

            $condition = password_hashed_verify($password, $person->password);
        }
        if ($condition) {
            $data['succeeded'] = true;


            if ($person->type == 'resident') {
                $data['person'] = new Resident($person);
            } else if ($person->type == 'caregiver') {
                $data['person'] = new Caregiver($person);
            }
        } else {
            $data['error'] = 'Incorrect password.';
        }
        return $data;
    }

}
