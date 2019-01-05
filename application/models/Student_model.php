<?php
    class Student_model extends CI_Model{
        public function __construct(){
            $this->load->database();
        }
        
        public function get_ba_ohne(){
            
            $this->db->order_by('Name', 'ASC');
            $this->db->where('#Annahmen', '0');
            $this->db->where('BA/MA', 'BA');
            $query = $this->db->get('student');
            return $query->result_array();
        }

        public function get_ma_ohne(){
            
            $this->db->order_by('Name', 'ASC');
            $this->db->where('#Annahmen', '0');
            $this->db->where('BA/MA', 'MA');
            $query = $this->db->get('student');
            return $query->result_array();
        }

        
    }