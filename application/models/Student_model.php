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

        //Trägt Studenten, die vom Lehrstuhl zugewiesen wurden, in Seminarzuteilung ein und Setzt #Annahmen +1
        public function zuweisen_durch_lehrstuhl($email, $id, $fristid){
            $data2 = array(
                'E-Mail' => $email,
                'SeminarID' => $id,
                'PhasenID' => $fristid,
            );
        
            $this->db->insert('Seminarzuteilung', $data2);

            $data1 = array(
                '#Annahmen' => '1',
            );
            $this->db->where('E-Mail', $email);
            $this->db->update('student', $data1);
            return true;

        }


            // Liest seminarbewerbungen ein
            public function bewerbung_hinzufuegen(){
                    

                //User data array(seminarbewerbung)
                $data = array(
                'e-mail' => $this->input->post('e-mail'),
                'seminarid' => $this->input->post('seminarid'),
                'ms' => $this->input->post('ms'),                 
                );

                //insert seminarbewerbung(seminarbewerbung)
                return $this->db->insert('seminarbewerbung', $data);
            }

        //Gibt zurück, ob der Student die Höchstanzahl an Seminarbewerbungen schon erreicht hat
        public function get_anzahl_bewerbungen($email){
            $this->db->select('#Bewerbungen');
            $this->db->from('student');
            $this->db->where('E-Mail', $email);
            $query = $this->db->get();
            return $query->result_array();
        }

        //Löscht alle Einträge bei Tabelle student
        public function delete_students(){
            return $this->db->empty_table('student');
        }

        //Löscht alle Einträge bei benutzeraccount mit Rolle student
        public function delete_users_students(){
            $this->db->where('Rolle', 'student');
            return $this->db->delete('benutzeraccount');
        }

        //LÖscht die HisQis Auszüge und Motivationsschreiben
        public function deleteUploadFiles(){
            $path = $_SERVER['DOCUMENT_ROOT'].'/seminar/uploads/';
            $files = glob($path.'*'); // get all file names
            foreach($files as $file){ // iterate files
            if(is_file($file))
                unlink($file);
            }   
        }
    }
       
        