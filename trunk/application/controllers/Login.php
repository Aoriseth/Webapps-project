<?php

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// redirect to base if the user is already logged in
		if ( $this->session->is_logged_in ) {
			redirect( base_url() );
		}

		// load appropriate language file
		if ( !isset( $this->session->language ) ) {
			// fallback on default
			$this->session->language = $this->config->item( 'language' );
		}
		$this->lang->load( 'common', $this->session->language );
		$this->lang->load( 'login', $this->session->language );

		// models
		$this->load->model( 'FaceRecKeys_model' );
		$this->load->model( 'Login_model' );
	}

	public function index()	// landing page
	{
		$data[ 'include' ] = $this->load->view( 'include', '', true );

		$data[ 'navbar' ] = $this->load->view( 'login/login_navbar', '', true );
		$data[ 'facial' ] = $this->load->view( 'login/login_facial_recognition', '', true );
		$data[ 'manual' ] = $this->load->view( 'login/login_manual', '', true );

		$this->parser->parse( 'login/login_main', $data );
	}

	public function en()
	{
		$this->session->language = 'english';
		redirect( base_url() );
	}

	public function nl()
	{
		$this->session->language = 'nederlands';
		redirect( base_url() );
	}

	public function get_facial_recognition_tokens()
	{
		// only allow AJAX requests
		if ( !$this->input->is_ajax_request() ) {
			redirect( '404' );
		}

		$result = $this->FaceRecKeys_model->getKeys();

		header( 'Content-Type: application/json' );
		echo json_encode( $result );
	}

	public function ajax()
	{
		// only allow AJAX requests
		if ( !$this->input->is_ajax_request() ) {
			redirect( '404' );
		}

		// check if POST is set correctly
		if ( !isset( $_POST[ 'username' ] ) || !isset( $_POST[ 'password' ] ) ) {
			header( 'Content-Type: application/json' );
			echo json_encode( array( 'success' => false, 'error' => 'Username or password field not set.' ) );
			return;
		}
		$username = $this->input->post( 'username' );
		$password = $this->input->post( 'password' );

		// check credentials with database
		$result = $this->Login_model->login( $username, $password );

		if ( $result[ 'succeeded' ] == true ) {
			$this->setup_login( $result[ 'person' ] );

			header( 'Content-Type: application/json' );
			echo json_encode( array( "success" => true ) );
		} else {
			header( 'Content-Type: application/json' );
			echo json_encode( array( 'success' => false, 'error' => $result[ 'error' ] ) );
		}
	}

	private function setup_login( $person )
	{
		$this->session->is_logged_in = true;
		$this->session->display_login_notification = true;

		$this->session->language = strtolower( $person->getLanguage() );
		$this->session->person = $person;

		$this->session->id = $person->getId();
		// *** TODO *** remove dependancies on this
		if ( $person->getType() == 'resident' ) {
			$this->session->completedSessions = $person->getCompletedSessions();
		}

		$this->session->first_name = $person->getFirstName();
		$this->session->type = $person->getType();
		//*** TODO ***
	}
}
