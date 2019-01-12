<?php
    class fristen_model extends CI_Model{
        public function __construct(){
            $this->load->database();
        }
        
        public function get_fristen(){
            $query = $this->db->get('fristen');
            return $query->result_array();
        }

        public function get_namen(){

            
            $query = $this->db->get('fristen');
            return $query->result_array();
        }
    }