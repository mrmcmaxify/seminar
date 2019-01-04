<?php  
    class User_model extends CI_Model{
        public function register($enc_password){
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
                'hisqis' => $this->input->post('hisqis'),
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
    }

