<?php

class Resident extends CI_Controller {

	public function __construct() {
		parent::__construct();

		// redirect to base if the user shouldn't be here
		if ( $this->session->type != 'resident' ) { redirect( base_url() ); }

		$this->load->library( 'parser' );
		$this->load->model( 'Question_model' );
	}

	function index()
	{
		redirect( 'resident/home' );
	}

	function home()
	{
		$data2[ 'name' ] = $this->session->first_name;
		$data[ 'content' ] = $this->parser->parse( 'resident/resident_home', $data2, true );

		$this->parser->parse( 'resident/resident_main', $data );
	}

	function gallery()
	{
		$data2[ 'name' ] = $this->session->first_name;
		$data[ 'content' ] = $this->parser->parse( 'resident/resident_gallery', $data2, true );

		$this->parser->parse( 'resident/resident_main', $data );
	}
	
	function categories()
	{
		$categories = $this->Question_model->getAllCategories( 'english' );
		
		shuffle( $categories );
		$data2[ 'categories' ] = array_splice( $categories, 0, 3 );

		$data[ 'content' ] = $this->parser->parse( 'resident/resident_categories', $data2, true );

		$this->parser->parse( 'resident/resident_main', $data );
	}

	function question()
	{
		if ( ! isset( $_GET[ 'category' ] ) ) {
			redirect( 'resident/categories' );
		}
		
		
		$category = $_GET[ 'category' ];	// $this->input->get/post does not work for some reason
		$questions = $this->Question_model->getAllQuestionsFrom( 'english', $category );

		$data2[ 'category' ] = htmlspecialchars( $category );
		$data2[ 'questions' ] = $questions;
		$data[ 'content' ] = $this->parser->parse( 'resident/resident_question', $data2, true );

		$this->parser->parse( 'resident/resident_main', $data );
	}

	function completed()
	{
		$data2[ '' ] = '';
		$data[ 'content' ] = $this->parser->parse( 'resident/resident_completed', $data2, true );

		$this->parser->parse( 'resident/resident_main', $data );
	}
}
