<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Who extends CI_Controller {

	public function index()
	{
		$data = [];
		$experts = $this->db->query('SELECT * FROM team ORDER BY position ASC')->result_array();

		$data['experts'] = $experts;
		$this->load->view('who' , $data);
	}
}
