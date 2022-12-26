<?php
defined('BASEPATH') OR exit('No direct script access allowed');
   
 class Projects extends CI_Controller
 {
 	protected $system_module = '';
 	function __construct()
	{
		parent::__construct();
		$this->load->library('Bitcoin_Library');
		$this->system_module = $this->bitcoin_library->check_access_perm($this->session->userdata('usertype_id'),'Projects',$this->uri->segment(4));
		$this->load->model('Master_Model');
		$this->load->library('image_lib');
        $this->load->library('Compress');
        $this->load->model('Gg_model','gg');
	}

	public function index()
	{
		$data = [];
		$data['access_permission'] = $this->system_module;
		$this->load->view('admin_panel/projects/project_list',$data);
	}

    public function frontend_view($mode='',$id='')
	{
		$data = [];
		$data['access_permission'] = $this->system_module;
		$data['mode'] = $mode;

		if($this->system_module['add_access']==1 && $mode=='add')
		{
			$this->load->view('admin_panel/projects/projects_form', $data);
		}
		else if($this->system_module['view_access']==1 && $mode=='edit')
        {
            $edit_data = $this->Master_Model->get_onerecord('projects',$id);
            $data['edit_data'] = $edit_data;

           	$this->load->view('admin_panel/projects/projects_form',$data);
        }
        else
        {
            redirect('backend/Error');
        }
		
	}

	public function frontend_list()
	{
		ini_set('memory_limit','512M');
		$data = [];

		$draw = intval($this->input->get("draw"));
	    $start = intval($this->input->get("start"));
	    $length = intval($this->input->get("length"));

	    $postdata = $this->input->post();
		// pre($postdata);die;
		$where_data = '';

	    if(!empty($postdata['from_date']) && !empty($postdata['to_date'])){
	    	// echo 'die';die();
	    	$where_data .= 'date(created) >= "'.$postdata['from_date'].'" AND date(created) <= "'.$postdata['to_date'].'" AND ';
	    }

		// pre($where_data);die;
		$where_data = preg_replace('/\W\w+\s*(\W*)$/', '$1', $where_data);
		
	    $list_value = $this->db->query('SELECT * FROM projects WHERE delete_flag = 1 AND '.$where_data.' ORDER BY id  DESC');

	    $list_data = $list_value->result_array();
	   
		$param = [];
		$param['env'] = 'gg';
		$param['select_data'] = 'id,image_name , project_master_id';
		$param['table_name'] ='project_images';
		$param['where'] = TRUE;
		$param['where_escape'] = FALSE;
		$param['where_data'] = array('featured_image' => 1);
		$param['return_array'] = TRUE;

		$image_name = $this->gg->get_table_data_with_type($param);
		$image_data = [];
		if(!empty($image_name)){
			foreach($image_name AS $i_key => $i_value){
				$image_data[$i_value['project_master_id']] = $i_value['image_name'];
			}
		}

	    foreach ($list_data as $key => $value) {
	    	$created = date('d-m-Y', strtotime($value['created']));
	    	$data[] = array(
	    			'<input type="checkbox" class="check_id" name="check_id" value="'.$value['id'].'">',
	    			$value['location'],
	    			$value['price'],
	    			$value['project_status'],
	    			'<img src="'.BASE_URL.PRODUCT_SMALL_IMAGE.$image_data[$value['id']].'" width="100" height="100">',
	    			$created,
                    '<a href="'.base_url().'admin_panel/Projects/frontend_view/edit/'.$value['id'].'"> <button type="button" class="btn btn-primary">EDIT</button></a>
                    '.anchor("admin_panel/Projects/delete/".$value['id'],"DELETE",array('onclick' => "return confirm('Do you want delete this record')" , 'class' => 'btn btn-danger')).'
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
		$insert_id = 0;
		$postdata = $this->input->post();
		$product_data = [
			'price'	=> $postdata['price'],
			'project_status' => $postdata['project_status'],
			'location' => $postdata['location'],
			'delete_flag' 				=> 1,
		];
		// pre($product_data);exit;
		if($id)
		{
			$push_array =  array(
				'updated' => date('Y-m-d H:i:s')
			);
			$final_data = array_merge($product_data, $push_array);

			$success = $this->Master_Model->do_update('projects',$id,$final_data);
		}
		else
		{
			$push_array =  array(
				'created' => date('Y-m-d H:i:s')
			);
			$final_data = array_merge($product_data, $push_array);
			// print_r($final_data);exit;
			
			$success = $this->db->insert('projects',$final_data);
			$insert_id = $this->db->insert_id();
		}
		$form_type = $postdata['submit_type'];
     	if($success)
     	{
     		$this->session->set_flashdata('success', 'yes');
     		if($insert_id){
				$url = 'admin_panel/projects/frontend_view/edit/'.$insert_id;
				redirect($url);
     		}
			else
				redirect('admin_panel/projects');
     	}
     	else if($error)
     	{
     		$this->session->set_flashdata('error', 'no');
			redirect('admin_panel/Dashboard');
     	}     
	}


	public function upload_image($id){
	 	$data = [];
		$data['access_permission'] = $this->system_module;
		$data['id'] = $id;

		$param = [];
		$param['env'] = 'gg';
		$param['select_data'] = 'id,project_master_id as product_id,image_name,featured_image';
		$param['table_name'] ='project_images';
		$param['where'] = TRUE;
		$param['where_escape'] = FALSE;
		$param['where_data'] = array('project_master_id' => $id);
		$param['return_array'] = TRUE;

		$image_name = $this->gg->get_table_data_with_type($param);
		// pre($image_name);exit;
		$data['image_name'] = $image_name;
		$this->load->view('admin_panel/projects/upload_image',$data);
	}

	public function image_upload(){
		ini_set('memory_limit', '1024M');
		$post = $this->input->post();
		$random = rand(100,1000);
        $order_no = $this->uri->segment(3);
        
        $file_path = getcwd().'/public/backend/product_images/';
        // pre($_FILES);exit;
        sleep(3);
        if($_FILES["product_image"]["name"] != ''){
            $output = '';
            $config['upload_path']          = $file_path;
            $config['allowed_types']        = 'gif|jpg|png|jpeg'; 
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            for($count = 0; $count<count($_FILES["product_image"]["name"]); $count++){
                $_FILES["file"]["name"] = $_FILES["product_image"]["name"][$count];
                
                $_FILES["file"]["name"] = str_replace(' ', '_', $_FILES["file"]["name"]);
                $_FILES["file"]["type"] = $_FILES["product_image"]["type"][$count];
                $_FILES["file"]["tmp_name"] = $_FILES["product_image"]["tmp_name"][$count];
                $_FILES["file"]["error"] = $_FILES["product_image"]["error"][$count];
                $_FILES["file"]["size"] = $_FILES["product_image"]["size"][$count];
                if($this->upload->do_upload('file')){

                    $data = $this->upload->data();
                    // pre($data);exit;
                    $zfile = getcwd().'/public/backend/product_images/'.$data['file_name']; // get file path
                    chmod($zfile,0777); // CHMOD file
                    
                    // new Code Start//
                    $file = getcwd().'/public/backend/product_images/'.$data['file_name'];
                    // New Code End //

                    // New Code start // 
                    $new_name_image = 'new_'.$random.$data['file_name'];
                    // New Code End // 

                    $new_img_name = $new_name_image;
                    $quality = 90; // Value that I chose
                    $destination_large = base_url().'public/backend/product_images/zoom_image'; 
                    $destination_thumb = base_url().'public/backend/product_images/thumb_image'; 
                    $destination_small = base_url().'public/backend/product_images/small_image'; 
                    
                    $compress = new Compress();
                    if($data['image_width'] >= 600 && $data['image_height'] >= 600){
                    	$compress->file_url = $file;
	                    $compress->new_name_image = $new_name_image;
	                    $compress->quality = $quality;
	                    $compress->destination = $destination_large;
	                    $compress->width = $data['image_width'];
	                    $compress->height = $data['image_height'];

	                    $result_large = $compress->compress_image();
                    }else{
                    	$compress->file_url = $file;
	                    $compress->new_name_image = $new_name_image;
	                    $compress->quality = $quality;
	                    $compress->destination = $destination_large;
	                    $compress->width = $data['image_width'];
	                    $compress->height = $data['image_height'];

	                    $result_large = $compress->compress_image();
                    }
                    // pre($result_large);die();
                    if($data['image_width'] >= 300 && $data['image_height'] >= 300){
                    	$compress->file_url = $file;
	                    $compress->new_name_image = $new_name_image;
	                    $compress->quality = $quality;
	                    $compress->destination = $destination_thumb;
	                    $compress->width = 300;
	                    $compress->height = 300;

	                    $result_thumb = $compress->compress_image();
                    }else{
                    	$compress->file_url = $file;
	                    $compress->new_name_image = $new_name_image;
	                    $compress->quality = $quality;
	                    $compress->destination = $destination_thumb;
	                    $compress->width = $data['image_width'];
	                    $compress->height = $data['image_height'];

	                    $result_thumb = $compress->compress_image();
                    }
                    
                    if($data['image_width'] >= 150 && $data['image_height'] >= 150){
                    	$compress->file_url = $file;
	                    $compress->new_name_image = $new_name_image;
	                    $compress->quality = $quality;
	                    $compress->destination = $destination_small;
	                    $compress->width = 150;
	                    $compress->height = 150;

	                    $result_small = $compress->compress_image();
                    }else{
                    	$compress->file_url = $file;
	                    $compress->new_name_image = $new_name_image;
	                    $compress->quality = $quality;
	                    $compress->destination = $destination_small;
	                    $compress->width = $data['image_width'];
	                    $compress->height = $data['image_height'];

	                    $result_small = $compress->compress_image();
                    }
                    
                    if(sizeof($result_small) < 0){
                    echo $this->compress->display_errors();exit;
                    }
                    else{
                    if(isset($file) && !empty($file))
                        {
                            $image_delete = getcwd().'/public/backend/product_images/'.$data['file_name'];
                            unlink($image_delete);
                        }
                        //echo json_encode($new_img_name);
                        // database entry comes here
                        $image_data[] = [
                            'project_master_id' => $post['product_id'],
                            'image_name' => $new_img_name
                        ];
                    }

                $random++;    	
                }else{
                	// echo "enter";
                	echo $this->upload->display_errors();
                	die();
                }
            }
            $success = $this->db->insert_batch('project_images',$image_data);
        }
        redirect('admin_panel/Projects/upload_image/'.$post['product_id']);
	} 

	public function featured_image($product_id,$id){
		// pre($product_id);
		$param = [];
		$param['env'] = 'gg';
		$param['select_data'] = '';
		$param['table_name'] ='project_images';
		$param['where_data'] = array('project_master_id' => $product_id);
		$param['update_data'] = array('featured_image' => 0);

		$this->gg->update_table_data_with_type($param);
		
		$param = [];
		$param['env'] = 'gg';
		$param['select_data'] = '';
		$param['table_name'] ='project_images';
		$param['where_data'] = array('id' => $id);
		$param['update_data'] = array('featured_image' => 1);

		$update = $this->gg->update_table_data_with_type($param);
		redirect('admin_panel/Projects/upload_image/'.$product_id);
		
	}


    public function delete_all_products(){
		$ids = $_POST['delete_id'];
		$data = [];
		if(!empty($ids)){
			foreach ($ids as $key => $value) {
				$this->delete($value,1);
			}
			$data = array('status' => 'success','msg' => 'Product deleted successfully','data' => '');
		}else{
			$data = array('status' => 'error','msg' => 'IDs are empty','data' => '');
		}
		echo json_encode($data);
	}

    public function delete($id,$check = ''){
		// echo $id;die;
		if(!empty($id)){
			$param = [];
			$param['env'] = 'gg';
			$param['select_data'] = '*';
			$param['table_name'] ='projects';
			$param['where'] = TRUE;
			$param['where_escape'] = FALSE;
			$param['where_data'] = array('id' => $id);
			$param['return_array'] = TRUE;

			$fetch_data = $this->gg->get_table_data_with_type($param)[0];
			// pre($fetch_data);die();
			if($fetch_data){
				
                $param_delete = [];
                $param_delete['env'] = 'gg';
                $param_delete['select_data'] = '';
                $param_delete['table_name'] ='project_images';
                $param_delete['where_data'] = array('project_master_id' => $id);

                $success = $this->gg->delete_table_data($param_delete);

                $param_delete = [];
                $param_delete['env'] = 'gg';
                $param_delete['select_data'] = '';
                $param_delete['table_name'] ='projects';
                $param_delete['where_data'] = array('id' => $id);

                $success = $this->gg->delete_table_data($param_delete);

                $param = [];
                $param['env'] = 'gg';
                $param['select_data'] = 'id,project_master_id as product_id,image_name,featured_image';
                $param['table_name'] ='project_images';
                $param['where'] = TRUE;
                $param['where_escape'] = FALSE;
                $param['where_data'] = array('project_master_id' => $id);
                $param['return_array'] = TRUE;

                $image_data = $this->gg->get_table_data_with_type($param);
                // pre($image_data);die();
                if(!empty($image_data)){
                    $param_delete = [];
                    $param_delete['env'] = 'gg';
                    $param_delete['select_data'] = '';
                    $param_delete['table_name'] ='project_images';
                    $param_delete['where_data'] = array('project_master_id' => $id);

                    $this->gg->delete_table_data($param_delete);

                    foreach ($image_data as $key => $value) {

                        $destination_large = getcwd().'/public/backend/product_images/zoom_image/'.$value['image_name'];
                        $destination_thumb = getcwd().'/public/backend/product_images/thumb_image/'.$value['image_name']; 
                        $destination_small = getcwd().'/public/backend/product_images/small_image/'.$value['image_name'];
                        
                        unlink($destination_large);
                        unlink($destination_thumb);
                        unlink($destination_small);
                    }
                }
			}
		}
		if(empty($check))
			redirect('admin_panel/Projects');
	}
}