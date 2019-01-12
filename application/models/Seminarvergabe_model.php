<?php
    class Seminarvergabe_model extends CI_Model{
        public function __construct(){
            $this->load->database();
        }

        
       

        public function get_lehrstuhl($email){
            $this->db->select('LehrstuhlName');
            $this->db->from('lehrstuhl');
            $this->db->where('E-Mail', $email);
            $query=$this->db->get();
            return $query->result_array();
          


        }
        public function get_seminare($lehrstuhl){
            $this->db->select('*');
            $this->db->from('seminarbewerbung');
            $this->db->join('seminar', 'seminar.SeminarID = seminarbewerbung.SeminarID', 'inner');
            $this->db->join('student', 'student.E-Mail = seminarbewerbung.E-Mail', 'inner');
          //  $this->db->where('LehrstuhlName', $lehrstuhl);
            $query=$this->db->get();
            return $query->result_array();
          


        }
    }