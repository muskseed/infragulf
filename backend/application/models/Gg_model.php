<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gg_model extends My_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
}