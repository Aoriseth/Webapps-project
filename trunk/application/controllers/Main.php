<?php

class Main extends CI_Controller {
	
	public function __construct() {
		parent::__construct();

		$this->load->helper( 'url' );
		$this->load->library( 'parser' );
		$this->load->library( 'session' );

		if ( $this->session->is_logged_in == false ) {
			redirect( base_url().'index.php/login' );
		}
	}

	public function index()
	{
		$data[ 'name' ] = $this->session->first_name;
		$this->parser->parse( 'main', $data );
	}
}
