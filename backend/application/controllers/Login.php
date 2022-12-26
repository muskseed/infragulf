<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* This is Login Page of the backend system
*/
class Login extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Master_Model');
	}

	public function index()
	{	
		$data = [];
		$expiry_data = $this->db->query('SELECT expire_date FROM product_subscription')->result_array();
		$expiry_date = $expiry_data[0]['expire_date'];
		$one_m_before  = date('Y-m-d', strtotime("-1 months", strtotime($expiry_date))); 
		$today_date = date('Y-m-d');
		$days_left = strtotime($expiry_date) - strtotime($today_date);
		$days_left = round($days_left / 86400);
		// pre($days_left);die;
		$expired_sub = 0;
		if($expiry_date < $today_date){
			$expired_sub = 1;
		}
		$data['expired_sub'] = $expired_sub; 
		$data['days_left'] = $days_left; 
		$data['expiry_date'] = $expiry_date; 
		$data['one_m_before'] = $one_m_before; 
		$data['today_date'] = $today_date; 
		$this->load->view('login',$data);
	}

	public function login_check()
	{
		$postdata = $this->input->post();
		$mobile_number = $postdata['mobile_number'];
		$password = $postdata['password'];

		$user_check = $this->Master_Model->get_num_rows('users',['mobile_number' => $mobile_number, 'password' => $password]);

		if($user_check > 0)
		{
			$user_data = $this->Master_Model->get_fetch_array('users',['mobile_number' => $mobile_number, 'password' => $password]);
			// print_r($user_data);exit;

			$session_data = array(
				'mobile_number' =>$user_data[0]['mobile_number'],
				'username' => $user_data[0]['username'],
				'full_name' => $user_data[0]['full_name'],
				'usertype_id' => $user_data[0]['usertype_id'],
				'designation' => $user_data[0]['designation'],
				'user_id' => $user_data[0]['id']
			);

			$this->session->set_userdata($session_data);
			// print_r($_SESSION);exit;
			redirect('admin_panel/Dashboard');
		}
		else
		{
			redirect('Login');
		}
	}

	
}
