<?php
    class Seminarvergabe_model extends CI_Model{
        public function __construct(){
            $this->load->database();
        }

        
       

     

        // Liefert alle Seminarbewerbungen des jeweiligen (angemeldeten) Lehrstuhls
        public function bewerbung($email){
            $this->db->select('student.E-Mail, seminarbewerbung.SeminarID, student.Fachsemester, student.BA/MA, student.ECTS, student.HisQis, seminarbewerbung.MS, seminar.MSnotwendig');
            $this->db->from('seminarbewerbung');
            $this->db->join('seminar', 'seminar.SeminarID = seminarbewerbung.SeminarID', 'inner');
            $this->db->join('student', 'student.E-Mail = seminarbewerbung.E-Mail', 'inner');
            $this->db->join('lehrstuhl', 'lehrstuhl.LehrstuhlName = seminar.LehrstuhlName', 'inner');
            $this->db->where('lehrstuhl.E-Mail', $email);
            $this->db->where('Eingeladen', '0');
            $query=$this->db->get();
            return $query->result_array();
          


        }

        // Liefert alle Seminarbewerbungen des ausgewählten Seminars des (angemeldeten) Lehrstuhls
        public function get_seminarbewerbung_seminarid($email, $seminarid){
            $this->db->select('student.E-Mail, student.Name, student.Studiengang, student.Vorname, seminar.SeminarName, seminarbewerbung.SeminarID, student.Fachsemester, student.BA/MA, student.ECTS, student.HisQis, seminarbewerbung.MS, seminar.MSnotwendig');
            $this->db->from('seminarbewerbung');
            $this->db->join('seminar', 'seminar.SeminarID = seminarbewerbung.SeminarID', 'inner');
            $this->db->join('student', 'student.E-Mail = seminarbewerbung.E-Mail', 'inner');
            $this->db->join('lehrstuhl', 'lehrstuhl.LehrstuhlName = seminar.LehrstuhlName', 'inner');
            $this->db->where('lehrstuhl.E-Mail', $email);
            $this->db->where('seminarbewerbung.SeminarID', $seminarid);
            $this->db->where('Eingeladen', '0');
            $query=$this->db->get();
            return $query->result_array();
          


        }

        //Gibt die Zuteilung von Studenten und Seminarplatz aus
        public function get_zuteilung($email, $id){
            $this->db->select('teilnehmer.E-Mail, teilnehmer.SeminarID, teilnehmer.PhasenID');
            $this->db->from('teilnehmer');
            $this->db->join('seminar', 'seminar.SeminarID = teilnehmer.SeminarID', 'inner');
            $this->db->join('lehrstuhl', 'lehrstuhl.LehrstuhlName = seminar.LehrstuhlName', 'inner');
            $this->db->where('lehrstuhl.E-Mail', $email);
            $this->db->where('teilnehmer.PhasenID', $id);
            $query=$this->db->get();
            return $query->result_array();
        }

        //Gibt die Zuteilung von Studenten und Seminarplatz des jeweiligen Seminars aus
        public function get_zuteilung_seminarid($email, $fristid, $seminarid){
            $this->db->select('teilnehmer.E-Mail, teilnehmer.SeminarID, teilnehmer.PhasenID');
            $this->db->from('teilnehmer');
            $this->db->join('seminar', 'seminar.SeminarID = teilnehmer.SeminarID', 'inner');
            $this->db->join('lehrstuhl', 'lehrstuhl.LehrstuhlName = seminar.LehrstuhlName', 'inner');
            $this->db->where('lehrstuhl.E-Mail', $email);
            $this->db->where('teilnehmer.PhasenID', $fristid);
            $this->db->where('teilnehmer.SeminarID', $seminarid);
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
       
        
        //Löscht die Zuteilung eines Seminarplatzes in Teilnehmer
        public function zuteilung_entfernen($email, $id){
            $data = array(
                'Eingeladen' => '0',
            );
            $this->db->where('E-Mail', $email);
            $this->db->where('SeminarID', $id);
            $this->db->update('seminarbewerbung', $data);

            $this->db->where('E-Mail', $email);
            return $this->db->where('SeminarID', $id)->delete('teilnehmer');
        }

        //Löscht das Seminar aus der Datenbank
        public function seminar_entfernen($id){
            return $this->db->where('SeminarID', $id)->delete('seminar');
        }

        public function get_verteilung_gesamt_query($email){
            $this->db->select('teilnehmer.E-Mail, teilnehmer.SeminarID');
            $this->db->from('teilnehmer');
            $this->db->join('seminar', 'seminar.SeminarID = teilnehmer.SeminarID', 'inner');
            $this->db->join('lehrstuhl', 'lehrstuhl.LehrstuhlName = seminar.LehrstuhlName', 'inner');
            $this->db->where('lehrstuhl.E-Mail', $email);
            return $query=$this->db->get();
        }

        public function get_verteilung_gesamt_seminar($email, $seminarid){
            $this->db->select('teilnehmer.E-Mail, teilnehmer.SeminarID');
            $this->db->from('teilnehmer');
            $this->db->join('seminar', 'seminar.SeminarID = teilnehmer.SeminarID', 'inner');
            $this->db->join('lehrstuhl', 'lehrstuhl.LehrstuhlName = seminar.LehrstuhlName', 'inner');
            $this->db->where('lehrstuhl.E-Mail', $email);
            $this->db->where('teilnehmer.SeminarID', $seminarid);
            $query=$this->db->get();
            return $query->result_array();
        }

        // Liefert den Namen eines Seminars nach ID
        public function get_seminarname($seminarid){
            $this->db->select('SeminarName');
            $this->db->from('seminar');
            $this->db->where('SeminarID', $seminarid);
            $query=$this->db->get();
            return $query->result_array();
        }
    }