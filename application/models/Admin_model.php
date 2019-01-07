<?php  
    class Admin_model extends CI_Model{

        //Fügt Benutzer mit Rolle dekan oder lehrstuhl in die Datenbank ein
        public function add_user($enc_password){
            //User data array(benutzeraccount)
            if($this->input->post('rolle')=='dekan'){
            $data = array(
                'e-mail' => $this->input->post('e-mail'),
                'passwort' => $enc_password,
                'rolle' => $this->input->post('rolle'),
            );
            

             //User data array(student)
             $data1 = array(
                'e-mail' => $this->input->post('e-mail'),
                'vorname' => $this->input->post('vorname'),
                'name' => $this->input->post('name'),
                'inhaber' => $this->input->post('inhaber'),
            );

            //insert user(benutzeraccount)
            $this->db->insert('benutzeraccount', $data);
            return $this->db->insert('dekanat', $data1);
           }

           else{
            $data = array(
                'e-mail' => $this->input->post('e-mail'),
                'passwort' => $enc_password,
                'rolle' => $this->input->post('rolle'),
            );
            

             //User data array(student)
             $data1 = array(
                'e-mail' => $this->input->post('e-mail'),
                'vorname' => $this->input->post('vorname'),
                'name' => $this->input->post('name'),
                'inhaber' => $this->input->post('inhaber'),
                'lehrstuhlname' => $this->input->post('lehrstuhlname'),
            );

            //insert user(benutzeraccount)
            $this->db->insert('benutzeraccount', $data);
            return $this->db->insert('lehrstuhl', $data1);

           }
        }

        //Überprüft ob eine Email bereits existiert und gibt true/false zurück
        public function admin_check_email_exists($email){
            $query = $this->db->get_where('benutzeraccount', array('E-Mail' => $email));
            if(empty($query->row_array())){
                return true;
            }else{
                return false;
            }
        }
        

    }