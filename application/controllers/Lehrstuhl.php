<?php

    class Lehrstuhl extends CI_Controller{

		//Seminar anlegen
        public function seminaranlegen(){
            $data['title']= 'Seminar anlegen';

            $this->form_validation->set_rules('seminarname', 'Seminarname', 'required');
            $this->form_validation->set_rules('lehrstuhlname', 'Lehrstuhlname', 'required');
            $this->form_validation->set_rules('beschreibung', 'Beschreibung', 'required');
            $this->form_validation->set_rules('soll-teilnehmerzahl', 'Soll-Teilnehmerzahl', 'required');
            $this->form_validation->set_rules('semester', 'Semester', 'required');
            $this->form_validation->set_rules('BA/MA', 'BA/MA', 'required');
            $this->form_validation->set_rules('msnotwendig', 'MSnotwendig', 'required');
         
            
            if($this->form_validation->run() === FALSE){
                $this->load->view('templates/header');
                $this->load->view('users/seminaranlegen', $data);
                $this->load->view('templates/footer');


            }else{
                $this->Seminaranlegen_model->seminaranlegen();
                //Set confirm message
                $this->session->set_flashdata('seminar_angelegt', 'Das Seminar wurde angelegt!');

                redirect('startseite');
            }
       
		}
		
		public function addstaff(){
            $data['title']= 'Mitarbeiter anlegen';

            $this->form_validation->set_rules('e-mail', 'Name', 'required|callback_check_email_exists');
            $this->form_validation->set_rules('password', 'Passwort', 'required');
            $this->form_validation->set_rules('password2', 'Passwort bestätigen', 'matches[password]');
            $this->form_validation->set_rules('vorname', 'Vorname', 'required');
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('inhaber', 'Inhaber', 'required');
            $this->form_validation->set_rules('lehrstuhlname', 'Lehrstuhlname', 'required');
       
            if($this->form_validation->run() === FALSE){
                $this->load->view('templates/header');
                $this->load->view('users/addstaff', $data);
                $this->load->view('templates/footer');


            }else{
                //Encrypt password
                $enc_password = md5($this->input->post('password'));

                $this->staff_model->addstaff($enc_password);

                //Set confirm message
                $this->session->set_flashdata('staff_added', 'Der Mitarbeiter wurde hinzugefügt!');

                redirect('startseite');
            }
       
        }
		
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