<?php  
    class Staff_model extends CI_Model{
        public function addstaff($enc_password){
            //User data array(benutzeraccount)
            $data = array(
                'e-mail' => $this->input->post('e-mail'),
                'passwort' => $enc_password,
                'rolle' => "lehrstuhl",
                'loginsperre' => '2'

            );
            

             //User data array(lehrstuhl)
             $data1 = array(
                'e-mail' => $this->input->post('e-mail'),
                'vorname' => $this->input->post('vorname'),
                'name' => $this->input->post('name'),
                'inhaber' => '2',
                'lehrstuhlname' => $this->input->post('lehrstuhlname'),                
            );

            //insert user(benutzeraccount)
            $this->db->insert('benutzeraccount', $data);
            return $this->db->insert('lehrstuhl', $data1);

           

        }


        


        
    }