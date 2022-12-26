<?php 
class Bitcoin_Library
{
	protected $CI="";

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->model('Master_Model');
		if($this->CI->session->userdata('mobile_number') == '')
		{
			redirect('Login');
		}
		
	}

	public function check_access_perm_old($usertype='',$module_name='',$mode='')
    {
    	if(empty($this->CI->session->userdata('mobile_number')))
		{
			redirect('Login');
		}
		else
		{
			if($usertype != '' && $module_name != '')
			{
				//echo "entered";exit;
				$this->CI->db->select('access_permission.view_access, access_permission.edit_access, access_permission.delete_access, access_permission.add_access, module.module_name')
             	->from('access_permission')
             	->join('module', 'module.id=access_permission.module_id')
             	->where('access_permission.usertype_id',$usertype)
             	->where('module.module_name',$module_name);

            	$access_perm = $this->CI->db->get()->result_array();
            	// print_r($access_perm);exit;
            	if($access_perm)
            	{
        			$session_data = ['add_access'=>$access_perm[0]['add_access'], 'edit_access'=>$access_perm[0]['edit_access'], 'delete_access'=>$access_perm[0]['delete_access'], 'view_access'=>$access_perm[0]['view_access'],'module_name' => $access_perm[0]['module_name']];

	            	$this->CI->session->set_userdata($session_data);

	            	if(isset($access_perm) && ($access_perm[0]['add_access']==1 || $access_perm[0]['edit_access']==1 || $access_perm[0]['delete_access']==1 || $access_perm[0]['view_access']==1))
		            {
		            	
		            	return $access_perm[0];
		            }
		            else
		            {
		            	redirect('backend/Error');
		            }
            	}
            	else
            	{
            		redirect('backend/Error');
            	}
			}
		}
    }

	public function check_access_perm($usertype='',$module_name='',$mode='')
    {
    	if(empty($this->CI->session->userdata('mobile_number')))
		{
			redirect('Login');
		}
		else
		{
			if($usertype != '' && $module_name != '')
			{
				$access_perm = ['add_access' => 1 , 'view_access' => 1 , 'delete_access' => 1 , 'edit_access' => 1];
				return $access_perm;
			}
		}
    }
}