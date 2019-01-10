<?php

    class Lehrstuhl extends CI_Controller{
		
		public function verteilen(){
			$email=$this->input->post('E-Mail');
			$id=$this->input->post('SeminarID');

			if($this->student_model->zuweisen($email,$id)){
				
				$this->session->set_flashdata('zugewiesen', 'Zuweisung erfolgreich!');
				
				

				$this->load->view('templates/header');
				$this->load->view('pages/startseite_lehrstuhl', $data);
				$this->load->view('templates/footer');

			}else{

				$this->session->set_flashdata('zugewiesen_nicht', 'Konnte nicht zuweisen, bitte Admin kontaktieren!');
			}



		}

		
	}