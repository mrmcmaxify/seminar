<?php

    class Users extends CI_Controller{

        //Registrierung
        public function register(){
            $data['title']= 'Registrieren';

            $this->form_validation->set_rules('e-mail', 'Name', 'required|callback_check_email_exists');
            $this->form_validation->set_rules('password', 'Passwort', 'required|callback_valid_password');
            $this->form_validation->set_rules('password2', 'Passwort bestätigen', 'matches[password]');
            $this->form_validation->set_rules('vorname', 'Vorname', 'required');
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('fachsemester', 'Fachsemester', 'required');
            $this->form_validation->set_rules('ba/ma', 'BA/MA', 'required');
            $this->form_validation->set_rules('ects', 'ECTS', 'required');
            
            if (empty($_FILES['hisqis']['name']))
                {
                $this->form_validation->set_rules('hisqis', 'HisQis', 'required');
                }


            if($this->form_validation->run() === FALSE){
                $this->load->view('templates/header');
                $this->load->view('users/register', $data);
                $this->load->view('templates/footer');


            }else{
                //Encrypt password
                $enc_password = md5($this->input->post('password'));

                
                //File Upload
                $config['upload_path']          = './uploads/';                
                $config['allowed_types']        = 'pdf';
                $config['max_size']             = 2048;
               

                $filename = time().$_FILES["hisqis"]['name'];
                $config['file_name'] = $filename;
              

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('hisqis'))
                {
                        $error = array('error' => $this->upload->display_errors());
                        
                        $this->session->set_flashdata('upload', 'Dateiupload fehlgeschlagen!');
                }
                else
                {
                        $data = array('upload_data' => $this->upload->data());
                        
                        //Aufruf register methode
                        $this->user_model->register($enc_password, $filename);

                        //Set confirm message
                        $this->session->set_flashdata('user_registered', 'Sie sind jetzt registriert!');

                        redirect('startseite');

                        
                }
                
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


                    //Lädt spezifische Daten für Dekan Startseite
                    if($user_data['rolle']==='dekan'){
                        $data['seminar']= $this->seminar_model->get_seminare();
                        $data['fristen']=$this->fristen_model->get_fristen();
                        $data['ba_ohne']=$this->student_model->get_ba_ohne();
                        $data['ma_ohne']=$this->student_model->get_ma_ohne();
			
		
			            $this->load->view('templates/header');
			            $this->load->view('pages/startseite_dekan', $data);
			            $this->load->view('templates/footer');

                    }else{
                     //Lädt Startseite des jeweiligen Benutzers   
                        redirect('startseite_'.$user_data['rolle']);
                      }

                    
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
       
        //Ändert das Passwort
        public function changepw(){
            $data['title']= 'Change Password';

            $this->form_validation->set_rules('password', 'Current Password');
            //Überprüfung ob neues Passwort den Regeln entspricht
            $this->form_validation->set_rules('newpassword', 'New Password', 'required|callback_valid_password');
            //Überprüfung ob neue Passwörter übereinstimmen
            $this->form_validation->set_rules('confpassword', 'Confirm Password', 'matches[newpassword]');
            
            //Lädt die View changepw
            if($this->form_validation->run() === FALSE){
                $this->load->view('templates/header');
                $this->load->view('users/changepw', $data);
                $this->load->view('templates/footer');


            }else{
                
                $cur_password = $this->input->post('password');
                $new_password = $this->input->post('newpassword');
                $conf_password = $this->input->post('confpassword');
                $userid = $this->session->userdata('user_email');
                $passwd = $this->user_model->getCurrPassword($userid);
                $enc_cur_password = md5($this->input->post('password'));
                //Überprüfung des aktuellen Passworts
                if($passwd->Passwort == $enc_cur_password){
                    $enc_new_password = md5($new_password);
                    if ($this->user_model->updatePassword($enc_new_password, $userid)){
                        $this->session->set_flashdata('pw_changed','Ihr Passwort wurde geändert.');
                        redirect('startseite');
                    }  
                    else{
                        echo 'Failed to update password';
                    }
                }
                else{
                    $this->session->set_flashdata('pw_nomatch', 'Das aktuelle Passwort ist falsch!');

                    redirect('users/changepw');
                }
            }               
        }

        
        //Mitarbeiter hinzufügen

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
             //Download HisQis-Auszug
    public function download($pdf){
        if(empty($pdf)){
            $this->session->set_flashdata('download', 'Kein HisQis-Auszug vorhanden!');
            redirect('dekan/startseite_dekan');


        }else{

            $this->load->helper('download');
            $data = file_get_contents(base_url('/uploads/'.$pdf));
            force_download($pdf, $data);

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

