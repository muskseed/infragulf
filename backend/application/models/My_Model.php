<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_Model extends CI_Model {
    // private $smdb;
    // private $mfdb
    // private $ipo_db;
    public $db;
    public $env;
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function makeConnection($params){
        $env = $params['env'];
        
        if($env=='db')
            $this->$env    = $this->load->database();
        else
            $this->$env   = $this->load->database($params['env'], TRUE);
        
    }

    private function closeConnection($params){
        $env = $params['env'];
        $this->$env->close();
    }

   
    public function get_table_data_with_type($params)
    {    
        $env ='db';
        if(!empty($params['env']))
            $env = $params['env'];
        // pre($params);die;
        $this->makeConnection($params);
        // pre($this->$env);die;
        
        if(!empty($params['distinct']))
        $this->$env->distinct();
        
        if(empty($params['escape_fields']))
            $params['escape_fields'] = TRUE;
        
        $this->$env->select($params['select_data'],$params['escape_fields']);
        
        $this->$env->from($params['table_name']);
        
        if(!empty($params['where']) && !empty($params['where_data'])){
            if($params['where_escape'])            
                $this->$env->where($params['where_data'], NULL, FALSE);
            else
            $this->$env->where($params['where_data']);
        }

        if(!empty($params['where_in']))
            $this->$env->where_in($params['where_in_field'], $params['where_in_data']);

        if(!empty($params['where_or']))
            $this->$env->or_where($params['where_or_data']);

        if(!empty($params['where_in_multi']))
        {
            foreach ($params['where_in_multi_data'] as $field => $field_value) 
                $this->$env->where_in($field, $field_value);
        }

        if(!empty($params['where_like']))
            $this->$env->like($params['where_like_data']);

        if(!empty($params['where_like_or']))
        {
            $where_like_or_str = "(";
             foreach ($params['where_like_or_data'] as $like_field => $like_array) 
                foreach ($like_array as $key => $like_value) 
                     $where_like_or_str .= " ".$like_field ." like '%".$like_value."%' OR";
            
            $where_like_or_str = substr($where_like_or_str, 0, -3); 
            $where_like_or_str .= ")";   
            $this->$env->where($where_like_or_str);
        }

        if(!empty($params['limit_data']))
            $this->$env->limit($params['limit_data'], $params['limit_start']);

        if(!empty($params['order_by']))
            $this->$env->order_by($params['order_by']);

        if(!empty($params['group_by']))
            $this->$env->group_by($params['group_by']);

        if(!empty($params['having'])){
           if(!empty($params['having_escape'])) 
                $this->$env->having($params['having'],null,false);
           else
                $this->$env->having($params['having']);
        }
            
        if(!empty($params['where_not_in']))
            $this->$env->where_not_in($params['where_not_in_field'],$params['where_not_in_array']);
        // x($params);

        if(!empty($params['db_prefix']))
            $this->$env->set_dbprefix($params['db_prefix_value']);

        if(!empty($params['join'])){
            if(!empty($params['multiple_joins'])){
                foreach($params['join_table'] as $k => $v){
                    $this->$env->join($v, $params['join_on'][$k], $params['join_type'][$k]);
                }
            }else $this->$env->join($params['join_table'], $params['join_on'], $params['join_type']);
        }
        
        $result = $this->$env->get();

        if(!empty($params['print_query']))
            echo '<BR>'.$this->$env->last_query();
        
        if(!empty($params['print_query_exit']))
        {
            // x($result,'asdasd');
            echo '<BR>'.$this->$env->last_query();
            exit;
        }

        // x($this->$env);
        
        if(!empty($result))
        {
            $this->closeConnection($params);
            //echo '<BR>'.$this->$env->last_query();//exit();
            if($result->num_rows() > 0)
            {
                if(empty($params['count']))
                {
                    if(!empty($params['return_array']))
                        return $result->result_array();
                    else
                        return $result->result();
                }
                else
                    return $result->num_rows();
            }
            else
                return false;
         }
            else
                return false;
        
    }



    public function update_table_data_with_type($params)
    {
        //echo "<pre>";print_r($params);exit;
        $env ='db';
        if(!empty($params['env']))
            $env = $params['env'];
            
        $this->makeConnection($params);
        
        if(!empty($params['batch']))
        {
            $this->$env->update_batch($params['table_name'], $params['update_data'], $params['where_key']); 
        }
        else
        {
            if(!empty($params['where_in']))
                $this->$env->where_in($params['where_in_field'], $params['where_in_data']);
            if(!empty($params['where_data']))
                $this->$env->where($params['where_data']);
            $this->$env->update($params['table_name'],$params['update_data']);
            // x($params);

        }

        if(!empty($params['print_query']))
            echo '<BR>'.$this->$env->last_query();
        
        if(!empty($params['print_query_exit']))
        {
            echo '<BR>'.$this->$env->last_query();
            exit;
        }
        $affected_rows = $this->$env->affected_rows();
        $this->closeConnection($params);
        return $affected_rows;
    }

    public function insert_table_data($params)
    {
        // x($params);
        $env ='db';
        if(!empty($params['env']))
            $env = $params['env'];
        $this->makeConnection($params);
        if(!empty($params['batch']))
            $this->$env->insert_batch($params['table_name'], $params['data']);
        else
            $this->$env->insert($params['table_name'], $params['data']);
        
        if(!empty($params['print_query']))
            echo '<BR>'.$this->$env->last_query();
        
        if(!empty($params['print_query_exit']))
        {
            echo '<BR>'.$this->$env->last_query();
            exit;
        }
        
        $insert_id  = $this->$env->insert_id();
        $this->closeConnection($params);
        return $insert_id;
    }

    public function delete_table_data($params)
    {
         $env ='db';
        if(!empty($params['env']))
            $env = $params['env'];
        
        $this->makeConnection($params);
        // echo "<pre>";print_r($this->db);exit;    
        if(empty($params['batch_key']))
            $this->$env->where($params['where_data']);
        else
           $this->$env->where_in($params['batch_key'],$params['where_data']);
       
        $this->$env->delete($params['table_name']);

        if(!empty($params['print_query']))
            echo '<BR>'.$this->$env->last_query();
        
        if(!empty($params['print_query_exit']))
        {
            echo '<BR>'.$this->$env->last_query();
            exit;
        }
        
        $affected_rows = $this->$env->affected_rows();
        $this->closeConnection($params);
        return $affected_rows;        
    }

    function truncate_table($params)
    {
        if(!empty($params['env']))
        {
            $this->makeConnection($params);
            $env = $params['env'];
            $this->$env->truncate($params['table_name']); 
            $this->closeConnection($params);
        }
    }

    function execute_query($params)
    {
        $this->makeConnection($params);
        $result = $this->$params['env']->query($params['query']);

        if(!empty($params['print_query']))
            echo '<BR>'.$this->$params['env']->last_query();
        
        if(!empty($params['print_query_exit']))
        {
            echo '<BR>'.$this->$params['env']->last_query();
            exit;
        }
        $this->closeConnection($params);
        return $result;
        /*if($result->num_rows() > 0)
                return $result->result();
            else
                return false;*/
    }
    
    function get_result_execute_query($params)
    {
        $this->makeConnection($params);
        $result = $this->$params['env']->query($params['query']);

        if(!empty($params['print_query']))
            echo '<BR>'.$this->$params['env']->last_query();
        
        if(!empty($params['print_query_exit']))
        {
            echo '<BR>'.$this->$params['env']->last_query();
            exit;
        }
        // return $result;
        if(!empty($result)) 
        {
            $this->closeConnection($params);
            //echo '<BR>'.$this->$env->last_query();//exit();
            if($result->num_rows() > 0)
            {
                if(empty($params['count']))
                {
                    if(!empty($params['return_array']))
                        return $result->result_array();
                    else
                        return $result->result();
                }else
                    return $result->num_rows();
            }else
                return false;
         }else
            return false;
    }
    
    function encrypt_decrypt($action, $string) {
        $output = false;

        // hash
        $key = hash('sha256', ENCRYPT_SECRET_KEY);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', ENCRYPT_SECRET_IV), 0, 16);

        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, ENCRYPT_METHOD, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), ENCRYPT_METHOD, $key, 0, $iv);
        }
        // $this->closeConnection($params);
        return $output;
    }
    
}

/* End of file samco_model.php */
/* Location: ./application/models/star_model.php */
