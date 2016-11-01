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
		// get 3 random categories
		$categories = $this->Question_model->getAllCategories( 'english' ); // TODO check if category already done
		shuffle( $categories );
		$categories = array_splice( $categories, 0, 3 );

		$data2[ 'categories' ] = $categories;
		$data[ 'content' ] = $this->parser->parse( 'resident/resident_categories', $data2, true );

		$this->parser->parse( 'resident/resident_main', $data );
	}

	function question()
	{
		if ( ! isset( $_GET[ 'category' ] ) ) {
			redirect( 'resident/categories' );
		}
		$category = $_GET[ 'category' ];	// TODO $this->input->get/post does not work for some reason

		if ( ! isset( $this->session->questions ) ) {
			$this->session->questions = $this->Question_model->getAllQuestionsFrom( 'english', $category );
		}

		if ( isset( $_POST[ 'option' ] ) ) {
			/*
			 * TODO: store answer
			 * form now posts the string value, use id instead?
			 */
		}

		if ( isset( $_GET[ 'index' ] ) ) {
			$index = $_GET[ 'index' ];		// TODO input filtering?
		} else {
			$index = 0;
		}

		if ( $index >= count( $this->session->questions ) ) {
			unset( $this->session->questions );
			redirect( 'resident/completed?category='.$category );
		}

		$question = $this->session->questions[ $index ];
		$options = $this->Question_model->getOptionsFor( $question->id );

		$data2[ 'category' ] = htmlspecialchars( $category );
		$data2[ 'index' ] = htmlspecialchars( $index );
		$data2[ 'category_size' ] = htmlspecialchars( count( $this->session->questions ) );
		$data2[ 'question' ] = htmlspecialchars( $question->question );
		$data2[ 'options' ] = $options;
		$data[ 'content' ] = $this->parser->parse( 'resident/resident_question', $data2, true );

		$this->parser->parse( 'resident/resident_main', $data );
	}

	function completed()
	{
		if ( isset( $_GET[ 'category' ] ) ) {
			$category = $_GET[ 'category' ];	// TODO filtering?
		} else {
			$category = '';
		}

		$data2[ 'category' ] = htmlspecialchars( $category );
		$data[ 'content' ] = $this->parser->parse( 'resident/resident_completed', $data2, true );

		$this->parser->parse( 'resident/resident_main', $data );
	}
}
