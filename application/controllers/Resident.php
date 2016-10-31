<?php

class Resident extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
		// redirect to base if the user shouldn't be here
		if ( $this->session->type != 'resident' ) { redirect( base_url() ); }

		$this->load->library( 'parser' );
	}

	function index()
	{
		redirect( 'resident/home' );
	}

	function home()
	{
		$data[ 'feedback' ] = '';
		$data[ 'content' ] = '';

		$this->parser->parse( 'resident/resident_main.php', $data );
	}
}
