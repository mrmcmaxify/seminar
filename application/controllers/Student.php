<?php

    class Student extends CI_Controller{


        //Aufruf der Startseite vom Student
		public function startseite_student(){
			$this->load->view('templates/header');
            $this->load->view('pages/startseite_student');
			$this->load->view('templates/footer');
        }


        //Beschreibung des speziellen Seminars anzeigen
        public function seminar_info(){
            //$email = $this->input->post('E-Mail');
			//$email='test';


            $beschreibung=array(
                'beschreibung'=>$this->input->post('Beschreibung')
            );

			$this->load->view('templates/header');
			$this->load->view('users/seminar_info', $beschreibung);
			$this->load->view('templates/footer');
        }

        //Bewerbung eines Studenten für ein Seminar
        public function bewerben(){
             //$email = $this->input->post('E-Mail');
			//$email='test';


            $seminarID=array(
                'seminarID'=>$this->input->post('SeminarID')
            );

			$this->load->view('templates/header');
			$this->load->view('users/bewerben', $seminarID);
			$this->load->view('templates/footer');
        }
        
    }
