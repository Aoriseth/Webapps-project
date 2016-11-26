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

		$data[ 'feedback' ] = '';
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

				redirect( base_url() );
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
