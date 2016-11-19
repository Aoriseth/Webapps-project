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
		$data2[ 'page' ] = 'home';
		$data[ 'navbar' ] = $this->parser->parse( 'caregiver/caregiver_navbar', $data2, true );
		$data[ 'navigation_buttons' ] = $this->parser->parse( 'caregiver/caregiver_navigation_buttons', $data2, true );

		$data2[ 'name' ] = $this->session->first_name;
		$data[ 'content' ] = $this->parser->parse( 'caregiver/caregiver_home', $data2, true );

		$this->parser->parse( 'caregiver/caregiver_main.php', $data );
	}
        
	function groups()
	{
		$data2[ 'page' ] = 'groups';
		$data[ 'navbar' ] = $this->parser->parse( 'caregiver/caregiver_navbar', $data2, true );
		$data[ 'navigation_buttons' ] = $this->parser->parse( 'caregiver/caregiver_navigation_buttons', $data2, true );

		$data[ 'content' ] = $this->load->view( 'caregiver/caregiver_groups', '', true );
		
		$this->parser->parse( 'caregiver/caregiver_main.php', $data );
	}
	
	function statistics()
	{
		$data2[ 'page' ] = 'statistics';
		$data[ 'navbar' ] = $this->parser->parse( 'caregiver/caregiver_navbar', $data2, true );
		$data[ 'navigation_buttons' ] = $this->parser->parse( 'caregiver/caregiver_navigation_buttons', $data2, true );
		
		$data[ 'content' ] = $this->load->view( 'caregiver/caregiver_statistics', '', true );

		$this->parser->parse( 'caregiver/caregiver_main.php', $data );
	}
	
	function overview()
	{
		$data2[ 'page' ] = 'overview';
		$data[ 'navbar' ] = $this->parser->parse( 'caregiver/caregiver_navbar', $data2, true );
		$data[ 'navigation_buttons' ] = $this->parser->parse( 'caregiver/caregiver_navigation_buttons', $data2, true );

		$data[ 'content' ] = $this->load->view( 'caregiver/caregiver_overview', '', true );
		
		$this->parser->parse( 'caregiver/caregiver_main.php', $data );
	}
	
	function resident()
	{
		$data2[ 'page' ] = 'resident';
		$data[ 'navbar' ] = $this->parser->parse( 'caregiver/caregiver_navbar', $data2, true );
		$data[ 'navigation_buttons' ] = $this->parser->parse( 'caregiver/caregiver_navigation_buttons', $data2, true );

		$data[ 'content' ] = $this->load->view( 'caregiver/caregiver_resident', '', true );
		
		$this->parser->parse( 'caregiver/caregiver_main.php', $data );
	}
}
