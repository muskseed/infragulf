<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_details extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

    public function property($property_id = ''){
        // pre($property_id);
        $data = [];
        if(!empty($property_id)){
            $fetch_data = $this->db->query('SELECT * FROM product_master WHERE id ="'.$property_id.'"')->result_array();
            if(!empty($fetch_data)){
                $fetch_data = $fetch_data[0];

                $image_data = $this->db->query('SELECT id , image_name FROM product_images WHERE product_master_id ="'.$fetch_data['id'].'"')->result_array();

                $region_data = $this->db->query('SELECT name FROM region WHERE id="'.$fetch_data['region'].'"')->result_array();
                $property_type = $this->db->query('SELECT property_name FROM property_type WHERE id="'.$fetch_data['property_type'].'"')->result_array();
                $agent_data = $this->db->query('SELECT * FROM team WHERE id="'.$fetch_data['agent_id'].'"')->result_array();
                $project_feature = $this->db->query('SELECT name FROM project_feature WHERE id IN('.$fetch_data['project_feature'].')')->result_array();
                $amenities_include = $this->db->query('SELECT name FROM amenities WHERE id IN('.$fetch_data['amenities_include'].')')->result_array();
                // pre($project_feature);die;

                $data['project_feature'] = $project_feature;
                $data['amenities_include'] = $amenities_include;
                $data['agent_data'] = $agent_data;
                $data['property_type'] = $property_type;
                $data['region_data'] = $region_data;
                $data['image_data'] = $image_data;
                $data['fetch_data'] = $fetch_data;
                // pre($data);die;
                $this->load->view('product_details' , $data);
            }else{
                redirect('home');
            }
        }else{
            redirect('home');
        }
    }
}