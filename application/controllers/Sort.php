<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sort extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Sort_model','residents');
                  $this->load->helper( 'date' );
                 date_default_timezone_set( 'Europe/Brussels' );
	}

	public function index()
	{
		$this->load->helper('url');
		$this->load->view('caregiver_overview');
	}

	public function ajax_list()
	{
		$list = $this->residents->get_datatables();
		$data = array();
		$no = $_POST['start'];
                
                
		foreach ($list as $residents) {
			$no++;
			$row = array();  
                       
                       $url = base_url() . 'index.php/caregiver/resident/' . $residents->id ;
                       
                        
                        $row[] = '<a class="btn" onclick="redirect('."'" . (string)$url ."'".')"> '. $residents->id .'</a>';
                        //$row[] = $residents->id;
			$row[] = $residents->first_name;
                        $row[] = $residents->last_name;
                        $row[] = $residents->gender;                       
                        $row[] = $residents->date_of_birth;                       
                        $row[] = $residents->floor_number;   
                        $row[] = $residents->room_number;   
                        $row[] = $residents->last_activity;
                        $row[] = $residents->last_completed;
                        $row[] = $residents->completed_sessions;
                      
                       
			//add html for action
			$row[] = '<a class="btn btn-success" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$residents->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$residents->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->residents->count_all(),
						"recordsFiltered" => $this->residents->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->residents->get_by_id($id);
		$data->date_of_birth = ($data->date_of_birth == '0000-00-00') ? '' : $data->date_of_birth; // if 0000-00-00 set to empty for datepicker compatibility
                $data->last_activity = ($data->last_activity == '0000-00-00') ? '' : $data->last_activity; // if 0000-00-00 set to empty for datepicker compatibility
                $data->last_completed = ($data->last_completed == '0000-00-00') ? '' : $data->last_completed; // if 0000-00-00 set to empty for datepicker compatibility
                $data->account_created_on = ($data->account_created_on == '0000-00-00') ? '' : $data->account_created_on; // if 0000-00-00 set to empty for datepicker compatibility
		echo json_encode($data);
	}

	public function ajax_add()
	{
              $session_In_Progress = 0;
              $completed_sessions = 0;
              $account_created_by = $this->session->id;
              $profile_picture_id = NULL ;
                
		$this->_validate();
		$data = array(
                    
				'id' => $this->input->post('id'),
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'gender' => $this->input->post('gender'),
                                'password' => $this->input->post('password'),
                                'date_of_birth' => $this->input->post('date_of_birth'),
                                'language' => $this->input->post('language'),
                                'floor_number' => $this->input->post('floor_number'),
                                'room_number' => $this->input->post('room_number'),
                                'last_domicile' => $this->input->post('last_domicile'),
                                'last_activity' => $this->input->post('last_activity'),
                                'last_completed' => $this->input->post('last_completed'),
				'completed_sessions' => $completed_sessions,
                                'session_in_progress' => $session_In_Progress,
                                'type' => $this->input->post('type'),                    
                                'account_created_by' => $account_created_by,
                                'account_created_on' => date( 'Y-m-d H:i:s' ),                   
                                 'profile_picture_id' => $profile_picture_id,   
                    
                    
                    
			);
		$insert = $this->residents->save($data);
		echo json_encode(array("status" => TRUE));
                echo 'succesfully added' ;
	}

	public function ajax_update()
	{
            
          
		$this->_validate();
		$data = array(
                    
                                'id' => $this->input->post('id'),
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'gender' => $this->input->post('gender'),
                                'password' => $this->input->post('password'),
                                'date_of_birth' => $this->input->post('date_of_birth'),
                                'language' => $this->input->post('language'),
                                'floor_number' => $this->input->post('floor_number'),
                                 'room_number' => $this->input->post('room_number'),
                                'last_domicile' => $this->input->post('last_domicile'),
                                'last_activity' => $this->input->post('last_activity'),
                                'last_completed' => $this->input->post('last_completed'),
				'completed_sessions' => $this->input->post('completed_sessions'),
                                'session_in_progress' => $this->input->post('session_in_progress'),
                                'type' => $this->input->post('type'),
                                'account_created_by' => $this->input->post('account_created_by'),
                                'account_created_on' => $this->input->post('account_created_on'),
				
			);
		$this->residents->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->residents->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}


	private function _validate()
	{                            
            
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('first_name') == '')
		{
			$data['inputerror'][] = 'firstName';
			$data['error_string'][] = 'First name is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('last_name') == '')
		{
			$data['inputerror'][] = 'lastName';
			$data['error_string'][] = 'Last name is required';
			$data['status'] = FALSE;
		}		

		if($this->input->post('gender') == '')
		{
			$data['inputerror'][] = 'gender';
			$data['error_string'][] = 'Please select gender';
			$data['status'] = FALSE;
		}

		if($this->input->post('password') == '')
		{
			$data['inputerror'][] = 'password';
			$data['error_string'][] = 'password is required';
			$data['status'] = FALSE;
		}
                
                if($this->input->post('date_of_birth') == '')
		{
			$data['inputerror'][] = 'date_of_birth';
			$data['error_string'][] = 'date_of_birth is required';
			$data['status'] = FALSE;
		}
                if($this->input->post('language') == '')
		{
			$data['inputerror'][] = 'language';
			$data['error_string'][] = 'language is required';
			$data['status'] = FALSE;
		}
                if($this->input->post('floor_number') == '')
		{
			$data['inputerror'][] = 'floor_number';
			$data['error_string'][] = 'floor_number is required';
			$data['status'] = FALSE;
		} 
                  if($this->input->post('room_number') == '')
		{
			$data['inputerror'][] = 'room_number';
			$data['error_string'][] = 'room_number is required';
			$data['status'] = FALSE;
		}  
                if($this->input->post('last_domicile') == '')
		{
			$data['inputerror'][] = 'last_domicile';
			$data['error_string'][] = 'last_domicile is required';
			$data['status'] = FALSE;
		}  
                 if($this->input->post('type') == '')
		{
			$data['inputerror'][] = 'type';
			$data['error_string'][] = 'type is required';
			$data['status'] = FALSE;
		}  
              


		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
        
       

}
