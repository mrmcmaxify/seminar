<?php
    class fristen_model extends CI_Model{
        public function __construct(){
            $this->load->database();
        }
        //liest gesamte fristen-tabelle as, sortiert nach ID
        public function get_fristen(){
            $this->db->order_by('ID', 'ASC');
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

        // Gibt Startzeitpunkt der Frist zurück
        public function get_frist_start($fristname){
            $this->db->select('Von');
            $this->db->from('fristen');
            $this->db->where('Name', $fristname);
            $query=$this->db->get();
            return $query->result_array();
          


        }
        // Gibt Endzeitpunkt der Frist zurück
        public function get_frist_ende($fristname){
            $this->db->select('Bis');
            $this->db->from('fristen');
            $this->db->where('Name', $fristname);
            $query=$this->db->get();
            return $query->result_array();
        }

        //Liefert alle Semester für ein Dropdown zurück
        function getAllSemester(){
            $query = $this->db->query('SELECT * FROM semesterzeiten');
            return $query->result();

        //echo 'Total Results: ' . $query->num_rows();
        }

        //Setzt die Fristen zuück
        public function delete_fristen(){

            $date1['Von']='0000-00-00';
            $date1['Bis']='0000-00-00';
            $this->db->where('ID','1');
            $this->db->update('fristen',$date1);

            $date2['Von']='0000-00-00';
            $date2['Bis']='0000-00-00';
            $this->db->where('ID','2');
            $this->db->update('fristen',$date2);

            $date3['Von']='0000-00-00';
            $date3['Bis']='0000-00-00';
            $this->db->where('ID','3');
            $this->db->update('fristen',$date3);

            $date4['Von']='0000-00-00';
            $date4['Bis']='0000-00-00';
            $this->db->where('ID','4');
            $this->db->update('fristen',$date4);

            $date5['Von']='0000-00-00';
            $date5['Bis']='0000-00-00';
            $this->db->where('ID','5');
            $this->db->update('fristen',$date5);

            $date6['Von']='0000-00-00';
            $date6['Bis']='0000-00-00';
            $this->db->where('ID','6');
            return $this->db->update('fristen',$date6);
        }

        //Gibt ID der aktuellen Frist zurück
        public function get_aktuelle_frist($heute){
            $this->db->select('ID');
            $this->db->from('fristen');
            $this->db->where('Von <', $heute);
            $this->db->where('Bis >', $heute);
            $query=$this->db->get();
            return $query->result_array();
        }
       
    }