<?php

class Resident extends CI_Controller {

    public function __construct()
	{
        parent::__construct();

        // redirect to base if the user shouldn't be here
        if ($this->session->type != 'resident') { redirect(base_url()); }

        // load appropriate language file
        if (!isset($this->session->language)) {
            // fallback on default
            $this->session->language = $this->config->item('language');
        }
        $this->lang->load('common', $this->session->language);
        $this->lang->load('resident', $this->session->language);

        // models
        $this->load->model('Question_model');
        $this->load->model('Answer_model');
        $this->load->model('Resident_model');
        $this->load->model('Picture_model');
    }

    function index()
	{
        redirect('resident/home');
    }

    private function display_common_elements( $page )
	{
        $data['include'] = $this->load->view('include', '', true);
        $data['navbar'] = $this->parser->parse('resident/resident_navbar', array('page' => $page), true);
        return $data;
    }

    function home()
	{
        $data = $this->display_common_elements('home');
        $residentId = $this->session->id;
        $querry2 =  $this->Picture_model->getNrCompleted($residentId);
        $data2['nrCompleted'] = $querry2[0]->pieces_collected;
        $querry = $this->Picture_model->getPictureTest($residentId);
        $data2['path'] = $querry[0]->picture_dir;
        $data2['puzzle'] = $querry[0]->picture_name;
        $data2['name'] = $this->session->first_name;
        $data2['display_login_notification'] = $this->session->display_login_notification;
        $this->session->display_login_notification = false;
        $data['content'] = $this->parser->parse('resident/resident_home', $data2, true);

        $this->parser->parse('resident/resident_main', $data);
    }

    function gallery()
	{
        $data = $this->display_common_elements('gallery');

        $data2['name'] = $this->session->first_name;
        $data['content'] = $this->parser->parse('resident/resident_gallery', $data2, true);

        $this->parser->parse('resident/resident_main', $data);
    }

    function categories()
	{
        $data = $this->display_common_elements('categories');

        // get 3 random categories
        $categories = $this->Question_model->getAllUnfinishedCategories($this->session->id);
        if (count($categories) == 0) {
            //If all categories are done, increment the session number
            $this->Resident_model->incrementSession($this->session->id);
            $this->session->completedSessions = $this->session->completedSessions + 1;

            //TODO DO SOMETHING WHEN ALL CATEGORIES ARE FINISHED
            //Possible to put the $category fetch and this condition before the narbar, button,... loading to prevent unnecessary loading
            //Or move this if statement block + $category fetch to somewhere more appropriate.
        }
        shuffle($categories);
        $categories = array_splice($categories, 0, 3);

        $data2['categories'] = $categories;
        $data['content'] = $this->parser->parse('resident/resident_categories', $data2, true);

        $this->parser->parse('resident/resident_main', $data);
    }

    function question()
	{
        /* ERROR: if user goes to home during questionnaire, variables are not reset
         * 
         * TODO
         * 	- reload questions from database
         * FUTURE
         * 	- detect if session in progress
         *
         * TODO
         * confirmation screen should also show progress bar
         * 
         * Work with AJAX?
         */
        if (!isset($_GET['category'])) {
            redirect('resident/categories');
        }

        $data = $this->display_common_elements('question');

        // get category
        $category = $this->input->get('category');
        $categoryID = $this->Question_model->getCategoryIdFrom($this->session->language, $category); //TODO: use real language setting
        // grab questions from database
        if (count($this->session->questions) == 0) {
            $this->session->questions = $this->Question_model->getAllUnansweredQuestionsFrom($this->session->id, $categoryID);
        }
        $allUnansweredQuestions = $this->Question_model->getAllUnansweredQuestionsFrom($this->session->id, $categoryID);


        // get index of current question
        if (isset($_GET['index'])) {
            $index = $this->input->get('index');
        } else {
            $index = 0;
        }

        // store the chosen option (if any)
        if (isset($_POST['option'])) {
            $residentID = $this->session->id;
            if ($index > 0) {
                $questionID = $this->session->questions[$index - 1]->id;
            } else {
                $questionID = $this->session->questions[$index]->id;
            }

            $options = $this->Question_model->getOptionsFor($questionID);
            foreach ($options as $option) {
                if ($option->option == filter_input(INPUT_POST, 'option')) {
                    $chosenOption = $option->id;
                    break;
                }
            }
            $this->Answer_model->storeAnswer($residentID, $questionID, $chosenOption);
        }
        // check if category is done
		// EVERYTHING INSIDE THIS IF BLOCK IS NEVER EXECUTED!
        if ($index >= count($this->session->questions)) {
            // clear array of questions
			$this->session->questions = array();
            $this->Picture_model->incrementPiecesCollected($residentID);
            redirect('resident/completed?category=' . $category);
        }

        $question = $this->session->questions[$index];
        $options = $this->Question_model->getOptionsFor($question->id);

        $data2['category'] = htmlspecialchars($category);

        $data2['index'] = htmlspecialchars($index);
        $data2['category_size'] = htmlspecialchars(count($this->session->questions));

        $data2['question'] = htmlspecialchars($question->question);
        $data2['questionID'] = htmlspecialchars($question->id);
        $data2['allUnansweredQuestions'] = $allUnansweredQuestions;
        $data2['options'] = $options;

        $data['content'] = $this->parser->parse('resident/resident_question', $data2, true);

        $this->parser->parse('resident/resident_main', $data);
    }

    function question_store_answer()
	{
        // only allow AJAX requests
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }

        echo "first echo: " . $this->input->raw_input_stream;
        $jsonDecoded = json_decode($this->security->xss_clean($this->input->raw_input_stream));
        // check if POST is set correct (at least kind of)

        $questionId = $jsonDecoded->question_id;
        $chosenOption = $jsonDecoded->chosen_option;

        $residentId = $this->session->id;

        if ($questionId != "" && $chosenOption != "" && $residentId != "") {
            $this->Answer_model->storeAnswer($residentId, $questionId, $chosenOption);

            echo 'Answer stored succesfully.';
        } else {
            echo 'Error: questionId or chosenoption empty or cannot find residentId';
        }
    }

    function completed()
	{
        $data = $this->display_common_elements('completed');

        if (isset($_GET['category'])) {
            $category = $this->input->get('category');
        } else {
            // TODO error message? ignored for now
            $category = '';
        }

        $data2['category'] = htmlspecialchars($category);
        $data['content'] = $this->parser->parse('resident/resident_completed', $data2, true);

        $this->parser->parse('resident/resident_main', $data);
    }

}
