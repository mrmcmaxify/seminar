<?php
    class seminar_model extends CI_Model{
        public function __construct(){
            $this->load->database();
        }
        
        public function get_seminare(){
            $query = $this->db->get('seminar');
            return $query->result_array();
        }
    }