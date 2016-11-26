<?php

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// redirect to base if the user is already logged in
		if ( $this->session->is_logged_in ) { redirect( base_url() ); }

		$this->load->library( 'parser' );
		$this->load->model( 'Login_model' );
		$this->load->model( 'FaceRecKeys_model' );
		$this->load->helper( 'url' );
	}

	public function index()
	{
		redirect( 'login/facial_recognition' );
	}

	public function facial_recognition()
	{
		$data2[ 'page' ] = 'facial_recognition';
		$data[ 'navigation_buttons' ] = $this->parser->parse( 'login/login_navigation_buttons', $data2, true );
		$data[ 'navbar' ] = $this->load->view( 'login/login_navbar', '', true );

		$data[ 'content' ] = $this->load->view( 'login/login_facial_recognition', '', true );

		$this->parser->parse( 'login/login_main', $data );
	}

	public function get_facial_recognition_tokens()
	{
		// only allow AJAX requests
		if ( ! $this->input->is_ajax_request() ) {
			redirect('404');
		}

		$result = $this->FaceRecKeys_model->getKeys();

	    header( 'Content-Type: application/json' );
		echo json_encode( $result );
	}

	public function manual()
	{
		$data2[ 'page' ] = 'manual';
		$data[ 'navigation_buttons' ] = $this->parser->parse( 'login/login_navigation_buttons', $data2, true );
		$data[ 'navbar' ] = $this->load->view( 'login/login_navbar', '', true );

		$data[ 'content' ] = $this->load->view( 'login/login_manual', '', true );

		$this->parser->parse( 'login/login_main', $data );
	}

	public function ajax()
	{
		// only allow AJAX requests
		if ( ! $this->input->is_ajax_request() ) {
			redirect('404');
		}

		// check if POST is set correct (at least kind of)
		if ( ! isset( $_POST[ 'username' ] ) || ! isset( $_POST[ 'password' ] ) ) {
		    header( 'Content-Type: application/json' );
			echo json_encode( array( 'success' => false, 'error' => 'Username or password field not set.' ) );
			return;
		}

		$username = $this->input->post( 'username' );
		$password = $this->input->post( 'password' );

		$result = $this->Login_model->login( $username, $password );

		if ( $result[ 'succeeded' ] == true ) {
			$this->setup_login( $result[ 'name' ], $result[ 'type' ] );

		    header( 'Content-Type: application/json' );
			echo json_encode( array( "success" => true ) );
		} else {
		    header( 'Content-Type: application/json' );
			echo json_encode( array( 'success' => false, 'error' => $result[ 'error' ] ) );
		}
	}
	
	private function setup_login( $name, $type )
	{
		$this->session->is_logged_in = true;
		$this->session->display_login_notification = true;
		/*
		 * TODO replace by Person class
		 */
		$this->session->first_name = $name;
		$this->session->type = $type;
	}
}
