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
		redirect( 'caregiver/home' );
	}

	function home()
	{
		$data[ 'navigation_buttons' ] = $this->load->view( 'caregiver/caregiver_navigation_buttons', '', true );

		$data[ 'name' ] = $this->session->first_name;

		$this->parser->parse( 'caregiver/caregiver_main.php', $data );
	}
	
	function groups()
	{
		$data[ 'navigation_buttons' ] = $this->load->view( 'caregiver/caregiver_navigation_buttons', '', true );
		
		$this->parser->parse( 'caregiver/caregiver_main.php', $data );
	}
	
	function statistics()
	{
		$data[ 'navigation_buttons' ] = $this->load->view( 'caregiver/caregiver_navigation_buttons', '', true );
		
		$this->parser->parse( 'caregiver/caregiver_main.php', $data );
	}
	
	function resident_overview()
	{
		$data[ 'navigation_buttons' ] = $this->load->view( 'caregiver/caregiver_navigation_buttons', '', true );
		
		$this->parser->parse( 'caregiver/caregiver_main.php', $data );
	}
	
	function resident_profile()
	{
		$data[ 'navigation_buttons' ] = $this->load->view( 'caregiver/caregiver_navigation_buttons', '', true );
		
		$this->parser->parse( 'caregiver/caregiver_main.php', $data );
	}
}
