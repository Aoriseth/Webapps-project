<?php

class Login extends CI_Controller {
	
	public function __construct() {
		parent::__construct();

		require 'lib/password.php';

		$this->load->library( 'parser' );
		$this->load->model( 'Login_model' );
	}

	public function index() {
		$this->parser->parse( 'login_screen_default' );
	}

	public function manual() {
		$data[ 'feedback' ] = "";
		$data[ 'username' ] = "";
		$data[ 'password' ] = "";

		if ( isset( $_POST[ 'username' ] ) ) {
			/*
			 * TODO
			 * filtering does not seem to work...
			 */
			// get input from POST
			$data[ 'username' ] = $this->input->post( 'username' );
			$data[ 'password' ] = $this->input->post( 'password' );

			// get stored password for this username
			$result = $this->Login_model->get_password_all( $data[ 'username' ] );

			// check if there are any matches
			if ( count( $result ) > 0 ) {
//				$list = $result;

				// iterate through matches to check password
				foreach( $result as $row ) {
                    if( password_verify( $data[ 'password' ], $row->password ) ) {
						$this->session->first_name = $row->first_name;
						$this->session->is_logged_in = true;

						/*
						 * TODO
						 * find out which type of user we are facing
						 * redirect to specific location
						 */

						redirect( base_url() );
						break;
                    } else {
                        $data[ 'feedback' ] = 'Incorrect password.';
                    }
				}
			} else {
				// no matches
				$data[ 'feedback' ] = 'The username you\'ve entered does not exist.';
			}
			
		}

		$this->parser->parse( 'login_screen_manual', $data );
	}
}
