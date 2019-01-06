<?php

    class Admin extends CI_Controller{

        function __construct(){
			parent::__construct();
			if($this->session->userdata('rolle') == 'admin' && $this->session->userdata('logged_in') == true){
			}
			elseif($this->session->userdata('logged_in') == true){
				redirect('users/logout');
			}
			else{
				redirect('users/login');
			}
		}
				
		public function startseite_admin(){


			$this->load->view('templates/header');
            $this->load->view('pages/startseite_admin');
			$this->load->view('templates/footer');


		}
	}
