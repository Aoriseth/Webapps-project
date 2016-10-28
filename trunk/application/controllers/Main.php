<?php

class Main extends CI_Controller {
	
	public function __construct() {
		parent::__construct();

		$this->load->helper( 'url' );
		$this->load->library( 'session' );

		if ( $this->session->is_logged_in == false ) {
			redirect( base_url().'index.php/login', 'location' );
		}
	}

	public function index()
	{
		$this->load->view( 'main' );
	}
}
