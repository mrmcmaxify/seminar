<?php
    class fristen_model extends CI_Model{
        public function __construct(){
            $this->load->database();
        }
        
        public function get_fristen(){
            $query = $this->db->get('fristen');
            return $query->result_array();
        }
    }