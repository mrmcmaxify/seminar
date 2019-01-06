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

                    redirect('startseite');
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
                $this->staff_model->addstaff();
                //Set confirm message
                $this->session->set_flashdata('seminar_angelegt', 'Das Seminar wurde angelegt!');

                redirect('startseite');
            }
       
        }

    }