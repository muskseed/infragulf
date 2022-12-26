<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* This is Master Model of the backend system
*/
class Audience_Model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function get_all_user()
	{
		$this->db->select('u.*');
		$this->db->from('users u');
		$this->db->join('usertype ut','ut.id = u.usertype_id');
		$this->db->where('u.delete_flag',1);
		$this->db->where('ut.id !=',1);
		$query = $this->db->get();
		$users = $query->result_array();

		return $users;
	}


	public function get_all_audience()
	{
		$this->db->select('*');
		$this->db->from('audience');
		$query = $this->db->get();
		$audience = $query->result_array();

		return $audience;
	}


	public function get_audience_users($audience_id)
	{
		$this->db->select('u.*');
		$this->db->from('users u');
		$this->db->join('audience_users au','au.users_id = u.id');
		$this->db->where('au.audience_id',$audience_id);
		$query = $this->db->get();
		$audience_users = $query->result_array();

		return $audience_users;
	}




	public function get_users_except_audience($audience_id)
	{
		$temp = [];
		$audience_users = $this->get_audience_users($audience_id);

		foreach ($audience_users as $k1 => $v1) 
		{
			$temp[$k1] = $v1['id'];
		}

		$this->db->select('u.*');
		$this->db->from('users u');
		$this->db->join('usertype ut','ut.id = u.usertype_id');
		$this->db->where('u.delete_flag',1);
		if(isset($temp) && !empty($temp))
		{
			$this->db->where_not_in('u.id', $temp);
		}
		$this->db->where('ut.id !=',1);
		$query = $this->db->get();
		$users = $query->result_array();

		return $users;
	}


	public function insert_user_in_audience($data)
	{
		foreach ($data['check_list'] as $key => $value) 
		{
			$audience_users = array(
	        'users_id'=>$value,
	        'audience_id'=>$data['aud']
	          );

			$this->db->insert('audience_users',$audience_users);
		}

		return true;
	}


	public function delete_user_from_audience($data)
	{
		foreach ($data['check_list'] as $key => $value) 
		{
			$this->db->where('users_id', $value);
	        $this->db->delete('audience_users');
	        // echo $this->db->last_query();exit;

		}

		return true;
	}
}