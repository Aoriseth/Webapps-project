<?php

class Caregiver extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// redirect to base if the user shouldn't be here
		if ( $this->session->type != 'caregiver' ) { redirect( base_url() ); }
		
		$this->load->library( 'parser' );
		$this->load->model( 'Question_model' );
                $this->load->model( 'Statistics_model' );
                $this->load->model( 'Resident_model' );
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
		$data2[ 'display_login_notification' ] = $this->session->display_login_notification;
		$this->session->display_login_notification = false;
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
	
	function statistics() {
		$categories = $this->Question_model->getAllCategories( 'English' );
                $residents = $this->Question_model->getResidents();
		$data2[ 'page' ] = 'statistics';
		$data[ 'navbar' ] = $this->parser->parse( 'caregiver/caregiver_navbar', $data2, true );
		$data[ 'navigation_buttons' ] = $this->parser->parse( 'caregiver/caregiver_navigation_buttons', $data2, true );
		$data2[ 'categories'] = $categories;
                $data2[ 'residents'] = $residents;
		$data[ 'content' ] = $this->load->view( 'caregiver/caregiver_statistics', $data2, true );
                

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
