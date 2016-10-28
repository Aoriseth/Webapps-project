<?php

class Login extends CI_Controller {
	
	public function __construct() {
		parent::__construct();

		$this->load->library( 'parser' );
		$this->load->library( 'session' );
	}

	public function index() {
		/*
		 * TODO
		 * filtering does not seem to work...
		 */
		$data[ 'username' ] = $this->input->post( 'username' );
		$data[ 'password' ] = $this->input->post( 'password' );

		// add code to check usernamen / password...
		$this->session->is_logged_in = true;
 
		$this->parser->parse( 'login_screen', $data );
	}
}
