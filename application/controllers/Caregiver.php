<?php

class Caregiver extends CI_Controller {

	public function __construct() {
		parent::__construct();

		// redirect to base if the user shouldn't be here
		if ( $this->session->type != 'caregiver' ) { redirect( base_url() ); }
		
		$this->load->library( 'parser' );
	}

	function index()
	{
		$data[ 'name' ] = $this->session->first_name;

		$this->parser->parse( 'caregiver/caregiver_main.php', $data );
	}
}
