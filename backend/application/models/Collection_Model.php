<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* This is Master Model of the backend system
*/
class Collection_Model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function get_all_user_with_token()
	{
		$where="ust.user_id = u.id";
		$this->db->select('u.*');
		$this->db->from('users u');
		$this->db->join('usertype ut','ut.id = u.usertype_id','left');
		$this->db->join('users_token ust','ust.user_id = u.id','left');
		$this->db->where('u.delete_flag',1);
		$this->db->where($where);
		$this->db->where('ut.id !=',1);
		$query = $this->db->get();
		$users = $query->result_array();

		// echo $this->db->last_query();exit;

		return $users;
	}


	
}