<?php  
    class Seminaranlegen_model extends CI_Model{
        public function seminaranlegen(){
           

             //User data array(lehrstuhl)
             $data1 = array(
                'seminarname' => $this->input->post('seminarname'),
                'lehrstuhlname' => $this->input->post('lehrstuhlname'),
                'beschreibung' => $this->input->post('beschreibung'), 
                'soll-teilnehmerzahl' => $this->input->post('soll-teilnehmerzahl'),
                'semester' => $this->input->post('semester'),
                'BA/MA' => $this->input->post('BA/MA'),
                'msnotwendig' => $this->input->post('msnotwendig'),
                
                
                              
            );

            //insert user(benutzeraccount)
            return $this->db->insert('lehrstuhl', $data1);

           

        }


        


        
    }