<?php
    class Student_model extends CI_Model{
        public function __construct(){
            $this->load->database();
        }
        //Liest Bachelor-Studenten ohne Seminarplatz aus
        public function get_ba_ohne(){
            
            $this->db->order_by('Fachsemester', 'DESC');
            $this->db->order_by('ECTS', 'DESC');
            $this->db->where('#Annahmen', '0');
            $this->db->where('BA/MA', 'BA');
            $query = $this->db->get('student');
            return $query->result_array();
        }
        //Liest Bachelor-Studenten ohne Seminarplatz aus
        public function get_ma_ohne(){
            
            $this->db->order_by('Fachsemester', 'DESC');
            $this->db->order_by('ECTS', 'DESC');
            $this->db->where('#Annahmen', '0');
            $this->db->where('BA/MA', 'MA');
            $query = $this->db->get('student');
            return $query->result_array();
        }

       
        
    }