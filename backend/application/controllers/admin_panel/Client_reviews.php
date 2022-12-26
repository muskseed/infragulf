<?php
defined('BASEPATH') OR exit('No direct script access allowed');
   
 class Client_reviews extends CI_Controller
 {
 	protected $system_module = '';
 	function __construct()
	{
		parent::__construct();
		$this->load->library('Bitcoin_Library');
		$this->system_module = $this->bitcoin_library->check_access_perm($this->session->userdata('usertype_id'),'Client_reviews',$this->uri->segment(4));
		$this->load->model('Master_Model');
	}

	public function index()
	{
		$data = [];
		$data['access_permission'] = $this->system_module;
		$this->load->view('admin_panel/client_reviews/list',$data);
	}

	public function frontend_view($mode='',$id='')
	{
		$data = [];
		$data['access_permission'] = $this->system_module;
		$data['mode'] = $mode;
        // pre($data);die;
		if($this->system_module['add_access']==1 && $mode=='add')
		{
			$this->load->view('admin_panel/client_reviews/form', $data);
		}
		else if($this->system_module['view_access']==1 && $mode=='edit')
        {
            $data['edit_data'] = $this->Master_Model->get_onerecord('client_reviews',$id);
            // print_r($data);exit;   
           	$this->load->view('admin_panel/client_reviews/form',$data);
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

	    $brand_value = $this->Master_Model->get_all_data('client_reviews');

	    $brand_data = $brand_value->result_array();
	    // print_r($user_data);exit;
	    foreach ($brand_data as $key => $value) {
	    	$data[] = array(
	    			'<input type="checkbox" class="check_id" name="check_id" value="'.$value['id'].'">',
	    			$value['name'],
	    			$value['city'],
	    			$value['review'],
	    			'<img style="width:100px" src ="'.BASE_URL.BANNER_UPLOAD_PATH.$value['image_name'].'"/>',
                    '<a href="'.base_url().'admin_panel/Client_reviews/frontend_view/edit/'.$value['id'].'"> <button type="button" class="btn btn-primary">EDIT</button></a>
                    <a href="'.base_url().'admin_panel/Client_reviews/delete_banner/'.$value['id'].'"> <button type="button" class="btn btn-danger">DELETE</button></a>
                    '
               );
	    }

	    $output = array(
               "draw" => $draw,
                 "recordsTotal" => $brand_value->num_rows(),
                 "recordsFiltered" => $brand_value->num_rows(),
                 "data" => $data
            );

	    echo json_encode($output);
	}

	public function form_action($id = '')
	{

		$postdata = $this->input->post();
		// pre($_FILES);
		// pre($postdata);exit;
		$file_path = './public/backend/brand_banner/';
		if($_FILES['image_name']['name']!="")
    	{
    		$config['upload_path']          = $file_path;
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 100000;
            //print_r($config);exit;
            //$this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('image_name'))
            {
                    $error = array('error' => $this->upload->display_errors());

                    print_r($error);exit;
            }
            else
            {
                    $data = array('upload_data' => $this->upload->data());
            }
            $image_name = $data['upload_data']['file_name'];
            unset($postdata['image_name']);
    	}else{
    		$image_name = $postdata['image_name'];
        	unset($postdata['image_name']);
    	}
		
			if($id)
			{
				$push_array =  array(
					'updated_by' => $this->session->userdata('username'),
					'updated' => date('Y-m-d H:i:s'),
					'image_name' =>$image_name
				);
				$final_data = array_merge($postdata, $push_array);
				// pre($final_data);die;
				$success = $this->Master_Model->do_update('client_reviews',$id,$final_data);
			}
			else
			{
				$push_array =  array(
					'created_by' => $this->session->userdata('username'),
					'created' => date('Y-m-d H:i:s'),
					'image_name' =>$image_name
				);
				$final_data = array_merge($postdata, $push_array);
				// print_r($final_data);exit;
				
				$success = $this->db->insert('client_reviews',$final_data);
			}

         	if($success)
         	{
         		$this->session->set_flashdata('success', '');
				redirect('admin_panel/Client_reviews');
         	}
         	else if($error)
         	{
         		$this->session->set_flashdata('error', '');
				redirect('admin_panel/Client_reviews');
         	}     
	}

	public function delete_banner($id , $check = ''){
		$this->db->query('DELETE FROM client_reviews WHERE id = '.$id.' ');

		if(empty($check))
			redirect('admin_panel/Client_reviews');
	}

	public function delete_all(){
		$ids = $_POST['delete_id'];
		$data = [];
		if(!empty($ids)){
			foreach ($ids as $key => $value) {
				$this->delete_banner($value,1);
			}
			$data = array('status' => 'success','msg' => 'Client Reviews deleted successfully','data' => '');
		}else{
			$data = array('status' => 'error','msg' => 'IDs are empty','data' => '');
		}
		echo json_encode($data);
	}

 }