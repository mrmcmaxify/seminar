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
                'loginsperre' => '2'
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
                'loginsperre' => '2'
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

        //gibt alle Logdateien zurück
        public function get_log(){
            $query = $this->db->get('logfile');
            return $query->result_array();
        }

        //gibt alle Logdateien eines bestimmten $search im $field zurück
        public function getLogsWhereLike($field, $search){
            $query = $this->db->like($field, $search)->order_by($field)->get('logfile');
            return $query->result_array();
        }

        public function get_semesterzeiten(){
            $this->db->order_by('bezeichnung', 'ASC');
            $query = $this->db->get('semesterzeiten');
            return $query->result_array();
        }
        //schreibt neue fristen ind fristen-tabelle
        public function semster_edit($data){
            
            $date1['bezeichnung']=$data['bezeichnung'];
            $date1['anfang']=$data['anfang'];
            $date1['ende']=$data['ende'];
            $this->db->insert('semesterzeiten',$date1);
            
            return true;
        }

        public function delete_semester($bezeichnung){
            return $this->db->where('bezeichnung', $bezeichnung)->delete('semesterzeiten');
        }

        public function check_semester_exists($bezeichnung){
            $query = $this->db->get_where('semesterzeiten', array('bezeichnung' => $bezeichnung));
            if(empty($query->row_array())){
                return true;
            }else{
                return false;
            }
        }

    }