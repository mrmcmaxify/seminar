<?php

    class Dekan extends CI_Controller{
		public function startseite_dekan(){

			$data['seminar']= $this->seminar_model->get_seminare();
			$data['fristen']=$this->fristen_model->get_fristen();
			$data['ba_ohne']=$this->student_model->get_ba_ohne();
			$data['ma_ohne']=$this->student_model->get_ma_ohne();

			$this->load->view('templates/header');
			$this->load->view('pages/startseite_dekan', $data);
			$this->load->view('templates/footer');


		}

		public function zuweisen_anzeigen(){

			$email=$this->input->post('E-Mail');
			$abschluss=$this->input->post('BA/MA');

			if($abschluss==='BA'){
				$data=array(
					'email'=>$this->input->post('E-Mail'),
					'name'=>$this->input->post('Name'),
					'vorname'=>$this->input->post('Vorname'),
					'seminar'=>$this->seminar_model->get_seminare_ma(),
					'beworben'=>$this->seminar_model->get_seminare_beworben($email),
	
				);
			}else{
				$data=array(
					'email'=>$this->input->post('E-Mail'),
					'name'=>$this->input->post('Name'),
					'vorname'=>$this->input->post('Vorname'),
					'seminar'=>$this->seminar_model->get_seminare_ba(),
					'beworben'=>$this->seminar_model->get_seminare_beworben($email),
	
				);
			}

			
			
			$this->load->view('templates/header');
			$this->load->view('pages/zuweisen_anzeigen', $data);
			$this->load->view('templates/footer');

		}

		public function zuweisen(){
			$email=$this->input->post('E-Mail');
			$id=$this->input->post('SeminarID');

			if($this->student_model->zuweisen($email,$id)){
				
				$this->session->set_flashdata('zugewiesen', 'Zuweisung erfolgreich!');
				
				$data['seminar']= $this->seminar_model->get_seminare();
				$data['fristen']=$this->fristen_model->get_fristen();
				$data['ba_ohne']=$this->student_model->get_ba_ohne();
				$data['ma_ohne']=$this->student_model->get_ma_ohne();

				$this->load->view('templates/header');
				$this->load->view('pages/startseite_dekan', $data);
				$this->load->view('templates/footer');

			}else{

				$this->session->set_flashdata('zugewiesen_nicht', 'Konnte nicht zuweisen, bitte Admin kontaktieren!');
			}



		}

		public function show_seminar(){
			$id=$this->input->post('SeminarID');
			$data= array(
				'seminar'=>$this->seminar_model->get_seminar($id),
			);

			$this->load->view('templates/header');
			$this->load->view('pages/show_seminar', $data);
			$this->load->view('templates/footer');


		}
	}










    