<?php
    class seminar_model extends CI_Model{
        public function __construct(){
            $this->load->database();
        }
        
        public function get_seminare(){
            $query = $this->db->get('seminar');
            return $query->result_array();
        }

        //Gibt alle Seminare aus, auf die sich ein bestimmter Student beworben hat
        public function get_seminare_beworben($email){
            $this->db->select('*');
            $this->db->from('seminarbewerbung');
            $this->db->join('seminar', 'seminarbewerbung.SeminarID = seminar.SeminarID', 'inner');
            $this->db->where('E-Mail', $email);
            $this->db->order_by('Seminarname', 'DESC');
            $query = $this->db->get();
            return $query->result_array();


        }

        // Liest seminarbewerbungen ein
        public function bewerbung_hinzufuegen($MSNotwendig, $seminarid){
    
            if ($MSNotwendig === 1){
                //User data array(seminarbewerbung)
                $data = array(
                    'e-mail' => $this->session->userdata('user_email'),
                    'seminarid' => $seminarid,
                    'ms' => $this->input->post('ms')              
                );
            }

            else{
                $data = array(
                    'e-mail' => $this->session->userdata('user_email'),
                    'seminarid' => $seminarid
                );
            } 


            //insert seminarbewerbung(seminarbewerbung)
            return $this->db->insert('seminarbewerbung', $data);

            

        }

        //Gibt Informationen zu bestimmtem Seminar aus, für Detailansicht
        public function get_seminar($id){
            $this->db->where('SeminarID', $id);
            $query = $this->db->get('seminar');
            return $query->result_array();
        }
        //gibt alle Bachelor-Seminare aus
        public function get_seminare_ba(){
            $this->db->where('BA/MA', 'BA');
            $query = $this->db->get('seminar');
            return $query->result_array();
        }
        //Gibt alle Master-Seminare aus
        public function get_seminare_ma(){
            $this->db->where('BA/MA', 'MA');
            $query = $this->db->get('seminar');
            return $query->result_array();
        }
        
        //Gibt alle Seminare aus, auf die sich ein bestimmter Student noch nicht beworben hat
        public function get_seminare_not_beworben($email, $bama, $data){
            
            
            $this->db->select('*');
            $this->db->from('seminar');
            //$this->db->join('seminar', 'seminar.SeminarID = seminarbewerbung.SeminarID', 'inner');
            //$this->db->where('Eingeladen', NULL);
            $this->db->where('seminar.BA/MA', $bama);
            //$this->db->where('student.E-Mail', $email);
            //$this->db->or_where('E-Mail', NULL);
            //$this->db->order_by('Seminarname', 'DESC');
            $query = $this->db->get();
            return $query->result_array();


        }

        //Gibt zurück, ob der Student die Höchstanzahl an Seminarbewerbungen schon erreicht hat
        public function get_anzahl_bewerbungen($email){
            $this->db->select('#Bewerbung');
            $this->db->from('student');
            $this->db->where('E-Mail', $email);
            $query = $this->db->get();
            return $query->result_array();
        }

        //erhöht die Anzahl der #Bewerbungen des Studenten
        public function bewerbungen_erhoehen($email, $anzahl){
            $data =array(
                '#Bewerbung' => $anzahl
            ); 
            $this->db->where('E-Mail', $email)->update('student', $data);
        }


        //löscht die ausgewählte Bewerbung
        public function bewerbung_loeschen($seminarid, $email){
            return $this->db->where('SeminarID', $seminarid)->where('E-Mail', $email)->delete('seminarbewerbung');
        }

        //gibt Seminare zurück, die vom Lehrstuhl zugesagt worden sind
        public function get_seminare_angemeldet($email, $bama){
            $this->db->select('*');
            $this->db->from('seminarbewerbung');
            $this->db->join('seminar', 'seminarbewerbung.SeminarID = seminar.SeminarID', 'inner');
            $this->db->where('E-Mail', $email);
            $this->db->where('seminar.BA/MA', $bama);
            $this->db->where('Eingeladen', 1);
            $this->db->order_by('Seminarname', 'DESC');
            $query = $this->db->get();
            return $query->result_array();
        }

        //fügt ein zugesagtes, angenommenes Seminar hinzu
        public function seminar_zusagen($seminarid, $email){
            $data = array(
                'SeminarID' => $seminarid,
                'E-Mail' => $email
            );

            $data1 = array(
                'ZugesagtAm' => 'NOW()'
            );

            $this->db->insert('seminarzuteilung', $data);
            $this->db->where('E-Mail', $email)->where('SeminarID', $seminarid)->update('seminarbewerbung', $data1);
        }

        //gibt die Anzahl der Zusagen eines Studenten zurück
        public function get_anzahl_zusagen($email){
            $this->db->select('#Annahmen');
            $this->db->from('student');
            $this->db->where('E-Mail', $email);
            $query = $this->db->get();
            return $query->result_array();
        }

        //erhöht die Anzahl der #Bewerbungen des Studenten
        public function zusagen_erhoehen($email, $anzahl){

            $data = array(
                '#Annahmen' =>  1
            );
 
            $this->db->where('E-Mail', $email)->update('student', $data);
        }

        //gibt Seminare zurück, die vom Lehrstuhl zugesagt worden sind
        public function get_seminare_zugesagt($email, $bama){
            $this->db->select('*');
            $this->db->from('seminarzuteilung');
            $this->db->join('seminar', 'seminarzuteilung.SeminarID = seminar.SeminarID', 'inner');
            $this->db->where('E-Mail', $email);
            $this->db->where('seminar.BA/MA', $bama);
            $this->db->order_by('Seminarname', 'DESC');
            $query = $this->db->get();
            return $query->result_array();
        }

        //gibt zurück, ob der eingeloggte Student ein BAchelor- oder Masterstudium absolviert
        public function get_bama($email){
            $this->db->select('BA/MA');
            $this->db->from('student');
            $this->db->where('E-Mail', $email);
            $query = $this->db->get();
            return $query->result_array();
        }
    }