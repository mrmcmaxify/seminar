<?php  
    class Seminaranlegen_model extends CI_Model{
        public function __construct(){
            $this->load->database();
        }
        public function seminaranlegen(){
            
             //User data array(seminar)
             $data1 = array(
                'seminarname' => $this->input->post('seminarname'),
                'lehrstuhlname' => $this->input->post('lehrstuhlname'),
                'beschreibung' => $this->input->post('beschreibung'), 
                'soll-teilnehmerzahl' => $this->input->post('soll-teilnehmerzahl'),
                'semester' => $this->input->post('semester'),
                'BA/MA' => $this->input->post('BA/MA'),
                'msnotwendig' => $this->input->post('msnotwendig'),
                
                
                              
            );

            //insert seminar(seminar)
            return $this->db->insert('seminar', $data1);

           
        
        }

        public function seminar_pflegen($data1, $id){
           

           

           //update seminar(seminar)
           return $this->db->where('SeminarID', $id)->update('seminar', $data1);

          

       }

        


         // Liefert das ausgewählte Seminar
         public function get_seminar($id){
            $this->db->select('*');
            $this->db->from('seminar');
            $this->db->where('SeminarID', $id);
            $query=$this->db->get();
            return $query->result_array();
          


        }
        public function get_fristen(){
            $this->db->select('Von');
            $this->db->from('fristen');
            $this->db->where('Name', 'Anmeldephase');
            $query=$this->db->get();
            return $query->result_array();
          


        }
    }