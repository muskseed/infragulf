<?php
defined('BASEPATH') OR exit('No direct script access allowed');
   
 /**
 * Users Controller of All Users Details
 */
 class Users extends CI_Controller
 {
 	protected $system_module = '';
 	function __construct()
	{
		parent::__construct();
		$this->load->library('Bitcoin_Library');
		$this->system_module = $this->bitcoin_library->check_access_perm($this->session->userdata('usertype_id'),'Users',$this->uri->segment(4));
		// print_r($this->system_module);exit;
		$this->load->model('Master_Model');
		$this->load->model('Gg_model','gg');
		$this->load->library('Sms_Library');
	}

	public function index()
	{
		$data = [];
		date_default_timezone_set('Asia/Kolkata');
		// pre(date('Y-m-d H:i:s'));die;
		$data['access_permission'] = $this->system_module;

		// User Type Role 
		$usertype_data = $this->db->query('SELECT * FROM usertype WHERE id != "1"');
		$data['usertype_data'] = $usertype_data->result_array();

		$this->load->view('admin_panel/users/users_list',$data);
	}

	public function frontend_view($mode='',$id='')
	{
		$data = [];
		$data['access_permission'] = $this->system_module;
		$data['mode'] = $mode;

		// Company Type Details
		$company_type_data = $this->Master_Model->get_all_data('company_type');
		$data['company_type'] = $company_type_data->result_array();

		// User Type Role 
		$usertype_data = $this->db->query('SELECT * FROM usertype WHERE id != "1"');
		$data['usertype_data'] = $usertype_data->result_array();

		// User status 
		$user_status = $this->Master_Model->get_all_data('user_status');
		$data['user_status'] = $user_status->result_array();

		// Delivery Mode
		$delivery_mode = $this->Master_Model->get_all_data('delivery_mode');
		$data['delivery_mode'] = $delivery_mode->result_array();

		if($this->system_module['add_access']==1 && $mode=='add')
		{
			$this->load->view('admin_panel/users/users_form', $data);
		}
		else if($this->system_module['view_access']==1 && $mode=='edit')
        {
            $data['edit_data'] = $this->Master_Model->get_onerecord('users',$id);
            // pre($data);exit;   
           	$this->load->view('admin_panel/users/users_form',$data);
        }
        else
        {
            redirect('backend/Error');
        }
		
	}

	public function frontend_list()
	{
		$data = [];
		$postdata = $this->input->post();
		// pre($postdata);die();
		$draw = intval($this->input->get("draw"));
	    $start = intval($this->input->get("start"));
	    $length = intval($this->input->get("length"));
	    $coll_assign = [0 => 'Not Assign', 1 => 'Assign'];
	    $where_data = '';

	    if(!empty($postdata['from_date']) && !empty($postdata['to_date'])){
	    	// echo 'die';die();
	    	$where_data .= 'date(users.created) >= "'.$postdata['from_date'].'" AND date(users.created) <= "'.$postdata['to_date'].'" AND ';
	    }

	    if(!empty($postdata['user_type'])){
	    	$where_data .= 'usertype_id ='.$postdata['user_type'].' AND ';
	    }

	    $where_data = preg_replace('/\W\w+\s*(\W*)$/', '$1', $where_data);
	    // pre($where_data);die;
	    $user_value = $this->db->query('SELECT users.id, users.full_name,users.mobile_number, users.email_id, usertype.name,users.user_status,users.collection_assign,users.cart_status FROM users,usertype WHERE users.usertype_id= usertype.id AND users.delete_flag = 1 AND users.usertype_id !=1 AND '.$where_data.' ORDER BY users.full_name asc');
	    // echo $this->db->last_query();die();
	    $user_data = $user_value->result_array();
	    // print_r($user_data);exit;
	    foreach ($user_data as $key => $value) {
	    	$cart_status = !empty($value['cart_status']) ? '<i class="glyphicon glyphicon-ok"> Read</i>' : '<i class="fa fa-remove"> Un-Read</i>';
	    	$cart_count = $this->db->query('SELECT count(id) as cnt FROM cart WHERE user_id='.$value['id'])->result_array();
	    	$data[] = array(
	    			'<input type="checkbox" class="check_id" name="check_id" value="'.$value['id'].'">',
	    			$value['full_name'],
                    $value['mobile_number'],
                    $value['email_id'],
                    $value['name'],
                    $value['user_status'],
                    '<a href="'.base_url().'admin_panel/Users/get_cart/'.$value['id'].'">'.$cart_count[0]['cnt'].' <i class="fa fa-eye"></i></a>',
                    $coll_assign[$value['collection_assign']],
                    $cart_status,
                    '<a href="'.base_url().'admin_panel/users/frontend_view/edit/'.$value['id'].'"> <button type="button" class="btn btn-primary">EDIT</button></a>
                    ',
                    anchor("admin_panel/users/delete_user/".$value['id'],"DELETE",array('onclick' => "return confirm('Do you want delete this record')" , 'class' => 'btn btn-danger'))
               );
	    }

	    $output = array(
               "draw" => $draw,
                 "recordsTotal" => $user_value->num_rows(),
                 "recordsFiltered" => $user_value->num_rows(),
                 "data" => $data
            );

	    echo json_encode($output);
	}

	public function unsold_cart(){
		$data = [];
		$data['access_permission'] = $this->system_module;
		$this->load->view('admin_panel/users/unsold_cart_list',$data);
	}

	public function unsold_cart_list()
	{
		$data = [];

		$draw = intval($this->input->get("draw"));
	    $start = intval($this->input->get("start"));
	    $length = intval($this->input->get("length"));
	    $coll_assign = [0 => 'Not Assign', 1 => 'Assign'];

	    $user_value = $this->db->query('SELECT users.id, users.full_name,users.mobile_number, users.email_id, usertype.name,users.user_status,users.collection_assign,users.cart_status FROM users,usertype WHERE users.usertype_id= usertype.id AND users.delete_flag = 1 AND users.usertype_id !=1 ORDER BY users.full_name asc');

	    $user_data = $user_value->result_array();
	    // print_r($user_data);exit;
	    foreach ($user_data as $key => $value) {
	    	$cart_status = !empty($value['cart_status']) ? '<i class="glyphicon glyphicon-ok"> Read</i>' : '<i class="fa fa-remove"> Un-Read</i>';
	    	$cart_count = $this->db->query('SELECT count(id) as cnt FROM cart WHERE user_id='.$value['id'])->result_array();
	    	if(!empty($cart_count[0]['cnt'])){
	    		$data[] = array(
		    			$value['full_name'],
	                    $value['mobile_number'],
	                    $value['email_id'],
	                    $value['user_status'],
	                    '<a href="'.base_url().'admin_panel/Users/get_cart/'.$value['id'].'">'.$cart_count[0]['cnt'].' <i class="fa fa-eye"></i></a>',
	                    '<a href="'.base_url().'admin_panel/Users/get_cart/'.$value['id'].'"> <button type="button" class="btn btn-primary">View</button></a>
	                    <a href="'.base_url().'admin_panel/Users/delete_cart_entry/'.$value['id'].'"> <button type="button" class="btn btn-danger">Delete</button></a>
	                    <a href="'.base_url().'admin_panel/Users/send_unsold_sms/'.$value['id'].'"> <button type="button" class="btn btn-success">SMS</button></a>
	                    '
	            );
	    	}
	    }

	    $output = array(
               "draw" => $draw,
                 "recordsTotal" => $user_value->num_rows(),
                 "recordsFiltered" => $user_value->num_rows(),
                 "data" => $data
            );

	    echo json_encode($output);
	}

	public function get_cart($id){
		$data = [];
		$data['id'] = $id;
		$user_value = $this->db->query('SELECT p.collection_sku_code,c.gross_wt,c.net_wt,c.quantity FROM product_master as p JOIN cart as c ON p.id=c.product_id WHERE c.user_id='.$id);

	    $user_data = $user_value->result_array();
	    // print_r($user_data);exit;
	    $total_gross_weight = 0;
	    $total_net_weight 	= 0;
	    $total_quantity 	= 0;
	    if(!empty($user_data)){
	    	foreach ($user_data as $key => $value) {
		    	$total_gross_weight = $total_gross_weight + $value['gross_wt'];
		    	$total_net_weight	= $total_net_weight + $value['net_wt'];
		    	$total_quantity		= $total_quantity + $value['quantity'];
		    }
	    }
	    $data['total_gross_weight'] = $total_gross_weight;
	    $data['total_net_weight']	= $total_net_weight;
	    $data['total_quantity']		= $total_quantity;
		$this->load->view('admin_panel/users/cart_list',$data);
	}

	public function cart_list_data($id){
		$data = [];
		$this->db->query("UPDATE users SET cart_status = 'read' WHERE id=".$id);
		$draw = intval($this->input->get("draw"));
	    $start = intval($this->input->get("start"));
	    $length = intval($this->input->get("length"));

	    $user_value = $this->db->query('SELECT p.id AS product_id , p.manufacturing_code,c.gross_wt,c.net_wt,c.quantity FROM product_master as p JOIN cart as c ON p.id=c.product_id WHERE c.user_id='.$id);

	    $user_data = $user_value->result_array();
	    // print_r($user_data);exit;
	    if(!empty($user_data)){
	    	foreach ($user_data as $key => $value) {
	    		$image_name = $this->db->query('SELECT image_name FROM product_images WHERE product_master_id='.$value['product_id'])->result_array();
	    		if(!empty($image_name)){
	    			$image = $image_name[0]['image_name'];
	    		}else{
	    			$image = '';
	    		}
		    	$data[] = array(
		    			$value['manufacturing_code'],
	                    $value['gross_wt'],
	                    $value['net_wt'],
	                    $value['quantity'],
	                    '<img src="'.BASE_URL.PRODUCT_SMALL_IMAGE.$image.'" width="100" height="100">',
	               );
		    }
	    }

	    $output = array(
               "draw" => $draw,
                 "recordsTotal" => $user_value->num_rows(),
                 "recordsFiltered" => $user_value->num_rows(),
                 "data" => $data
            );

	    echo json_encode($output);
	}

	public function delete_user($id , $check = ''){
		if(!empty($id)){
			$param_delete = [];
			$param_delete['env'] = 'gg';
			$param_delete['select_data'] = '';
			$param_delete['table_name'] ='users';
			$param_delete['where_data'] = array('id' => $id);
			// $param_delete['print_query_exit'] = TRUE;

			$this->gg->delete_table_data($param_delete);

			if(empty($check))
				redirect('admin_panel/Users');
		}else{
			redirect('admin_panel/Dashboard');
		}
	}

	public function delete_all(){
		$ids = $_POST['delete_id'];
		$data = [];
		if(!empty($ids)){
			foreach ($ids as $key => $value) {
				$this->delete_user($value,1);
			}
			$data = array('status' => 'success','msg' => 'Product deleted successfully','data' => '');
		}else{
			$data = array('status' => 'error','msg' => 'IDs are empty','data' => '');
		}
		echo json_encode($data);
	}

	public function assign_collection($id){
		// pre($id);
		if(!empty($id)){
			$data['tree_view'] = $this->tree_view();
			// pre($data);die;

			$selected = $this->db->query('SELECT c.id,c.col_name FROM collection AS c JOIN user_collection_allocation AS u ON c.id = u.collection_id WHERE u.user_id='.$id)->result_array();
			$selected_data 	= [];
			$select_id 		= [];
			if(!empty($selected)){
				foreach ($selected as $key => $value) {
					$selected_data[] = [
						'text' 	=> $value['col_name'],
						'id'	=> $value['id']
					];

					$select_id[] = [
						$value['id']
					];
				}
			}
			$data['selected_data'] 	= $selected_data;
			$data['select_id'] 		= $select_id;
			$this->load->view('admin_panel/users/assign_order',$data);
		}else{
			redirect('admin_panel/Dashboard');
		}
	}

	public function tree_view()
	{
		$data = [];
		$parent_key = 0; // pass any key of the parent
		$row = $this->db->query('SELECT id, col_name from collection WHERE col_parent_id="'.$parent_key.'"');
		  
		if($row->num_rows() > 0)
		{
			$result = $row->result_array();
			foreach ($result as $key => $value) 
			{
				$data[] = [
					'id' => $value['id'],
					'name' => $value['col_name'],
					'text' => $value['col_name'],
					'items' => $this->category_tree($value['id']),
					'expanded' => true

				];
				// $data[] = $this->category_tree($value['id']);
			}
		}
		else
		{
		  	$data=["id"=>"0","name"=>"No data presnt in list","text"=>"No Data is presnt in list","items"=>[]];
		}
		// pre($data);exit();
		return json_encode(array_values($data),JSON_PRETTY_PRINT);
	}

	public function category_tree($parent_key)
	{
	  $row1 = [];
	  $row = $this->db->query('SELECT id, col_name from collection WHERE col_parent_id="'.$parent_key.'"')->result_array();
	  	foreach($row as $key => $value)
        {
         $id = $value['id'];
         $row1[$key]['id'] = $value['id'];
         $row1[$key]['name'] = $value['col_name'];
         $row1[$key]['text'] = $value['col_name'];
         $row1[$key]['items'] = array_values($this->category_tree($value['id']));
         $row1[$key]['expanded'] = true;
        }
        return $row1;
	 }

	 public function assign_category(){
	 	// pre($_POST);die;
	 	$user_id 	= $_POST['user_id'];
	 	$data 		= $_POST['data'];
	 	if(!empty($user_id) && !empty($data)){
			
			foreach ($data as $key => $value) {
				$assign_col_data[] = [
					'user_id' 		=> $user_id,
					'collection_id' => $value['id'],
					'created' 		=> date('Y-m-d H:i:s'), 
					'updated' 		=> date('Y-m-d H:i:s'),
					'created_by' 	=> $this->session->userdata('username') 
				];
			}
			// pre($assign_col_data);die;
			$param_delete = [];
			$param_delete['env'] = 'gg';
			$param_delete['select_data'] = '';
			$param_delete['table_name'] ='user_collection_allocation';
			$param_delete['where_data'] = array('user_id' => $user_id);
			// $param_delete['print_query_exit'] = TRUE;

			$delete = $this->gg->delete_table_data($param_delete);
			// pre($delete);die;
			$success = $this->db->insert_batch('user_collection_allocation',$assign_col_data);
			if($success){
				$param = [];
				$param['env'] = 'gg';
				$param['select_data'] = '';
				$param['table_name'] ='users';
				$param['where_data'] = array('id' => $id);
				$param['update_data'] = array('collection_assign' => 1);

				$this->gg->update_table_data_with_type($param);
				// redirect('admin_panel/Users');
				// $this->send_assign_col_sms($user_id);

				$param 					= [];
				$param['env']	 		= 'gg';
				$param['select_data'] 	= 'id,gcm_no';
				$param['table_name'] 	='users';
				$param['return_array'] 	= TRUE;
				$param['where'] 		= TRUE;
				$param['where_data'] 	= array('id' => $user_id);

				$get_data = $this->gg->get_table_data_with_type($param);
				// pre($get_data);die;

				$title 				= BRAND_NAME;
				$sub_title 			= 'Category Assign';
	            $registrationIds[0] = $get_data[0]['gcm_no'];
	            $this->sendNotification($title,$sub_title,0,$registrationIds);

				echo '1';
			}
	 	}else{
	 		echo '0';
	 		// redirect('admin_panel/Dashboard');
	 	}		
	 }

	public function assign_collection_old($id){
		// pre($id);
		if(!empty($id)){
			$param = [];
			$param['env'] = 'gg';
			$param['select_data'] = 'id';
			$param['table_name'] ='collection';
			$param['return_array'] = TRUE;

			$collection = $this->gg->get_table_data_with_type($param);
			
			foreach ($collection as $key => $value) {
				$assign_col_data[] = [
					'user_id' => $id,
					'collection_id' => $value['id'],
					'created' => date('Y-m-d H:i:s'), 
					'updated' => date('Y-m-d H:i:s'),
					'created_by' => $this->session->userdata('username') 
				];
			}
			// pre($assign_col_data);die;
			$param_delete = [];
			$param_delete['env'] = 'gg';
			$param_delete['select_data'] = '';
			$param_delete['table_name'] ='user_collection_allocation';
			$param_delete['where_data'] = array('user_id' => $id);
			// $param_delete['print_query_exit'] = TRUE;

			$delete = $this->gg->delete_table_data($param_delete);
			// pre($delete);die;
			$success = $this->db->insert_batch('user_collection_allocation',$assign_col_data);
			if($success){
				$param = [];
				$param['env'] = 'gg';
				$param['select_data'] = '';
				$param['table_name'] ='users';
				$param['where_data'] = array('id' => $id);
				$param['update_data'] = array('collection_assign' => 1);

				$this->gg->update_table_data_with_type($param);
				redirect('admin_panel/Users');
			}
			// pre($assign_col_data);die;
		}else{
			redirect('admin_panel/Dashboard');
		}
	}

	public function form_action($id = '')
	{
		$postdata = $this->input->post();
			if($postdata['user_status_db'] == 'Inactive'){
				if($postdata['user_status'] == 'Active'){
					$sms_data = [
						'mobile_number' => $postdata['mobile_number'],
						'full_name' 	=> $postdata['full_name']
					];

					$this->sent_approved_msg($sms_data);
				}
			}
		// pre($postdata);exit;

			unset($postdata['user_status_db']);
			if($id)
			{
				$push_array =  array(
					'updated_by' => $this->session->userdata('username'),
					'updated' => date('Y-m-d H:i:s')
				);
				$final_data = array_merge($postdata, $push_array);

				$success = $this->Master_Model->do_update('users',$id,$final_data);
				$user_id = $id;
			}
			else
			{
				$push_array =  array(
					'created_by' => $this->session->userdata('username'),
					'created' => date('Y-m-d H:i:s'),
					'delete_flag' => 1
				);
				$final_data = array_merge($postdata, $push_array);
				// print_r($final_data);exit;
				
				$success = $this->db->insert('users',$final_data);
				$user_id = $this->db->insert_id();
			}
			$this->update_user_details($final_data,$user_id);
         	if($success)
         	{
         		$this->session->set_flashdata('success', 'Clients Updated Successfully');
         		if($id){
         			redirect('admin_panel/users');
         		}else{
         			redirect('admin_panel/users/frontend_view/edit/'.$user_id);
         		}
         	}
         	else if($error)
         	{
         		$this->session->set_flashdata('error', 'Something Went Wrong');
				redirect('admin_panel/users');
         	}     
	}

	public function update_user_details($post , $user_id){
		// pre($post);die;
		if($post['company_type_id'] == 2 || $post['company_type_id'] == 3){
			$update_client_data = [
				'login_date'	=> '2025-12-01',
				'login_hours'	=> '1',
				'login_minutes'	=> '1',
				'clock'			=> 'am',
			];

			$this->Master_Model->do_update('users',$user_id,$update_client_data);

			$collection_data = $this->db->query('SELECT * FROM collection')->result_array();
			if(!empty($collection_data)){
				foreach ($collection_data as $key => $value) {
					$assign_col_data[] = [
						'user_id' 		=> $user_id,
						'collection_id' => $value['id'],
						'created' 		=> date('Y-m-d H:i:s'), 
						'updated' 		=> date('Y-m-d H:i:s'),
						'created_by' 	=> $this->session->userdata('username') 
					];
				}
				// pre($assign_col_data);die;
				$param_delete = [];
				$param_delete['env'] = 'gg';
				$param_delete['select_data'] = '';
				$param_delete['table_name'] ='user_collection_allocation';
				$param_delete['where_data'] = array('user_id' => $user_id);
				// $param_delete['print_query_exit'] = TRUE;

				$delete = $this->gg->delete_table_data($param_delete);
				$success = $this->db->insert_batch('user_collection_allocation',$assign_col_data);
				if($success){
					$param = [];
					$param['env'] = 'gg';
					$param['select_data'] = '';
					$param['table_name'] ='users';
					$param['where_data'] = array('id' => $user_id);
					$param['update_data'] = array('collection_assign' => 1);

					$this->gg->update_table_data_with_type($param);
				}
			}
		}
	}

	public function get_records()
    {
		ob_start();
		header("Access-Control-Allow-Origin: *");
		header('Content-Type: application/json');
		try
		{
			if(!isset($_REQUEST['type']) || empty($_REQUEST['type']))
			{
				throw new exception("Type is not set.");
			}

			$type = $_REQUEST['type'];
			if($type=='getCountries')
			{
				$data = $this->getCountries();
			} 

			if($type=='getStates')
			{
				if(!isset($_REQUEST['countryId']) || empty($_REQUEST['countryId']))
				{
					throw new exception("Country Id is not set.");
				}
				$countryId = $_REQUEST['countryId'];
				$data = $this->getStates($countryId);
			}

			if($type=='getCities')
			{
				if(!isset($_REQUEST['stateId']) || empty($_REQUEST['stateId']))
				{
					throw new exception("State Id is not set.");
				}
				$stateId = $_REQUEST['stateId'];
				$data = $this->getCities($stateId);
			}
		}
		catch(Exception $e)
		{
			$data = array('status'=>'error', 'tp'=>0, 'msg'=>$e->getMessage());
		}
		finally
		{
			echo json_encode($data);
		}
		ob_flush();
	}

	public function getCountries()
	{
		try
		{
			$query = "SELECT id, name FROM countries";
			$result = $this->db->query($query)->result_array();
			if(!$result)
			{
				throw new exception("Country not found.");
			}
			$res = array();
			foreach($result as $val)
			{
				$res[$val['id']] = $val['name'];
			}
			$data = array('status'=>'success', 'tp'=>1, 'msg'=>"Countries fetched successfully.", 'result'=>$res);
		}
		catch(Exception $e)
		{
			$data = array('status'=>'error', 'tp'=>0, 'msg'=>$e->getMessage());
		}
		finally
		{
			return $data;
		}
	}

	// Fetch all states list by country id
	public function getStates($countryId)
	{
		try
		{
			$query = "SELECT id, name FROM states WHERE country_id=".$countryId;
			$result = $this->db->query($query)->result_array();
			if(!$result)
			{
				throw new exception("State not found.");
			}
			$res = array();
			foreach($result as $val)
			{
				$res[$val['id']] = $val['name'];
			}
			$data = array('status'=>'success', 'tp'=>1, 'msg'=>"States fetched successfully.", 'result'=>$res);
		} 
		catch(Exception $e)
		{
			$data = array('status'=>'error', 'tp'=>0, 'msg'=>$e->getMessage());
		}
		finally
		{
			return $data;
		}
	}

	public function getCities($stateId)
	{
		try
		{
			$query = "SELECT id, name FROM cities WHERE state_id in(".$stateId.")";
			$result = $this->db->query($query)->result_array();
			if(!$result)
			{
				throw new exception("City not found.");
			}
			$res = array();
			foreach($result as $val)
			{
				$res[$val['id']] = $val['name'];
			}
			$data = array('status'=>'success', 'tp'=>1, 'msg'=>"Cities fetched successfully.", 'result'=>$res);
		}
		catch(Exception $e)
		{
			$data = array('status'=>'error', 'tp'=>0, 'msg'=>$e->getMessage());
		}
		finally
		{
			return $data;
		}
	}

	public function delete_cart_entry($id){
		if(!empty($id)){
			$this->db->query('DELETE FROM cart WHERE user_id='.$id);
			redirect('admin_panel/Users/unsold_cart');
		}
	}

	public function sent_approved_msg($sms_data){
		$mobile_number 	= '91'.$sms_data['mobile_number'];
		$client_name 	= isset($sms_data['full_name']) && !empty($sms_data['full_name']) ? $sms_data['full_name'] : 'Client' ;
		if(isset($mobile_number) && !empty($mobile_number))
		{
			$message = "Dear ".$client_name.",

Your Account is activated Successfully, Please Login and check new designs.

- ".BRAND_NAME."
";

			$data_sms = $this->sms_library->send_sms($mobile_number,$message);
			// pre($data_sms);
		}
	}

	public function send_unsold_sms($id){
		$user_details = $this->db->query('SELECT * FROM users WHERE id='.$id)->result_array();
		if(!empty($user_details)){
			$cart_data = $this->db->query('SELECT id FROM cart WHERE user_id='.$id)->result_array();
			if(!empty($cart_data)){
				$mobile_number = '91'.$user_details[0]['mobile_number'];
				$message 	= 'Dear '.$user_details[0]['full_name'].',

Your Products in Cart, Please check it out.

-'.BRAND_NAME.'
	';
			
			$data_sms = $this->sms_library->send_sms($mobile_number,$message);
			// pre($data_sms);

			$this->session->set_flashdata('sms_sent', 'SMS Sent Successfully');
			redirect('admin_panel/users/unsold_cart');
			}
			redirect('admin_panel/users/unsold_cart');
		}
		redirect('admin_panel/users/unsold_cart');
	}

	public function send_assign_col_sms($id){
		$user_details = $this->db->query('SELECT * FROM users WHERE id='.$id)->result_array();
		if(!empty($user_details)){
				$mobile_number = '91'.$user_details[0]['mobile_number'];
				$message 	= 'Dear '.$user_details[0]['full_name'].',

Category Assign to you, Please check the new design.

-'.BRAND_NAME.'
	';
			
			$data_sms = $this->sms_library->send_sms($mobile_number,$message);
			// pre($data_sms);

			$this->session->set_flashdata('sms_sent', 'SMS Sent Successfully');
		}
	}

	public function sendNotification($title,$subtitle,$order_id,$registrationIds){
	    define( 'API_ACCESS_KEY', 'AAAApofyaCQ:APA91bEg13FDkO8aknkKdqUPsXQq9OniMvzm4ttL5WXWQQ0D20-15dL29r2SNB8uUzVQSLoE_6KXGuYJzph8p49SwkAZSsTyUEh-TzidS3xk1dDnluZWM9my1CgT3Hlc6MA7RxXXNMHv');

	    $ch = curl_init("https://fcm.googleapis.com/fcm/send");

	        //Title of the Notification.
	        $title = $title;

	        //Body of the Notification.
	        $body = $subtitle;

	        //Creating the notification array.
	        $notification = array('title' =>$title , 'text' => $body);
	        foreach ($registrationIds as $key => $value) {
	            $arrayToSend = array('to' => $value,'priority'=>'high','click_action'=>'order_details','data'=>array("title"=>"$title","subtitle"=> "$body","order_id" => "$order_id"));

	        //Generating JSON encoded string form the above array.
	        $json = json_encode($arrayToSend);
	        //Setup headers:
	        $headers = array();
	        $headers[] = 'Content-Type: application/json';
	        $headers[] = 'Authorization: key= AAAApofyaCQ:APA91bEg13FDkO8aknkKdqUPsXQq9OniMvzm4ttL5WXWQQ0D20-15dL29r2SNB8uUzVQSLoE_6KXGuYJzph8p49SwkAZSsTyUEh-TzidS3xk1dDnluZWM9my1CgT3Hlc6MA7RxXXNMHv'; // key here

	        //Setup curl, add headers and post parameters.
	        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
	        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);       

	        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	        //Send the request
	        $response = curl_exec($ch);
	    }

	    // pre($response);
	        //Close request
	    curl_close($ch);
	    //return $result;
	}
 }