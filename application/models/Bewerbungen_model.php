<?php
    class Bewerbungen_model extends CI_Model{
        public function __construct(){
            $this->load->database();
        }
        //Liefert alle Bewerbungen der Studenten
        public function get_bewerbungen(){
            
            $this->db->order_by('SeminarID', 'ASC');
            $query = $this->db->get('seminarbewerbung');
            return $query->result_array();
        }

    }