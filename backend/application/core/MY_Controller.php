<?php
defined('BASEPATH') OR exit('No direct script access allowed');
   
 class MY_Controller extends CI_Controller
 {
 	protected $system_module = '';
 	function __construct()
	{
		parent::__construct();
		$this->load->library('Compress');
	}

	
    public function upload_product_images($files_data){
        // pre($files);die;
		$return_data = [];
		$random = rand(100,1000);
		$file_path = getcwd().'/public/backend/product_images/';

		$output = '';
		$config['upload_path']          = $file_path;
		$config['allowed_types']        = 'gif|jpg|png|jpeg'; 
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		
		$_FILES["file"]["name"] = $files_data["file"]["name"];
		
		$_FILES["file"]["name"] = str_replace(' ', '_', $files_data["file"]["name"]);
		$_FILES["file"]["type"] = $files_data["file"]["type"];
		$_FILES["file"]["tmp_name"] = $files_data["file"]["tmp_name"];
		$_FILES["file"]["error"] = $files_data["file"]["error"];
		$_FILES["file"]["size"] = $files_data["file"]["size"];
		// pre($_FILES);exit;
		if($this->upload->do_upload('file')){
			$compress = new Compress();

			$data = $this->upload->data();
			// pre($data);exit;
			
			$zfile = getcwd().'/public/backend/product_images/'.$data['file_name']; // get file path
			chmod($zfile,0777); // CHMOD file
			
			// new Code Start//
			// New Code End //
			$file = getcwd().'/public/backend/product_images/'.$data['file_name'];

			// New Code start // 
			// New Code End // 
			$new_name_image = 'new_'.$random.$data['file_name'];

			$new_img_name = $new_name_image;
			$quality = 90; // Value that I chose
			$destination_large = base_url().'public/backend/product_images/zoom_image'; 
			$destination_thumb = base_url().'public/backend/product_images/thumb_image'; 
			$destination_small = base_url().'public/backend/product_images/small_image'; 
			
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
				$return_data = array('status' => 'error' , 'msg' => $this->compress->display_errors() , 'data' => '');
				return $return_data;
			}
			else{
				if(isset($file) && !empty($file))
				{
					$image_delete = getcwd().'/public/backend/product_images/'.$data['file_name'];
					unlink($image_delete);
				}
				$return_data = array('status' => 'success' , 'msg' => 'Image upload successfully' , 'data' => $new_name_image);
				return $return_data;
			}  	
		}else{
			$return_data = array('status' => 'error' , 'msg' => $this->upload->display_errors() , 'data' => '');
			return $return_data;
		}
    }

	public function insert_logs($post){
        $type = isset($post['type']) && !empty($post['type']) ? $post['type'] : 'NA';
        $module = isset($post['module']) && !empty($post['module']) ? $post['module'] : 'NA';
        $description = isset($post['description']) && !empty($post['description']) ? $post['description'] : 'NA';
        $ip = isset($post['ip']) && !empty($post['ip']) ? $post['ip'] : $_SERVER['REMOTE_ADDR'];
        $user_agent = isset($post['user_agent']) && !empty($post['user_agent']) ? $post['user_agent'] : $_SERVER['HTTP_USER_AGENT'];
        $created = date('Y-m-d h:i:s');

        $insert_data = [
            'type' => $type,
            'module' => $module,
            'description' => $description,
            'ip' => $ip,
            'user_agent' => $user_agent,
            'created' => $created,
        ];

        $this->db->insert('system_panel_logs',$insert_data);
    }

	

	public function file_logs($data){
		$content = "Request data :" . json_encode($data) . " ";
    	if(file_exists($_SERVER['DOCUMENT_ROOT'] . "/public/logs/".date('Y-m-d').".txt")){
    		$mode = 'a';
    	}else{
    		$mode = 'wb';
    	}
    	//echo $mode;
	    $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/public/logs/".date('Y-m-d').".txt",$mode);
	    fwrite($fp,$content);
	    fclose($fp);
	}
}