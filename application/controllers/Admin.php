<?php

    class Admin extends CI_Controller{

		//Konstruktor mit Login und Rollen Überprüfung
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
		
		//Aufruf der Startseite vom Admin
		public function startseite_admin(){
			$this->load->view('templates/header');
            $this->load->view('pages/startseite_admin');
			$this->load->view('templates/footer');
		}

		//Fügt Benutzer mit Rolle Lehrstuhl oder Dekan hinzu
		public function add_user(){
            $data['title']= 'Add User';

            $this->form_validation->set_rules('e-mail', 'Name', 'required|callback_admin_check_email_exists');
            $this->form_validation->set_rules('password', 'Passwort', 'required|callback_valid_password');
            $this->form_validation->set_rules('password2', 'Passwort bestätigen', 'matches[password]');
            $this->form_validation->set_rules('vorname', 'Vorname', 'required');
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('rolle', 'Rolle', 'required');
			$this->form_validation->set_rules('inhaber', 'Inhaber', 'required');
			$this->form_validation->set_rules('lehrstuhlname', 'LehrstuhlName');
			
            if($this->form_validation->run() === FALSE){
                $this->load->view('templates/header');
                $this->load->view('admin/add_user', $data);
                $this->load->view('templates/footer');


            }else{
                //Encrypt password
                $enc_password = md5($this->input->post('password'));

                
                //Aufruf register methode
                $this->admin_model->add_user($enc_password);

                //Set confirm message
                $this->session->set_flashdata('user_added', 'Der Benutzer wurde angelegt.');

				// linkname wird an die view übergeben und dort wird mit ok dieser link aufgerufen (hier wird zurückgeführt)
				$link['linkname']='admin/add_user';
                $this->load->view('templates/header');
            	$this->load->view('pages/ok', $link);
				$this->load->view('templates/footer');
            }
       
        }

        //Überprüft ob Passwort den Anforderungen entspricht(Zahlen, kleine und große Buchstaben, Sonderzeichen)
        public function valid_password($password = ''){
		    $password = trim($password);
		    $regex_lowercase = '/[a-z]/';
		    $regex_uppercase = '/[A-Z]/';
		    $regex_number = '/[0-9]/';
		    $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>§~]/';
		    if (empty($password)){
			    $this->form_validation->set_message('valid_password', 'Ein {field} wird benötigt.');
			    return FALSE;
		    }
		    if (preg_match_all($regex_lowercase, $password) < 1){
			    $this->form_validation->set_message('valid_password', 'Das {field} muss mindesten einen Kleinbuchstaben bestehen.');
			    return FALSE;
		    }
		    if (preg_match_all($regex_uppercase, $password) < 1){
			    $this->form_validation->set_message('valid_password', 'Das {field} muss mindesten einen Großbuchstaben bestehen.');
			    return FALSE;
		    }
		    if (preg_match_all($regex_number, $password) < 1){
			    $this->form_validation->set_message('valid_password', 'Das {field} muss mindesten eine Zahl enthalten.');
			    return FALSE;
		    }
		    if (preg_match_all($regex_special, $password) < 1){
			    $this->form_validation->set_message('valid_password', 'Das {field} muss mindesten ein Sonderzeichen enthalten.' . ' ' . htmlentities('!@#$%^&*()\-_=+{};:,<.>§~'));
			    return FALSE;
		    }
		    if (strlen($password) < 8){
			    $this->form_validation->set_message('valid_password', 'Das {field} muss aus mindesten 8 Zeichen bestehen.');
			    return FALSE;
		    }
		    if (strlen($password) > 32){
			    $this->form_validation->set_message('valid_password', 'Das {field} kann nicht größer als 32 Zeichen sein.');
			    return FALSE;
		    }
		    return TRUE;
		}

		//Überprüft ob Email bei Funktion add_user bereits existiert
		public function admin_check_email_exists($email){
            $this->form_validation->set_message('admin_check_email_exists', 'Diese E-Mail-Adresse ist bereits im System regstriert');

			if($this->admin_model->admin_check_email_exists($email)){
                return true;
            }else{
                return false;
            }
		}
}


