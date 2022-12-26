<?php

class Bit_Webservice
{
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->model('Master_Model');
		$system_settings = $this->CI->db->get('system_settings')->result_array();
	}

	public function get_single_value($table,$coiumn_name,$id)
	{
		$data = $this->CI->db->select($coiumn_name)->from($table)->where('id',$id)->get()->result_array();
		
		return ((array_key_exists("0",$data)) ? $data[0][$coiumn_name] : "");
	}

	// Fetch user related OR Assigned products ID
	public function user_allocated_product_id($user_id,$table)
	{
        $final_ids = [];
        $ids = [];
        if(!empty($user_id))
        {
			$col_data = $this->CI->db->query('SELECT collection_id from user_collection_allocation WHERE user_id="'.$user_id.'"');

            if($col_data->num_rows() > 0)
            {
                $collection_ids = $col_data->result_array();

                foreach($collection_ids as $key => $value)
                {
                    $final_ids[] = $value['collection_id'];
                }
            }

            $user_products = $this->CI->db->query('SELECT collection_id FROM '.$table.' WHERE id IN (SELECT `product_inventory_id` FROM user_products)');

            if($user_products->num_rows() > 0)
            {
                $user_product_ids = $user_products->result_array();

                foreach ($user_product_ids as $key => $value) 
                {
                    $final_ids[] = $value['collection_id'];
                }
            }

        }
		
        $rich_products = $this->CI->db->query('SELECT collection_id FROM '.$table.' WHERE id IN (SELECT `product_inventory_id` FROM rich_products)');

        if($rich_products->num_rows() > 0)
        {
            $rich_product_ids = $rich_products->result_array();

            foreach ($rich_product_ids as $key => $value) 
            {
                $final_ids[] = $value['collection_id'];
            }
        }

        $final_ids = array_unique($final_ids);

        $ids = array_values($final_ids);

        return $ids;
	}

	public function fetch_normal_mode_type_ids($user_id,$collection_id,$table)
	{
		$images_table = ($table == 'product_master' ? 'product_images' : 'inventory_images');
        $table_id = ($table == 'product_master' ? 'product_master_id' : 'inventory_master_id');

        $data[0] = [];

        if ($table == 'product_master')
        {
        	$allocation_ids 	= [];

        	if ($user_id != '' || $user_id != '0')
        	{
        		$get_client_access = $this->check_access($user_id);
        		// pre($get_client_access);die;
        		if($get_client_access == 1){
        			$check_allocation_id = $this->CI->db->select('collection_id')->get_where('user_collection_allocation',['user_id' => $user_id, 'collection_id' => $collection_id]);

	        		if ($check_allocation_id->num_rows() > 0)
			        {
			            $allocation_ids = $this->CI->db->query('SELECT id AS product_inventory_id FROM '.$table.' WHERE collection_id = "'.$collection_id.'"');

			            if ($allocation_ids->num_rows() > 0){
			                $allocation_ids = $allocation_ids->result_array();
			            }else{
			                unset($allocation_ids);
			                $allocation_ids = [];
			            }
			        }else{
			            $allocation_ids = $this->CI->db->query('SELECT id AS product_inventory_id FROM '.$table.' WHERE collection_id = "'.$collection_id.'" limit 10');

			            if ($allocation_ids->num_rows() > 0){
			                $allocation_ids = $allocation_ids->result_array();
			            }else{
			                unset($allocation_ids);
			                $allocation_ids = [];
			            }
			        }
        		}else{
        			$allocation_ids = $this->CI->db->query('SELECT id AS product_inventory_id FROM '.$table.' WHERE collection_id = "'.$collection_id.'" limit 10');

		            if ($allocation_ids->num_rows() > 0){
		                $allocation_ids = $allocation_ids->result_array();
		            }else{
		                unset($allocation_ids);
		                $allocation_ids = [];
		            }
        		}
        	}        
	        
	        $ids = $allocation_ids;

	        $ids = array_column($ids, 'product_inventory_id');
	        $data[0] = array_unique($ids);
        }else if($table == 'inventory_master'){
        	$check_allocation_id = $this->CI->db->select('collection_id')->get_where('user_collection_allocation',['user_id' => $user_id, 'collection_id' => $collection_id]);

        	if ($check_allocation_id->num_rows() > 0)
	        {
	            $allocation_ids = $this->CI->db->query('SELECT id AS product_inventory_id FROM '.$table.' WHERE collection_id = "'.$collection_id.'"');

	            if ($allocation_ids->num_rows() > 0)
	            {
	                $allocation_ids = $allocation_ids->result_array();
	            }
	            else
	            {
	                unset($allocation_ids);
	                $allocation_ids = [];
	            }
	        }
	        else
	        {
	            unset($allocation_ids);
	            $allocation_ids = [];
	        }

	        $ids = array_column($allocation_ids, 'product_inventory_id');
	        $data[0] = array_unique($ids);
        }
        return $data[0];
	}

	public function check_access($user_id){
		$assign_user = 0;
		$get_client_data = $this->CI->db->query('SELECT id , login_date , login_hours , login_minutes , clock FROM users WHERE id='.$user_id)->result_array();
		if(!empty($get_client_data)){
			date_default_timezone_set('Asia/Kolkata');
			$current_date = date('Y-m-d H:i:s');
			// pre($get_client_data);die;
			if(!empty($get_client_data[0]['login_date']) && $get_client_data[0]['login_date'] != '0000-00-00'){
				$login_date = $get_client_data[0]['login_date'];

				if(strlen($get_client_data[0]['login_hours']) == 1){
					$login_hours = '0'.$get_client_data[0]['login_hours'];
				}else{
					$login_hours = $get_client_data[0]['login_hours'];
				}

				if(strlen($get_client_data[0]['login_minutes']) == 1){
					$login_minutes = '0'.$get_client_data[0]['login_minutes'];
				}else{
					$login_minutes = $get_client_data[0]['login_minutes'];
				}

				if($get_client_data[0]['clock'] == 'pm'){
					$login_hours = $login_hours + 12;
				}
				$assign_date = $login_date.' '.$login_hours.':'.$login_minutes.':00';
				// pre($current_date);pre($assign_date);die;
				if($assign_date > $current_date){
					$assign_user = 1;
				}
			}
		}
		return $assign_user;
	}

	// Without Login fetch grids
	public function fetch_normal_mode_type_ids_login($collection_id,$table)
	{
		$images_table = ($table == 'product_master' ? 'product_images' : 'inventory_images');
        $table_id = ($table == 'product_master' ? 'product_master_id' : 'inventory_master_id');

        $data[0] = [];

        if ($table == 'product_master')
        {
        	$allocation_ids = [];
        	$user_product_ids = [];
        	$rich_product_ids = [];

        	
    		$check_allocation_id = $this->CI->db->select('id')->get_where('collection',['id' => $collection_id]);

    		if ($check_allocation_id->num_rows() > 0)
	        {
	            $allocation_ids = $this->CI->db->query('SELECT id AS product_inventory_id FROM '.$table.' WHERE collection_id = "'.$collection_id.'"');

	            if ($allocation_ids->num_rows() > 0)
	            {
	                $allocation_ids = $allocation_ids->result_array();
	            }
	            else
	            {
	                unset($allocation_ids);
	                $allocation_ids = [];
	            }
	        }
	        else
	        {
	            unset($allocation_ids);
	            $allocation_ids = [];
	        }

	        // User Assign Products

	        $user_product_ids = $this->CI->db->query('SELECT product_inventory_id FROM user_products WHERE product_inventory_id IN (SELECT id FROM '.$table.' WHERE collection_id = "'.$collection_id.'")');

	        if ($user_product_ids->num_rows() > 0)
	        {
	            $user_product_ids = $user_product_ids->result_array();
	        }
	        else
	        {
	            $user_product_ids = [];
	        }

        	$rich_product_ids = $this->CI->db->query('SELECT product_inventory_id FROM rich_products WHERE product_inventory_id IN (SELECT id FROM '.$table.' WHERE collection_id = '.$collection_id.')');

	        if ($rich_product_ids->num_rows() > 0)
	        {
	            $rich_product_ids = $rich_product_ids->result_array();
	        }
	        else
	        {
	            $rich_product_ids = [];
	        }	        
	        
	        $ids = array_merge($allocation_ids, $rich_product_ids);
	        $ids = array_merge($ids, $user_product_ids);

	        $ids = array_column($ids, 'product_inventory_id');
	        $data[0] = array_unique($ids);
        }
        return $data[0];
	}

	public function get_my_collection_id($my_collection_id)
	{
		$data = [];
		$product_inventory_id =[];
		$product_id = [];

		$product_inventory_id = $this->CI->db->select('product_inventory_id')->get_where('my_catalogue_values', ['catalogue_id' => $my_collection_id]);

		if($product_inventory_id->num_rows() > 0)
		{
			$product_id = $product_inventory_id->result_array();
		}
		$ids = array_column($product_id, 'product_inventory_id');
		$data[0] = $ids;
		
		return $data[0];
	}

	public function get_grid_data($product_ids, $user_id, $table, $page_no, $record, $mode_type,$sort_by)
	{
		if(!empty($product_ids))
        {
        	$ids = implode(',', $product_ids);
			$images_table = ($table == 'product_master' ? 'product_images' : 'inventory_images');
	        $table_id = ($table == 'product_master' ? 'product_master_id' : 'product_master_id');

	        $data[0] = [];

	        if($sort_by == '0')
			{
				$field = 'sku_code';
				$order = 'DESC';
			}
			else if($sort_by == '1')
			{
				$field = 'sku_code';
				$order = 'ASC';
			}
			else if($sort_by == '2')
			{
				$field = 'gross_wt';
				$order = 'DESC';
			}
			else if($sort_by == '3')
			{
				$field = 'gross_wt';
				$order = 'ASC';
			}
			else if($sort_by == '4')
			{
				$field = 'net_wt';
				$order = 'DESC';
			}
			else if($sort_by == '5')
			{
				$field = 'net_wt';
				$order = 'ASC';
			}else if($sort_by == '6')
			{
				$field = 'id';
				$order = 'DESC';
			}else if($sort_by == '7')
			{
				$field = 'id';
				$order = 'ASC';
			}

	        $start = ($page_no*$record);

	        if($table == 'product_master'){
	        	if(!empty($user_id)){
		        	$get_products = $this->CI->db->query('SELECT id, collection_id ,sku_code, collection_sku_code, manufacturing_code, gross_wt, net_wt, product_name , shape , date(created) AS created , product_status FROM '.$table.' WHERE delete_flag = 1 AND id IN ('.$ids.') ORDER BY '.$field.' '.$order.' LIMIT '.$start.', '.$record.' ');
		        }else{
		        	$get_products = $this->CI->db->query('SELECT id, collection_id ,sku_code, collection_sku_code, manufacturing_code, gross_wt, net_wt, product_name , shape , date(created) AS created  , product_status FROM '.$table.' WHERE delete_flag = 1 AND id IN ('.$ids.') ORDER BY '.$field.' '.$order.' LIMIT 0,20');
		        }
		        
		        // echo $this->CI->db->last_query();exit;
		        if($get_products->num_rows() > 0)
		        {
		        	$get_products = $get_products->result_array();
		        	$count = 1;
		        	foreach ($get_products as $key => $value) 
		        	{
		        		// Get Product Id
		        		$product_master_id = $value['id'];

		        		$image_data = $this->CI->db->query('SELECT image_name FROM product_images WHERE featured_image = 1 AND '.$table_id.'='.$value['id'])->result_array();

		        		$quantity_data = $this->CI->db->query('SELECT quantity FROM cart WHERE user_id = '.$user_id.' AND product_id='.$value['id']. ' AND product_inventory_type="'.$table.'"')->result_array();

		        		$in_cart = $this->check_produt_in_cart_wish($product_master_id, $user_id, 'cart', $table);
						$in_wishlist = $this->check_produt_in_cart_wish($product_master_id, $user_id, 'wishlist', $table);

		        		$image_name = isset($image_data[0]['image_name']) ? $image_data[0]['image_name'] : 'Not Available';

						$stock_arr = ['0' => 'On Order' , '1' => 'In Stock'];
		        		if(!empty($value['product_name'])){
		        			$product_list = ['Code'=> $value['manufacturing_code'],'Gross_Wt'=> $value['gross_wt'], 'Status' => $stock_arr[$value['product_status']] ,'Name' => $value['product_name']];
		        		}else{
							$product_list = ['Code'=> $value['manufacturing_code'],'gross_wt'=> $value['gross_wt'] , 'Status' => $stock_arr[$value['product_status']]];
		        		}
						// $product_list = ['Code'=> $value['manufacturing_code'],'Gross_Wt'=> $value['gross_wt'],'Name' => $value['product_name'] , 'Shape' => $value['shape']];
						
						$label_key = array_keys($product_list);
						$label_value = array_values($product_list);

		        		$data[0]['products'][] = [
		        			'date_no'				=> "$count",
		        			'product_inventory_type'=> $table,
		        			'product_inventory_id' 	=> $value['id'],
		        			'collection_id' 		=> $value['collection_id'],
		        			'collection_sku_code' 	=> $value['collection_sku_code'],
		        			'created' 				=> $value['created'],
		        			'key'					=> $label_key,
		        			'value'					=> $label_value,
		        			'quantity' 				=> isset($quantity_data[0]['quantity']) && !empty($quantity_data[0]['quantity']) ? $quantity_data[0]['quantity'] : "0",
		        			'image_name' 			=> $image_name,
		        			'in_cart' 				=> $in_cart,
		        			'in_wishlist' 			=> $in_wishlist
		        		];
		        		$count++;
		        	}
		        	$final_data = array('ack' => '1' , 'msg' => 'Data fetched successfully' , 'data' => $data[0]);
		        }
		        else
		        {
		        	$final_data = array('ack' => '0' , 'msg' => 'No products found' , 'data' => '');
		        }
	        }else if($table == 'inventory_master'){
	        	if(!empty($user_id)){
		        	$get_products = $this->CI->db->query('SELECT id,product_master_id, sku_code, collection_sku_code, manufacturing_code, gross_wt, net_wt, product_name FROM '.$table.' WHERE id IN ('.$ids.') ORDER BY '.$field.' '.$order.' LIMIT '.$start.', '.$record.' ');
		        }
		        
		        // echo $this->CI->db->last_query();exit;
		        if($get_products->num_rows() > 0)
		        {
		        	$get_products = $get_products->result_array();

		        	foreach ($get_products as $key => $value) 
		        	{
		        		// Get Product Id
		        		$product_master_id = $value['product_master_id'];

		        		$image_data = $this->CI->db->query('SELECT image_name FROM product_images WHERE featured_image = 1 AND '.$table_id.'='.$value['product_master_id'])->result_array();

		        		$quantity_data = $this->CI->db->query('SELECT quantity FROM cart WHERE user_id = '.$user_id.' AND product_id='.$value['id']. ' AND product_inventory_type="'.$table.'"')->result_array();

		        		$in_cart = $this->check_produt_in_cart_wish($product_master_id, $user_id, 'cart', $table);
						$in_wishlist = $this->check_produt_in_cart_wish($product_master_id, $user_id, 'wishlist', $table);

		        		$image_name = isset($image_data[0]['image_name']) ? $image_data[0]['image_name'] : 'Not Available';

		        		$product_list = [
		        			'design_number'	=> $value['manufacturing_code'],
		        			'gross_wt'		=> $value['gross_wt']
		        		];

		        		$label_key = array_keys($product_list);
						$label_value = array_values($product_list);

		        		$data[0]['products'][] = [
		        			'product_inventory_type'=> $table,
		        			'product_inventory_id' 	=> $value['id'],
		        			'key'					=> $label_value,
		        			'value'					=> $label_value,
		        			'image_name' 			=> $image_name,
		        			'in_cart' 				=> $in_cart,
		        			'in_wishlist' 			=> $in_wishlist,
		        			'quantity' 				=> isset($quantity_data[0]['quantity']) && !empty($quantity_data[0]['quantity']) ? $quantity_data[0]['quantity'] : "0",
		        		];
		        	}
		        }
		        else
		        {
		        	$data[0]['error'] = 'No Products found.';
		        }
	        }
	        
	        
	    }else{
        	$final_data = array('ack' => '0' , 'msg' => 'No Products present in this Search.' , 'data' => '');
        }

        return $final_data;
	}

	public function check_produt_in_cart_wish($product_id, $user_id, $cart_wish_table, $master_table)
	{
		if($user_id)
		{
			$check_cart_wish = $this->CI->db->query("SELECT * FROM ".$cart_wish_table." WHERE `user_id` = '".$user_id."' AND `product_inventory_type` = '".$master_table."' AND `product_id` IN(SELECT `id` FROM `product_master` WHERE `id` = '".$product_id."')")->num_rows();
		}
		else
		{
			$check_cart_wish = 0;
		}
		
		return (($check_cart_wish > 0) ? 1 : 0);
	}

	public function get_product_details($product_ids, $user_id, $table, $product_code, $mode_type)
	{
		if(!empty($product_ids))
        {
        	$ids = implode(',', $product_ids);
			$images_table = ($table == 'product_master' ? 'product_images' : 'product_images');
	        $table_id = ($table == 'product_master' ? 'product_master_id' : 'product_master_id');
	        $product_default = [];

	        $data[0] = [];
	        if($table == 'product_master'){
	        	if($mode_type == 'home_products')
		        {
		        	$get_products = $this->CI->db->query('SELECT id, (SELECT col_name FROM collection WHERE collection.id = collection_id) AS collection_name FROM '.$table.' WHERE delete_flag = 1 AND id="'.$product_code.'"');
		        }
		        elseif ($mode_type == 'cart') 
		        {
		        	$product_id = $product_ids[0];
		        	// echo $product_id;exit;
		        	$get_products = $this->CI->db->query('SELECT id, (SELECT col_name FROM collection WHERE collection.id = collection_id) AS collection_name FROM '.$table.' WHERE delete_flag = 1 AND id ="'.$product_id.'"');
		        }else if($mode_type == 'wishlist'){
		        	$product_id = $product_ids[0];
		        	// echo $product_id;exit;
		        	$get_products = $this->CI->db->query('SELECT id, (SELECT col_name FROM collection WHERE collection.id = collection_id) AS collection_name FROM '.$table.' WHERE delete_flag = 1 AND id ="'.$product_id.'"');
		        }else{
		        	$get_products = $this->CI->db->query('SELECT id, (SELECT col_name FROM collection WHERE collection.id = collection_id) AS collection_name FROM '.$table.' WHERE id IN ('.$ids.') AND delete_flag = 1 AND id="'.$product_code.'"');
		        }
		        // echo $this->CI->db->last_query();die;
		        if($get_products->num_rows() > 0)
		        {
		        	$get_products = $get_products->result_array();
		        	// pre($get_products);exit;
		        	$collection_name = array_column($get_products, 'collection_name');
					$ids = array_column($get_products, 'id');

		        	foreach ($ids as $key => $value) 
		        	{
		        		$product_id = $value;
						$col_name = $collection_name[$key];
						// pre($col_name);exit;

						$collection_sku_code = '';

						$collection_sku_code = $this->CI->db->get_where($table, ['id' => $product_id]);

						if($collection_sku_code->num_rows() > 0)
						{
							$collection_sku_code = $collection_sku_code->result_array();
							// pre($collection_sku_code);exit;
							$product_karat_val 	= $this->get_karat_name($collection_sku_code[0]['karat_default_id']);
							$gross_wt 			= $collection_sku_code[0]['gross_wt'];
							$net_wt 			= $collection_sku_code[0]['net_wt'];
							$collection_id 		= $collection_sku_code[0]['collection_id'];
							$product_sku_code 	= $collection_sku_code[0]['collection_sku_code'];
							$mfg_code 			= $collection_sku_code[0]['manufacturing_code'];
							$product_name 		= $collection_sku_code[0]['product_name'];
							$tone_default_id 	= $collection_sku_code[0]['tone_default_id'];
							$polish_default_id 	= $collection_sku_code[0]['polish_default_id'];
							$color_default_id 	= $collection_sku_code[0]['color_default_id'];
							$weight 			= $collection_sku_code[0]['weight'];
							$mul_length 		= $collection_sku_code[0]['mul_length'];
							$length 			= $collection_sku_code[0]['length'];
							
						}
						else
						{
							$product_karat_val 		= '';
							$product_sku_code 		= '';
							$gross_wt 				= 0;
							$net_wt 				= 0;
							$collection_id 			= 0;
							$product_name 			= '';
							$mfg_code 				= '';
							$tone_default_id		= 0;
							$polish_default_id 		= 0;
							$color_default_id 		= 0;
							$weight 				= '';
							$mul_length 			= '';
						}

		        		// Product Image Name
		        		// $image_name = $this->CI->db->query('SELECT image_name FROM product_images WHERE featured_image = 1 AND '.$table_id.'='.$value['id'])->result_array();
		        		if($table == 'product_master')
						{
							$image_name = $this->CI->db->select('image_name')->get_where($images_table,array('product_master_id'=>$product_id));
							$large_image = PRODUCT_LARGE_IMAGE;
							$zoom_image = PRODUCT_ZOOM_IMAGE;
							$thumb_image = PRODUCT_THUMB_IMAGE;
							$small_image = PRODUCT_SMALL_IMAGE; 
						}

						if($image_name->num_rows() > 0)
						{
							$image_name = $image_name->result_array();
							$image_name = array_column($image_name,'image_name');
						}
						else
						{
							$image_name = [];
						}

						// Products Default
						$product_default_data = $this->CI->db->query('SELECT gross_wt, net_wt, melting_id,(SELECT melting_name FROM melting WHERE id = melting_id) AS melting FROM '.$table.' WHERE id = '.$product_id.'');

						if($product_default_data->num_rows() > 0)
						{
							$product_default_data = $product_default_data->result_array();
							$product_default_data = $product_default_data[0];
							
							// pre($default_query);
							foreach($product_default_data as $k => $v)
							{
								if ($v == null)
								{
									$product_default_data[$k] = '';
								}
							}
						}
						else
						{
							$product_default_data = [];
						}
						$melting_id = isset($product_default_data['melting_id']) && !empty($product_default_data['melting_id']) ? $product_default_data['melting_id'] : "0";
						$key_value_mix = [];
						foreach ($collection_sku_code as $key_mat => $value_mat) 
						{
							if($mode_type == 'cart')
							{
								$product_default = $this->CI->db->query('SELECT * FROM '.$table.' WHERE id = '.$product_id.'')->result_array();
								
							}else if($mode_type == 'wishlist'){
								$product_default = $this->CI->db->query('SELECT * FROM '.$table.' WHERE id = '.$product_id.'')->result_array();
							}

							$tone_name 		= $this->CI->db->query('SELECT tone_type FROM tone WHERE id='.$tone_default_id)->result_array();
							$polish_name 	= $this->CI->db->query('SELECT polish_type FROM polish WHERE id='.$polish_default_id)->result_array(); 
							$color_name 	= $this->CI->db->query('SELECT color_type FROM color WHERE id='.$color_default_id)->result_array();
							$key_value_mix = [
								'Gross_Wt' 		=> $value_mat['gross_wt'],
								'Net_Wt' 		=> $value_mat['net_wt'],
								// 'size' 			=> $value_mat['size'],
								'Length' 		=> $value_mat['length'],
								'Melting' 		=> $product_default_data['melting'],
								'Design_Number' => $mfg_code,
							];
							
						}
						// pre($key_value_mix);die;	
						$label_key = array_keys($key_value_mix);
						$label_value = array_values($key_value_mix);

		        		// Check product in Cart and Wishlist
		        		$in_cart = $this->check_produt_in_cart_wish($product_id, $user_id, 'cart', $table);
						$in_wishlist = $this->check_produt_in_cart_wish($product_id, $user_id, 'wishlist', $table);
		        		

		        		$sold_count = $this->CI->db->query('SELECT count(id) as cnt FROM order_details WHERE product_id='.$product_id)->result_array();
		        		if(!empty($weight)){
		        			$weight_arr = explode(',', $weight);
		        		}else{
		        			$weight_arr = [];
						}
						
						if(!empty($mul_length)){
		        			$mul_length = explode(',', $mul_length);
		        		}else{
		        			$mul_length = [];
		        		}
		        		$data[0][] = [
		        			$table_id 				=> $product_id,
		        			'product_name' 			=> $product_name,
		        			'collection_name' 		=> $col_name,
		        			'design_number' 		=> $mfg_code,
		        			'key_label' 			=> $label_key,
		        			'key_value' 			=> $label_value,
		        			'tone' 					=> $tone_default_id,
		        			'polish' 				=> $polish_default_id,
		        			'color' 				=> $color_default_id,
		        			'image_name' 			=> $image_name,
		        			'default_melting_id' 	=> $melting_id,
		        			'large_image' 			=> $large_image,
		        			'zoom_image' 			=> $zoom_image,
		        			'thumb_image' 			=> $thumb_image,
		        			'small_image' 			=> $small_image,
		        			'product_default' 		=> $product_default,
		        			'in_cart' 				=> $in_cart,
		        			'in_wishlist' 			=> $in_wishlist,
		        			'sold_cnt'	 			=> $sold_count[0]['cnt'],
		        			'weight'				=> $weight_arr,
		        			'mul_length'			=> $mul_length,
		        			'length'				=> $length
		        		];
		        	}
		        	$final_data = array('ack' => '1' , 'msg' => 'Data fetched successfully' , 'data' => $data[0]);
		        }
		        else
		        {
		        	$final_data = array('ack' => '0' ,'msg' => 'No data found' , 'data' => '');
		        }
	        }else if($table == 'inventory_master'){
	        	if ($mode_type == 'cart') 
		        {
		        	$product_id = $product_ids[0];
		        	// echo $product_id;exit;
		        	$get_products = $this->CI->db->query('SELECT id, (SELECT col_name FROM collection WHERE collection.id = collection_id) AS collection_name FROM '.$table.' WHERE id ="'.$product_id.'"');
		        }
		        else
		        {
		        	$get_products = $this->CI->db->query('SELECT id, (SELECT col_name FROM collection WHERE collection.id = collection_id) AS collection_name FROM '.$table.' WHERE id IN ('.$ids.') AND id="'.$product_code.'"');
		        }
		        // echo $this->CI->db->last_query();die;
		        if($get_products->num_rows() > 0)
		        {
		        	$get_products = $get_products->result_array();
		        	// pre($get_products);exit;
		        	$collection_name = array_column($get_products, 'collection_name');
					$ids = array_column($get_products, 'id');

		        	foreach ($ids as $key => $value) 
		        	{
		        		$product_id = $value;
						$col_name = $collection_name[$key];
						// pre($col_name);exit;

						$collection_sku_code = '';

						$collection_sku_code = $this->CI->db->get_where($table, ['id' => $product_id]);

						if($collection_sku_code->num_rows() > 0)
						{
							$collection_sku_code = $collection_sku_code->result_array();
							// pre($collection_sku_code);exit;
							$gross_wt 			= $collection_sku_code[0]['gross_wt'];
							$net_wt 			= $collection_sku_code[0]['net_wt'];
							$collection_id 		= $collection_sku_code[0]['collection_id'];
							$product_sku_code 	= $collection_sku_code[0]['collection_sku_code'];
							$mfg_code 			= $collection_sku_code[0]['manufacturing_code'];
							$product_name 		= $collection_sku_code[0]['product_name'];
							$tone_default_id 	= $collection_sku_code[0]['tone'];
							$polish_default_id 	= $collection_sku_code[0]['polish'];
							$color_default_id 	= $collection_sku_code[0]['color'];
							$quantity 			= $collection_sku_code[0]['quantity'];
							
						}
						else
						{
							$product_karat_val 		= '';
							$product_sku_code 		= '';
							$gross_wt 				= 0;
							$net_wt 				= 0;
							$collection_id 			= 0;
							$product_name 			= '';
							$mfg_code 				= '';
							$tone_default_id		= 0;
							$polish_default_id 		= 0;
							$color_default_id 		= 0;
						}

						// pre($collection_sku_code);die;
		        		if($table == 'inventory_master')
						{
							$image_name = $this->CI->db->select('image_name')->get_where($images_table,array('product_master_id'=>$collection_sku_code[0]['product_master_id']));
							// echo $this->CI->db->last_query();die;
							$large_image = PRODUCT_LARGE_IMAGE;
							$zoom_image = PRODUCT_ZOOM_IMAGE;
							$thumb_image = PRODUCT_THUMB_IMAGE;
							$small_image = PRODUCT_SMALL_IMAGE; 
						}

						if($image_name->num_rows() > 0)
						{
							$image_name = $image_name->result_array();
							$image_name = array_column($image_name,'image_name');
						}
						else
						{
							$image_name = [];
						}

						// Products Default
						$product_default_data = $this->CI->db->query('SELECT gross_wt, net_wt, melting,(SELECT melting_name FROM melting WHERE id = melting) AS melting FROM '.$table.' WHERE id = '.$product_id.'');

						if($product_default_data->num_rows() > 0)
						{
							$product_default_data = $product_default_data->result_array();
							$product_default_data = $product_default_data[0];
							
							// pre($default_query);
							foreach($product_default_data as $k => $v)
							{
								if ($v == null)
								{
									$product_default_data[$k] = '';
								}
							}
						}
						else
						{
							$product_default_data = [];
						}
						$melting_id = isset($product_default_data['melting']) && !empty($product_default_data['melting']) ? $product_default_data['melting'] : 0;
						$key_value_mix = [];
						foreach ($collection_sku_code as $key_mat => $value_mat) 
						{
							if($mode_type == 'cart')
							{
								$product_default = $this->CI->db->query('SELECT * FROM '.$table.' WHERE id = '.$product_id.'')->result_array();
								
							}

							$tone_name 		= $this->CI->db->query('SELECT tone_type FROM tone WHERE id='.$tone_default_id)->result_array();
							$polish_name 	= $this->CI->db->query('SELECT polish_type FROM polish WHERE id='.$polish_default_id)->result_array(); 
							$color_name 	= $this->CI->db->query('SELECT color_type FROM color WHERE id='.$color_default_id)->result_array();
							$key_value_mix = [
								'weight' 		=> $value_mat['gross_wt'],
								'length' 		=> $value_mat['length'],
								'size' 			=> $value_mat['size'],
								'melting' 		=> $product_default_data['melting'],
								'tone' 			=> $tone_name[0]['tone_type'],
								'polish' 		=> $polish_name[0]['polish_type'],
								'color' 		=> $color_name[0]['color_type'],
								'design_number' => $mfg_code,
							];
							
						}
						// pre($key_value_mix);die;	
						$label_key = array_keys($key_value_mix);
						$label_value = array_values($key_value_mix);
		        		
		        		// Check product in Cart and Wishlist
		        		$in_cart = $this->check_produt_in_cart_wish($product_id, $user_id, 'cart', $table);
						$in_wishlist = $this->check_produt_in_cart_wish($product_id, $user_id, 'wishlist', $table);

		        		$data[0][] = [
		        			$table_id 				=> $product_id,
		        			'product_name' 			=> $product_name,
		        			'collection_name' 		=> $col_name,
		        			'design_number' 		=> $mfg_code,
		        			'quantity'				=> $quantity,
		        			'key_label' 			=> $label_key,
		        			'key_value' 			=> $label_value,
		        			'tone' 					=> $tone_default_id,
		        			'polish' 				=> $polish_default_id,
		        			'color' 				=> $color_default_id,
		        			'image_name' 			=> $image_name,
		        			'default_melting_id' 	=> $melting_id,
		        			'large_image' 			=> $large_image,
		        			'zoom_image' 			=> $zoom_image,
		        			'thumb_image' 			=> $thumb_image,
		        			'small_image' 			=> $small_image,
		        			'product_default' 		=> $product_default,
		        			'in_cart' 				=> $in_cart,
		        			'in_wishlist' 			=> $in_wishlist,
		        		];
		        	}
		        }
		        else
		        {
		        	$data[0]['error'] = 'No Products found.';
		        }
	        }
	        
	        
	    }
	    else
        {
        	$final_data = array('ack' => '0' ,'msg' => 'No Products present in this Search.' , 'data' => '');
        }
        // pre($data[0]);exit;
        return $final_data;
	}

	// Get Hallmarking Rate
	public function get_hallmarking_rates($id)
	{
		if(!empty($id))
		{
			$get_hall_rates = $this->CI->db->query('SELECT (SELECT hallmarking_type FROM hallmarking WHERE hallmarking.id = '.$id.') AS name, rate FROM set_hallmarking_rate WHERE hallmarking_id = '.$id.'');
		
			if($get_hall_rates->num_rows() > 0)
			{
				$get_hall_rates = $get_hall_rates->result_array();
				$get_hall_rates = $get_hall_rates[0];
			}
			else
			{
				unset($get_hall_rates);
				$get_hall_rates = 0;
			}	
		}
		else
		{
			$get_hall_rates = 0;
		}

		return $get_hall_rates;
	}

	// Get Certification Rate
	public function get_certification_rates($id)
	{
		if(!empty($id))
		{
			$get_cert_rates = $this->CI->db->query('SELECT (SELECT certification_type FROM certification WHERE certification.id = '.$id.') AS name, rate FROM set_certification_rate WHERE certification_id = '.$id.'');
		
			if($get_cert_rates->num_rows() > 0)
			{
				$get_cert_rates = $get_cert_rates->result_array();
				$get_cert_rates = $get_cert_rates[0];
			}
			else
			{
				unset($get_cert_rates);
				$get_cert_rates = 0;
			}	
		}
		else
		{
			$get_cert_rates = 0;
		}

		return $get_cert_rates;
	}
	public function get_karat_name($karat_id)
	{
		$karat_name = $this->CI->db->select('karat_type')->get_where('karat', ['id' => $karat_id]);

		if($karat_name->num_rows() > 0)
		{
			$karat_name = $karat_name->result_array();
			$karat_name = $karat_name[0]['karat_type'];
		}
		else
		{
			unset($karat_name);
			$karat_name = '';
		}
		return $karat_name;
	}

	public function get_karat_change_rate($karat_id)
	{
		if(!empty($karat_id))
		{
			$karat_rate_change = $this->CI->db->query('SELECT (SELECT karat_type FROM karat WHERE karat.id = karat_to) AS karat_name, rate FROM karat_rate_change WHERE karat_from = '.$karat_id);

			if ($karat_rate_change->num_rows() > 0)
			{
				$karat_rate_change = $karat_rate_change->result_array();
			}
			else
			{
				unset($karat_rate_change);
				$karat_rate_change = [];
			}	
		}
		else
		{
			$karat_rate_change = [];
		}
		return $karat_rate_change;
	}

	public function get_karat_default_id($product_id, $table)
	{
		$karat_id = $this->CI->db->select('karat_default_id')->get_where($table, ['id' => $product_id]);
		if ($karat_id->num_rows() > 0)
		{
			$karat_id = $karat_id->result_array();
			$karat_id = $karat_id[0]['karat_default_id'];
		}
		else
		{
			unset($karat_id);
			$karat_id = 0;
		}
		return $karat_id;
	}

	public function get_karat_rate($karat_id)
	{
		$get_rate = $this->CI->db->select('rate')->get_where('karat_rate_set', ['karat_id' => $karat_id]);

		if($get_rate->num_rows() > 0)
		{
			$get_rate = $get_rate->result_array();

			return $get_rate[0]['rate'];
		}
		else
		{
			return 0;
		}
	}

	public function get_karat_type_rate($karat_type_id)
	{
		if(isset($karat_type_id) && !empty($karat_type_id))
		{
			$get_karat_rate = $this->CI->db->query('SELECT rate FROM karat_type_rate_set WHERE karat_type_id = '.$karat_type_id.' ORDER BY id DESC LIMIT 0,1');

			if($get_karat_rate->num_rows() > 0)
			{
				$get_karat_rate = $get_karat_rate->result_array();
				$karat_type_rate = $get_karat_rate[0]['rate'];
			}
			else
			{
				$karat_type_rate = '0';
			}		
		}
		else
		{
			$karat_type_rate = '0';
		}
		
		return $karat_type_rate;
	}

	public function create_unique_string($length=15,$table='',$field='')
	{
		$all_characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		$charactersLength = strlen($all_characters);
		$unique_string = '';
		for($i = 0; $i < $length; $i++)
		{
			$unique_string .= $all_characters[rand(0, $charactersLength - 1)];
		}
		
		if($table != '' && $field != '')
		{
			$data = $this->CI->db->get_where($table,[$field=>$unique_string]);
			if($data->num_rows() > 0)
			{
				$this->create_unique_string(15,$table,$field);
			}
		}
		return $unique_string;
	} 

	public function get_product_id_by_filter($product_ids, $table, $user_id)
	{
		if(!empty($product_ids))
		{
			if($table == 'product_master')
			{
				$check = 1;
				$product_ids = implode(',', $product_ids);
				$gross_filter_id = [];
				
				if(isset($_REQUEST['min_gross_weight']) && isset($_REQUEST['max_gross_weight']))
				{
					$max_gross_weight = number_format($_REQUEST['max_gross_weight'], 3, '.', '');
					$min_gross_weight = number_format($_REQUEST['min_gross_weight'], 3, '.', '');

					//Gross Wt Product Ids
					if($max_gross_weight != '' && $min_gross_weight != '')
					{
						$gross_filter_id = $this->CI->db->query('SELECT id AS product_master_id FROM product_master WHERE gross_wt BETWEEN '.$min_gross_weight.' AND '.$max_gross_weight.' AND id IN ('.$product_ids.')');
						// echo $this->CI->db->last_query()."<br />";
						if($gross_filter_id->num_rows() > 0)
						{
							$gross_filter_id = $gross_filter_id->result_array();
							$gross_filter_id = array_column($gross_filter_id, 'product_master_id');
						}
						else
						{
							$gross_filter_id = [];
							$check = 0;
						}
					}
				}

				$product_ids = ((!empty($gross_filter_id)) ? implode(",",$gross_filter_id) : (($check != 0) ? $product_ids : []));

				$net_filter_id = [];
					
					if(isset($_REQUEST['min_net_weight']) && isset($_REQUEST['max_net_weight']) && !empty($product_ids))
					{
						$min_net_weight = number_format($_REQUEST['min_net_weight'], 3, '.', '');
						$max_net_weight = number_format($_REQUEST['max_net_weight'], 3, '.', '');

						// Net Wt Product Ids
						if($max_net_weight != '' && $min_net_weight != '')
						{
							$net_filter_id = $this->CI->db->query('SELECT id AS product_master_id FROM product_master WHERE net_wt BETWEEN "'.$min_net_weight.'" AND "'.$max_net_weight.'" AND id IN ('.$product_ids.')');
							// echo $this->CI->db->last_query();exit;
							if($net_filter_id->num_rows() > 0)
							{
								$net_filter_id = $net_filter_id->result_array();
								$net_filter_id = array_column($net_filter_id, 'product_master_id');
							}
							else
							{
								$net_filter_id = [];
								$check = 0;
							}
						}
					}

					$product_ids = ((!empty($net_filter_id)) ? implode(",",$net_filter_id) : (($check != 0) ? $product_ids : []));

					$created_id = [];
					
					if(isset($_REQUEST['created_date_from']) && isset($_REQUEST['created_date_to']) && !empty($product_ids))
					{
						$created_date_from 	= $_REQUEST['created_date_from'];
						$created_date_to 	= $_REQUEST['created_date_to'];

						// Net Wt Product Ids
						if($created_date_from != '' && $created_date_to != '')
						{
							$created_id = $this->CI->db->query('SELECT id AS product_master_id FROM product_master WHERE DATE(created) BETWEEN "'.$created_date_from.'" AND "'.$created_date_to.'" AND id IN ('.$product_ids.')');
							// echo $this->CI->db->last_query();exit;
							if($created_id->num_rows() > 0)
							{
								$created_id = $created_id->result_array();
								$created_id = array_column($created_id, 'product_master_id');
							}
							else
							{
								$created_id = [];
								$check = 0;
							}
						}
					}

					$product_ids = ((!empty($created_id)) ? implode(",",$created_id) : (($check != 0) ? $product_ids : []));

					$product_status = [];
					
					if(isset($_REQUEST['product_status']) && !empty($product_ids))
					{
						$product_status = $_REQUEST['product_status'];
						
						// Product Status Ids
						if($product_status != '')
						{
							$product_status = $this->CI->db->query('SELECT id AS product_master_id FROM product_master WHERE id IN ('.$product_ids.') AND product_status IN ('.$product_status.') AND product_status != 0 AND product_status IS NOT NULL');

							if($product_status->num_rows() > 0)
							{
								$product_status = $product_status->result_array();
								$product_status = array_column($product_status, 'product_master_id');
							}
							else
							{
								$product_status = [];
								$check = 0;
							}
						}
					}

					$product_ids = ((!empty($product_status)) ? implode(",",$product_status) : (($check != 0) ? $product_ids : []));
					$color_type = [];

					if(isset($_REQUEST['color_type']) && !empty($product_ids))
					{
						$color_type = $_REQUEST['color_type'];
						
						// Product Status Ids
						if($color_type != '')
						{
							$color_type = $this->CI->db->query('SELECT id AS product_master_id FROM product_master WHERE id IN ('.$product_ids.') AND color_default_id IN ('.$color_type.')');

							if($color_type->num_rows() > 0)
							{
								$color_type = $color_type->result_array();
								$color_type = array_column($color_type, 'product_master_id');
							}
							else
							{
								$color_type = [];
								$check = 0;
							}
						}
					}

					$product_ids = ((!empty($color_type)) ? implode(",",$color_type) : (($check != 0) ? $product_ids : []));
					$tone_type = [];

					if(isset($_REQUEST['tone_type']) && !empty($product_ids))
					{
						$tone_type = $_REQUEST['tone_type'];
						
						// Product Status Ids
						if($tone_type != '')
						{
							$tone_type = $this->CI->db->query('SELECT id AS product_master_id FROM product_master WHERE id IN ('.$product_ids.') AND tone_default_id IN ('.$tone_type.')');

							if($tone_type->num_rows() > 0)
							{
								$tone_type = $tone_type->result_array();
								$tone_type = array_column($tone_type, 'product_master_id');
							}
							else
							{
								$tone_type = [];
								$check = 0;
							}
						}
					}

					$product_ids = ((!empty($tone_type)) ? implode(",",$tone_type) : (($check != 0) ? $product_ids : []));
					$polish_type = [];

					if(isset($_REQUEST['polish_type']) && !empty($product_ids))
					{
						$polish_type = $_REQUEST['polish_type'];
						
						// Product Status Ids
						if($polish_type != '')
						{
							$polish_type = $this->CI->db->query('SELECT id AS product_master_id FROM product_master WHERE id IN ('.$product_ids.') AND tone_default_id IN ('.$polish_type.')');

							if($polish_type->num_rows() > 0)
							{
								$polish_type = $polish_type->result_array();
								$polish_type = array_column($polish_type, 'product_master_id');
							}
							else
							{
								$polish_type = [];
								$check = 0;
							}
						}
					}

					$product_ids = ((!empty($polish_type)) ? implode(",",$polish_type) : (($check != 0) ? $product_ids : []));

					if(!empty($product_ids))
					{
						$all_filter_ids = [];
						
						if(!empty($gross_filter_id))
						{
							if(!empty($all_filter_ids))
							{
								$all_filter_ids = array_intersect($all_filter_ids,$gross_filter_id);
							}
							else
							{
								$all_filter_ids = array_merge($all_filter_ids,$gross_filter_id);
							}
						}

						if(!empty($net_filter_id))
						{
							if(!empty($all_filter_ids))
							{
								$all_filter_ids = array_intersect($all_filter_ids,$net_filter_id);
							}
							else
							{
								$all_filter_ids = array_merge($all_filter_ids,$net_filter_id);
							}
						}

						if(!empty($created_id))
						{
							if(!empty($all_filter_ids))
							{
								$all_filter_ids = array_intersect($all_filter_ids,$created_id);
							}
							else
							{
								$all_filter_ids = array_merge($all_filter_ids,$created_id);
							}
						}

						if(!empty($product_status))
						{
							if(!empty($all_filter_ids))
							{
								$all_filter_ids = array_intersect($all_filter_ids,$product_status);
							}
							else
							{
								$all_filter_ids = array_merge($all_filter_ids,$product_status);
							}
						}

						if($check == 1)
						{
							$product_ids = explode(",",$product_ids);
						}
						else
						{
							$product_ids = array_unique($all_filter_ids);
						}
					}
					else
					{
						$product_ids = [];
					}

					$data[0] = $product_ids;
			}
		}
		else
		{
			$data[0] = [];
		}
		return $data[0];
	}

	public function fetch_user_assign_ids($user_id,$table,$collection_ids)
	{
        $table_id = ($table == 'product_master' ? 'product_master_id' : 'inventory_master_id');
        $data[0] = [];

        if ($table == 'product_master')
        {
        	$allocation_ids 	= [];

        	if ($user_id != '' || $user_id != '0')
        	{
        		$get_client_access = $this->check_access($user_id);
        		// pre($get_client_access);die;
        		if($get_client_access == 1){
        			$check_allocation_id = $this->CI->db->query('SELECT collection_id FROM user_collection_allocation WHERE user_id='.$user_id.' AND collection_id IN('.$collection_ids.')')->result_array();
        			// echo $this->CI->db->last_query();
	        		if (!empty($check_allocation_id))
			        {
			        	$check_allocation_id = array_column($check_allocation_id, 'collection_id');
 		       			$check_allocation_id = implode(',', $check_allocation_id);
        			// pre($check_allocation_id);die;
			            $allocation_ids = $this->CI->db->query('SELECT id AS product_inventory_id FROM '.$table.' WHERE collection_id IN('.$check_allocation_id.')');

			            if ($allocation_ids->num_rows() > 0){
			                $allocation_ids = $allocation_ids->result_array();
			            }else{
			                unset($allocation_ids);
			                $allocation_ids = [];
			            }
			        }else{
			            $allocation_ids = $this->CI->db->query('SELECT id AS product_inventory_id FROM '.$table.' WHERE collection_id IN('.$collection_ids.') limit 10');

			            if ($allocation_ids->num_rows() > 0){
			                $allocation_ids = $allocation_ids->result_array();
			            }else{
			                unset($allocation_ids);
			                $allocation_ids = [];
			            }
			        }
        		}else{
        			$allocation_ids = $this->CI->db->query('SELECT id AS product_inventory_id FROM '.$table.' WHERE collection_id IN('.$collection_ids.') limit 10');

		            if ($allocation_ids->num_rows() > 0){
		                $allocation_ids = $allocation_ids->result_array();
		            }else{
		                unset($allocation_ids);
		                $allocation_ids = [];
		            }
        		}
        	}        
	        
	        $ids = $allocation_ids;

	        $ids = array_column($ids, 'product_inventory_id');
	        $data[0] = array_unique($ids);
        }else if($table == 'inventory_master'){
        	$check_allocation_id = $this->CI->db->select('collection_id')->get_where('user_collection_allocation',['user_id' => $user_id, 'collection_id' => $collection_id]);

        	if ($check_allocation_id->num_rows() > 0)
	        {
	            $allocation_ids = $this->CI->db->query('SELECT id AS product_inventory_id FROM '.$table.' WHERE collection_id = "'.$collection_id.'"');

	            if ($allocation_ids->num_rows() > 0)
	            {
	                $allocation_ids = $allocation_ids->result_array();
	            }
	            else
	            {
	                unset($allocation_ids);
	                $allocation_ids = [];
	            }
	        }
	        else
	        {
	            unset($allocation_ids);
	            $allocation_ids = [];
	        }

	        $ids = array_column($allocation_ids, 'product_inventory_id');
	        $data[0] = array_unique($ids);
        }
        return $data[0];
	}

	public function get_product_id_by_filter_advance_search($product_ids, $table, $user_id)
	{
		if(!empty($product_ids))
		{
			if($table == 'product_master')
			{
				$check = 1;
				$product_ids = implode(',', $product_ids);
				$gross_filter_id = [];
				
				if(isset($_REQUEST['min_gross_weight']) && isset($_REQUEST['max_gross_weight']))
				{
					$max_gross_weight = number_format($_REQUEST['max_gross_weight'], 3, '.', '');
					$min_gross_weight = number_format($_REQUEST['min_gross_weight'], 3, '.', '');

					//Gross Wt Product Ids
					if($max_gross_weight != '' && $min_gross_weight != '')
					{
						$gross_filter_id = $this->CI->db->query('SELECT id AS product_master_id FROM product_master WHERE gross_wt BETWEEN '.$min_gross_weight.' AND '.$max_gross_weight.' AND id IN ('.$product_ids.')');
						// echo $this->CI->db->last_query();die;
						if($gross_filter_id->num_rows() > 0)
						{
							$gross_filter_id = $gross_filter_id->result_array();
							$gross_filter_id = array_column($gross_filter_id, 'product_master_id');
						}
						else
						{
							$gross_filter_id = [];
							$check = 0;
						}
					}
				}

				$product_ids = ((!empty($gross_filter_id)) ? implode(",",$gross_filter_id) : (($check != 0) ? $product_ids : []));


				$length_filter_id = [];
				
				if(isset($_REQUEST['min_length']) && isset($_REQUEST['max_length']))
				{
					$max_length = $_REQUEST['max_length'];
					$min_length = $_REQUEST['min_length'];

					//Gross Wt Product Ids
					if($max_length != '' && $min_length != '')
					{
						$length_filter_id = $this->CI->db->query('SELECT id AS product_master_id FROM product_master WHERE length BETWEEN '.$min_length.' AND '.$max_length.' AND id IN ('.$product_ids.')');
						// echo $this->CI->db->last_query();die;
						if($length_filter_id->num_rows() > 0)
						{
							$length_filter_id = $length_filter_id->result_array();
							$length_filter_id = array_column($length_filter_id, 'product_master_id');
						}
						else
						{
							$length_filter_id = [];
							$check = 0;
						}
					}
				}

				$product_ids = ((!empty($length_filter_id)) ? implode(",",$length_filter_id) : (($check != 0) ? $product_ids : []));

				$net_filter_id = [];
					
				if(isset($_REQUEST['min_net_weight']) && isset($_REQUEST['max_net_weight']) && !empty($product_ids))
				{
					$min_net_weight = number_format($_REQUEST['min_net_weight'], 3, '.', '');
					$max_net_weight = number_format($_REQUEST['max_net_weight'], 3, '.', '');

					// Net Wt Product Ids
					if($max_net_weight != '' && $min_net_weight != '')
					{
						$net_filter_id = $this->CI->db->query('SELECT id AS product_master_id FROM product_master WHERE net_wt BETWEEN "'.$min_net_weight.'" AND "'.$max_net_weight.'" AND id IN ('.$product_ids.')');
						// echo $this->CI->db->last_query();exit;
						if($net_filter_id->num_rows() > 0)
						{
							$net_filter_id = $net_filter_id->result_array();
							$net_filter_id = array_column($net_filter_id, 'product_master_id');
						}
						else
						{
							$net_filter_id = [];
							$check = 0;
						}
					}
				}

				$product_ids = ((!empty($net_filter_id)) ? implode(",",$net_filter_id) : (($check != 0) ? $product_ids : []));

				$created_id = [];
					
				if(isset($_REQUEST['created_date_from']) && isset($_REQUEST['created_date_to']) && !empty($product_ids))
				{
					$created_date_from 	= $_REQUEST['created_date_from'];
					$created_date_to 	= $_REQUEST['created_date_to'];

					// Net Wt Product Ids
					if($created_date_from != '' && $created_date_to != '')
					{
						$created_id = $this->CI->db->query('SELECT id AS product_master_id FROM product_master WHERE DATE(created) BETWEEN "'.$created_date_from.'" AND "'.$created_date_to.'" AND id IN ('.$product_ids.')');
						// echo $this->CI->db->last_query();exit;
						if($created_id->num_rows() > 0)
						{
							$created_id = $created_id->result_array();
							$created_id = array_column($created_id, 'product_master_id');
						}
						else
						{
							$created_id = [];
							$check = 0;
						}
					}
				}

				$product_ids = ((!empty($created_id)) ? implode(",",$created_id) : (($check != 0) ? $product_ids : []));

				$product_status = [];
				
				if(isset($_REQUEST['product_status']) && !empty($product_ids))
				{
					$product_status = $_REQUEST['product_status'];
					
					// Product Status Ids
					if($product_status != '')
					{
						$product_status = $this->CI->db->query('SELECT id AS product_master_id FROM product_master WHERE id IN ('.$product_ids.') AND product_status IN ('.$product_status.') AND product_status != 0 AND product_status IS NOT NULL');

						if($product_status->num_rows() > 0)
						{
							$product_status = $product_status->result_array();
							$product_status = array_column($product_status, 'product_master_id');
						}
						else
						{
							$product_status = [];
							$check = 0;
						}
					}
				}

				$product_ids = ((!empty($product_status)) ? implode(",",$product_status) : (($check != 0) ? $product_ids : []));

				$melting_id = [];
				
				if(isset($_REQUEST['melting_id']) && !empty($product_ids))
				{
					$melting_id = $_REQUEST['melting_id'];
					
					// melting_id Ids
					if($melting_id != '')
					{
						$melting_id = $this->CI->db->query('SELECT id AS product_master_id FROM product_master WHERE id IN ('.$product_ids.') AND melting_id IN ('.$melting_id.')');

						if($melting_id->num_rows() > 0)
						{
							$melting_id = $melting_id->result_array();
							$melting_id = array_column($melting_id, 'product_master_id');
						}
						else
						{
							$melting_id = [];
							$check = 0;
						}
					}
				}

				$product_ids = ((!empty($melting_id)) ? implode(",",$melting_id) : (($check != 0) ? $product_ids : []));

				if(!empty($product_ids))
				{
					$all_filter_ids = [];
					
					if(!empty($gross_filter_id))
					{
						if(!empty($all_filter_ids))
						{
							$all_filter_ids = array_intersect($all_filter_ids,$gross_filter_id);
						}
						else
						{
							$all_filter_ids = array_merge($all_filter_ids,$gross_filter_id);
						}
					}

					if(!empty($length_filter_id))
					{
						if(!empty($all_filter_ids))
						{
							$all_filter_ids = array_intersect($all_filter_ids,$length_filter_id);
						}
						else
						{
							$all_filter_ids = array_merge($all_filter_ids,$length_filter_id);
						}
					}

					if(!empty($net_filter_id))
					{
						if(!empty($all_filter_ids))
						{
							$all_filter_ids = array_intersect($all_filter_ids,$net_filter_id);
						}
						else
						{
							$all_filter_ids = array_merge($all_filter_ids,$net_filter_id);
						}
					}

					if(!empty($created_id))
					{
						if(!empty($all_filter_ids))
						{
							$all_filter_ids = array_intersect($all_filter_ids,$created_id);
						}
						else
						{
							$all_filter_ids = array_merge($all_filter_ids,$created_id);
						}
					}

					if(!empty($product_status))
					{
						if(!empty($all_filter_ids))
						{
							$all_filter_ids = array_intersect($all_filter_ids,$product_status);
						}
						else
						{
							$all_filter_ids = array_merge($all_filter_ids,$product_status);
						}
					}

					if(!empty($melting_id))
					{
						if(!empty($all_filter_ids))
						{
							$all_filter_ids = array_intersect($all_filter_ids,$melting_id);
						}
						else
						{
							$all_filter_ids = array_merge($all_filter_ids,$melting_id);
						}
					}

					if($check == 1)
					{
						$product_ids = explode(",",$product_ids);
					}
					else
					{
						$product_ids = array_unique($all_filter_ids);
					}
				}
				else
				{
					$product_ids = [];
				}
				$data[0] = $product_ids;
			}
		}
		else
		{
			$data[0] = [];
		}
		return $data[0];
	}

	public function advanced_search_design_assign($design_number , $user_id,$table){
		$id = '';
		$check_exist = $this->CI->db->query('SELECT id,collection_id FROM '.$table.' WHERE manufacturing_code="'.$design_number.'"')->result_array();
		if(!empty($check_exist)){
			// pre($check_exist);die;
			$check_assign = $this->CI->db->query('SELECT id FROM user_collection_allocation WHERE user_id='.$user_id.' AND collection_id='.$check_exist[0]['collection_id'])->result_array();
			if(!empty($check_assign)){
				$id = $check_exist[0]['id'];
			}
		}
		return $id;
	}

	public function advanced_search_design_grid_data($product_ids, $user_id, $table)
	{
		if(!empty($product_ids))
        {
        	$ids 			= $product_ids;
			$images_table 	= ($table == 'product_master' ? 'product_images' : 'inventory_images');
	        $table_id 		= ($table == 'product_master' ? 'product_master_id' : 'product_master_id');

	        $data[0] = [];

	        if($table == 'product_master'){
	        	$get_products = $this->CI->db->query('SELECT id, sku_code, collection_id ,collection_sku_code, manufacturing_code, gross_wt, net_wt, product_name , shape FROM '.$table.' WHERE delete_flag = 1 AND id IN ('.$ids.')');
		        
		        // echo $this->CI->db->last_query();exit;
		        if($get_products->num_rows() > 0)
		        {
		        	$get_products = $get_products->result_array();

		        	foreach ($get_products as $key => $value) 
		        	{
		        		// Get Product Id
		        		$product_master_id = $value['id'];

		        		$image_data = $this->CI->db->query('SELECT image_name FROM product_images WHERE featured_image = 1 AND '.$table_id.'='.$value['id'])->result_array();

		        		$quantity_data = $this->CI->db->query('SELECT quantity FROM cart WHERE user_id = '.$user_id.' AND product_id='.$value['id']. ' AND product_inventory_type="'.$table.'"')->result_array();

		        		$in_cart = $this->check_produt_in_cart_wish($product_master_id, $user_id, 'cart', $table);
						$in_wishlist = $this->check_produt_in_cart_wish($product_master_id, $user_id, 'wishlist', $table);

		        		$image_name = isset($image_data[0]['image_name']) ? $image_data[0]['image_name'] : 'Not Available';

		        		if(!empty($value['product_name']) && !empty($value['shape'])){
		        			$product_list = ['Code'=> $value['manufacturing_code'],'Gross_Wt'=> $value['gross_wt'],'Name' => $value['product_name'] , 'Shape' => $value['shape']];
		        		}else if(empty($value['product_name']) && !empty($value['shape'])){
		        			$product_list = ['Code'=> $value['manufacturing_code'],'Gross_Wt'=> $value['gross_wt'], 'Shape' => $value['shape']];
		        		}else if(!empty($value['product_name']) && empty($value['shape'])){
		        			$product_list = ['Code'=> $value['manufacturing_code'],'Gross_Wt'=> $value['gross_wt'],'Name' => $value['product_name']];
		        		}else{
							$product_list = ['Code'=> $value['manufacturing_code'],'gross_wt'=> $value['gross_wt']];
		        		}

		        		$label_key = array_keys($product_list);
						$label_value = array_values($product_list);

		        		$data[0]['products'][] = [
		        			'date_no'				=> '1',
		        			'product_inventory_type'=> $table,
		        			'product_inventory_id' 	=> $value['id'],
		        			'collection_id' 		=> $value['collection_id'],
		        			'collection_sku_code' 	=> $value['collection_sku_code'],
		        			'key'					=> $label_key,
		        			'value'					=> $label_value,
		        			'quantity' 				=> isset($quantity_data[0]['quantity']) && !empty($quantity_data[0]['quantity']) ? $quantity_data[0]['quantity'] : "0",
		        			'image_name' 			=> $image_name,
		        			'in_cart' 				=> $in_cart,
		        			'in_wishlist' 			=> $in_wishlist
		        		];
		        	}
		        	$final_data = array('ack' => '1' , 'msg' => 'Data fetched successfully' , 'data' => $data[0]);
		        }
		        else
		        {
		        	$final_data = array('ack' => '0' , 'msg' => 'No products found' , 'data' => '');
		        }
	        }else if($table == 'inventory_master'){
	        	$get_products = $this->CI->db->query('SELECT id,product_master_id, collection_id ,sku_code, collection_sku_code, manufacturing_code, gross_wt, net_wt, product_name FROM '.$table.' WHERE id IN ('.$ids.')');
		        
		        // echo $this->CI->db->last_query();exit;
		        if($get_products->num_rows() > 0)
		        {
		        	$get_products = $get_products->result_array();

		        	foreach ($get_products as $key => $value) 
		        	{
		        		// Get Product Id
		        		$product_master_id = $value['product_master_id'];

		        		$image_data = $this->CI->db->query('SELECT image_name FROM product_images WHERE featured_image = 1 AND '.$table_id.'='.$value['product_master_id'])->result_array();

		        		$quantity_data = $this->CI->db->query('SELECT quantity FROM cart WHERE user_id = '.$user_id.' AND product_id='.$value['id']. ' AND product_inventory_type="'.$table.'"')->result_array();

		        		$in_cart = $this->check_produt_in_cart_wish($product_master_id, $user_id, 'cart', $table);
						$in_wishlist = $this->check_produt_in_cart_wish($product_master_id, $user_id, 'wishlist', $table);

		        		$image_name = isset($image_data[0]['image_name']) ? $image_data[0]['image_name'] : 'Not Available';

		        		$product_list = [
		        			'design_number'	=> $value['manufacturing_code'],
		        			'gross_wt'		=> $value['gross_wt']
		        		];

		        		$label_key = array_keys($product_list);
						$label_value = array_values($product_list);

		        		$data[0]['products'][] = [
		        			'product_inventory_type'=> $table,
		        			'product_inventory_id' 	=> $value['id'],
		        			'collection_id' 		=> $value['collection_id'],
		        			'key'					=> $label_value,
		        			'value'					=> $label_value,
		        			'image_name' 			=> $image_name,
		        			'in_cart' 				=> $in_cart,
		        			'in_wishlist' 			=> $in_wishlist,
		        			'quantity' 				=> isset($quantity_data[0]['quantity']) && !empty($quantity_data[0]['quantity']) ? $quantity_data[0]['quantity'] : "0",
		        		];
		        	}
		        }
		        else
		        {
		        	$data[0]['error'] = 'No Products found.';
		        }
	        }
	        
	        
	    }else{
        	$final_data = array('ack' => '0' , 'msg' => 'No Products present in this Search.' , 'data' => '');
        }

        return $final_data;
	}

	public function get_product_id_catalogue($catalogue_id)
	{
		$data = [];
		$product_inventory_id =[];
		$product_id = [];

		$product_inventory_id = $this->CI->db->select('product_inventory_id')->get_where('my_catalogue_values', ['catalogue_id' => $catalogue_id]);

		if($product_inventory_id->num_rows() > 0)
		{
			$product_id = $product_inventory_id->result_array();
		}
		$ids = array_column($product_id, 'product_inventory_id');
		$data[0] = $ids;
		
		return $data[0];
	}

	public function get_marketing_grid($product_ids, $user_id, $table, $page_no, $record,$sort_by)
	{
		if(!empty($product_ids))
        {
        	$ids = implode(',', $product_ids);
			$images_table = ($table == 'product_master' ? 'product_images' : 'inventory_images');
	        $table_id = ($table == 'product_master' ? 'product_master_id' : 'product_master_id');

	        $data[0] = [];

	        if($sort_by == '1')
			{
				$field = 'gross_wt';
				$order = 'DESC';
			}
			else if($sort_by == '2')
			{
				$field = 'gross_wt';
				$order = 'ASC';
			}
			else if($sort_by == '3')
			{
				$field = 'net_wt';
				$order = 'DESC';
			}
			else if($sort_by == '4')
			{
				$field = 'net_wt';
				$order = 'ASC';
			}else if($sort_by == '5')
			{
				$field = 'id';
				$order = 'DESC';
			}else if($sort_by == '6')
			{
				$field = 'id';
				$order = 'ASC';
			}else if($sort_by == '7')
			{
				$field = 'price';
				$order = 'DESC';
			}else if($sort_by == '8')
			{
				$field = 'price';
				$order = 'ASC';
			}

	        $start = ($page_no*$record);

	        if($table == 'product_master'){
	        	if(!empty($user_id)){
		        	$get_products = $this->CI->db->query('SELECT id, collection_id ,sku_code, collection_sku_code, manufacturing_code, gross_wt, net_wt, product_name  ,shape , date(created) AS created FROM '.$table.' WHERE delete_flag = 1 AND id IN ('.$ids.') ORDER BY '.$field.' '.$order.' LIMIT '.$start.', '.$record.' ');
		        }else{
		        	$get_products = $this->CI->db->query('SELECT id, collection_id ,sku_code, collection_sku_code, manufacturing_code, gross_wt, net_wt, product_name  ,shape , date(created) AS created FROM '.$table.' WHERE delete_flag = 1 AND id IN ('.$ids.') ORDER BY '.$field.' '.$order.' LIMIT 0,20');
		        }
		        
		        // echo $this->CI->db->last_query();exit;
		        if($get_products->num_rows() > 0)
		        {
		        	$get_products = $get_products->result_array();
		        	$count = 1;
		        	foreach ($get_products as $key => $value) 
		        	{
		        		// Get Product Id
		        		$product_master_id = $value['id'];

		        		$image_data = $this->CI->db->query('SELECT image_name FROM product_images WHERE featured_image = 1 AND '.$table_id.'='.$value['id'])->result_array();

		        		$quantity_data = $this->CI->db->query('SELECT quantity FROM cart WHERE user_id = '.$user_id.' AND product_id='.$value['id']. ' AND product_inventory_type="'.$table.'"')->result_array();

		        		$in_cart = $this->check_produt_in_cart_wish($product_master_id, $user_id, 'cart', $table);
						$in_wishlist = $this->check_produt_in_cart_wish($product_master_id, $user_id, 'wishlist', $table);

		        		$image_name = isset($image_data[0]['image_name']) ? $image_data[0]['image_name'] : 'Not Available';

		        		$product_list = ['Code'=> $value['manufacturing_code'],'gross_wt'=> $value['gross_wt']];

		        		$label_key = array_keys($product_list);
						$label_value = array_values($product_list);

		        		$data[0]['products'][] = [
		        			'date_no'				=> "$count",
		        			'product_inventory_type'=> $table,
		        			'product_inventory_id' 	=> $value['id'],
		        			'collection_id' 		=> $value['collection_id'],
		        			'collection_sku_code' 	=> $value['collection_sku_code'],
		        			'created' 				=> $value['created'],
		        			'price' 				=> $value['price'],
		        			'key'					=> $label_key,
		        			'value'					=> $label_value,
		        			'quantity' 				=> isset($quantity_data[0]['quantity']) && !empty($quantity_data[0]['quantity']) ? $quantity_data[0]['quantity'] : "0",
		        			'image_name' 			=> $image_name,
		        			'in_cart' 				=> $in_cart,
		        			'in_wishlist' 			=> $in_wishlist
		        		];
		        		$count++;
		        	}
		        	$final_data = array('ack' => '1' , 'msg' => 'Data fetched successfully' , 'data' => $data[0]);
		        }
		        else
		        {
		        	$final_data = array('ack' => '0' , 'msg' => 'No products found' , 'data' => '');
		        }
	        }else{
				$final_data = array('ack' => '0' , 'msg' => 'Please check table name' , 'data' => '');
			}
	    }else{
        	$final_data = array('ack' => '0' , 'msg' => 'No Products present in this Search.' , 'data' => '');
        }

        return $final_data;
	}

	public function get_product_id_by_filter_marketing($product_ids, $table, $user_id)
	{
		if(!empty($product_ids))
		{
			if($table == 'product_master')
			{
				$check = 1;
				$product_ids = implode(',', $product_ids);
				$price_filter_id = [];
				
				if(isset($_REQUEST['price']) && !empty($_REQUEST['price']))
				{
					$price = $_REQUEST['price'];
					if($price == 1){
						$min_price = 0;
						$max_price = 5000;
					}else if($price == 2){
						$min_price = 5000;
						$max_price = 10000;
					}else if($price == 3){
						$min_price = 10000;
						$max_price = 20000;
					}else if($price == 4){
						$min_price = 20000;
						$max_price = 30000;
					}else if($price == 5){
						$min_price = 30000;
						$max_price = 40000;
					}else if($price == 6){
						$min_price = 40000;
						$max_price = 100000;
					}else{
						$min_price = 0;
						$max_price = 5000;
					}
					$price_filter_id = $this->CI->db->query('SELECT id AS product_master_id FROM product_master WHERE price BETWEEN '.$min_price.' AND '.$max_price.' AND id IN ('.$product_ids.')');
					// echo $this->CI->db->last_query()."<br />";
					if($price_filter_id->num_rows() > 0)
					{
						$price_filter_id = $price_filter_id->result_array();
						$price_filter_id = array_column($price_filter_id, 'product_master_id');
					}
					else
					{
						$price_filter_id = [];
						$check = 0;
					}
				}

				$product_ids = ((!empty($price_filter_id)) ? implode(",",$price_filter_id) : (($check != 0) ? $product_ids : []));

				$gross_filter_id = [];
					
					if(isset($_REQUEST['gross_wt']) && !empty($_REQUEST['gross_wt']) && !empty($product_ids))
					{
						$gross_wt = $_REQUEST['gross_wt'];
						if($gross_wt == 1){
							$min_gross_wt = 0;
							$max_gross_wt = 100;
						}else if($gross_wt == 2){
							$min_gross_wt = 100;
							$max_gross_wt = 200;
						}else if($gross_wt == 3){
							$min_gross_wt = 200;
							$max_gross_wt = 300;
						}else if($gross_wt == 4){
							$min_gross_wt = 300;
							$max_gross_wt = 400;
						}else if($gross_wt == 5){
							$min_gross_wt = 400;
							$max_gross_wt = 500;
						}else if($gross_wt == 6){
							$min_gross_wt = 500;
							$max_gross_wt = 5000;
						}else{
							$min_gross_wt = 0;
							$max_gross_wt = 100;
						}
						
							$gross_filter_id = $this->CI->db->query('SELECT id AS product_master_id FROM product_master WHERE gross_wt BETWEEN "'.$min_gross_wt.'" AND "'.$max_gross_wt.'" AND id IN ('.$product_ids.')');
							// echo $this->CI->db->last_query();exit;
							if($gross_filter_id->num_rows() > 0)
							{
								$gross_filter_id = $gross_filter_id->result_array();
								$gross_filter_id = array_column($gross_filter_id, 'product_master_id');
							}
							else
							{
								$gross_filter_id = [];
								$check = 0;
							}
					}

					$product_ids = ((!empty($gross_filter_id)) ? implode(",",$gross_filter_id) : (($check != 0) ? $product_ids : []));

					$net_filter_id = [];
					
					if(isset($_REQUEST['net_wt']) && !empty($_REQUEST['net_wt']) && !empty($product_ids))
					{
						$net_wt = $_REQUEST['net_wt'];
						if($net_wt == 1){
							$min_net_wt = 0;
							$max_net_wt = 100;
						}else if($net_wt == 2){
							$min_net_wt = 100;
							$max_net_wt = 200;
						}else if($net_wt == 3){
							$min_net_wt = 200;
							$max_net_wt = 300;
						}else if($net_wt == 4){
							$min_net_wt = 300;
							$max_net_wt = 400;
						}else if($net_wt == 5){
							$min_net_wt = 400;
							$max_net_wt = 500;
						}else if($net_wt == 6){
							$min_net_wt = 500;
							$max_net_wt = 5000;
						}else{
							$min_net_wt = 0;
							$max_net_wt = 100;
						}
						
							$net_filter_id = $this->CI->db->query('SELECT id AS product_master_id FROM product_master WHERE net_wt BETWEEN "'.$min_net_wt.'" AND "'.$max_net_wt.'" AND id IN ('.$product_ids.')');
							// echo $this->CI->db->last_query();exit;
							if($net_filter_id->num_rows() > 0)
							{
								$net_filter_id = $net_filter_id->result_array();
								$net_filter_id = array_column($net_filter_id, 'product_master_id');
							}
							else
							{
								$net_filter_id = [];
								$check = 0;
							}
					}

					$product_ids = ((!empty($net_filter_id)) ? implode(",",$net_filter_id) : (($check != 0) ? $product_ids : []));

					if(!empty($product_ids))
					{
						$all_filter_ids = [];
						
						if(!empty($price_filter_id))
						{
							if(!empty($all_filter_ids))
							{
								$all_filter_ids = array_intersect($all_filter_ids,$price_filter_id);
							}
							else
							{
								$all_filter_ids = array_merge($all_filter_ids,$price_filter_id);
							}
						}

						if(!empty($gross_filter_id))
						{
							if(!empty($all_filter_ids))
							{
								$all_filter_ids = array_intersect($all_filter_ids,$gross_filter_id);
							}
							else
							{
								$all_filter_ids = array_merge($all_filter_ids,$gross_filter_id);
							}
						}

						if(!empty($net_filter_id))
						{
							if(!empty($all_filter_ids))
							{
								$all_filter_ids = array_intersect($all_filter_ids,$net_filter_id);
							}
							else
							{
								$all_filter_ids = array_merge($all_filter_ids,$net_filter_id);
							}
						}

						if($check == 1)
						{
							$product_ids = explode(",",$product_ids);
						}
						else
						{
							$product_ids = array_unique($all_filter_ids);
						}
					}
					else
					{
						$product_ids = [];
					}

					$data[0] = $product_ids;
			}
		}
		else
		{
			$data[0] = [];
		}
		return $data[0];
	}
}