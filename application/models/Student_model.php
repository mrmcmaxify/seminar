<?php
    class Student_model extends CI_Model{
        public function __construct(){
            $this->load->database();
        }

       

        //Liest Bachelor-Studenten ohne Seminarplatz aus
        public function get_ba_ohne(){
            
            
            $this->db->select('*');
            $this->db->from('student');
            $this->db->join('seminarbewerbung', 'seminarbewerbung.E-Mail = student.E-Mail', 'inner');
            $this->db->where('#Annahmen', '0');
            $this->db->where('BA/MA', 'BA');
            $this->db->order_by('Fachsemester', 'DESC');
            $this->db->order_by('ECTS', 'DESC');
            $query = $this->db->get();
            return $query->result_array();
        }
        //Liest Master-Studenten ohne Seminarplatz aus
        public function get_ma_ohne(){
            
            $this->db->select('*');
            $this->db->from('student');
            $this->db->join('seminarbewerbung', 'seminarbewerbung.E-Mail = student.E-Mail', 'inner');
            $this->db->where('#Annahmen', '0');
            $this->db->where('BA/MA', 'MA');
            $this->db->order_by('Fachsemester', 'DESC');
            $this->db->order_by('ECTS', 'DESC');
            $query = $this->db->get();
            return $query->result_array();
        }
        //Trägt Studenten in Seminarzuteilung ein und Setzt #Annahmen +1
        public function zuweisen($email, $id){
            $data = array(
                'E-Mail' => $email,
                'SeminarID' => $id,
                
            );
        
            $this->db->insert('Seminarzuteilung', $data);

            $data1 = array(
                '#Annahmen' => '1',
            );
            $this->db->where('E-Mail', $email);
            $this->db->update('student', $data1);

        }

       
        
    }