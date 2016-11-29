<?php

class Caregiver extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// redirect to base if the user shouldn't be here
		if ( $this->session->type != 'caregiver' ) { redirect( base_url() ); }
		
		$this->load->library( 'parser' );
		$this->load->model( 'Question_model' );
		$this->load->model( 'Statistics_model' );
		$this->load->model( 'Resident_model' );
		$this->load->model( 'Picture_model' );
	}

	function index()
	{
		redirect( 'caregiver/home' );
	}

	function home()
	{
		$data2[ 'page' ] = 'home';
		$data[ 'navbar' ] = $this->parser->parse( 'caregiver/caregiver_navbar', $data2, true );
		$data[ 'navigation_buttons' ] = $this->parser->parse( 'caregiver/caregiver_navigation_buttons', $data2, true );

		$data2[ 'name' ] = $this->session->first_name;
		$data2[ 'display_login_notification' ] = $this->session->display_login_notification;
		$this->session->display_login_notification = false;
		$data[ 'content' ] = $this->parser->parse( 'caregiver/caregiver_home', $data2, true );

		$this->parser->parse( 'caregiver/caregiver_main.php', $data );

	}
        
	function groups()
	{
                $residents = $this->Resident_model->getAllResidents();
		$data2[ 'page' ] = 'groups';
		$data[ 'navbar' ] = $this->parser->parse( 'caregiver/caregiver_navbar', $data2, true );
		$data[ 'navigation_buttons' ] = $this->parser->parse( 'caregiver/caregiver_navigation_buttons', $data2, true );
                $data2[ 'residents'] = $residents;
		$data[ 'content' ] = $this->load->view( 'caregiver/caregiver_groups', $data2, true );
		$this->parser->parse( 'caregiver/caregiver_main.php', $data );
	}
	
	function statistics() {
		$categories = $this->Question_model->getAllCategories( 'English' );
                $residents = $this->Resident_model->getAllResidents();
		$data2[ 'page' ] = 'statistics';
		$data[ 'navbar' ] = $this->parser->parse( 'caregiver/caregiver_navbar', $data2, true );
		$data[ 'navigation_buttons' ] = $this->parser->parse( 'caregiver/caregiver_navigation_buttons', $data2, true );
		$data2[ 'categories'] = $categories;
                $data2[ 'residents'] = $residents;
		$data[ 'content' ] = $this->load->view( 'caregiver/caregiver_statistics', $data2, true );
                

		$this->parser->parse( 'caregiver/caregiver_main.php', $data );
	}
	
	function overview()
	{
		$data2[ 'page' ] = 'overview';
		$data[ 'navbar' ] = $this->parser->parse( 'caregiver/caregiver_navbar', $data2, true );
		$data[ 'navigation_buttons' ] = $this->parser->parse( 'caregiver/caregiver_navigation_buttons', $data2, true );

		$data[ 'content' ] = $this->load->view( 'caregiver/caregiver_overview', '', true );
		
		$this->parser->parse( 'caregiver/caregiver_main.php', $data );
	}
	
	function resident()
	{
		$data2[ 'page' ] = 'resident';
		$data[ 'navbar' ] = $this->parser->parse( 'caregiver/caregiver_navbar', $data2, true );
		$data[ 'navigation_buttons' ] = $this->parser->parse( 'caregiver/caregiver_navigation_buttons', $data2, true );

		$data[ 'content' ] = $this->load->view( 'caregiver/caregiver_resident', '', true );
		
		$this->parser->parse( 'caregiver/caregiver_main.php', $data );
	}
        
        function load_charts(){
                // only allow AJAX requests
//		if ( ! $this->input->is_ajax_request() ) {
//			//redirect('404');
//		}
                 
                if ( isset( $_POST[ 'resident' ] ) ) {
                    
                    $categories = $this->Question_model->getAllCategories( 'English');
                    $resident = $_POST[ 'resident' ];
                    $resultArray = [];
          
                    array_push($resultArray, $categories);
                    foreach($categories as $category){
                        
                        $result = $this->Statistics_model->getScoreCategory($resident, (int)$category->id);
                        array_push($resultArray, $result);
                    }
                    
                    
                    echo json_encode($resultArray);
		}
                
                else{
                    header( 'Content-Type: application/json' );
			echo json_encode( array( 'resident' => 'undefined', 'category' => 'undefined' ) );
			return;
                }
              
              //header( 'Content-Type: application/json' );
                  
        }
		
		
		function upload() {
			$target_dir = "uploads/";
			$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			// Check if image file is a actual image or fake image
			if(isset($_POST["submit"])) {
				$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
				if($check !== false) {
					echo "File is an image - " . $check["mime"] . ".";
					$uploadOk = 1;

				} else {
					echo "File is not an image."; 
					$uploadOk = 0;

				}
			}
			// Check if file already exists
			if (file_exists($target_file)) {
				echo "File already exists.";
				$uploadOk = 0;
			}
			// Check file size
			if ($_FILES["fileToUpload"]["size"] > 500000) {
				echo "File is too large.";
				$uploadOk = 0;
			}
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "PNG" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				echo "Only JPG, JPEG, PNG & GIF files are allowed.";
				$uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				echo "File was not uploaded.";
			// if everything is ok, try to upload file
			} else {
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
				} else {
					echo "There was an error uploading your file.";
				}
			}
		}
}
