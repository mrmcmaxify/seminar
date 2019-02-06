<?php

    class Users extends CI_Controller{
        //Registrierung
        public function register(){
            $fristname = 'Anmeldephase';
            $von = $this->Fristen_model->get_frist_start($fristname);
            $frist_start = $von['0'];
            $startdatum = $frist_start['Von'];
            $bis = $this->Fristen_model->get_frist_ende($fristname);
            $frist_ende = $bis['0'];
            $enddatum = $frist_ende['Bis'];
            $heute = date("Y-m-d");
            if ( ($heute < $startdatum) || ($heute > $enddatum) ) {
                $this->load->view('templates/header');
                $this->load->view('pages/ausserhalb_frist');
                $this->load->view('templates/footer');
            }
            else {
            
                $data['title']= 'Registrieren';
                $data['studiengang']=$this->user_model->get_studiengang();
                $this->form_validation->set_rules('e-mail', 'Name', 'required|valid_email|callback_check_email_exists|callback_email_check');
                $this->form_validation->set_rules('password', 'Passwort', 'required|callback_valid_password');
                $this->form_validation->set_rules('password2', 'Passwort bestätigen', 'matches[password]');
                $this->form_validation->set_rules('vorname', 'Vorname', 'required');
                $this->form_validation->set_rules('name', 'Name', 'required');
                $this->form_validation->set_rules('studiengang', 'Studiengang', 'required');
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

                //E-Mail-Verifikation
                $hash = md5( rand(0,1000) ); // Generate random 32 character hash and assign it to a local variable.
                // Example output: f4552671f8909587cf485ea990207f3b

                //Empfänger E-Mail
                $email = $this->input->post('e-mail');

                //Empfänger-Passwort
                $password = $this->input->post('password');
                
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
                        $this->user_model->register($enc_password, $filename, $hash);

                        $to      = $email; // Send email to our user
                        $subject = 'Signup | Verification'; // Give the email a subject 
                        $message = '

                        Thanks for signing up!
                        Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.

                        ------------------------
                        Username: '.$email.'
                        
                        ------------------------

                        Please click this link to activate your account:
                        https://132.231.36.202/seminar/users/verify/?email='.$email.'&hash='.$hash.'

                        '; // Our message above including the link
                                    

                        //mail($to, $subject, $message, $headers); // Send our email
                        $this->Send_Mail($to, $subject, $message);

                        //Set confirm message
                        $this->session->set_flashdata('user_registered', 'Sie sind jetzt registriert und können nun Ihren Acount per Mail verifizieren!');

                        redirect('startseite');

                        
                }
                
            }
        }
       
        }

        //Überprüft ob die Email zur Uni gehört
        public function email_check($email) {

            $this->form_validation->set_message('email_check', 'Die E-Mail-Adresse muss mit @gw.uni-passau.de enden.');
            return strpos($email, '@gw.uni-passau.de') !== false;
            
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


            }
            else{
                
                //Get e-mail
                $email = $this->input->post('e-mail');
                $user = $this->user_model->getUser($email);
                $sperre=$user->Loginsperre;
                $versuch=$user->Loginversuch;
                if($sperre=='2'){
                    
                        //Get and encrypt password
                        $password = md5($this->input->post('password'));

                        //Login user
                        $user_rolle = $this->user_model->login($email, $password);

                        $rolle = $user->Rolle;

                        if(!($rolle=='admin') && $versuch<4){
                        if($user_rolle){
                            //Create session
                        $user_data = array(
                            'user_email' => $email,
                            'rolle' => $user_rolle,
                            'logged_in' => true


                        );
                        $this->user_model->add_loginversuch($email, 0);
                        $this->session->set_userdata($user_data);
                        

                            //Set message
                            $this->session->set_flashdata('user_loggedin', 'Sie sind jetzt eingeloggt!');


                            //Lädt spezifische Daten für Dekan Startseite
                            if($user_data['rolle']==='dekan'){
                                $data['seminar']= $this->seminar_model->get_seminare();
                                $data['fristen']=$this->Fristen_model->get_fristen();
                                $data['ba_ohne']=$this->student_model->get_ba_ohne();
                                $data['ma_ohne']=$this->student_model->get_ma_ohne();
                    
                
                                $this->load->view('templates/header');
                                $this->load->view('pages/startseite_dekan', $data);
                                $this->load->view('templates/footer');
                                
                            }elseif($user_data['rolle']==='admin'){
                                $data['seminar']= $this->seminar_model->get_seminare();
                                $data['fristen']=$this->Fristen_model->get_fristen();
                    
                                    $this->load->view('templates/header');
                                    $this->load->view('pages/startseite', $data);
                                    $this->load->view('templates/footer');
                            
                            }elseif($user_data['rolle']==='lehrstuhl'){
                                $email=$_SESSION['user_email'];
                                $data= array(
                                    
                                    'seminar'=>$this->Seminarvergabe_model->get_seminare($email),
                    
                                );
                                
                                $this->load->view('templates/header');
                                $this->load->view('pages/startseite_lehrstuhl', $data);
                                $this->load->view('templates/footer');
                            }else{
                            //Lädt Startseite des jeweiligen Benutzers   
                                redirect('startseite_'.$user_data['rolle']);
                            }
                        
                            
                    }else{
                        if($versuch==2){
                            $this->session->set_flashdata('user_lock_warning', 'Bei der nächsten, falschen Passworteingabe wird Ihr Account gesperrt!.');
                        }
                        $versuch++;
                        $this->user_model->add_loginversuch($email, $versuch);
                        $this->session->set_flashdata('login_failed', 'Login fehlgeschlagen');
                        if($versuch==4){
                            $this->session->set_flashdata('user_lock_warning', 'Bei der nächsten, falschen Passworteingabe wird Ihr Account gesperrt!.');
                            $this->user_model->lock_user($email);
                            $this->session->set_flashdata('user_locked_pw', 'Sie haben Ihr Passwort zu oft falsch eingegeben. Ihr Benutzeraccount wurde gesperrt. Bitte wenden Sie sich an den Administrator.');
                            
                        }

                        redirect('users/login');

                    }
                }
                elseif($rolle=='admin'){
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
                            $data['fristen']=$this->Fristen_model->get_fristen();
                            $data['ba_ohne']=$this->student_model->get_ba_ohne();
                            $data['ma_ohne']=$this->student_model->get_ma_ohne();
                
            
                            $this->load->view('templates/header');
                            $this->load->view('pages/startseite_dekan', $data);
                            $this->load->view('templates/footer');
                            
                        }elseif($user_data['rolle']==='admin'){
                            $data['seminar']= $this->seminar_model->get_seminare();
                            $data['fristen']=$this->Fristen_model->get_fristen();
                
                                $this->load->view('templates/header');
                                $this->load->view('pages/startseite', $data);
                                $this->load->view('templates/footer');
                        
                        }elseif($user_data['rolle']==='lehrstuhl'){
                            $email=$_SESSION['user_email'];
                            $data= array(
                                
                                'seminar'=>$this->Seminarvergabe_model->get_seminare($email),
                
                            );
                            
                            $this->load->view('templates/header');
                            $this->load->view('pages/startseite_lehrstuhl', $data);
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
                elseif($versuch>3){
                    $this->user_model->lock_user($email);
                    $this->session->set_flashdata('user_locked_pw', 'Sie haben Ihr Passwort zu oft falsch eingegeben. Ihr Benutzeraccount wurde gesperrt. Bitte wenden Sie sich an den Administrator.');
                    redirect('users/login');
                }
                else{
                    $this->session->set_flashdata('user_is_locked_pw', 'Ihr Benutzeraccount ist gesperrt, da Sie das Passwort zu oft eingegeben haben. Bitte wenden Sie sich an den Administrator.');
                redirect('users/login');
                }
                
            }else{
                $this->session->set_flashdata('user_is_locked', 'Diese E-Mail existiert nicht im System oder Ihr Benutzeraccount ist gesperrt. Bitte wenden Sie sich an den Administrator.');
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

            // Logout durch Loginsperre
            echo $message;


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

        //Check if e-mail exists
        public function check_email_exists1($email){

            if($this->user_model->check_email_exists($email)){
                return false;
            }else{
                return true;
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
			$data['fristen']= $this->Fristen_model->get_fristen();
			
		
			
			$this->load->view('templates/header');
			$this->load->view('users/bewerben', $data);
			$this->load->view('templates/footer');
        }


        //Beschreibung des Seminars anzeigen
        public function seminar_info(){
            $data['seminar']= $this->seminar_model->get_seminare();
			$data['fristen']= $this->Fristen_model->get_fristen();
			
		
			
			$this->load->view('templates/header');
			$this->load->view('users/seminar_info', $data);
			$this->load->view('templates/footer');
        }
        //Zurück Button für Seminar-Detail-Ansicht
        public function goback(){

            if(empty($_SESSION['logged_in'])){

                $data['seminar']= $this->seminar_model->get_seminare();
                $data['fristen']=$this->Fristen_model->get_fristen();

                $this->load->view('templates/header');
                $this->load->view('pages/startseite', $data);
                $this->load->view('templates/footer');
                

            }else{
                


                if($_SESSION['rolle']==='dekan'){
                    $data['seminar']= $this->seminar_model->get_seminare();
                    $data['fristen']=$this->Fristen_model->get_fristen();
                    $data['ba_ohne']=$this->student_model->get_ba_ohne();
                    $data['ma_ohne']=$this->student_model->get_ma_ohne();
        
    
                    $this->load->view('templates/header');
                    $this->load->view('pages/startseite_dekan', $data);
                    $this->load->view('templates/footer');

                }else{
                 //Lädt Startseite des jeweiligen Benutzers   
                    redirect('startseite_'.$_SESSION['rolle']);
                  }

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
        
        public function Send_Mail($receiver_email, $subject, $message) {



			// Storing submitted values
			$sender_email = 'seminarplatzvergabe.uni.passau@gmail.com';
			$user_password = 'rfvBGT5%';
			$username = 'seminarplatzvergabe.uni.passau@gmail.com';
			
			// Load email library and passing configured values to email library
			$this->load->library('email');
			// Configure email library
			$config['protocol'] = 'smtp';
			$config['smtp_host'] = 'ssl://smtp.googlemail.com';
			$config['smtp_port'] = 465;
			$config['smtp_user'] = $sender_email;
			$config['smtp_pass'] = $user_password;
			$config['smtp_timeout'] = '7';
			$config['charset'] = 'utf-8';
			$config['newline'] = "\r\n";
			$config['mailtype'] = 'text/html';
			$config['validation'] = TRUE;
			

			// Load email library and passing configured values to email library
			$this->email->initialize($config);
	
			// Sender email address
			$this->email->from($sender_email, $username);
			// Receiver email address
			$this->email->to($receiver_email);
			// Subject of email
			$this->email->subject($subject);
			// Message in email
			$this->email->message($message);

			echo $this->email->print_debugger();
	
			if ($this->email->send()) {
				$data['message_display'] = 'Email Successfully Send !';
				$this->session->set_flashdata('email_success', 'Email Successfully Send !');
			} else {
				$this->session->set_flashdata('email_error', 'Invalid Gmail Account or Password !');
				echo $this->email->print_debugger();
			}
			
		}

		public function send_emails(){
			$this->load->view('templates/header');
            $this->load->view('users/send_emails');
			$this->load->view('templates/footer');
		}

        public function verifizieren($email){



			$this->load->view('templates/header');
			$this->load->view('pages/verifizieren', $email);
			$this->load->view('templates/footer');


        }

        function generatePassword ( $passwordlength = 8,
                            $numNonAlpha = 1,
                            $numNumberChars = 1,
                            $useCapitalLetter = true ) {
    
            $numberChars = '123456789';
            $specialChars = '!$%&=?*-:;.,+~@_';
            $secureChars = 'abcdefghjkmnpqrstuvwxyz';
            $stack = '';
                
            // Stack für Password-Erzeugung füllen
            $stack = $secureChars;
            
            if ( $useCapitalLetter == true )
                $stack .= strtoupper ( $secureChars );
                
            $count = $passwordlength - $numNonAlpha - $numNumberChars;
            $temp = str_shuffle ( $stack );
            $stack = substr ( $temp , 0 , $count );
            
            if ( $numNonAlpha > 0 ) {
                $temp = str_shuffle ( $specialChars );
                $stack .= substr ( $temp , 0 , $numNonAlpha );
            }
                
            if ( $numNumberChars > 0 ) {
                $temp = str_shuffle ( $numberChars );
                $stack .= substr ( $temp , 0 , $numNumberChars );
            }
                    
                
            // Stack durchwürfeln
            $stack = str_shuffle ( $stack );
                
            // Rückgabe des erzeugten Passwort
            return $stack;
            
        }
        
        public function passwort_vergessen(){
            $data['title']= 'Passwort vergessen';

            $this->form_validation->set_rules('e-mail', 'E-Mail', 'required|callback_email_check');
            
       
            if($this->form_validation->run() === FALSE){
                $this->load->view('templates/header');
                $this->load->view('users/passwort_vergessen', $data);
                $this->load->view('templates/footer');


            }
            else{

                

                //Get e-mail
                $email = $this->input->post('e-mail');

                if ($this->check_email_exists1($email)){
                    $password = $this->generatePassword();
                

                    //E_amil verschicken
                    $receiver_email= $email;
                    $subject= 'Neues Passwort für Seminarplatzvergabesystem';
                    $message = 'Hier ist Ihr neues Passwort für das Seminarplatzvergabesystem: '
                    . $password.
                    ' ' ;
                    
                    //Encrypt password
                    $enc_password = md5($password);
    
                    $this->Send_Mail($receiver_email, $subject, $message);
    
                    $this->user_model->updatePassword($enc_password, $receiver_email);

                    $this->session->set_flashdata('user_registered', 'Das neue Passwort wurde an Ihre E-Mail versendet!');
    
                    redirect('/startseite');
                }
                else{
                    $this->session->set_flashdata('email_error', 'Die E-Mail ist nicht im System registriert!');

                    $this->load->view('templates/header');
                    $this->load->view('users/passwort_vergessen', $data);
                    $this->load->view('templates/footer');
                }

                
                
            }
        }

        public function passwort_vergessen1(){

            $data['title']= 'Passwort vergessen';
            $this->load->view('templates/header');
            $this->load->view('users/passwort_vergessen', $data);
            $this->load->view('templates/footer');
        }

        public function verify(){

            $data['title']= 'verify';
            $this->load->view('templates/header');
            $this->load->view('users/verify', $data);
            $this->load->view('templates/footer');
        }

        public function verify1(){

            $data['title']= 'verify';
            $hash=$this->input->post('Hash');
            $email=$this->input->post('Email');


            $register = $this->user_model->verify($email, $hash);


            if ($register === FALSE){
                $this->load->view('templates/header');
                $this->load->view('users/verify_denied', $data);
                $this->load->view('templates/footer');
            }
            else{
                $this->user_model->verify1($email, $hash);
                $this->load->view('templates/header');
                $this->load->view('users/verify_accepted', $data);
                $this->load->view('templates/footer');
            }
        }

      
    }

