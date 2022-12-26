<?php
defined('BASEPATH') OR exit('No direct script access allowed');
   
 class Office_staff extends CI_Controller
 {
 	protected $system_module = '';
 	function __construct()
	{
		parent::__construct();
		$this->load->library('Bitcoin_Library');
		$this->system_module = $this->bitcoin_library->check_access_perm($this->session->userdata('usertype_id'),'Office_staff',$this->uri->segment(4));
        if($_SESSION['usertype_id'] != 1){
		    redirect('admin_panel/Dashboard');
        }
		$this->load->model('Master_Model');
	}

	public function index()
	{
        // pre($_SESSION);die;
		$data = [];
		$data['access_permission'] = $this->system_module;
		$this->load->view('admin_panel/office_staff/staff_list',$data);
	}

	public function frontend_view($mode='',$id='')
	{
		$data = [];
		$data['access_permission'] = $this->system_module;
		$data['mode'] = $mode;
        // pre($data);die;
		if($this->system_module['add_access']==1 && $mode=='add')
		{
			$this->load->view('admin_panel/office_staff/staff_form', $data);
		}
		else if($this->system_module['view_access']==1 && $mode=='edit')
        {
            $data['edit_data'] = $this->Master_Model->get_onerecord('users',$id);
            // print_r($data);exit;   
           	$this->load->view('admin_panel/office_staff/staff_form',$data);
        }
        else
        {
            redirect('backend/Error');
        }
		
	}

	public function frontend_list()
	{
		$data = [];

		$draw = intval($this->input->get("draw"));
	    $start = intval($this->input->get("start"));
	    $length = intval($this->input->get("length"));

	    $brand_data = $this->db->query('SELECT * FROM users WHERE usertype_id != 1')->result_array();
	    // print_r($user_data);exit;
	    foreach ($brand_data as $key => $value) {
	    	$data[] = array(
	    			'<input type="checkbox" class="check_id" name="check_id" value="'.$value['id'].'">',
	    			$value['full_name'],
	    			$value['email_id'],
	    			$value['mobile_number'],
	    			$value['designation'],
                    '<a href="'.base_url().'admin_panel/office_staff/frontend_view/edit/'.$value['id'].'"> <button type="button" class="btn btn-primary">EDIT</button></a>
                    <a href="'.base_url().'admin_panel/office_staff/delete/'.$value['id'].'"> <button type="button" class="btn btn-danger">DELETE</button></a>
                    '
               );
	    }

	    $output = array(
               "draw" => $draw,
                 "recordsTotal" => count($brand_data),
                 "recordsFiltered" => count($brand_data),
                 "data" => $data
            );

	    echo json_encode($output);
	}

	public function form_action($id = '')
	{
		$insert_id = 0;
		$postdata = $this->input->post();
		$product_data = [
			'full_name' => $postdata['full_name'],
			'email_id'	=> $postdata['email_id'],
			'mobile_number'	=> $postdata['mobile_number'],
			'password' => $postdata['password'],
			'designation' => $postdata['designation'],
            'usertype_id' => 2,
			'delete_flag' 				=> 1,
		];
		// pre($product_data);exit;
		if($id)
		{
			$push_array =  array(
				'updated_by' => $this->session->userdata('username'),
				'updated' => date('Y-m-d H:i:s')
			);
			$final_data = array_merge($product_data, $push_array);

			$success = $this->Master_Model->do_update('users',$id,$final_data);
		}
		else
		{
			$push_array =  array(
				'created_by' => $this->session->userdata('username'),
				'created' => date('Y-m-d H:i:s')
			);
			$final_data = array_merge($product_data, $push_array);
			// print_r($final_data);exit;
			
			$success = $this->db->insert('users',$final_data);
			$insert_id = $this->db->insert_id();
		}

		redirect('admin_panel/office_staff');
     	
	}

	public function delete($id , $check = ''){
		$this->db->query('DELETE FROM users WHERE id = '.$id.' ');

		if(empty($check))
			redirect('admin_panel/office_staff');
	}

	public function delete_all(){
		$ids = $_POST['delete_id'];
		$data = [];
		if(!empty($ids)){
			foreach ($ids as $key => $value) {
				$this->delete($value,1);
			}
			$data = array('status' => 'success','msg' => 'Team Memeber deleted successfully','data' => '');
		}else{
			$data = array('status' => 'error','msg' => 'IDs are empty','data' => '');
		}
		echo json_encode($data);
	}

 }