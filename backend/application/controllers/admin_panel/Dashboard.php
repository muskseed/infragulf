<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
/**
* Dashboard of backend system
*/
class Dashboard extends CI_Controller
{
	protected $system_module = '';

	function __construct()
	{
		parent::__construct();
		$this->load->library('Bitcoin_Library');
		$this->system_module = $this->bitcoin_library->check_access_perm($this->session->userdata('usertype_id'),'Dashboard',$this->uri->segment(4));
		// print_r($this->system_module);exit;
		$this->load->model('Master_Model');
	}

	public function index()
	{
        // pre($_SESSION);die;
		$data = [];
        $count_buy = $this->db->query('SELECT count(id) AS count FROM product_master WHERE business_type ="buy" AND delete_flag = 1')->result_array();
        $data['count_buy'] = $count_buy[0]['count'];

        $count_rent = $this->db->query('SELECT count(id) AS count FROM product_master WHERE business_type ="rent" AND delete_flag = 1')->result_array();
        $data['count_rent'] = $count_rent[0]['count'];

        $sell_leads = $this->db->query('SELECT count(id) AS count FROM sell_registration')->result_array();
        $data['sell_leads'] = $sell_leads[0]['count'];

        $leads = $this->db->query('SELECT count(id) AS count FROM registration')->result_array();
        $data['leads'] = $leads[0]['count'];

		$this->load->view('admin_panel/dashboard/dashboard_page',$data);
	}

    public function logout(){
        $this->session->sess_destroy();
        redirect('Login');
    }

    public function profile()
    {
        $data = [];
        $data['edit_data'] = $this->Master_Model->get_onerecord('users',$_SESSION['user_id']);
        // pre($data);exit;   
        $this->load->view('admin_panel/others/profile',$data);
        
    }

    public function profile_action($id = '')
    {

        $postdata = $this->input->post();
        // pre($_FILES);
        // pre($postdata);exit;
        
        if($id)
        {
            $push_array =  array(
                'updated_by' => $this->session->userdata('username'),
                'updated' => date('Y-m-d H:i:s'),
            );
            $final_data = array_merge($postdata, $push_array);
            // pre($final_data);die;
            $success = $this->Master_Model->do_update('users',$id,$final_data);
        }

        if($success)
        {
            $this->session->set_flashdata('success', '');
            redirect('admin_panel/Dashboard/profile');
        }
        else if($error)
        {
            $this->session->set_flashdata('error', '');
            redirect('admin_panel/Dashboard');
        }     
    }
}
