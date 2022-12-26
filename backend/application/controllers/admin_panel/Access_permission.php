<?php
defined('BASEPATH') OR exit('No direct script access allowed');
  
 class Access_permission extends CI_Controller
 {
 	protected $system_module = '';
 	function __construct()
	{
		parent::__construct();
		$this->load->model('Master_Model');
		$this->load->model('Gg_model','gg');
		$this->load->library('Sms_Library');

		if($this->session->userdata('usertype_id') != 1){
			redirect('admin_panel/dashboard');
		}
	}

	public function index()
	{
		$data = [];
		$this->load->view('admin_panel/access_permission/permission_list',$data);
	}

	public function frontend_list()
	{
		$data = [];

		$draw = intval($this->input->get("draw"));
	    $start = intval($this->input->get("start"));
	    $length = intval($this->input->get("length"));

	    $list_value = $this->db->query('SELECT id,module_name FROM module');

	    $list_data = $list_value->result_array();
	    // print_r($list_data);exit;
	    $product_status = [0 => 'Sold' , 1 => 'Available'];
	    foreach ($list_data as $key => $value) {
	    	$admin_active = $this->db->query('SELECT id FROM access_permission WHERE module_id='.$value['id'].' AND usertype_id=3')->result_array();
	    	if(!empty($admin_active)){
	    		$admin_active = 'Active';
	    		$admin_url = '<a href="'.base_url().'admin_panel/access_permission/active_and_deactive/deactive/'.$value['id'].'/3"> <button type="button" class="btn btn-danger">De Active</button></a>
	    			';
	    	}else{
	    		$admin_active = 'Not Active';
	    		$admin_url = '<a href="'.base_url().'admin_panel/access_permission/active_and_deactive/active/'.$value['id'].'/3"> <button type="button" class="btn btn-success">Active</button></a>';
	    	}

	    	$users_active = $this->db->query('SELECT id FROM access_permission WHERE module_id='.$value['id'].' AND usertype_id=4')->result_array();
	    	if(!empty($users_active)){
	    		$users_active = 'Active';
	    		$users_url = '<a href="'.base_url().'admin_panel/access_permission/active_and_deactive/deactive/'.$value['id'].'/4"> <button type="button" class="btn btn-danger">De Active</button></a>
	    			';
	    	}else{
	    		$users_active = 'Not Active';
	    		$users_url = '<a href="'.base_url().'admin_panel/access_permission/active_and_deactive/active/'.$value['id'].'/4"> <button type="button" class="btn btn-success">Active</button></a>';
	    	}

	    	$data[] = array(
	    			$value['module_name'],
	    			$admin_active,
	    			$users_active,
	    			$admin_url,
	    			$users_url,
               );
	    }

	    $output = array(
               "draw" => $draw,
                 "recordsTotal" => $list_value->num_rows(),
                 "recordsFiltered" => $list_value->num_rows(),
                 "data" => $data
            );

	    echo json_encode($output);
	}

	public function active_and_deactive($status , $id,$role_id){
		if(!empty($status) && !empty($id)){
			if($status == 'active'){
				$insert_array = [ 
					'usertype_id' => $role_id,
					'module_id' => $id,
					'view_access' => 1,
					'add_access' => 1,
					'edit_access' => 1,
					'delete_access' => 1
				];

				$param_ins = [];
				$param_ins['env'] = 'gg';
				$param_ins['table_name'] ='access_permission';
				$param_ins['data'] = $insert_array;

				$this->gg->insert_table_data($param_ins);
			}else{
				$param_delete = [];
				$param_delete['env'] = 'gg';
				$param_delete['select_data'] = '';
				$param_delete['table_name'] ='access_permission';
				$param_delete['where_data'] = array('module_id' => $id,'usertype_id' => $role_id);

				$this->gg->delete_table_data($param_delete);
			}
			redirect('admin_panel/access_permission');
		}else{
			redirect('admin_panel/access_permission');
		}
	}
}