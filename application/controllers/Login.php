<?php

class Login extends CI_Controller {
	
	public function __construct() {
		parent::__construct();

		$this->load->library( 'parser' );
		$this->load->model( 'Login_model' );
		$this->load->helper( 'url' );                
	}

	public function index() {
		if ( $this->session->is_logged_in )	{
			redirect( 'login/success' );
		} else {
			redirect( 'login/facial_recognition' );
		}
	}

	public function success() {
		if ( ! $this->session->is_logged_in )	{
			redirect( base_url() );
		}

		$data['navbar'] = $this->load->view( 'login/login_navbar', '', true );
		$data[ 'navigation_buttons' ] = $this->load->view( 'login/login_go_home_button', '', true );

		$data[ 'feedback' ] = '<div class="jumbotron">Welcome ' . $this->session->first_name . ', you\'ve logged in succesfully.';
		$data[ 'content' ] = '<p><i>This page confirms the user has succesfully logged in.</i></p>';

		$this->parser->parse( 'login/login_main', $data );
	}
	
	public function facial_recognition() {
		if ( $this->session->is_logged_in )	{
			redirect( 'login/success' );
		}

		$data[ 'navbar' ] = $this->load->view( 'login/login_navbar', '', true );
		$data[ 'navigation_buttons' ] = $this->load->view( 'login/login_navigation_buttons', '', true );

		$data[ 'feedback' ] = '';
		$data[ 'content' ] = $this->load->view( 'login/login_facial_recognition', '', true );

		$this->parser->parse( 'login/login_main', $data );		
	}

	public function manual() {
		if ( $this->session->is_logged_in )	{
			redirect( 'login/success' );
		}
		
		$data[ 'navbar' ] = $this->load->view( 'login/login_navbar', '', true );
		$data[ 'navigation_buttons' ] = $this->load->view( 'login/login_navigation_buttons', '', true );

		$data[ 'feedback' ] = '';

		$username = '';
		$password = '';

		if ( isset( $_POST[ 'username' ] ) ) {
			$username = $this->input->post( 'username' );
			$password = $this->input->post( 'password' );

			$result = $this->Login_model->login( $username, $password );

			if ( $result[ 'succeeded' ] == true ) {
				$this->session->is_logged_in = true;
				$this->session->first_name = $result[ 'name' ];
				$this->session->type = $result[ 'type' ];

				redirect( 'login/success' );
			} else {
				// TODO remove HTML code from controller
				$data[ 'feedback' ] = '<span style="color:red">'.$result[ 'error' ].'</span>';
			}
		}

		// filter output that will be displayed in html!
		$data2[ 'username' ] = htmlspecialchars( $username );
		$data2[ 'password' ] = htmlspecialchars( $password );
		// re-insert login attempt into form
		$data[ 'content' ] = $this->parser->parse( 'login/login_form', $data2, true );

		$this->parser->parse( 'login/login_main', $data );
	}
}
