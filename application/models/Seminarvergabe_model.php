<?php
    class Seminarvergabe_model extends CI_Model{
        public function __construct(){
            $this->load->database();
        }

        
       

      /*  public function get_lehrstuhl($email){
            $this->db->select('LehrstuhlName');
            $this->db->from('lehrstuhl');
            $this->db->where('E-Mail', $email);
            $query=$this->db->get();
            return $query->result_array();
         


        }
        */ 

        // Liefert alle Seminarbewerbungen des jeweiligen (angemeldeten) Lehrstuhls
        public function get_seminarbewerbung($email){
            $this->db->select('student.E-Mail, seminarbewerbung.SeminarID, student.Fachsemester, student.BA/MA, student.ECTS, student.HisQis, seminarbewerbung.MS');
            $this->db->from('seminarbewerbung');
            $this->db->join('seminar', 'seminar.SeminarID = seminarbewerbung.SeminarID', 'inner');
            $this->db->join('student', 'student.E-Mail = seminarbewerbung.E-Mail', 'inner');
            $this->db->join('lehrstuhl', 'lehrstuhl.LehrstuhlName = seminar.LehrstuhlName', 'inner');
            $this->db->where('lehrstuhl.E-Mail', $email);
            $query=$this->db->get();
            return $query->result_array();
          


        }

        //Gibt die Zuteilung von Studenten und Seminarplatz aus
        public function get_zuteilung($email, $id){
            $this->db->select('seminarzuteilung.E-Mail, seminarzuteilung.SeminarID, seminarzuteilung.PhasenID');
            $this->db->from('seminarzuteilung');
            $this->db->join('seminar', 'seminar.SeminarID = seminarzuteilung.SeminarID', 'inner');
            $this->db->join('lehrstuhl', 'lehrstuhl.LehrstuhlName = seminar.LehrstuhlName', 'inner');
            $this->db->where('lehrstuhl.E-Mail', $email);
            $this->db->where('seminarzuteilung.PhasenID', $id);
            $query=$this->db->get();
            return $query->result_array();
        }

        // Liefert alle Seminarbewerbungen des jeweiligen (angemeldeten) Lehrstuhls
        public function get_seminare($email){
            $this->db->select('*');
            $this->db->from('seminar');
            $this->db->join('lehrstuhl', 'lehrstuhl.LehrstuhlName = seminar.LehrstuhlName', 'inner');
            $this->db->where('lehrstuhl.E-Mail', $email);
            $query=$this->db->get();
            return $query->result_array();
          


        }
       
        
        //Löscht die Zuteilung eines Seminarplatzes
        public function zuteilung_entfernen($email, $id){
            $this->db->where('E-Mail', $email);
            return $this->db->where('SeminarID', $id)->delete('seminarzuteilung');
        }

        //Löscht das Seminar aus der Datenbank
        public function seminar_entfernen($id){
            return $this->db->where('SeminarID', $id)->delete('seminar');
        }
    }