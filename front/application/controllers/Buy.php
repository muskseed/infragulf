<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buy extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data = [];

		$region_data = $this->db->query('SELECT id , name FROM region')->result_array();
		$data['region_data'] = $region_data;

		$property_data = $this->db->query('SELECT id , property_name FROM property_type')->result_array();
		$data['property_data'] = $property_data;

		$bed_data = $this->db->query('SELECT distinct(bedroom) AS bedroom FROM product_master ORDER BY bedroom ASC')->result_array();
		$data['bed_data'] = $bed_data;

		$return_data = $this->fetch_buy_data();
		$data['return_data'] = $return_data;
		// pre($data);die;
		$this->load->view('buy' , $data);
	}

	public function fetch_buy_data(){
		// pre($_GET);die;
		$where_data = "business_type = 'buy' AND ";

		if(!empty($_GET['region_call'])){
	    	$where_data .= ' region IN ('.$_GET['region_call'].') AND ';
		}

		if(!empty($_GET['property_call'])){
	    	$where_data .= ' property_type IN ('.$_GET['property_call'].') AND ';
		}

		if(!empty($_GET['bedroom_call'])){
			$bed_call = $_GET['bedroom_call'];
			$bed_call = explode(',',$bed_call);
			$bed_where = '';
			foreach($bed_call AS $b_call){
				$bed_where .= "'".$b_call."',";
			}
			$bed_where = rtrim($bed_where , ",");
	    	$where_data .= ' bedroom IN ('.$bed_where.') AND ';
			// pre($_GET['bedroom_call']);die;
		}

		if(!empty($_GET['price_range'])){
			$price_range = explode(',' , $_GET['price_range']);
			if(in_array('1' , $price_range)){
				$where_data .= ' (price >= 0 AND price <= 10000) OR ';
			}

			if(in_array('2' , $price_range)){
				$where_data .= ' (price >= 10001 AND price <= 20000) OR ';
			}

			if(in_array('3' , $price_range)){
				$where_data .= ' (price >= 20001 AND price <= 30000) OR ';
			}

			if(in_array('4' , $price_range)){
				$where_data .= ' (price >= 30001 AND price <= 40000) OR ';
			}

			if(in_array('5' , $price_range)){
				$where_data .= ' (price >= 40001) OR ';
			}
		}
		// pre($where_data);die;
		$where_data = preg_replace('/\W\w+\s*(\W*)$/', '$1', $where_data);
		
		if($_GET['sort_by'] == 'newest'){
			$order_by = 'id  DESC';
		}else if($_GET['sort_by'] == 'high_low'){
			$order_by = 'price  DESC';
		}else if($_GET['sort_by'] == 'low_high'){
			$order_by = 'price  ASC';
		}else{
			$order_by = 'id  DESC';
		}
	    $list_value = $this->db->query('SELECT * FROM product_master WHERE delete_flag = 1 AND '.$where_data.' ORDER BY '.$order_by);
		// echo $this->db->last_query();die;
	    $list_data = $list_value->result_array();
		// pre($list_data);die;
		$final_data = [];
		if(!empty($list_data)){
			$image_data = $this->db->query('SELECT product_master_id , image_name FROM product_images WHERE featured_image = 1')->result_array();
			$image_arr = [];
			foreach($image_data AS $i_value){
				$image_arr[$i_value['product_master_id']] = $i_value['image_name'];
			}

			$property_type_data = $this->db->query('SELECT id , property_name FROM property_type')->result_array();
			$property_type_arr = [];
			foreach($property_type_data AS $p_value){
				$property_type_arr[$p_value['id']] = $p_value['property_name'];
			}

			foreach($list_data AS $value){
				$final_data[]= [
					'id' => $value['id'],
					'business_type' => $value['business_type'],
					'property_type' => $property_type_arr[$value['property_type']],
					'price' => $value['price'],
					'area' => $value['area'],
					'property_title' => $value['property_title'],
					'area_sqft' => $value['area_sqft'],
					'bedroom' => $value['bedroom'],
					'bath' => $value['bath'],
					'image_name' => $image_arr[$value['id']]
				];
			}
		}
		// pre($final_data);die;
		return $final_data;
	}
}
