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
	function upload() {
		if(isset($_POST["submit"])) {
			$uploadOk = 1;
			$target_dir = "assets/imgs/";
			//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

			$finfo = new finfo(FILEINFO_MIME_TYPE);
			$img_types = array(
						'jpg' => 'image/jpeg',
						'png' => 'image/png',
						'JPG' => 'image/JPEG',
						'PNG' => 'image/PNG'
						);
			if(false === $ext = array_search($finfo->file($_FILES["fileToUpload"]["tmp_name"]), $img_types, true)) {
				$uploadOk = 0;
			}
			
			$target_name = basename(sprintf('./uploads/%s.%s', sha1_file($_FILES["fileToUpload"]["tmp_name"]), $ext));
			$target_file = $target_dir . $target_name;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

			// Check if image file is a actual image or fake image
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check == false) {
				$uploadOk = 0;
				echo 'Fake image. ';
			}

			// Check if file already exists
			if (file_exists($target_file)) {
				//File already exists
				$uploadOk = 0;
				echo 'File already exists. ';
			}
			// Check file size
			if ($_FILES["fileToUpload"]["size"] > 800000) {
				//File is too large
				$uploadOk = 0;
				echo 'File too large. ';
			}
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "JPG"
					&& $imageFileType != "png" && $imageFileType != "PNG"
					&& $imageFileType != "jpeg" && $imageFileType != "JPEG" ) {
				//Something else than a jpg, JPG, png, PNG, jpeg, JPEG cannot be uploaded
				$uploadOk = 0;
				echo 'Wrong type. ';
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk != 0) {
				if (is_uploaded_file($_FILES["fileToUpload"]["tmp_name"])) {
					move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
					//If this line is reached, the upload was successful
					echo 'Picture uploaded! ';
					echo $target_file;
					$this->Picture_model->storeNewPuzzlePicture($target_dir, $target_name, 'r123');
					echo '<img src=/"'. $target_file .'" />';
					echo '<img src="'. $target_file .'" />';
					echo '<img src=' . $target_file . ' />';
					echo '<img src=/'. $target_file .' />';
					$fullname = '/assets/imgs/Lilliane.png';
					echo '<img src=' . $fullname . ' />';
					$fullname = '/assets/imgs/puzzle.jpg';
					echo '<img src=' . $fullname . ' />';
				}
				else {
					echo 'File is not uploaded';
				}
			}
			else {
				echo 'Upload failed';
			}
		}
	}
}
