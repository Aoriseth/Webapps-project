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
		$data[ 'navigation_buttons' ] = $this->load->view( 'resident/resident_navigation_buttons', '', true );

		$data2[ 'name' ] = $this->session->first_name;
		$data[ 'content' ] = $this->parser->parse( 'resident/resident_home', $data2, true );

		$this->parser->parse( 'resident/resident_main', $data );
	}

	function gallery()
	{
		$data[ 'navbar' ] = $this->load->view( 'resident/resident_navbar', '', true );
		$data[ 'navigation_buttons' ] = $this->load->view( 'resident/resident_navigation_buttons', '', true );

		$data2[ 'name' ] = $this->session->first_name;
		$data[ 'content' ] = $this->parser->parse( 'resident/resident_gallery', $data2, true );

		$this->parser->parse( 'resident/resident_main', $data );
	}

	function categories()
	{
		$data[ 'navbar' ] = $this->load->view( 'resident/resident_navbar', '', true );
		$data[ 'navigation_buttons' ] = $this->load->view( 'resident/resident_navigation_buttons', '', true );

		// get 3 random categories
		// TODO check if category is already done
		$categories = $this->Question_model->getAllCategories( 'english' );
		shuffle( $categories );
		$categories = array_splice( $categories, 0, 3 );

		$data2[ 'categories' ] = $categories;
		$data[ 'content' ] = $this->parser->parse( 'resident/resident_categories', $data2, true );

		$this->parser->parse( 'resident/resident_main', $data );
        }

	function question()
	{
		$data[ 'navbar' ] = $this->load->view( 'resident/resident_navbar', '', true );
		$data[ 'navigation_buttons' ] = $this->load->view( 'resident/resident_navigation_buttons', '', true );

		// detect the category
		if ( ! isset( $_GET[ 'category' ] ) ) {
			redirect( 'resident/categories' );
		}
		$category = $this->input->get( 'category' );

		// grab the questions from database, if not aready loaded into session
		if ( ! isset( $this->session->questions ) ) {
			$this->session->questions = $this->Question_model->getAllQuestionsFrom( 'english', $category );
		}

		if ( isset( $_GET[ 'index' ] ) ) {
			$index = $this->input->get( 'index' );
		} else {
			$index = 0;
		}
                
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
                        $this->Answer_model->storeAnswer($residentID, $questionID, $chosenOption, $currentSession);
		}

		// check if caterogy is done
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
		$data['navbar'] = $this->load->view( 'resident/resident_navbar', '', true );
		$data[ 'navigation_buttons' ] = $this->load->view( 'resident/resident_navigation_buttons', '', true );

		if ( isset( $_GET[ 'category' ] ) ) {
			$category = $this->input->get( 'category' );
		} else {
			// TODO error message?
			$category = '';
		}

		$data2[ 'category' ] = htmlspecialchars( $category );
		$data[ 'content' ] = $this->parser->parse( 'resident/resident_completed', $data2, true );

		$this->parser->parse( 'resident/resident_main', $data );
	}
}
