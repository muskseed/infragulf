<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* This is Master Model of the backend system
*/
class Csv_Import_Model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function upload_products($data)
  	{
  		$final_error = [];
  		$sku_count = 1;
	    if(!empty($data)){
	      	foreach ($data as $key => $value) {
		        $col_id = '';
		        $short_code = '';
		        $error_msg = '';
		        $array_missing = [];
		        if(!empty($value['cat_name'])){
		          $col_data = $this->db->query("select id ,short_code from collection where LCASE(col_name)='".strtolower(addslashes($value['cat_name']))."' and col_parent_id='0'");
		          if($col_data->num_rows() > 0){
		            $col_data = $col_data->result_array();
		            $parent_id = $col_data[0]['id'];
		            $short_code = $col_data[0]['short_code'];
		            $col_id = $parent_id;
		            // Checking Subcategory 1
		            if(!empty($value['cat_name1']) && !empty($parent_id)){
		              $col1_data = $this->db->query("select id,short_code from collection where LCASE(col_name)='".strtolower(addslashes($value['cat_name1']))."' and col_parent_id='".$parent_id."'");
		              if($col1_data->num_rows() > 0){
		                $col1_data = $col1_data->result_array();
		                $parent_id1 = $col1_data[0]['id'];
		                $short_code = $col1_data[0]['short_code'];
		                $col_id = $parent_id1;
		                // Checking subcategory 2
		                if(!empty($value['cat_name2']) && !empty($parent_id1)){
		                  $col2_data = $this->db->query("select id,short_code from collection where LCASE(col_name)='".strtolower(addslashes($value['cat_name2']))."' and col_parent_id='".$parent_id1."'");
		                  if($col2_data->num_rows() > 0){
		                    $col2_data = $col2_data->result_array();
		                    $parent_id2 = $col2_data[0]['id'];
		                    $short_code = $col2_data[0]['short_code'];
		                    $col_id = $parent_id2;
		                    // Checking sub category 3
		                    if(!empty($value['cat_name3']) && !empty($parent_id2)){
		                      $col3_data = $this->db->query("select id,short_code from collection where LCASE(col_name)='".strtolower(addslashes($value['cat_name3']))."' and col_parent_id='".$parent_id2."'");
		                      if($col3_data->num_rows() > 0){
		                        $col3_data = $col3_data->result_array();
		                        $parent_id3 = $col3_data[0]['id'];
		                        $short_code = $col3_data[0]['short_code'];
		                        $col_id = $parent_id3;
		                        // Checking sub category 4
		                        if(!empty($value['cat_name4']) && !empty($parent_id3))
		                        {
		                          $col4_data = $this->db->query("select id,short_code from collection where LCASE(col_name)='".strtolower(addslashes($value['cat_name4']))."' and col_parent_id='".$parent_id3."'");
		                          if($col4_data->num_rows() > 0){
		                            $col4_data = $col4_data->result_array();
		                            $parent_id4 = $col4_data[0]['id'];
		                            $short_code = $col4_data[0]['short_code'];
		                            $col_id = $parent_id4;
		                            // Checking sub category 5
		                            if(!empty($value['cat_name5']) && !empty($parent_id4)){
		                              $col5_data = $this->db->query("select id,short_code from collection where LCASE(col_name)='".strtolower(addslashes($value['cat_name5']))."' and col_parent_id='".$parent_id4."'");
		                              if($col5_data->num_rows() > 0){
		                                $col5_data = $col5_data->result_array();
		                                $parent_id5 = $col5_data[0]['id'];
		                                $short_code = $col5_data[0]['short_code'];
		                                $col_id = $parent_id5;
		                              }else{
		                                $error_msg .= "cat_name5 is not Available,";
		                                $array_missing = [
		                                	'cat_name5' => $value['cat_name5']
		                                ]; 
		                              }
		                            }
		                          }else{
		                            $error_msg .= "cat_name4 is not Available,";
		                            $array_missing = [
	                                	'cat_name4' => $value['cat_name4']
	                                ]; 
		                          }
		                        }
		                      }else{
		                        $error_msg .= "cat_name3 is not Available,";
		                        $array_missing = [
                                	'cat_name3' => $value['cat_name3']
                                ]; 
		                      }
		                    }
		                  }else{
		                    $error_msg .= "cat_name2 is not Available,";
		                    $array_missing = [
                            	'cat_name2' => $value['cat_name2']
                            ]; 
		                  }
		                }
		              }else{
		                $error_msg .= "cat_name1 is not Available,";
		                $array_missing = [
                        	'cat_name1' => $value['cat_name1']
                        ]; 
		              }
		            }
		          }else{
		            $error_msg .= "cat_name is not Available,";
		            $array_missing = [
                    	'cat_name' => $value['cat_name']
                    ]; 
		          }
		        }else{
		        	$error_msg .= "cat_name is Required,";
		            $array_missing = [
                    	'required' => 'cat_name'
                    ];
		        }
		        // pre($array_missing);
		        if(empty($array_missing)){
		          	if(!empty($value['design_number'])){
			            $manufacturing_che = $this->db->query('SELECT id FROM product_master WHERE manufacturing_code="'.$value['design_number'].'"')->result_array();
			            if(count($manufacturing_che) == 0){
			              	$sku_code = $this->db->query('SELECT id,sku_code FROM product_master ORDER BY id DESC LIMIT 1')->result_array();
			              	if(count($sku_code) > 0)
			                	$sku = $sku_code[0]['sku_code'] + $sku_count;
			              	else
			                	$sku = 1;

			              	$collection_sku_code = $short_code.$sku;
			              	if(isset($value['product_status']) && !empty($value['product_status'])){
			              		if(strtolower($value['product_status']) == 'active')
			              			$product_status = 1;
			              		else
			              			$product_status = 0;
			              	}else
			              		$product_status = 1;

			              	$melting_data = $this->db->query('SELECT id FROM melting WHERE melting_name="'.$value['melting_name'].'"')->result_array();
			              	if(!empty($melting_data)){
			              		$melting_id = $melting_data[0]['id'];
			              	}else{
			              		$melting_id = 0;
			              	}

			              	$worker_data = $this->db->query('SELECT * FROM worker WHERE worker_name="'.$value['worker_name'].'"')->result_array();
			              	if(!empty($worker_data)){
			              		$worker_id 		= $worker_data[0]['id'];
			              		$worker_name 	= $worker_data[0]['worker_name'];
								$worker_name 	= substr($worker_name, 0, 2);
								$worker_code 	= $collection_sku_code.'/'.$worker_name;
			              	}else{
			              		$worker_id 		= 0;
			              		$worker_code 	= '';
			              	}
			              
			              	$final_data = [
				                'sku_code' 				=> $sku,
				                'collection_id' 		=> $col_id,
				                'collection_sku_code' 	=> $collection_sku_code,
				                'manufacturing_code' 	=> $collection_sku_code.'-'.$value['design_number'],
				                'gross_wt' 				=> $value['gross_wt'],
				                'less' 				=> $value['less'],
				                'amount' 				=> $value['amount'],
				                'net_wt' 				=> $value['gross_wt'] - $value['less'],
				                'product_name' 			=> isset($value['product_name']) && !empty($value['product_name']) ? $value['product_name'] : '',
				                'length'				=> isset($value['length']) && !empty($value['length']) ? $value['length'] : '',
				                'mul_length'			=> isset($value['multiple_length']) && !empty($value['multiple_length']) ? $value['multiple_length'] : $value['length'],
				                'size'					=> isset($value['size']) && !empty($value['size']) ? $value['size'] : '',
				                'weight'				=> isset($value['multiple_weight']) && !empty($value['multiple_weight']) ? $value['multiple_weight'] : $value['gross_wt'],
				                'product_status' 		=> $product_status,
				                'delete_flag'			=> 1,
				                'melting_id'			=> $melting_id,
				                'worker_id'				=> $worker_id,
								'worker_code'			=> $worker_code,
								'created'				=> date('Y-m-d H:i:s')
			              	];
			              	// pre($final_data);die;
			              	$success = $this->db->insert('product_master',$final_data);
			              	// echo $this->db->last_query();die;
			              	$sku_count++;
			            }else{
			            	$error_msg .= 'design_number already exist,';
			            }
		          	}else{
		          		$error_msg .= 'design_number is required,';
					}
					if(!empty($error_msg)){
						$array_missing = [
			        		'cat_name' => $value['cat_name'],
			        		'cat_name1' => $value['cat_name1'],
			        		'cat_name2' => $value['cat_name2'],
			        		'cat_name3' => $value['cat_name3'],
			        		'cat_name4' => $value['cat_name4'],
			        		'cat_name5' => $value['cat_name5'],
			        		'design_number' => $value['design_number'],
			        		'gross_wt' => $value['gross_wt'],
			        		'less' => $value['less'],
			        		'product_name' => $value['product_name'],
			        		'error' => $error_msg
			        	];
			        	array_push($final_error, $array_missing);
					}
		        }else{
		        	$array_missing = [
		        		'cat_name' => $value['cat_name'],
		        		'cat_name1' => $value['cat_name1'],
		        		'cat_name2' => $value['cat_name2'],
		        		'cat_name3' => $value['cat_name3'],
		        		'cat_name4' => $value['cat_name4'],
		        		'cat_name5' => $value['cat_name5'],
		        		'design_number' => $value['design_number'],
		        		'gross_wt' => $value['gross_wt'],
		        		'less' => $value['less'],
		        		'product_name' => $value['product_name'],
		        		'error' => $error_msg
		        	];
		        	array_push($final_error, $array_missing);
		        }    
	      	}// end foreach
	      	header("Content-type: application/csv");
            header("Content-Disposition: attachment; filename=\"product_master".".csv\"");
            header("Pragma: no-cache");
            header("Expires: 0");

            $handle = fopen('php://output', 'w');

            foreach ($final_error as $final_error) {
                fputcsv($handle, $final_error);
            }
            fclose($handle);
	    }
  	}
}