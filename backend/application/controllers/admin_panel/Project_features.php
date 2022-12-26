<?php
defined('BASEPATH') OR exit('No direct script access allowed');
   
 class Project_features extends CI_Controller
 {
 	protected $system_module = '';
 	function __construct()
	{
		parent::__construct();
		$this->load->library('Bitcoin_Library');
		$this->system_module = $this->bitcoin_library->check_access_perm($this->session->userdata('usertype_id'),'Project_features',$this->uri->segment(4));
		$this->load->model('Master_Model');
	}

	public function index()
	{
		$data = [];
		$data['access_permission'] = $this->system_module;
		$this->load->view('admin_panel/project_features/list',$data);
	}

	public function frontend_view($mode='',$id='')
	{
		$data = [];
		$data['access_permission'] = $this->system_module;
		$data['mode'] = $mode;
		// print_r($data);exit;

		if($this->system_module['add_access']==1 && $mode=='add')
		{
			$this->load->view('admin_panel/project_features/form', $data);
		}
		else if($this->system_module['view_access']==1 && $mode=='edit')
        {
            $data['form_edit_data'] = $this->Master_Model->get_onerecord('project_feature',$id);
            //print_r($data);exit;   
           	$this->load->view('admin_panel/project_features/form',$data);
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

	    $list_value = $this->Master_Model->get_all_data('project_feature');

	    $list_data = $list_value->result_array();
	    // print_r($user_data);exit;
	    foreach ($list_data as $key => $value) {
	    	$data[] = array(
	    			$value['name'],
                    '<a href="'.base_url().'admin_panel/project_features/frontend_view/edit/'.$value['id'].'"> <button type="button" class="btn btn-primary">EDIT</button></a>'
                    .anchor("admin_panel/project_features/delete/".$value['id'],"DELETE",array('onclick' => "return confirm('Do you want delete this record')" , 'class' => 'btn btn-danger')).'
                    ',
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

	public function form_action($id = '')
	{

		$postdata = $this->input->post();
		// print_r($_FILES);
		// print_r($postdata);exit;
		
		if($id)
		{
			$push_array =  array(
				'updated_by' => $this->session->userdata('username'),
				'updated' => date('Y-m-d H:i:s')
			);
			$final_data = array_merge($postdata, $push_array);

			$success = $this->Master_Model->do_update('project_feature',$id,$final_data);
		}
		else
		{
			$push_array =  array(
				'created_by' => $this->session->userdata('username'),
				'created' => date('Y-m-d H:i:s')
			);
			$final_data = array_merge($postdata, $push_array);
			// print_r($final_data);exit;
			
			$success = $this->db->insert('project_feature',$final_data);
		}

     	if($success)
     	{
     		$this->session->set_flashdata('success', 'yes');
			redirect('admin_panel/project_features');
     	}
     	else if($error)
     	{
     		$this->session->set_flashdata('error', 'no');
			redirect('admin_panel/project_features');
     	}     
	}

    public function delete($id){
        $this->db->query('DELETE FROM project_feature WHERE id="'.$id.'"');
        $this->session->set_flashdata('delete', 'yes');
		redirect('admin_panel/project_features');
    }
}