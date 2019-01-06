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

			//$email = $this->input->post('E-Mail');
			//$email='test';

			$email=array(
				'email'=>$this->input->post('E-Mail')

			);

			$this->load->view('templates/header');
			$this->load->view('pages/zuweisen_anzeigen', $email);
			$this->load->view('templates/footer');

		}
	}










    