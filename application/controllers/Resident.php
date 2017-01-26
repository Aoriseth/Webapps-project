<?php

/**
 * Handles all the pages and logic related to the residents.
 */
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

    function index() { // landing page
        redirect('resident/home');
    }

    private function display_common_elements($page) { // elements that are present on every page
        $data['include'] = $this->load->view('include', '', true);
        $data['navbar'] = $this->parser->parse('resident/resident_navbar', array('page' => $page), true);
        return $data;
    }

    function home() {
        $data = $this->display_common_elements('home');

        // login notification
        $data2['display_login_notification'] = $this->session->display_login_notification;
        $this->session->display_login_notification = false;

        // puzzle
        $residentId = $this->session->id;

        $query2 = $this->Picture_model->getPictureTest($residentId);
        if ($query2 != null) {
            $data2['path'] = $query2[0]->picture_dir;
            $data2['puzzle'] = $query2[0]->picture_name;
        } else {
            $this->Picture_model->activateNewPuzzle($residentId);

            if ($query2 != null) {
                $data2['path'] = $query2[0]->picture_dir;
                $data2['puzzle'] = $query2[0]->picture_name;
            } else {
                $data2['path'] = null;
                $data2['puzzle'] = null;
            }
            header("Refresh:0");
            return;
        }
        $data2['categories'] = $this->Question_model->getFinishedCategorySets($residentId);
        $data2['name'] = $this->session->first_name;

        // insert into page
        $data['content'] = $this->parser->parse('resident/resident_home', $data2, true);
        $this->parser->parse('resident/resident_main', $data);
    }

    function gallery() {
        $data = $this->display_common_elements('gallery');

        // gallery iamges
        $residentId = $this->session->id;
        $query = $this->Picture_model->getNCompletedPictures($residentId, 5);
//      if( count( $query ) != 0 ) {
        $data2['imgdata'] = $query;
//      }
        // insert into page
        $data['content'] = $this->parser->parse('resident/resident_gallery', $data2, true);
        $this->parser->parse('resident/resident_main', $data);
    }

    function categories() {
        $data = $this->display_common_elements('categories');

        // get 3 random categories
        $categories = $this->Question_model->getAllUnfinishedCategories($this->session->id, 3);
        $cat = $this->Question_model->getAllCategoryNames($this->session->language);

        // when all categories are completed
        if (count($categories) == 0) {
            $this->Score_model->addSessionScore($this->session->id);
            $this->Resident_model->incrementSession($this->session->id);
            $this->session->completedSessions = $this->Resident_model->getSessionsCompleted($this->session->id);
            $this->Resident_model->setInProgress($this->session->id, 0);
            $this->Resident_model->updateLastCompleted($this->session->id);
            $this->Picture_model->updateAndChangePuzzle($this->session->id);
            header("Refresh:0");
            return;
        }
        $data2['cat'] = $cat;
        $data2['categories'] = $categories;

        // insert into page
        $data['content'] = $this->parser->parse('resident/resident_categories', $data2, true);
        $this->parser->parse('resident/resident_main', $data);
    }

    function question() {
        // redirect to categories if no category is set
        if (!isset($_GET['category'])) {
            redirect('resident/categories');
        }
        $category = $this->input->get('category');

        $data = $this->display_common_elements('question');

        // get questions and their answers
        $categorySetID = $this->Question_model->getCategorySetIdFrom($this->session->language, $category);
        $allUnansweredQuestions = $this->Question_model->getAllUnansweredQuestionsFrom($this->session->id, $categorySetID);
        $options = $this->Question_model->getOptionsFor($allUnansweredQuestions[0]->question_set, $this->session->language);
        $questions = $this->Question_model->getAllQuestionSetsFrom($categorySetID);
        $totNumberQuestions = count($questions) - count($allUnansweredQuestions);

        $data2['category'] = $category;
        $data2['allUnansweredQuestions'] = $allUnansweredQuestions;
        $data2['options'] = $options;
        $data2['numberQuestions'] = $totNumberQuestions;

        // insert into page
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

    function delete_answers() {
        // only allow AJAX requests
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }

        $jsonDecoded = json_decode($this->security->xss_clean($this->input->raw_input_stream));
        $questionSet = $jsonDecoded->question_set;

        $this->Answer_model->deleteAllAnswers($this->session->id, $questionSet);
    }

    function completed() {
        // category should be set in GET
        if (isset($_GET['category'])) {
            $category = $this->input->get('category');
        } else {
            $category = ''; // unhandled error condition
        }

        $data = $this->display_common_elements('completed');

        $categorySetID = $this->Question_model->getCategorySetIdFrom($this->session->language, $category);
        $tip = $this->Tip_model->getTipFromCategorySet($categorySetID)->tip;

        $this->Score_model->addCategoryScore($this->session->id, $categorySetID);

        $data2['category'] = htmlspecialchars($category);
        $data2['setID'] = $categorySetID;
        $data2['tip'] = htmlspecialchars($tip);

        $residentId = $this->session->id;

        $query2 = $this->Picture_model->getPictureTest($residentId);
        if ($query2 != null) {
            $data2['path'] = $query2[0]->picture_dir;
            $data2['puzzle'] = $query2[0]->picture_name;
        } else {
            $data2['path'] = null;
            $data2['puzzle'] = null;
        }

        // insert into page
        $data['content'] = $this->parser->parse('resident/resident_completed', $data2, true);
        $this->parser->parse('resident/resident_main', $data);
    }

}
