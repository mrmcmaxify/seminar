<?php  
    class User_model extends CI_Model{
        public function register($enc_password, $filename){
            //User data array(benutzeraccount)
            $data = array(
                'e-mail' => $this->input->post('e-mail'),
                'passwort' => $enc_password,
                'rolle' => "student"

            );
            

             //User data array(student)
             $data1 = array(
                'e-mail' => $this->input->post('e-mail'),
                'vorname' => $this->input->post('vorname'),
                'name' => $this->input->post('name'),
                'fachsemester' => $this->input->post('fachsemester'),
                'ba/ma' => $this->input->post('ba/ma'),
                'ects' => $this->input->post('ects'),
                'hisqis' => $filename,
            );

            //insert user(benutzeraccount)
            $this->db->insert('benutzeraccount', $data);
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
    }