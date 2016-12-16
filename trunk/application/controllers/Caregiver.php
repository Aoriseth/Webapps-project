<?php

class Caregiver extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// redirect to base if the user shouldn't be here
		if ( $this->session->type != 'caregiver' ) {
			redirect( base_url() );
		}

		// load appropriate language file
		if ( !isset( $this->session->language ) ) {
			// fallback on default
			$this->session->language = $this->config->item( 'language' );
		}
		$this->lang->load( 'common', $this->session->language );
		$this->lang->load( 'caregiver', $this->session->language );

		// models
		$this->load->model( 'Picture_model' );
		$this->load->model( 'Question_model' );
		$this->load->model( 'Resident_model' );
		$this->load->model( 'Statistics_model' );
		$this->load->model( 'Group_model' );
	}

	function index()
	{
		redirect( 'caregiver/home' );
	}

	private function display_common_elements( $page )
	{
		$data[ 'include' ] = $this->load->view( 'include', '', true );

		$data2[ 'pages' ] = [ 'home', 'overview', 'groups', 'statistics' ];
		$data2[ 'page_active' ] = $page;
		$data[ 'navbar' ] = $this->parser->parse( 'caregiver/caregiver_navbar', $data2, true );

		return $data;
	}

	function home()
	{
		$data = $this->display_common_elements( 'home' );
                $residents = $this->Resident_model->getAllResidents();
                //$data2['recent_residents'] = $this->Resident_model->getNMostRecentCompletedResidents();
                foreach($residents as $resident){
                    
                }
		$data2[ 'name' ] = $this->session->first_name;

		$data2[ 'display_login_notification' ] = $this->session->display_login_notification;
		$this->session->display_login_notification = false;

		$data[ 'content' ] = $this->parser->parse( 'caregiver/caregiver_home', $data2, true );

		$this->parser->parse( 'caregiver/caregiver_main.php', $data );
	}

	function overview()
	{
		$data = $this->display_common_elements( 'overview' );

		$data[ 'content' ] = $this->load->view( 'caregiver/caregiver_overview', '', true );

		$this->parser->parse( 'caregiver/caregiver_main.php', $data );
	}

	function groups()
	{
		$data = $this->display_common_elements( 'groups' );
		$data2[ 'residents' ] = $this->Resident_model->getAllResidents();
		$data2[ 'floors'] = $this->Resident_model->getAllFloors();
		$data2[ 'caregiverID' ] = $this->session->id; // ??
                $data2[ 'groups' ] = $this->Group_model->getGroups();
		$data[ 'content' ] = $this->load->view( 'caregiver/caregiver_groups', $data2, true );

		$this->parser->parse( 'caregiver/caregiver_main.php', $data );
	}
        
        function result(){
		$data = $this->display_common_elements( 'result' );
                $data[ 'result' ] = $this->load->view( 'caregiver/caregiver_filter', '', true );
		$this->parser->parse( 'caregiver/caregiver_groups.php', $data );
        }


	function statistics()
	{
		$data = $this->display_common_elements( 'statistics' );

		$data2[ 'residents' ] = $this->Resident_model->getAllResidents();
		$data2[ 'categories' ] = $this->Question_model->getAllCategoryNames( $this->session->language );
		$data[ 'content' ] = $this->load->view( 'caregiver/caregiver_statistics', $data2, true );

		$this->parser->parse( 'caregiver/caregiver_main.php', $data );
	}

	function resident( $resident = '' )
	{
		// redirect to overview page if no resident given
		if ( empty( $resident ) ) {
			redirect( 'caregiver/overview' );
		}
                $residentComment = $this->Statistics_model->generateResidentComment($resident);
		$data = $this->display_common_elements( 'resident' );
                $residentObject = $this->Resident_model->getResidentById($resident);
                $data2['comment'] = $residentComment;
                $data2[ 'categories' ] = $this->Question_model->getAllCategoryNames( $this->session->language );
		$data2[ 'id' ] = $resident;
                $data2[ 'name' ] = $residentObject[0]->first_name;
                $data2[ 'last_name' ] = $residentObject[0]->last_name;
                $data2[ 'date_of_birth' ] = $residentObject[0]->date_of_birth;
                $data2[ 'language' ] = $residentObject[0]->language;
                $data2[ 'floor' ] = $residentObject[0]->floor_number;
                $data2[ 'room' ] = $residentObject[0]->room_number;
                $data2[ 'sessions_completed' ] = $residentObject[0]->completed_sessions;
                $data2[ 'last_activity' ] = $residentObject[0]->last_activity;
                $data2['average_score'] = round($this->Statistics_model->getTotalScoreResident($resident));
		$data[ 'content' ] = $this->parser->parse( 'caregiver/caregiver_resident', $data2, true );

		$this->parser->parse( 'caregiver/caregiver_main.php', $data );
	}

	function filterGroup() {
		// TODO is this an AJAX call? block direct access then
                $resultArray = [];
                $ageMin = $_POST['ageMin']; 
                $ageMax = $_POST['ageMax'];
                $gender = $_POST['gender'];
                $floors = $_POST['floors'];

                if (isset($ageMin, $ageMax, $gender, $floors)) {
                        //
                        $floors = $this->input->post( 'floors' );
                        $gender = $this->input->post( 'gender' );
                        $array_requirements = array('floor_number' => intval($floors), 'gender' => $gender); // string to int
                        $filter_residents = $this->Resident_model->getResidentsWith( $array_requirements ) ;
                        foreach ( $filter_residents as $resident ) {
                            array_push( $resultArray, $resident );
			}
                }
		header( 'Content-Type: application/json' );     
                echo json_encode( $resultArray );
        }
        
        function addGroup(){
            
                $residentIDs = $_POST['selected_residents']; 
                $caregiverID = $_POST['caregiverID']; 
                $filter = $_POST['filter']; 
                $this->Group_model->addGroup($filter, $caregiverID, $residentIDs);
        }
        
        function getGroups(){
                echo json_encode ($this->Group_model->getGroups());
        }
        
	function load_resident_chart()
	{
		// only allow AJAX requests
		if ( ! $this->input->is_ajax_request() ) {
			redirect( '404' );
		}

		$resultArray = [];

		if ( isset( $_POST[ 'resident' ] ) ) {
			$resident = $this->input->post( 'resident' );
			$categories = $this->Question_model->getAllCategories(); // as ID

			//array of strings
			$Yarray = [];
			//array of ints
			$Xarray = [];

			foreach ( $categories as $category ) {
				$result = $this->Statistics_model->getScoreCategory( $resident, $category->id );
				$categoryName = $this->Question_model->getCategoryName( $category->id, $this->session->language );
				array_push( $Yarray, $categoryName[ 0 ]->category );
				array_push( $Xarray, $result );
			}
			array_push( $resultArray, $Xarray );
			array_push( $resultArray, $Yarray );
		}
                header( 'Content-Type: application/json' );     
                echo json_encode( $resultArray );
	}        
	function load_category_chart()
	{	
                // only allow AJAX requests
		if ( ! $this->input->is_ajax_request() ) {
			redirect( '404' );
		}

		$resultArray = [];
                
		if ( isset( $_POST[ 'category' ] ) ) {
			$category = $this->input->post( 'category' );
			$residents = $this->Resident_model->getAllResidents();

			//array of strings
			$Yarray = [];
			//array of ints
			$Xarray = [];

			foreach ( $residents as $resident ) {
				$result = $this->Statistics_model->getScoreCategory( $resident->id, $category );
				array_push( $Yarray, $resident->first_name );
				array_push( $Xarray, $result );
			}
			array_push( $resultArray, $Xarray );
			array_push( $resultArray, $Yarray );
		}

		header( 'Content-Type: application/json' );     
		echo json_encode( $resultArray );
	}
        
        function load_category_course_chart()
	{	
                // only allow AJAX requests
		if ( ! $this->input->is_ajax_request() ) {
			redirect( '404' );
		}

		$resultArray = [];
                
		if ( isset( $_POST[ 'category' ] ) && isset( $_POST[ 'resident' ] ) ) {
			$category = $this->input->post( 'category' );
                        $resident = $this->input->post( 'resident' );
                        $residentObject = $this->Resident_model->getResidentById($resident)[0];
                        $sessions = $this->Score_model->getAllCompletedSessionScoresAndDates( $resident );
			//array of strings
			$Yarray = [];
			//array of ints
			$Xarray = [];
			foreach ( $sessions as $session){
				$result = $this->Statistics_model->getScoresCategoryofSession( $resident, $category, $session->session);
				array_push( $Yarray, $session->completed_on );
				array_push( $Xarray, $result );
			}
			array_push( $resultArray, $Xarray );
			array_push( $resultArray, $Yarray );
		}

		header( 'Content-Type: application/json' );     
		echo json_encode( $resultArray );
	}
        
        function load_avarage_score_per_resident_chart()
	{
		// only allow AJAX requests
		if ( ! $this->input->is_ajax_request() ) {
			redirect( '404' );
		}

		$resultArray = [];


                $residents = $this->Resident_model->getAllResidents();
                $categories = $this->Question_model->getAllCategories(); // as ID

                //array of strings
                $Yarray = [];
                //array of ints
                $Xarray = [];

                foreach ( $residents as $resident ) {
                    $totalScore = $this->Statistics_model->getTotalScoreResident($resident->id);
                    array_push( $Yarray, $resident->first_name );
                    array_push( $Xarray, $totalScore );
                }    
                    
                array_push( $resultArray, $Xarray );
                array_push( $resultArray, $Yarray );
		
		
		
		header( 'Content-Type: application/json' );     
		echo json_encode( $resultArray );
	}
        
        function load_avarage_score_per_category_chart()
	{
		// only allow AJAX requests
		if ( ! $this->input->is_ajax_request() ) {
			redirect( '404' );
		}

		$resultArray = [];


                $residents = $this->Resident_model->getAllResidents();
                $categories = $this->Question_model->getAllCategories(); // as ID

                //array of strings
                $Yarray = [];
                //array of ints
                $Xarray = [];

                foreach ( $categories as $category ) {
                    $totalScore = $this->Statistics_model->getTotalScoreCategory($residents, $category->id);   
                    array_push( $Yarray, $this->Question_model->getCategoryName($category->id, $this->session->language)[0]->category );
                    array_push( $Xarray, $totalScore );
                }    
                    
                array_push( $resultArray, $Xarray );
                array_push( $resultArray, $Yarray );
		
		
		
		header( 'Content-Type: application/json' );     
		echo json_encode( $resultArray );
	}
        

	/**
	 * Upload a picture that is stored on the computer. Uploaded pictures are stored
	 * in the upload folder.
	 * 
	 * |===============================|
	 * | THIS IS A TEMPORARY FUNCTION. |
	 * |===============================|
	 * 
	 * TODO: Move all of this code to the place where it is needed/appropriate for uploading pictures.
	 */
	function upload()
	{
		// only allow AJAX requests
		if ( ! $this->input->is_ajax_request() ) {
			redirect( '404' );
		}

		if ( isset( $_POST[ "submit" ] ) ) {
			$target_dir = "assets/pictures/";

			$finfo = new finfo( FILEINFO_MIME_TYPE );
			$img_types = array(
				'jpeg' => 'image/jpeg',
				'jpg' => 'image/jpg',
				'png' => 'image/png'
			);

			if ( false === $ext = array_search( $finfo->file( $_FILES[ "fileToUpload" ][ "tmp_name" ] ), $img_types, true ) ) {
				return;
			}

			$target_name = basename( sprintf( './uploads/%s.%s', sha1_file( $_FILES[ "fileToUpload" ][ "tmp_name" ] ), $ext ) );
			$target_file = $target_dir.$target_name;
			$imageFileType = pathinfo( $target_file, PATHINFO_EXTENSION );

			//Check if image file is an actual image
			$check = getimagesize( $_FILES[ "fileToUpload" ][ "tmp_name" ] );
			if ( $check == false ) {
				echo 'Fake image.';
				return;
			}

			//Check if file already exists, rename if it exists. Give up if it fails too many times.
			$counter = 0;
			while ( file_exists( $target_file ) ) {
				if($counter > 8) {
					echo 'Chances of this happening are astronomically small. Please try again later.';
					return;
				}
				$randomString = substr( md5( microtime() ), mt_rand( 0, 26 ), 1 );
				$target_file = $target_file.$randomString;
				$counter = $counter + 1;
			}

			//Check file size
			if ( $_FILES[ "fileToUpload" ][ "size" ] > 700000 ) {
				echo 'File too large. ';
				return;
			}
			
			//Allow certain file formats
			if ( $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
				//Something else than a jpg, png or jpeg cannot be uploaded
				echo 'This type of images is not supported. ';
				return;
			}
			
			//Now that all checks are done, really upload the file.
			if ( is_uploaded_file( $_FILES[ "fileToUpload" ][ "tmp_name" ] ) ) {
				move_uploaded_file( $_FILES[ "fileToUpload" ][ "tmp_name" ], $target_file );
				chmod( $target_file, 0644 ); //Change the permissions of the uploaded file, otherwise you can't open it.

				// TODO hard-coded resident ID --> replace by parameter in AJAX call?
				$this->Picture_model->storeNewPuzzlePicture( $target_dir, $target_name, 'r123' );

				echo 'Picture uploaded! ' . $target_file . '<br/>';
				echo '<img src=/' . $target_dir . $target_name . ' />';
			} else {
				echo 'File is not uploaded';
			}
		}
	}
}
