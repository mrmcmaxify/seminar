<?php

    class Users extends CI_Controller{

        public function register(){
            $data['title']= 'Sign Up';

            $this->form_validation->set_rules('e-mail', 'Name', 'required');
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
                $this->load->view('templates/header');


            }else{
                //Encrypt password
                $enc_password = md5($this->input->post('password'));

                $this->user_model->register($enc_password);

                //Set confirm message
                $this->session->set_flashdata('user_registered', 'Sie sind jetzt registriert!');

                redirect('startseite');
            }
       
        }

    }