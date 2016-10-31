<?php

class Resident extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
		// redirect to base if the user shouldn't be here
		if ( $this->session->type != 'resident' ) { redirect( base_url() ); }
	}

	function index()
	{
		$this->load->view( 'resident/resident_main.php' );
	}
}
