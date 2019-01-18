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
        public function get_seminare_beworben($email, $bama){
            $this->db->select('*');
            $this->db->from('seminarbewerbung');
            $this->db->join('seminar', 'seminarbewerbung.SeminarID = seminar.SeminarID', 'inner');
            $this->db->where('E-Mail', $email);
            $this->db->where('seminar.BA/MA', $bama);
            $this->db->order_by('Seminarname', 'DESC');
            $query = $this->db->get();
            return $query->result_array();


        }

        //Gibt alle Seminare aus, auf die sich ein bestimmter Student beworben hat
        public function get_seminare_beworben1($email, $bama){
            $this->db->select('*');
            $this->db->from('seminarbewerbung');
            $this->db->join('seminar', 'seminarbewerbung.SeminarID = seminar.SeminarID', 'inner');
            $this->db->where('E-Mail', $email);
            $this->db->where('seminar.BA/MA', $bama);
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
        public function get_seminare_not_beworben($email, $bama){
            $this->db->select('*');
            $this->db->from('seminar');
            $this->db->where('seminar.BA/MA', $bama);
            $this->db->order_by('Seminarname', 'DESC');
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

        //erhöht die Anzahl der #Bewerbungen des Studenten
        public function bewerbungen_erhoehen($email){

            $data =array(
                '#Bewerbung' => (int)'#Bewerbung' + 1
            );
            
            
            $this->db->where('E-Mail', $email)->update('student', $data);
        }


        //löscht die ausgewählte Bewerbung
        public function bewerbung_loeschen($seminarid, $email){
            return $this->db->where('SeminarID', $seminarid)->where('E-Mail', $email)->delete('seminarbewerbung');
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

        //erhöht die Anzahl der #Bewerbungen des Studenten
        public function zusagen_erhoehen($email, $anzahl){

            $data = array(
                '#Annahmen' =>  1
            );
    
            $this->db->where('E-Mail', $email)->update('student', $data);
        }



        //gibt zurück, ob der eingeloggte Student ein BAchelor- oder Masterstudium absolviert
        public function get_bama($email){
            $this->db->select('BA/MA');
            $this->db->from('student');
            $this->db->where('E-Mail', $email);
            $query = $this->db->get();
            return $query->result_array();
        }

        //Speichert Seminarinfos in die Statistik
        public function save_seminare($semester){
            $old=$this->db->where('Semester',$semester)->get('seminar')->result_array();
            foreach($old as $new) {
                $data=array(
                    'SeminarID'=>$new['SeminarID'],
                    'SeminarName'=>$new['SeminarName'],
                    'LehrstuhlName'=>$new['LehrstuhlName'],
                    'Ist_Teilnehmerzahl'=>$new['Ist-Teilnehmerzahl'],
                    'Soll_Teilnehmerzahl'=>$new['Soll-Teilnehmerzahl'],
                    'Semester'=>$new['Semester'],
                    'BA/MA'=>$new['BA/MA']
                );
                return $this->db->insert('statistik', $data);
            }
        }

        //Gibt Anzahl Bachelorstudenten ohne Seminarzuteilung zurück
        public function count_ba_ohne_zusagen(){
            $this->db->select('*')
                ->from('student')
                ->where('"student.BA/MA"','BA')
                ->where('"student.E-Mail" NOT IN (select "E-Mail" from seminarzuteilung)',NULL,FALSE);
                $query = $this->db->get();
            echo $query->num_rows();
        }

        //Gibt Anzahl Masterstudenten ohne Seminarzuteilung zurück
        public function count_ma_ohne_zusagen(){
            $this->db->select('*')
                ->from('student')
                ->where('"student.BA/MA"','BA')
                ->where('"student.E-Mail" NOT IN (select "E-Mail" from seminarzuteilung)',NULL,FALSE);
                $query = $this->db->get();
            echo $query->num_rows();
        }

        //Gibt das aktuelle Semester zurück
        public function getCurSemester($date){
            $query = $this->db->where('ende >=', $date)->where('anfang <=', $date)->get('semesterzeiten');
            if($query->num_rows() > 0){
                return $query->row();
            }

        }
       
        //Speichert die Studentenstatistik
        public function save_studenten_statistik($data){
           return $this->db->insert('statistik_studenten', $data);
        }

        //Löscht alle Seminare des Semsters $semester
        public function delete_seminare($semester){
            $this->db->where('Semester', $semester);
            return $this->db->delete('seminar');
        }

        //markiert das Semester als geresetet um erneutes resetten zu vermeiden
        public function update_reset($semester){
            $data =array(
                'reset' => '1'
            );
            $this->db->where('bezeichnung', $semester)->update('semesterzeiten', $data);
        }

    }