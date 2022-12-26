<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Property_management extends CI_Controller {

	public function index()
	{
		$this->load->view('property-management');
	}
}
