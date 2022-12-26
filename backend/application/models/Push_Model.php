<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* This is Master Model of the backend system
*/
class Push_Model extends CI_Model
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

		// pre($users);exit;

		return $users;
	}


	public function all_notification_sent()
	{

		$this->db->select('id');
        $this->db->from('users');
        $this->db->where('user_status','Available');
        $query = $this->db->get();
        $users = $query->num_rows();


		$this->db->select('id');
		$this->db->from('send_push');
		$this->db->where('push_status',1);
		$this->db->where('send_type',1);
		$query = $this->db->get();
		$all_notification_users = $query->num_rows();
		// pre($all_notification_users);exit;


		$all_notification_sent = ($all_notification_users * $users);
		

		return $all_notification_sent;
	}




	public function audience_notification_sent()
	{
		$this->db->select('*');
		$this->db->from('send_push_selective');
		$this->db->where('status',1);
		$this->db->where('status',3);
		$query = $this->db->get();
		$audience_notification_sent = $query->num_rows();

		// pre($users);exit;

		return $audience_notification_sent;
	}



	public function selective_notification_sent()
	{
		$this->db->select('*');
		$this->db->from('send_push_selective');
		$this->db->where('status',1);
		$this->db->where('send_type',2);
		$query = $this->db->get();
		$selective_notification_sent = $query->num_rows();

		// pre($users);exit;

		return $selective_notification_sent;
	}

	public function push_key()
	{
		$this->db->select('value');
		$this->db->from('system_settings');
		$this->db->where('key','push_key');
		$query = $this->db->get();
		$push_key = $query->result_array();

		return $push_key;
	}


	public function get_all_audience()
	{
		$this->db->select('a.id,a.audience_name');
		$this->db->from('audience a');
		$this->db->join('audience_users au','au.audience_id = a.id','left');
		$this->db->group_by('au.audience_id');
		$this->db->where('au.audience_id !=','');
		$query = $this->db->get();
		$audience = $query->result_array();

		// pre($audience);exit;

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



	public function send_push($message,$type)
	{
		$send_push = array(
	        'message'=>$message,
	        'send_type'=>$type,
	        'created_by'=> $this->session->userdata('username'),
	          );

		$this->db->insert('send_push',$send_push);
		return $this->db->insert_id();
	}


	public function set_cron($url, $occurrence)
	{
		$output = shell_exec('crontab -u www-data -l > /var/www/html/bitcoin_new/bitcoin.bak');
		$result = file_get_contents('/var/www/html/bitcoin_new/bitcoin.bak');
		// pre($result);
		$result = file_put_contents('/var/www/html/bitcoin_new/bitcoin.bak', $result.''.$occurrence[0].' '.$occurrence[1].' '.$occurrence[2].' '.$occurrence[3].' '.$occurrence[4].' curl '.$url.''.PHP_EOL);
		$output = shell_exec('crontab /var/www/html/bitcoin_new/bitcoin.bak');
		$output = shell_exec('sudo service apache2 restart');

		// echo "Url : ".$url."<br />";
		// pre($occurrence);
		// $output = shell_exec('crontab -u www-data -l');
		// echo "<pre>$output</pre>";
	}
}