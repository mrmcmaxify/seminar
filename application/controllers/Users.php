<?php

    class Users extends CI_Controller{

        public function register(){
            $data['title']= 'Sign Up';

            $this->form_validation->set_rules('e-mail', 'Name', 'required|callback_check_email_exists');
            $this->form_validation->set_rules('password', 'Passwort', 'required');
            $this->form_validation->set_rules('password2', 'Passwort bestätigen', 'matches[password]');
            $this->form_validation->set_rules('vorname', 'Vorname', 'required');
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('fachsemester', 'Fachsemester', 'required');
            $this->form_validation->set_rules('ba/ma', 'BA/MA', 'required');
            $this->form_validation->set_rules('ects', 'ECTS', 'required');
            $this->form_validation->set_rules('hisqis', 'HisQis', 'required');
       
            if($this->form_validation->run() === FALSE){
                $this->load->view('templates/header');
                $this->load->view('users/register', $data);
                $this->load->view('templates/footer');


            }else{
                //Encrypt password
                $enc_password = md5($this->input->post('password'));

                $this->user_model->register($enc_password);

                //Set confirm message
                $this->session->set_flashdata('user_registered', 'Sie sind jetzt registriert!');

                redirect('startseite');
            }
       
        }
        //User Log in
        public function login(){
            $data['title']= 'Sign In';

            $this->form_validation->set_rules('e-mail', 'E-Mail', 'required');
            $this->form_validation->set_rules('password', 'Passwort', 'required');
            
       
            if($this->form_validation->run() === FALSE){
                $this->load->view('templates/header');
                $this->load->view('users/login', $data);
                $this->load->view('templates/footer');


            }else{
                
                //Get e-mail
                $email = $this->input->post('e-mail');
                //Get and encrypt password
                $password = md5($this->input->post('password'));

                //Login user
                $user_rolle = $this->user_model->login($email, $password);

                if($user_rolle){
                    //Create session
                   $user_data = array(
                    'user_email' => $email,
                    'rolle' => $user_rolle,
                    'logged_in' => true


                   );

                   $this->session->set_userdata($user_data);


                    //Set message
                    $this->session->set_flashdata('user_loggedin', 'Sie sind jetzt eingeloggt!');

                    redirect('startseite_'.$user_data['rolle']);
                }else{
                    $this->session->set_flashdata('login_failed', 'Login fehlgeschlagen');

                    redirect('users/login');

                }

                
            }
       
        }

        //Log user out
        public function logout(){
            //unset user data
            $this->session->unset_userdata('user_email');
            $this->session->unset_userdata('rolle');
            $this->session->unset_userdata('logged_in');

            //Set logout message
            $this->session->set_flashdata('user_loggedout', 'Sie sind jetzt ausgeloggt!');

            redirect('startseite');

        }


        //Check if e-mail exists
        public function check_email_exists($email){
            $this->form_validation->set_message('check_email_exists', 'Diese E-Mail-Adresse ist bereits im System regstriert');

            if($this->user_model->check_email_exists($email)){
                return true;
            }else{
                return false;
            }

        }

        //Bewerbung für ein Seminar
        public function bewerben(){
            $data['seminar']= $this->seminar_model->get_seminare();
			$data['fristen']= $this->fristen_model->get_fristen();
			
		
			
			$this->load->view('templates/header');
			$this->load->view('users/bewerben', $data);
			$this->load->view('templates/footer');
        }


        //Beschreibung des Seminars anzeigen
        public function seminar_info(){
            $data['seminar']= $this->seminar_model->get_seminare();
			$data['fristen']= $this->fristen_model->get_fristen();
			
		
			
			$this->load->view('templates/header');
			$this->load->view('users/seminar_info', $data);
			$this->load->view('templates/footer');
        }
    }

        // Funktion für startseite_student Button
        function meine_funktion() {
            // Deine PHP-Funktion, z. B.:
            echo 'Hallo Welt!';
        }

        
        


    