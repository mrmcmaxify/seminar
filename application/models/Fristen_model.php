<?php
    class fristen_model extends CI_Model{
        public function __construct(){
            $this->load->database();
        }
        
        public function get_fristen(){
            $query = $this->db->get('fristen');
            return $query->result_array();
        }
        //schreibt neue fristen ind fristen-tabelle
        public function fristen_edit($data){
            
            $date1['Von']=$data['von1'];
            $date1['Bis']=$data['bis1'];
            $this->db->where('ID','1');
            $this->db->update('fristen',$date1);

            $date2['Von']=$data['von2'];
            $date2['Bis']=$data['bis2'];
            $this->db->where('ID','2');
            $this->db->update('fristen',$date2);

            $date3['Von']=$data['von3'];
            $date3['Bis']=$data['bis3'];
            $this->db->where('ID','3');
            $this->db->update('fristen',$date3);

            $date4['Von']=$data['von4'];
            $date4['Bis']=$data['bis4'];
            $this->db->where('ID','4');
            $this->db->update('fristen',$date4);

            $date5['Von']=$data['von5'];
            $date5['Bis']=$data['bis5'];
            $this->db->where('ID','5');
            $this->db->update('fristen',$date5);

            $date6['Von']=$data['von6'];
            $date6['Bis']=$data['bis6'];
            $this->db->where('ID','6');
            $this->db->update('fristen',$date6);
            
            return true;


        }

       
    }