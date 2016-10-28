<?php

class Login extends CI_Controller {
	
	public function __construct() {
		parent::__construct();

		$this->load->library( 'session' );
	}

	public function index() {
		$this->session->is_logged_in = true;

		$this->load->view( 'login_screen' );
	}
}
