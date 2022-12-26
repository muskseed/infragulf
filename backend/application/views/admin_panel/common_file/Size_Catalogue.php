<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Size_Catalogue extends CI_Controller
{
	protected $check_module="";

	public function __construct()
	{
		parent::__construct();
		$this->check_module = array(
            'view_perm' => 1,
            'edit_perm' => 1,
            'delete_perm' => 1,
            'add_perm' => 1
        );
	}

	public function index()
	{
		if($this->check_module['view_perm']==1 || $this->check_module['edit_perm']==1 || $this->check_module['delete_perm']==1)
        {
            $this->load->view('backend/size_catalogue/size_catalogue_list',['check_module'=>$this->check_module]);
        }
        else
        {
            redirect("backend/Size_Catalogue/form_view/add");
        }
	}

	public function form_view($mode='',$id='')
	{
		$data = [];

		$data['check_module'] = $this->check_module;

		$data['mode']=$mode;

		$custom_fields = $this->jfv4_library->get_module_custom_fields('Size_Catalogue',$id);
		
		$data['custom_fields'] = $custom_fields;
		
		$data['mode']=$mode;

        if($this->check_module['add_perm']==1 && $mode=='add')
        {
            $this->load->view('backend/size_catalogue/size_catalogue_form',$data);
        }
       	else if($mode=='edit' && $this->check_module['view_perm']==1)
        {
           	$data['size_catalogue1'] = $this->Master_Model->get_onerecord('size_catalogue',$id);

           	$size_catalogue = $this->Master_Model->get_onerecord('size_catalogue',$id);

			$set_array = [
							'id' => $size_catalogue[0]['id'],
							'catalogue_name' => $size_catalogue[0]['catalogue_name'],
							'default_size_id' => $size_catalogue[0]['default_size_id'],
							'rate_increase' => $size_catalogue[0]['rate_increase'],
							'rate_decrease' => $size_catalogue[0]['rate_decrease'],
							'calculation_type' => $size_catalogue[0]['calculation_type']
						 ];

			$data['edit_data'] = $set_array;
			
			$size_catalogue_data = $this->db->select('sizes_id')->from('size_catalogue_values')->where(['size_catalogue_id' => $size_catalogue[0]['id']])->get()->result_array();
			
			$sizes = [];

			foreach($size_catalogue_data as $key => $value)
			{
				array_push($sizes,$value['sizes_id']);
			}
			
			$set_array_1 = ['sizes_id' => $sizes ];

		   	$data['edit_data'] = array_replace($data['edit_data'],$set_array_1);
		   	$this->load->view('backend/size_catalogue/size_catalogue_form',$data);
        }
        else
        {
            redirect('backend/Error');
        }
	}

	public function form_action($id='')
	{
		
		$customFeildsArr = $this->jfv4_library->get_custom_field_values('Size_Catalogue');

		$postdata = array(
					'catalogue_name' => $_POST['catalogue_name'],
					'default_size_id' => $_POST['default_size_id'],
					'rate_increase' => $_POST['rate_increase'],
					'rate_decrease' => $_POST['rate_decrease'],
					'calculation_type' => $_POST['calculation_type']
				);

		$postdata = $this->jfv4_library->trim_spaces_from_postdata_values($postdata);
		// pre($postdata);exit;
		if($id)
		{
			$postdata['updated_by'] = $this->session->userdata('id');
			// Update Data
			$this->Master_Model->do_update('size_catalogue',$id,$postdata);
			$this->db->delete('size_catalogue_values',['size_catalogue_id'=>$id]);

			foreach($_POST['sizes_id'] as $value)
			{
				$postvalue = [
							'sizes_id' => $value,
							'size_catalogue_id' => $id,
							'updated_by' => $this->session->userdata('id')
						];
				
				$success = $this->Master_Model->do_insert('size_catalogue_values',$postvalue);
			}

			$this->jfv4_form->get_alert_messages('Success','Your Data Updated Successfully');
		}
		else
		{
			$postdata['created_by'] = $this->session->userdata('id');

			//Insert Data 
			if($this->db->get_where('size_catalogue',['catalogue_name'=>$postdata['catalogue_name']])->num_rows()==0)
			{
				$this->Master_Model->do_insert('size_catalogue',$postdata);
				$last_inserted_id = $this->db->insert_id();

				foreach($_POST['sizes_id'] as $value)
				{
					$postvalue = array(
									'sizes_id' => $value,
									'size_catalogue_id' => $last_inserted_id,
									'created_by' => $this->session->userdata('id')
								   );

					$success = $this->Master_Model->do_insert('size_catalogue_values',$postvalue);
				}

				$this->jfv4_form->get_alert_messages('Success','Your Data Inserted Successfully');
			}
			else
			{
				$success = 1;
				$this->jfv4_form->get_alert_messages('Danger','Size Catalogue Already Exists');	
			}
		}

		$record_id = $id ? $id : $last_inserted_id;
		$this->jfv4_library->insert_custom_field_values($customFeildsArr,$record_id);

		//If Success then redirect to List view
		if($success) redirect('backend/Size_Catalogue');
	}
	
	public function list_view()
	{	
		$sIndexColumn = "id";
		$sColumns = array('catalogue_name','id');
		$sTable = 'size_catalogue';
		$custom_condition = '';
		$sOrder = '';

		$output = $this->jfv4_library->datatable($sIndexColumn,$sColumns,$sTable,$custom_condition,$sOrder);

		$rResult = $output['rawdata'];

		$checkedA = explode(',', $_REQUEST['checked_values']);

		foreach($rResult as $aRow)
        {
        	$row = array();
        	$action_str = '';

        	$checkbox_str = '<input type="checkbox" class="styled" value="'.$aRow['id'].'" name="list_checkbox[]" ';

        	if(in_array($aRow['id'], $checkedA))
        	{
        		$checkbox_str .= 'checked="checked" >';
        	}
        	else
        	{
        		$checkbox_str .= '>';
        	}

        	$row[] = $checkbox_str;

        	foreach($aRow as $key=>$value)
            {
                $row[] = $value;
            }

            $entryId = end($row);
            array_pop($row);

            $action_str .= '<div class="btn-group">
								<a href="'.base_url().'backend/Size_Catalogue/form_view/edit/'.$entryId.'" class="btn btn-default">Edit</a>
							</div>';

            $row[] = $action_str;

			$row['DT_RowId'] = $entryId;

			if(in_array($aRow['id'], $checkedA))
			{
				$row['DT_RowClass'] = 'selected';
			}

            $output['data'][] = $row;
        }

        $output['rawdata'] = '';
		echo json_encode( $output );
	}

	public function delete($id='')
    {
    	if($this->check_module['delete_perm']==1)
    	{
    		if(isset($_POST['search_data']))
	        {
	            $delete_ids = explode(',',$_POST['search_data']);
	            
	            foreach($delete_ids as $key => $value)
	            {
	                $success = $this->db->where(['size_catalogue_id' => $value])->delete('size_catalogue_values');
	                
	                if($success)
	                {
	                	$success = $this->db->where(['id' => $value])->delete('size_catalogue');
	                }
	            }
	        }

	        if($success)
	        {
	            $this->jfv4_form->get_alert_messages('Danger','Your Data Deleted Successfully');
	            redirect('backend/Size_Catalogue');
	        }
    	}
    	else
    	{
    		redirect('backend/Error');
    	}
    }
}