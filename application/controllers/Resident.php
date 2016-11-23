<?php

class Resident extends CI_Controller {

	public function __construct() {
		parent::__construct();

		// redirect to base if the user shouldn't be here
		if ( $this->session->type != 'resident' ) { redirect( base_url() ); }

		$this->load->library( 'parser' );
		$this->load->model( 'Question_model' );
		$this->load->model('Answer_model');
	}

	function index()
	{
		redirect( 'resident/home' );
	}

	function home()
	{
		$data[ 'navbar' ] = $this->load->view( 'resident/resident_navbar', '', true );
		$data2[ 'page' ] = 'home';
		$data[ 'navigation_buttons' ] = $this->parser->parse( 'resident/resident_navigation_buttons', $data2, true );

		$data2[ 'name' ] = $this->session->first_name;
		$data[ 'content' ] = $this->parser->parse( 'resident/resident_home', $data2, true );

		$this->parser->parse( 'resident/resident_main', $data );
	}

	function gallery()
	{
		$data[ 'navbar' ] = $this->load->view( 'resident/resident_navbar', '', true );
		$data2[ 'page' ] = 'gallery';
		$data[ 'navigation_buttons' ] = $this->parser->parse( 'resident/resident_navigation_buttons', $data2, true );

		$data2[ 'name' ] = $this->session->first_name;
		$data[ 'content' ] = $this->parser->parse( 'resident/resident_gallery', $data2, true );

		$this->parser->parse( 'resident/resident_main', $data );
	}

	function categories()
	{
		$data[ 'navbar' ] = $this->load->view( 'resident/resident_navbar', '', true );
		$data2[ 'page' ] = 'categories';
		$data[ 'navigation_buttons' ] = $this->parser->parse( 'resident/resident_navigation_buttons', $data2, true );

		// get 3 random categories
		$categories = $this->Question_model->getAllUnfinishedCategories($this->session->id, 'English', ($this->session->completedSessions + 1));
		if(count($categories) == 0) {
			//TODO DO SOMETHING WHEN ALL CATEGORIES ARE FINISHED
			//Possible to put the $category fetch and this condition before the narbar, button,... loading to prevent unnecessary loading
		}
		shuffle( $categories );
		$categories = array_splice( $categories, 0, 3 );
                
		$data2[ 'categories' ] = $categories;
		$data[ 'content' ] = $this->parser->parse( 'resident/resident_categories', $data2, true );

		$this->parser->parse( 'resident/resident_main', $data );
	}

	function question()
	{
		/* ERROR: if user goes to home during questionnaire, variables are not reset
		 * 
		 * TODO
		 *	- reload questions from database
		 * FUTURE
		 *	- detect if session in progress
		 */
		/*
		 * TODO
		 * progress bar is confusion: we start at 1?
		 * confirmation screen should also show load bar
		 * 
		 * Work with AJAX?
		 */
		if ( ! isset( $_GET[ 'category' ] ) ) {
			redirect( 'resident/categories' );
		}

		$data[ 'navbar' ] = $this->load->view( 'resident/resident_navbar', '', true );
		$data2[ 'page' ] = 'question';
		$data[ 'navigation_buttons' ] = $this->parser->parse( 'resident/resident_navigation_buttons', $data2, true );

		// get category
		$category = $this->input->get( 'category' );
		$categoryID = $this->Question_model->getCategoryIdFrom('English', $category); //TODO: use real language setting
		
		// grab questions from database
		if ( count( $this->session->questions ) == 0 ) {
			$this->session->questions = $this->Question_model->getAllUnansweredQuestionsFrom($this->session->id, 'English', $categoryID, ($this->session->completedSessions + 1));
		}

		// get index of current question
		if ( isset( $_GET[ 'index' ] ) ) {
			$index = $this->input->get( 'index' );
		} else {
			$index = 0;
		}

		// store the chosen option (if any)
		if (isset($_POST['option'])) {
			$residentID = $this->session->id;
			$currentSession = ($this->session->completedSessions + 1); //TODO: use real values.
			if($index > 0) {
				$questionID = $this->session->questions[$index-1]->id;
			}
			else {
				$questionID = $this->session->questions[$index]->id;
			}

			$options = $this->Question_model->getOptionsFor($questionID);
			foreach($options as $option) {
				if($option->option == filter_input(INPUT_POST, 'option')) {
					$chosenOption = $option->id;
					break;
				}
			}
			$this->Answer_model->storeAnswer($residentID, $questionID, $chosenOption, $categoryID, $currentSession);
		}

		// check if category is done
		if ( $index >= count( $this->session->questions ) ) {
			// clear array of questions
			$this->session->questions = array();
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
		$data['navbar'] = $this->load->view( 'resident/resident_navbar', '', true );
		$data2[ 'page' ] = 'completed';
		$data[ 'navigation_buttons' ] = $this->parser->parse( 'resident/resident_navigation_buttons', $data2, true );
                
		if ( isset( $_GET[ 'category' ] ) ) {
			$category = $this->input->get( 'category' );
		} else {
			// TODO error message? ignored for now
			$category = '';
		}

		$data2[ 'category' ] = htmlspecialchars( $category );
		$data[ 'content' ] = $this->parser->parse( 'resident/resident_completed', $data2, true );

		$this->parser->parse( 'resident/resident_main', $data );
	}
}
