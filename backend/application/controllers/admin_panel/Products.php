<?php
defined('BASEPATH') OR exit('No direct script access allowed');
   
 class Products extends CI_Controller
 {
 	protected $system_module = '';
 	function __construct()
	{
		parent::__construct();
		$this->load->library('Bitcoin_Library');
		$this->system_module = $this->bitcoin_library->check_access_perm($this->session->userdata('usertype_id'),'Products',$this->uri->segment(4));
		$this->load->model('Master_Model');
		$this->load->library('image_lib');
        $this->load->library('Compress');
        $this->load->model('Gg_model','gg');
	}

	public function index()
	{
		$data = [];
		$data['access_permission'] = $this->system_module;
		$this->load->view('admin_panel/products_master/products_list',$data);
	}

	public function frontend_view($mode='',$id='')
	{
		$data = [];
		$data['access_permission'] = $this->system_module;
		$data['mode'] = $mode;

		$property_type = $this->db->query('SELECT id , property_name FROM property_type')->result_array();
		$data['property_type'] = $property_type;

		$region = $this->db->query('SELECT id , name FROM region')->result_array();
		$data['region'] = $region;

		$project_feature = $this->db->query('SELECT id , name FROM project_feature')->result_array();
		$data['project_feature'] = $project_feature;

		$amenities = $this->db->query('SELECT id , name FROM amenities')->result_array();
		$data['amenities'] = $amenities;

		$team = $this->db->query('SELECT id , name FROM team')->result_array();
		$data['team'] = $team;

		if($this->system_module['add_access']==1 && $mode=='add')
		{
			$this->load->view('admin_panel/products_master/products_form', $data);
		}
		else if($this->system_module['view_access']==1 && $mode=='edit')
        {
            $edit_data = $this->Master_Model->get_onerecord('product_master',$id);
            $data['edit_data'] = $edit_data;

           	$this->load->view('admin_panel/products_master/products_form',$data);
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

		if(!empty($postdata['business_type'])){
	    	// echo 'die';die();
	    	$where_data .= ' business_type = "'.$postdata['business_type'].'" AND ';
		}
		// pre($where_data);die;
		$where_data = preg_replace('/\W\w+\s*(\W*)$/', '$1', $where_data);
		
	    $list_value = $this->db->query('SELECT * FROM product_master WHERE delete_flag = 1 AND '.$where_data.' ORDER BY id  DESC');

	    $list_data = $list_value->result_array();
	   
		$param = [];
		$param['env'] = 'gg';
		$param['select_data'] = 'id,image_name , product_master_id';
		$param['table_name'] ='product_images';
		$param['where'] = TRUE;
		$param['where_escape'] = FALSE;
		$param['where_data'] = array('featured_image' => 1);
		$param['return_array'] = TRUE;

		$image_name = $this->gg->get_table_data_with_type($param);
		$image_data = [];
		if(!empty($image_name)){
			foreach($image_name AS $i_key => $i_value){
				$image_data[$i_value['product_master_id']] = $i_value['image_name'];
			}
		}

		$param = [];
		$param['env'] = 'gg';
		$param['select_data'] = 'id,name';
		$param['table_name'] ='region';
		$param['return_array'] = TRUE;
		$region_data = $this->gg->get_table_data_with_type($param);

		$region_arr = [];
		if(!empty($region_data)){
			foreach($region_data AS $r_key => $r_value){
				$region_arr[$r_value['id']] = $r_value['name'];
			}
		}

	    foreach ($list_data as $key => $value) {
	    	$created = date('d-m-Y', strtotime($value['created']));
	    	$data[] = array(
	    			'<input type="checkbox" class="check_id" name="check_id" value="'.$value['id'].'">',
	    			$value['property_title'],
	    			$value['price'],
	    			$value['area_sqft'],
	    			$value['area'],
	    			$region_arr[$value['region']],
	    			'<img src="'.BASE_URL.PRODUCT_SMALL_IMAGE.$image_data[$value['id']].'" width="100" height="100">',
	    			$created,
                    '<a href="'.base_url().'admin_panel/Products/frontend_view/edit/'.$value['id'].'"> <button type="button" class="btn btn-primary">EDIT</button></a>
                    '.anchor("admin_panel/Products/delete/".$value['id'],"DELETE",array('onclick' => "return confirm('Do you want delete this record')" , 'class' => 'btn btn-danger')).'
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
		$project_feature = implode(',' ,$postdata['project_feature']);
		$amenities_include = implode(',' ,$postdata['amenities_include']);
		$product_data = [
			'business_type' => $postdata['business_type'],
			'property_type'	=> $postdata['property_type'],
			'price'	=> $postdata['price'],
			'area' => $postdata['area'],
			'property_title' => $postdata['property_title'],
			'price_sq_ft' => $postdata['price_sq_ft'],
			'rera_no' => $postdata['rera_no'],
			'ref_no' => $postdata['ref_no'],
			'furnishing' => $postdata['furnishing'],
			'project_feature' => $project_feature,
			'amenities_include' => $amenities_include,
			'area_sqft' => $postdata['area_sqft'],
			'bedroom' => $postdata['bedroom'],
			'bath' => $postdata['bath'],
			'agent_id' => $postdata['agent_id'],
			'description' => $postdata['description'],
			'region' => $postdata['region'],
			'maps' => $postdata['maps'],
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

			$success = $this->Master_Model->do_update('product_master',$id,$final_data);
		}
		else
		{
			$push_array =  array(
				'created_by' => $this->session->userdata('username'),
				'created' => date('Y-m-d H:i:s')
			);
			$final_data = array_merge($product_data, $push_array);
			// print_r($final_data);exit;
			
			$success = $this->db->insert('product_master',$final_data);
			$insert_id = $this->db->insert_id();
		}
		$form_type = $postdata['submit_type'];
     	if($success)
     	{
     		$this->session->set_flashdata('success', 'yes');
     		if($insert_id){
				$url = 'admin_panel/Products/frontend_view/edit/'.$insert_id;
				redirect($url);
     		}
			else
				redirect('admin_panel/Products');
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
		$param['select_data'] = 'id,product_master_id as product_id,image_name,featured_image';
		$param['table_name'] ='product_images';
		$param['where'] = TRUE;
		$param['where_escape'] = FALSE;
		$param['where_data'] = array('product_master_id' => $id);
		$param['return_array'] = TRUE;

		$image_name = $this->gg->get_table_data_with_type($param);
		// pre($image_name);exit;
		$data['image_name'] = $image_name;
		$this->load->view('admin_panel/products_master/upload_image',$data);
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
                            'product_master_id' => $post['product_id'],
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
            $success = $this->db->insert_batch('product_images',$image_data);
        }
        redirect('admin_panel/Products/upload_image/'.$post['product_id']);
	} 

	public function featured_image($product_id,$id){
		// pre($product_id);
		$param = [];
		$param['env'] = 'gg';
		$param['select_data'] = '';
		$param['table_name'] ='product_images';
		$param['where_data'] = array('product_master_id' => $product_id);
		$param['update_data'] = array('featured_image' => 0);

		$this->gg->update_table_data_with_type($param);
		
		$param = [];
		$param['env'] = 'gg';
		$param['select_data'] = '';
		$param['table_name'] ='product_images';
		$param['where_data'] = array('id' => $id);
		$param['update_data'] = array('featured_image' => 1);

		$update = $this->gg->update_table_data_with_type($param);
		redirect('admin_panel/Products/upload_image/'.$product_id);
		
	}

	public function delete_image($id){
		// pre($id);
		$param = [];
		$param['env'] = 'gg';
		$param['select_data'] = 'id,product_master_id as product_id,image_name,featured_image';
		$param['table_name'] ='product_images';
		$param['where'] = TRUE;
		$param['where_escape'] = FALSE;
		$param['where_data'] = array('id' => $id);
		$param['return_array'] = TRUE;

		$image_data = $this->gg->get_table_data_with_type($param);
		// pre($image_data);exit;
		$param_delete = [];
		$param_delete['env'] = 'gg';
		$param_delete['select_data'] = '';
		$param_delete['table_name'] ='product_images';
		$param_delete['where_data'] = array('id' => $id);

		$success = $this->gg->delete_table_data($param_delete);
		// $success = TRUE;
		if($success){
			$destination_large = getcwd().'/public/backend/product_images/zoom_image/'.$image_data[0]['image_name']; 
            $destination_thumb = getcwd().'/public/backend/product_images/thumb_image/'.$image_data[0]['image_name']; 
            $destination_small = getcwd().'/public/backend/product_images/small_image/'.$image_data[0]['image_name'];
            // pre($destination_large); 
            unlink($destination_large);
            unlink($destination_thumb);
            unlink($destination_small);
            redirect('admin_panel/Products/upload_image/'.$image_data[0]['product_id']);
		}
	}

	public function product_active(){
		$ids = implode(',', $_POST['delete_id']);
		// pre($ids);die();
		$data = [];
		if(!empty($ids)){
			$this->db->query('UPDATE product_master SET product_status = 1 WHERE id IN('.$ids.')');
			// echo $this->db->last_query();die;
			$data = array('status' => 'success','msg' => 'Product status updated successfully','data' => '');
		}else{
			$data = array('status' => 'error','msg' => 'IDs are empty','data' => '');
		}
		echo json_encode($data);
	}

	public function product_deactive(){
		$ids = implode(',', $_POST['delete_id']);
		// pre($ids);die();
		$data = [];
		if(!empty($ids)){
			$this->db->query('UPDATE product_master SET product_status = 0 WHERE id IN('.$ids.')');
			// echo $this->db->last_query();die;
			$data = array('status' => 'success','msg' => 'Product status updated successfully','data' => '');
		}else{
			$data = array('status' => 'error','msg' => 'IDs are empty','data' => '');
		}
		echo json_encode($data);
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

	public function delete_bulk_products(){
		// pre($_POST['delete_id']);die();
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
			$param['table_name'] ='product_master';
			$param['where'] = TRUE;
			$param['where_escape'] = FALSE;
			$param['where_data'] = array('id' => $id);
			$param['return_array'] = TRUE;

			$fetch_data = $this->gg->get_table_data_with_type($param)[0];
			// pre($fetch_data);die();
			if($fetch_data){
				// unset($fetch_data['id']);
				// unset($fetch_data['created']);
				// unset($fetch_data['created_by']);
				// unset($fetch_data['updated']);
				// unset($fetch_data['updated_by']);
				// $insert_array = array('product_id' => $id);
				// $final_array = array_merge($insert_array,$fetch_data);
				

				// $param_ins = [];
				// $param_ins['env'] = 'gg';
				// $param_ins['table_name'] ='product_master_backup';
				// $param_ins['data'] = $final_array;

				// $insert_data = $this->gg->insert_table_data($param_ins);
				// pre($insert_data);die;
				if(1){
					$param_delete = [];
					$param_delete['env'] = 'gg';
					$param_delete['select_data'] = '';
					$param_delete['table_name'] ='product_master';
					$param_delete['where_data'] = array('id' => $id);

					$success = $this->gg->delete_table_data($param_delete);

					$param_delete = [];
					$param_delete['env'] = 'gg';
					$param_delete['select_data'] = '';
					$param_delete['table_name'] ='cart';
					$param_delete['where_data'] = array('product_id' => $id);

					$this->gg->delete_table_data($param_delete);

					$param_delete = [];
					$param_delete['env'] = 'gg';
					$param_delete['select_data'] = '';
					$param_delete['table_name'] ='wishlist';
					$param_delete['where_data'] = array('product_id' => $id);

					$this->gg->delete_table_data($param_delete);

					$param_delete = [];
					$param_delete['env'] = 'gg';
					$param_delete['select_data'] = '';
					$param_delete['table_name'] ='order_details';
					$param_delete['where_data'] = array('product_id' => $id);

					$this->gg->delete_table_data($param_delete);

					$param_delete = [];
					$param_delete['env'] = 'gg';
					$param_delete['select_data'] = '';
					$param_delete['table_name'] ='my_collection_values';
					$param_delete['where_data'] = array('product_inventory_id' => $id);

					$this->gg->delete_table_data($param_delete);

					$param = [];
					$param['env'] = 'gg';
					$param['select_data'] = 'id,product_master_id as product_id,image_name,featured_image';
					$param['table_name'] ='product_images';
					$param['where'] = TRUE;
					$param['where_escape'] = FALSE;
					$param['where_data'] = array('product_master_id' => $id);
					$param['return_array'] = TRUE;

					$image_data = $this->gg->get_table_data_with_type($param);
					// pre($image_data);die();
					if(!empty($image_data)){
						$param_delete = [];
						$param_delete['env'] = 'gg';
						$param_delete['select_data'] = '';
						$param_delete['table_name'] ='product_images';
						$param_delete['where_data'] = array('product_master_id' => $id);

						$this->gg->delete_table_data($param_delete);

						foreach ($image_data as $key => $value) {

							$image_backup[] = [
								'product_id'	=> $value['product_id'],
								'product_images'	=> $value['image_name'],	
							]; 
							$destination_large = getcwd().'/public/backend/product_images/zoom_image/'.$value['image_name'];
				            $destination_thumb = getcwd().'/public/backend/product_images/thumb_image/'.$value['image_name']; 
				            $destination_small = getcwd().'/public/backend/product_images/small_image/'.$value['image_name'];

				            $backup_large = getcwd().'/public/backend/product_images_backup/'.$value['image_name']; 
				            // pre($backup_large);
				            copy($destination_large, $backup_large);
				            
				            unlink($destination_large);
				            unlink($destination_thumb);
				            unlink($destination_small);
						}
						// pre($image_backup);die();
						$this->db->insert_batch('product_image_backup', $image_backup); 
					}
				}
			}
		}
		if(empty($check))
			redirect('admin_panel/Products');
	}

	public function get_code($id){
		if(!empty($id)){
			$param = [];
			$param['env'] = 'gg';
			$param['select_data'] = 'id,short_code';
			$param['table_name'] ='collection';
			$param['where'] = TRUE;
			$param['where_escape'] = FALSE;
			$param['where_data'] = array('id' => $id);
			$param['return_array'] = TRUE;

			$collection = $this->gg->get_table_data_with_type($param);
			// pre($collection);

			$param = [];
			$param['env'] = 'gg';
			$param['select_data'] = 'id';
			$param['table_name'] ='product_master';
			$param['order_by'] = 'id desc';
			$param['limit_data'] ='1';
			$param['limit_start'] ='0';
			$param['return_array'] = TRUE;

			$number = $this->gg->get_table_data_with_type($param);
			// pre($number);
			$sku_code = $collection[0]['short_code'].'_'.$number[0]['id'];
			// pre($sku_code);
			echo $sku_code;
		}
	}

	public function get_worker_code(){
		$worker_id = $_POST['worker_id'];
		$col_sku_code = $_POST['col_sku_code'];

		$param = [];
		$param['env'] = 'gg';
		$param['select_data'] = 'id,worker_name';
		$param['table_name'] ='worker';
		$param['where'] = TRUE;
		$param['where_escape'] = FALSE;
		$param['where_data'] = array('id' => $worker_id);
		$param['return_array'] = TRUE;

		$worker = $this->gg->get_table_data_with_type($param);
		
		$worker_name = $worker[0]['worker_name'];
		$worker_name = substr($worker_name, 0, 2);
		// pre($col_sku_code);
		$worker_code = $col_sku_code.'/'.$worker_name;
		echo $worker_code;
	}

	public function download_qr_file(){
		$fileName = 'product_qr.xlsx';
		$path = getcwd().'/public/backend/qrcode_file/';
		unlink($path . $fileName);
		$ids = implode(',', $_POST['delete_id']);
		// pre($ids);die();
		$data = [];
		if(!empty($ids)){
			$product_data = $this->db->query('SELECT id , manufacturing_code ,gross_wt ,net_wt  , less , amount , melting_id FROM product_master WHERE id IN('.$ids.')')->result_array();
			// pre($product_data);die;

			$melting_data = $this->db->query('SELECT id , melting_name FROM melting')->result_array();
			$melting_arr = [];
			if(!empty($melting_data)){
				foreach($melting_data AS $m_key => $m_value){
					$melting_arr[$m_value['id']] = $m_value['melting_name'];
				}
			}
			$final_data = [];
			foreach($product_data AS $p_key => $p_value){
				$final_data[] = [
					'design_number' => $p_value['manufacturing_code'],
					'gross_wt' => $p_value['gross_wt'],
					'net_wt' => $p_value['net_wt'],
					'less' => $p_value['less'],
					'amount' => $p_value['amount'],
					'melting' => $melting_arr[$p_value['melting_id']],
				];
			}
			// pre($final_data);die;
			// load excel library
			$this->load->library('excel');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->setActiveSheetIndex(0);
			// set Header
			$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'CODE');
			$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'GR. WT');
			$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'LESS.WT');
			$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'NT.WT');
			$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'AMOUNT');
			$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'PURITY');
			// set Row
			$rowCount = 2;
			foreach ($final_data as $element) {
				$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element['design_number']);
				$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['gross_wt']);
				$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['less']);
				$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['net_wt']);
				$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['amount']);
				$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['melting']);
				
				$rowCount++;
			}
			$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			$objWriter->save($path . $fileName);
			// download file
			$data = array('status' => 'success','msg' => 'File Created successfully','data' => '');
			echo json_encode($data);
		}else{
			$data = array('status' => 'error','msg' => 'IDs are empty','data' => '');
			echo json_encode($data);
		}
	}

	public function download_qrcode_file(){
		header("Content-Type: application/vnd.ms-excel");
		redirect(base_url().'/public/backend/qrcode_file/product_qr.xlsx');
	}
 }