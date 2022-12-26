<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* This is Master Model of the backend system
*/
class Master_Model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	// Insert Data into tables
	public function insert($table_name,$value)
	{
		return $this->db->insert($table_name,$value);
	}

	// Update table data
	public function do_update($tablename,$id,$postvalue)
	{
		return $this->db->where('id',$id)->update($tablename,$postvalue);
	}

	//  Delete particular value from Table
	public function do_delete($tablename,$id)
	{
		return $this->db->where('id',$id)->delete($tablename);
	}

	// Custom Delete Function
	public function do_delete_custom($tablename,$columns)
	{
		return $this->db->where($columns)->delete($tablename);
	}

	// Get Table data without any condition (Example : num_rows)
	public function get_data($tablename, $columns)
	{
		return $this->db->get_where($tablename, $columns);
	}

	// Get Table Num rows
	public function get_num_rows($tablename, $columns)
	{
		return $this->db->get_where($tablename, $columns)->num_rows();
	}

	// Get all data of of table from condition
	public function get_fetch_array($tablename, $columns)
	{
		return $this->db->get_where($tablename, $columns)->result_array();
	}

	// Get all data of table
	public function get_all_data($table)
	{
		return $this->db->query('SELECT * FROM '.$table);
	}

	public function get_onerecord($tablename,$id)
	{
		return $this->db->get_where($tablename,array('id'=>$id))->result_array();
	}

	public function get_columns($tablename='', $columns='', $condition='', $group_by='')
	{
		if($condition!='' && $group_by=='')
		{
			return $this->db->select($columns)->where($condition)->get($tablename)->result_array();
		}
		else if($condition!='' && $group_by!='')
		{
			return $this->db->select($columns)->where($condition)->group_by($group_by)->get($tablename)->result_array();
		}
		else
		{
			return $this->db->select($columns)->get($tablename)->result_array();
		}
	}

	public function updateRecord($tbl_name,$data_array,$where_arr)
	{
		$this->db->where($where_arr,NULL);
		if($this->db->update($tbl_name,$data_array))
		{return true;}
		else
		{return false;}
	}

	public function sendNotification($title,$subtitle,$order_id,$registrationIds){
	    define( 'API_ACCESS_KEY', 'AAAApofyaCQ:APA91bEg13FDkO8aknkKdqUPsXQq9OniMvzm4ttL5WXWQQ0D20-15dL29r2SNB8uUzVQSLoE_6KXGuYJzph8p49SwkAZSsTyUEh-TzidS3xk1dDnluZWM9my1CgT3Hlc6MA7RxXXNMHv');

	    $ch = curl_init("https://fcm.googleapis.com/fcm/send");

	        //The device token.


	        //Title of the Notification.
	        $title = $title;

	        //Body of the Notification.
	        $body = $subtitle;

	        //Creating the notification array.
	        $notification = array('title' =>$title , 'text' => $body);
	        foreach ($registrationIds as $key => $value) {


	        //This array contains, the token and the notification. The 'to' attribute stores the token.
	            
	        // $arrayToSend = array('to' => $value, 'notification' => $notification,'priority'=>'high','click_action'=>'mybooking','data'=>array("title"=>"$title","subtitle"=> "$body","type"=>"test"));
	            $arrayToSend = array('to' => $value,'priority'=>'high','click_action'=>'order_details','data'=>array("title"=>"$title","subtitle"=> "$body","order_id"=>"$order_id"));

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


	public function sendNotificationNew($title,$subtitle,$registrationIds){
	    define( 'API_ACCESS_KEY', 'AAAAwx2rI90:APA91bHQNKnacDMDv1L7vqWAdwSTVbzn5F0voHQ9U_-y-DADbTMLMCaQlGU_NwxC7KX5E3zkQjaFGm1tMhjCkHmafPreJ64ZY0hUJx4Cuon_iPgq71XHwIbcmPkpYefayXsG4e-aDx_N');

	    $ch = curl_init("https://fcm.googleapis.com/fcm/send");

	        //The device token.


	        //Title of the Notification.
	        $title = $title;

	        //Body of the Notification.
	        $body = $subtitle;

	        //Creating the notification array.
	        $notification = array('title' =>$title , 'text' => $body);
	        foreach ($registrationIds as $key => $value) {


	        //This array contains, the token and the notification. The 'to' attribute stores the token.
	            
	        // $arrayToSend = array('to' => $value, 'notification' => $notification,'priority'=>'high','click_action'=>'mybooking','data'=>array("title"=>"$title","subtitle"=> "$body","type"=>"test"));
	            $arrayToSend = array('to' => $value,'priority'=>'high','click_action'=>'order_details','data'=>array("title"=>"$title","subtitle"=> "$body","order_id"=> ""));

	        //Generating JSON encoded string form the above array.
	        $json = json_encode($arrayToSend);
	        //Setup headers:
	        $headers = array();
	        $headers[] = 'Content-Type: application/json';
	        $headers[] = 'Authorization: key= AAAAwx2rI90:APA91bHQNKnacDMDv1L7vqWAdwSTVbzn5F0voHQ9U_-y-DADbTMLMCaQlGU_NwxC7KX5E3zkQjaFGm1tMhjCkHmafPreJ64ZY0hUJx4Cuon_iPgq71XHwIbcmPkpYefayXsG4e-aDx_N'; // key here

	        //Setup curl, add headers and post parameters.
	        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
	        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);       

	        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	        //Send the request
	        $response = curl_exec($ch);
	    }

	    pre($response);
	        //Close request
	    curl_close($ch);
	    //return $result;
	}

    public function send_gcm($worker_id,$gcm_no,$type){

		if($worker_id == NULL){
			$output['ack'] = "0";
			$output['msg'] = 'worker id is mendatory';
			return $output;exit;
		}

		if($gcm_no == NULL){
			$output['ack'] = "0";
			$output['msg'] = 'gcm_no is mendatory';
			return $output;exit;
		}

		if($type == NULL){
			$output['ack'] = "0";
			$output['msg'] = 'type is mendatory';
			return $output;exit;
		}

		//if both field available than update
		if($type == 'worker'){
			$where = array('id'=>$worker_id);
	        $update = array('gcm_no'=>$gcm_no);
	        $this->updateRecord('worker',$update,$where);
	        $output['ack'] = "1";
			$output['msg'] = 'gcm_no updated successfully';
		}else if($type == 'client'){
			$where = array('id'=>$worker_id);
	        $update = array('gcm_no'=>$gcm_no);
	        $this->updateRecord('users',$update,$where);
	        $output['ack'] = "1";
			$output['msg'] = 'gcm_no updated successfully';
		}

        return $output;
	}
}