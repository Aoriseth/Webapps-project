<?php

class Resident extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // redirect to base if the user shouldn't be here
        if ($this->session->type != 'resident') {
            redirect(base_url());
        }

        // load appropriate language file
        if (!isset($this->session->language)) {
            // fallback on default
            $this->session->language = $this->config->item('language');
        }
        $this->lang->load('common', $this->session->language);
        $this->lang->load('resident', $this->session->language);

        // models
        $this->load->model('Answer_model');
        $this->load->model('Picture_model');
        $this->load->model('Question_model');
        $this->load->model('Resident_model');
        $this->load->model('Tip_model');
        $this->load->model('Score_model');
    }

    function index() {
        redirect('resident/home');
    }

    private function display_common_elements($page) {
        $data['include'] = $this->load->view('include', '', true);
        $data['navbar'] = $this->parser->parse('resident/resident_navbar', array('page' => $page), true);
        return $data;
    }

    function home() {
        $data = $this->display_common_elements('home');

        $residentId = $this->session->id;

        $query2 = $this->Picture_model->getPictureTest($residentId);
        $data2['path'] = $query2[0]->picture_dir;
        $data2['puzzle'] = $query2[0]->picture_name;

        $data2['categories'] = $this->Question_model->getFinishedCategorySets($residentId);
        $data2['name'] = $this->session->first_name;

        $data2['display_login_notification'] = $this->session->display_login_notification;
        $this->session->display_login_notification = false;

        $data['content'] = $this->parser->parse('resident/resident_home', $data2, true);

        $this->parser->parse('resident/resident_main', $data);
    }

    function gallery() {
        $data = $this->display_common_elements('gallery');

        $data['content'] = $this->load->view('resident/resident_gallery', '', true);

        $residentId = $this->session->id;
        $query = $this->Picture_model->getFinishedPicture($residentId);
        $data2['path'] = $query[0]->picture_dir;
        $data2['puzzle'] = $query[0]->picture_name;

        $data['content'] = $this->parser->parse('resident/resident_gallery', $data2, true);

        $this->parser->parse('resident/resident_main', $data);
    }

    function categories() {
        $data = $this->display_common_elements('categories');

        // get 3 random categories
        $categories = $this->Question_model->getAllUnfinishedCategories($this->session->id, 3);

        if (count($categories) == 0) {
            $this->Score_model->addSessionScore($this->session->id);
            $this->Resident_model->incrementSession($this->session->id);
            $this->session->completedSessions = $this->Resident_model->getSessionsCompleted($this->session->id);
            $this->Picture_model->updateAndChangePuzzle($this->session->id);
            header("Refresh:0");

            // TODO: something when all categories are finished
            /*
             * Possible to put the $category fetch and this condition before the
             * navbar, button,... loading to prevent unnecessary loading.
             * Or move this if statement block + $category fetch to somewhere
             * more appropriate.
             */
            // !!! Important: ensure that everything in this if-block occurs exactly 1 time.
        }

        $data2['categories'] = $categories;

        $data['content'] = $this->parser->parse('resident/resident_categories', $data2, true);

        $this->parser->parse('resident/resident_main', $data);
    }

    function question() {
        if (!isset($_GET['category'])) {
            redirect('resident/categories');
        }
        $category = $this->input->get('category');

        $data = $this->display_common_elements('question');

        $categorySetID = $this->Question_model->getCategorySetIdFrom($this->session->language, $category);
        $allUnansweredQuestions = $this->Question_model->getAllUnansweredQuestionsFrom($this->session->id, $categorySetID);
        $options = $this->Question_model->getOptionsFor($allUnansweredQuestions[0]->question_set, $this->session->language);

        $data2['category'] = $category;
        $data2['allUnansweredQuestions'] = $allUnansweredQuestions;
        $data2['options'] = $options;

        $data['content'] = $this->parser->parse('resident/resident_question', $data2, true);

        $this->parser->parse('resident/resident_main', $data);
    }

    function question_store_answer() {
        // only allow AJAX requests
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }

        $jsonDecoded = json_decode($this->security->xss_clean($this->input->raw_input_stream));

        $questionSet = $jsonDecoded->question_set;
        $chosenOptionSet = $jsonDecoded->chosen_option;

        if ($questionSet != "" && $chosenOptionSet != "") {
            $this->Answer_model->storeAnswer($this->session->id, $questionSet, $chosenOptionSet);

            echo 'Answer stored succesfully.';
        } else {
            echo 'Error: questionId or chosenoption empty.';
        }
    }

    function completed() {
        if (isset($_GET['category'])) {
            $category = $this->input->get('category');
        } else {
            $category = ''; // error condition
        }

        $data = $this->display_common_elements('completed');

        $data2['category'] = htmlspecialchars($category);
        $categorySetID = $this->Question_model->getCategorySetIdFrom($this->session->language, $category);
        $tip = $this->Tip_model->getTipFromCategorySet($categorySetID)->tip;
        $data2['tip'] = htmlspecialchars($tip);
        $data['content'] = $this->parser->parse('resident/resident_completed', $data2, true);

        $this->Score_model->addCategoryScore($this->session->id, $categorySetID);

        $this->parser->parse('resident/resident_main', $data);
    }

    function delete_answers() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }
		
		$jsonDecoded = json_decode($this->security->xss_clean($this->input->raw_input_stream));
        $questionSet = $jsonDecoded->question_set;
		
        //$questionSet = $this->input->post('question_set');
		$this->Answer_model->deleteAllAnswers($this->session->id, $questionSet);
    }

}
