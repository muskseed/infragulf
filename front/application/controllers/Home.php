<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		// pre($_SESSION);die;
		$data = [];
		$buy_data = $this->fetch_data('buy');
		$rent_data = $this->fetch_data('rent');

		$client_reviews = $this->db->query('SELECT * FROM client_reviews ORDER BY id DESC LIMIT 3')->result_array();

		$experts = $this->db->query('SELECT * FROM team ORDER BY position ASC')->result_array();

		$off_plan = $this->db->query('SELECT * FROM off_plan ORDER BY position ASC LIMIT 6')->result_array();

		$offer_plan_image_data = $this->db->query('SELECT product_master_id , image_name FROM off_plan_images WHERE featured_image = 1')->result_array();
		$offer_data_arr = [];
		foreach($offer_plan_image_data AS $value){
			$offer_data_arr[$value['product_master_id']] = $value['image_name'];
		}

		$off_plan_data = [];
		foreach($off_plan AS $o_value){
			$off_plan_data[] = [
				'id' => $o_value['id'],
				'image_name' => $offer_data_arr[$o_value['id']]
			];
		}

		$data['experts'] = $experts;
		$data['client_reviews'] = $client_reviews;
		$data['buy_data'] = $buy_data;
		$data['rent_data'] = $rent_data;
		$data['off_plan'] = $off_plan_data;
		// pre($data);die;
		$this->load->view('home' , $data);
	}

	public function fetch_data($business_type){
		$product_data = $this->db->query('SELECT * FROM product_master WHERE business_type = "'.$business_type.'" ORDER BY id DESC LIMIT 6')->result_array();
		// pre($product_data);die;

		$return_data = [];
		if(!empty($product_data)){
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

			foreach($product_data AS $key => $value){
				$return_data[] = [
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
		// pre($return_data);die;
		return $return_data;
	}

	public function register(){
		$data = [];
		$postdata = $this->input->post();
		// pre($postdata);
		if(!empty($postdata['name_modal']) && !empty($postdata['email_modal']) && $postdata['mobile_modal']){
			$insert_array = [
				'name' => $postdata['name_modal'],
				'email' => $postdata['email_modal'],
				'mobile' => $postdata['mobile_modal'],
				'created' => date('Y-m-d H:i:s')
			];

			$this->db->insert('registration',$insert_array);

			$the_session = array("form_session" => "1");
			$this->session->set_userdata($the_session);

			$data = array('status' => 'success' ,'msg' => 'Request send successfully to team' , 'data' => '');
		}else{
			$data = array('status' => 'error' , 'msg' => 'Please enter all details' , 'data' => '');
		}
		echo json_encode($data);
	}

	public function destroy_session(){
		session_destroy();
		redirect('home');
	}

	public function search_property(){
		$html = '';
		$postdata = $this->input->post();
		// pre($postdata);
		if(!empty($postdata['search'])){
			$fetch_data = $this->db->query('SELECT id , property_title FROM product_master WHERE property_title LIKE "%'.$postdata['search'].'%" OR area LIKE "%'.$postdata['search'].'%" LIMIT 10')->result_array();
			// pre($fetch_data);die;
			if(!empty($fetch_data)){
				$html .= '<ul class="search-list">';
				foreach($fetch_data AS $value){
					$html .='
						<li>
						<a href="'.base_url().'product_details/property/'.$value['id'].'" class="flex-wrap"><img src="'. BASE_URL.'assets/images/gray-search.svg"> <span class="ml-1">'.$value['property_title'].'</span></a>
						</li>
					';
				}
				$html .= '</ul>';
			}else{
				$html = '<ul class="search-list">
					<li>
					<a href="#" class="flex-wrap"><img src="'. BASE_URL.'assets/images/gray-search.svg"> <span class="ml-1">No Property found</span></a>
					</li>
				</ul>';
			}
		}else{
			$html = '<ul class="search-list">
			<li>
			  <a href="#" class="flex-wrap"><img src="'. BASE_URL.'assets/images/gray-search.svg"> <span class="ml-1">No Property found</span></a>
			</li>
		  </ul>';
		}
		echo $html;
	}

	public function about_agent($id){
		$data = [];

		$team_data = $this->db->query('SELECT * FROM team WHERE id= "'.$id.'"')->result_array();
		$data['team_data'] = $team_data;
		
		$this->load->view('about-agent' , $data);
	}
}
