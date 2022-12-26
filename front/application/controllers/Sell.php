<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sell extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('sell');
	}

	public function register(){
		$data = [];
		$postdata = $this->input->post();
		// pre($postdata);
		if(!empty($postdata['name_modal']) && !empty($postdata['email_modal']) && $postdata['mobile_modal']){
			$insert_array = [
				'name' => $postdata['name_modal'],
				'email' => $postdata['email_modal'],
				'mobile' => $postdata['mobile_modal'],
				'created' => date('Y-m-d H:i:s')
			];

			$this->db->insert('sell_registration',$insert_array);

			$the_session = array("form_session" => "1");
			$this->session->set_userdata($the_session);

			$data = array('status' => 'success' ,'msg' => 'Request send successfully to team' , 'data' => '');
		}else{
			$data = array('status' => 'error' , 'msg' => 'Please enter all details' , 'data' => '');
		}
		echo json_encode($data);
	}
}
