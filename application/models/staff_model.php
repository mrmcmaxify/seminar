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
        public function addstaff_dekan($enc_password){
            //User data array(benutzeraccount)
            $data = array(
                'e-mail' => $this->input->post('e-mail'),
                'passwort' => $enc_password,
                'rolle' => "dekan",
                'loginsperre' => '2'

            );
            

        


        
             //User data array(lehrstuhl)
             $data1 = array(
                'e-mail' => $this->input->post('e-mail'),
                'vorname' => $this->input->post('vorname'),
                'name' => $this->input->post('name'),
                'inhaber' => '2',               
            );

            //insert user(benutzeraccount)
            $this->db->insert('benutzeraccount', $data);
            return $this->db->insert('dekanat', $data1);

           

        }


        // Liefert den Namen des Lehrstuhls der angemeldeten Person
        public function get_lehrstuhl($email){
            $this->db->select('LehrstuhlName');
            $this->db->from('lehrstuhl');
            $this->db->where('lehrstuhl.E-Mail', $email);
            $query=$this->db->get();
            return $query->result_array();
        


        }
        


        
                
                // Liefert die Anzahl bereits registrierter Dekanats-Mitarbeiter
                public function get_anzahl_dekanats_mitarbeiter(){
                    $this->db->select('count(*)');
                    $this->db->from('dekanat');
                    $query=$this->db->get();
                    return $query->result_array();
                  
        
        
                }
                
        // Gibt zurück, ob angemeldeter Nutzer Dekanats-Inhaber ist
        public function get_info_inhaber($email){
            $this->db->select('Inhaber');
            $this->db->from('dekanat');
            $this->db->where('dekanat.E-Mail', $email);
            $query=$this->db->get();
            return $query->result_array();
          


        }
    }