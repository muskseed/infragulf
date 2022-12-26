<?php
defined('BASEPATH') OR exit('No direct script access allowed');
   
 class System_settings extends CI_Controller
 {
 	protected $system_module = '';
 	function __construct()
	{
		parent::__construct();
		$this->load->library('Bitcoin_Library');
		$this->system_module = $this->bitcoin_library->check_access_perm($this->session->userdata('usertype_id'),'System_settings',$this->uri->segment(4));
		// print_r($this->system_module);exit;
		$this->load->model('Master_Model');
		//$this->load->library('upload');
	}

	public function index()
	{
		$data = [];
		$data['access_permission'] = $this->system_module;
		$system_data = $this->db->query('SELECT * FROM system_settings')->result_array();
		$data['system_data'] = $system_data;
		$this->load->view('admin_panel/system_settings/setting_list',$data);
	}

	public function form_action($id = '')
	{

		$postdata = $this->input->post();
		foreach ($postdata as $key => $value) {
			$final_data[] = [
				'key'	=> $key,
				'value' => $value,
			];
		}
		// pre($final_data);die;
		$this->db->query('DELETE FROM system_settings');     
		$this->db->insert_batch('system_settings',$final_data);
		redirect('admin_panel/System_settings');
	}
}