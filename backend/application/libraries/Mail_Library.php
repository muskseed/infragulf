<?php

class Mail_Library
{
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->model('Master_Model');
	}

	public function send_mail($post){
		$send_email 	= $post['email'];
		$subject 		= $post['subject'];
		$content 		= $post['content'];
		$mail = new PHPMailer();
		// print_r($mail);exit;
		$mail->IsSMTP();
		$mail->Host = "jewelmarts.in";

		$mail->SMTPAuth = true;
		//$mail->SMTPSecure = "ssl";
		$mail->Port = 587;
		$mail->Username = "support@jewelmarts.in";
		$mail->Password = "mK2;u^0wcWdq";

		$mail->From = "shubh@gmail.com";
		$mail->FromName = BRAND_NAME;
		$mail->AddAddress($send_email);
		//$mail->AddReplyTo("mail@mail.com");

		$mail->IsHTML(true);

		$mail->Subject = $subject;
		$mail->Body = $content;
        
        if($mail->Send()){
        	$return = 1;
        }else{
        	$return = 0;
        }
        return $return;
	}
}