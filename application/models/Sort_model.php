<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sort_model extends CI_Model {

	var $table = 'residents';
        //set column field database for datatable orderable
	var $column_order = array('id','first_name','last_name','gender','password','date_of_birth','language','floor_number','room_number','last_domicile','last_activity','last_completed','completed_sessions','session_in_progress','type','account_created_by','account_created_on','profile_picture_id');   
        //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $column_search = array('id','first_name','last_name'); 
         // default order 
	var $order = array('id' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
               
	}

	private function _get_datatables_query()
	{$this->db->from($this->table);	$i = 0;	                
		foreach ($this->column_search as $item){ 
                    if($_POST['search']['value']) 
			{if($i===0){$this->db->group_start(); 
                                    $this->db->like($item, $_POST['search']['value']);
                                    }
				else{
					$this->db->or_like($item, $_POST['search']['value']);
				}
                                if(count($this->column_search) - 1 == $i)                                      
					$this->db->group_end(); 
			}$i++;
		}		
		if(isset($_POST['order'])){
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order)){
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->table);
	}
}
