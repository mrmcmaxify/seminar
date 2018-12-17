<?php  
    class User_model extends CI_Model{
        public function register($enc_password){
            //User data array(benutzeraccount)
            $data = array(
                'e-mail' => $this->input->post('e-mail'),
                'password' => $enc_password,
                'rolle' => "student"

            );
            
            //insert user(benutzeraccount)
            return $this->db->insert('benutzeraccount', $data);

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

            //insert user (student)
            return $this->db->insert('student', $data1);

        }
    }