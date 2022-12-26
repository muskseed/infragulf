<?php
defined('BASEPATH') OR exit('No direct script access allowed');
   
 class Registration extends CI_Controller
 {
 	protected $system_module = '';
 	function __construct()
	{
		parent::__construct();
		$this->load->library('Bitcoin_Library');
		$this->system_module = $this->bitcoin_library->check_access_perm($this->session->userdata('usertype_id'),'Registration',$this->uri->segment(4));
		$this->load->model('Master_Model');
	}

	public function index()
	{
		$data = [];
		$data['access_permission'] = $this->system_module;
		$this->load->view('admin_panel/registration/list',$data);
	}

	public function frontend_list()
	{
		$data = [];

		$draw = intval($this->input->get("draw"));
	    $start = intval($this->input->get("start"));
	    $length = intval($this->input->get("length"));

	    $list_value = $this->Master_Model->get_all_data('registration');

	    $list_data = $list_value->result_array();
	    // print_r($user_data);exit;
	    foreach ($list_data as $key => $value) {
	    	$data[] = array(
	    			$value['name'],
	    			$value['email'],
	    			$value['mobile'],
	    			date('Y-m-d' ,strtotime($value['created'])),
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
}