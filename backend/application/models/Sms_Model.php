<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* This is Master Model of the backend system
*/
class Sms_Model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('Sms_Library');
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



	public function send_sms($message,$type)
	{
		$send_sms = array(
	        'message'=>$message,
	        'send_type'=>$type,
	        'created_by'=> $this->session->userdata('username'),
	          );

		$this->db->insert('send_sms',$send_sms);
		return $this->db->insert_id();
	}

	public function send_sms_specific($message,$type,$mobile)
	{
		$send_sms = array(
	        'message'=>$message,
	        'send_type'=>$type,
	        'created_by'=> $this->session->userdata('username'),
	          );

		$this->db->insert('send_sms',$send_sms);
		$insert_id = $this->db->insert_id();


		// send sms to user
		$message = urlencode($message);
        $this->sms_library->send_multiple_sms($mobile,$message);

        $this->db->where('id', $insert_id);
        $this->db->update('send_sms', array('sms_status' => 1));
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