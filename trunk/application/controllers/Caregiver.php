<?php

class Caregiver extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// redirect to base if the user shouldn't be here
		if ( $this->session->type != 'caregiver' ) { redirect( base_url() ); }

		// load appropriate language file
		if ( !isset( $this->session->language ) ) {
			// fallback on default
			$this->session->language = $this->config->item( 'language' );
		}
		$this->lang->load( 'common', $this->session->language );
		$this->lang->load( 'caregiver', $this->session->language );

		$this->load->model( 'Picture_model' );
		$this->load->model( 'Question_model' );
		$this->load->model( 'Resident_model' );
		$this->load->model( 'Statistics_model' );
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

		$data2[ 'name' ] = $this->session->first_name;
		$data2[ 'display_login_notification' ] = $this->session->display_login_notification;
		$this->session->display_login_notification = false;
		$data[ 'content' ] = $this->parser->parse( 'caregiver/caregiver_home', $data2, true );

		$this->parser->parse( 'caregiver/caregiver_main.php', $data );
	}

	function groups()
	{
		$data = $this->display_common_elements( 'groups' );

		$residents = $this->Resident_model->getAllResidents();

		$data2[ 'residents' ] = $residents;
		$data[ 'content' ] = $this->load->view( 'caregiver/caregiver_groups', $data2, true );
		$this->parser->parse( 'caregiver/caregiver_main.php', $data );
	}

	function statistics()
	{
		$data = $this->display_common_elements( 'statistics' );

		$language = 'Nederlands';	// TODO remove hard-coded value
		$data2[ 'categories' ] = $this->Question_model->getAllCategoryNames( $language );
		$data2[ 'residents' ] = $this->Resident_model->getAllResidents();

		$data[ 'content' ] = $this->load->view( 'caregiver/caregiver_statistics', $data2, true );

		$this->parser->parse( 'caregiver/caregiver_main.php', $data );
	}

	function overview()
	{
		$data = $this->display_common_elements( 'overview' );

		$data[ 'content' ] = $this->load->view( 'caregiver/caregiver_overview', '', true );

		$this->parser->parse( 'caregiver/caregiver_main.php', $data );
	}

	function resident()
	{
		$data = $this->display_common_elements( 'resident' );

		$data[ 'content' ] = $this->load->view( 'caregiver/caregiver_resident', '', true );

		$this->parser->parse( 'caregiver/caregiver_main.php', $data );
	}

	function load_charts()
	{
		// only allow AJAX requests
//		if ( ! $this->input->is_ajax_request() ) {
//			//redirect('404');
//		}
		$language = 'Nederlands';	// TODO recmove hard-coded value
		$resultArray = [];

		if ( isset( $_POST[ 'resident' ] ) ) {
			$categories = $this->Question_model->getAllCategories(); // as ID
			$resident = $_POST[ 'resident' ];
			//array of strings
			$Yarray = [];
			//array of ints
			$Xarray = [];

			foreach ( $categories as $category ) {
				$result = $this->Statistics_model->getScoreCategory( $resident, $category->id );
				$categoryName = $this->Question_model->getCategoryName( $category->id, $language );
				array_push( $Yarray, $categoryName[ 0 ]->category );
				array_push( $Xarray, $result );
			}
			//array_push($chart1, $Xarray);
			//array_push($chart1, $Yarray);
			array_push( $resultArray, $Xarray );
			array_push( $resultArray, $Yarray );
		}
		if ( isset( $_POST[ 'category' ] ) ) {
			$category = $_POST[ 'category' ];
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
			//array_push($chart2, $Xarray);
			//array_push($chart2, $Yarray);
			array_push( $resultArray, $Xarray );
			array_push( $resultArray, $Yarray );
		}
		//array_push($resultArray, $chart1);
		//array_push($resultArray, $chart2);
		echo json_encode( $resultArray );
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
	function upload()
	{
		if ( isset( $_POST[ "submit" ] ) ) {
			$uploadOk = 1;
			$target_dir = "assets/pictures/";

			$finfo = new finfo( FILEINFO_MIME_TYPE );
			$img_types = array(
				'jpeg' => 'image/jpeg',
				'jpg' => 'image/jpg',
				'png' => 'image/png'
			);
			if ( false === $ext = array_search( $finfo->file( $_FILES[ "fileToUpload" ][ "tmp_name" ] ), $img_types, true ) ) {
				$uploadOk = 0;
			}

			$target_name = basename( sprintf( './uploads/%s.%s', sha1_file( $_FILES[ "fileToUpload" ][ "tmp_name" ] ), $ext ) );
			$target_file = $target_dir . $target_name;
			$imageFileType = pathinfo( $target_file, PATHINFO_EXTENSION );

			// Check if image file is a actual image or fake image
			$check = getimagesize( $_FILES[ "fileToUpload" ][ "tmp_name" ] );
			if ( $check == false ) {
				$uploadOk = 0;
				echo 'Fake image. ';
			}

			// Check if file already exists
			if ( file_exists( $target_file ) ) {
				//File already exists
				$uploadOk = 0;
				echo 'File already exists. ';
			}
			// Check file size
			if ( $_FILES[ "fileToUpload" ][ "size" ] > 700000 ) {
				//File is too large
				$uploadOk = 0;
				echo 'File too large. ';
			}
			// Allow certain file formats
			if ( $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
				//Something else than a jpg, JPG, png, PNG, jpeg, JPEG cannot be uploaded
				$uploadOk = 0;
				echo 'Wrong type. ';
			}
			// Check if $uploadOk is set to 0 by an error
			if ( $uploadOk != 0 ) {
				if ( is_uploaded_file( $_FILES[ "fileToUpload" ][ "tmp_name" ] ) ) {
					move_uploaded_file( $_FILES[ "fileToUpload" ][ "tmp_name" ], $target_file );
					chmod( $target_file, 0644 ); //Change the permission of the uploaded file, otherwise you can't open it.
					//If this line is reached, the upload was successful
					echo 'Picture uploaded! ';
					echo $target_file;
					echo '<br/>';
					$this->Picture_model->storeNewPuzzlePicture( $target_dir, $target_name, 'r123' );
					echo '<img src=/' . $target_dir . $target_name . ' />';
				} else {
					echo 'File is not uploaded';
				}
			} else {
				echo 'Upload failed';
			}
		}
	}
}
