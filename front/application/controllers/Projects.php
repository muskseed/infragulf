<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class projects extends CI_Controller {

	public function index()
	{
		$data = []; 
		$projects_data = $this->db->query('SELECT * FROM off_plan ORDER BY position ASC')->result_array();
		$image_name = $this->db->query('SELECT * FROM off_plan_images')->result_array();
		$image_data = [];
		if(!empty($image_name)){
			foreach($image_name AS $i_key => $i_value){
				$image_data[$i_value['product_master_id']] = $i_value['image_name'];
			}
		}

		$final_data = [];
		foreach($projects_data AS $key => $value){
			$final_data[] = [
				'id' => $value['id'],
				'price' => $value['price'],
				'project_status' => $value['status'],
				'location' => $value['area'],
				'property_title' => $value['property_title'],
				'image_name' => $image_data[$value['id']]
			];
		}
		$data['final_data'] = $final_data;
		$this->load->view('projects' , $data);
	}
}
