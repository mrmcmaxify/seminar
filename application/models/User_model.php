<?php  
    class User_model extends CI_Model{
        public function register($enc_password, $filename){
            //User data array(benutzeraccount)
            $data = array(
                'e-mail' => $this->input->post('e-mail'),
                'passwort' => $enc_password,
                'rolle' => "student",
                'Loginsperre' => '2'

            );
            

             //User data array(student)
             $data1 = array(
                'e-mail' => $this->input->post('e-mail'),
                'vorname' => $this->input->post('vorname'),
                'name' => $this->input->post('name'),
                'studiengang' => $this->input->post('studiengang'),
                'fachsemester' => $this->input->post('fachsemester'),
                'ba/ma' => $this->input->post('ba/ma'),
                'ects' => $this->input->post('ects'),
                'hisqis' => $filename,
            );

            //insert user(benutzeraccount)
            $this->db->insert('benutzeraccount', $data);
            //insert user(student)
            return $this->db->insert('student', $data1);

           

        }


        //Log user in
        public function login($email, $password){
            //validate
            $this->db->where('E-Mail', $email);
            $this->db->where('Passwort', $password);

            $result = $this->db->get('benutzeraccount');

            if($result->num_rows() == 1){
                return $result->row(0)->Rolle;
            }else{
                return false;
            }
        }


        //Check email exists
        public function check_email_exists($email){
            $query = $this->db->get_where('benutzeraccount', array('E-Mail' => $email));
            if(empty($query->row_array())){
                return true;
            }else{
                return false;
            }
        }

        //Gibt den User als Objekt zur Passwortüberprüfung zurück
        public function getCurrPassword($userid){
            $query = $this->db->where(['e-mail'=>$userid])->get('benutzeraccount');
              if($query->num_rows() > 0){
                  return $query->row();
              }
            }
        //Ändert das Passwort under Datenbank des Users mit Email $userid
        public function updatePassword($enc_new_password, $userid){
            $data = array(
                'E-Mail' => $userid,
                'Passwort' => $enc_new_password,
            );
            return $this->db->where('E-Mail', $userid)->update('benutzeraccount', $data);
        }

        //Gibt alle Benutzer die im Feld $field den Suchbegriff $search enthalten zurück
        public function getUserWhereLike($field, $search){
            $query = $this->db->like($field, $search)->order_by($field)->get('benutzeraccount');
            return $query->result_array();
        }

        //Gibt alle Benutzer zurück
        public function get_users(){
            $query = $this->db->get('benutzeraccount');
            return $query->result_array();
        }

        //Löscht den Benutzer mit der $email
        public function delete_user($email){
            return $this->db->where('E-Mail', $email)->delete('benutzeraccount');
        }

        //Setzt Loginsperre auf 1 = Gesperrt
        public function lock_user($email){
            $data = array(
                'E-Mail' => $email,
                'Loginsperre' => '1',
            );
            $this->db->where('E-Mail', $email)->update('benutzeraccount', $data);
        }

        //Setzt Loginsperre auf 2 = Nicht gesperrt
        public function unlock_user($email){
            $data = array(
                'E-Mail' => $email,
                'Loginsperre' => '2',
            );
            $this->db->where('E-Mail', $email)->update('benutzeraccount', $data);
        }

        //Fügt dem Log einen Eintrag mit dem Benutzer $email und der $event id hinzu
        public function add_log($email, $eventid, $seminarname){
            if($eventid=='1'){
                $data = array(
                    'E-Mail' => $email,
                    'Event-id'=> $eventid,
                    'Aktion' => 'Anmeldung an Seminar',
                    'Seminar' => $seminarname
                );
                $this->db->insert('logfile', $data);    
            }

            if($eventid=='2'){
                $data = array(
                    'E-Mail' => $email,
                    'Event-id'=> $eventid,
                    'Aktion' => 'Abmeldung von Seminar',
                    'Seminar' => $seminarname
                );
                $this->db->insert('logfile', $data);    
            }

            if($eventid=='3'){
                $data = array(
                    'E-Mail' => $email,
                    'Event-id'=> $eventid,
                    'Aktion' => 'Annahme Seminaranmeldung',
                    'Seminar' => $seminarname
                );
                $this->db->insert('logfile', $data);    
            }

            if($eventid=='4'){
                $data = array(
                    'E-Mail' => $email,
                    'Event-id'=> $eventid,
                    'Aktion' => 'Rücktritt Seminaranmeldung',
                    'Seminar' => $seminarname
                );
                $this->db->insert('logfile', $data);    
            }
        } 
        
        public function getUser($email){
            $query = $this->db->where(['e-mail'=>$email])->get('benutzeraccount');
              if($query->num_rows() > 0){
                  return $query->row();
              }
            }

            public function delete_user_student($email){
                $this->db->where('E-Mail', $email)->delete('student');
            }

            public function delete_user_lehrstuhl($email){
                $this->db->where('E-Mail', $email)->delete('lehrstuhl');
            }

            public function delete_user_dekan($email){
                $this->db->where('E-Mail', $email)->delete('dekanat');
            }

            public function get_studiengang(){
                $query = $this->db->get('studiengang');
                return $query->result_array();


            }
}