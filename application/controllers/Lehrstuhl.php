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
        
        //Seminar pflegen
        public function seminar_pflegen(){
            $id=$this->input->post('SeminarID');
            
           /* $data['title']= 'Seminar pflegen';

            $this->form_validation->set_rules('seminarname', 'Seminarname');
            $this->form_validation->set_rules('beschreibung', 'Beschreibung');
            $this->form_validation->set_rules('soll-teilnehmerzahl', 'Soll-Teilnehmerzahl');
            $this->form_validation->set_rules('semester', 'Semester');
           
         
            
            if($this->form_validation->run() === FALSE){
                $this->load->view('templates/header');
                $this->load->view('users/seminar_pflegen');
                $this->load->view('templates/footer');


            }else{
              */ 
                //User data array(seminar)
                if (!empty($this->input->post('seminarname'))) {
                    $data1['seminarname']  = $this->input->post('seminarname');
                }
                if (!empty($this->input->post('beschreibung'))) {
                    $data1['beschreibung']  = $this->input->post('beschreibung');
                }
                if (!empty($this->input->post('soll-teilnehmerzahl'))) {
                    $data1['soll-teilnehmerzahl']  = $this->input->post('soll-teilnehmerzahl');
                }
                if (!empty($this->input->post('semester'))) {
                    $data1['semester']  = $this->input->post('semester');
                }
           /* $data1 = array(
                'seminarname' => $this->input->post('seminarname'),
                'beschreibung' => $this->input->post('beschreibung'), 
                'soll-teilnehmerzahl' => $this->input->post('soll-teilnehmerzahl'),
                'semester' => $this->input->post('semester'),
                
                
                              
            ); 
            */
                $this->Seminaranlegen_model->seminar_pflegen($data1, $id);
                //Set confirm message
                $this->session->set_flashdata('aenderung_gespeichert', 'Die Änderungen wurden gespeichert!');

                redirect('startseite');
            //}
       
		}
		
		public function addstaff(){
            $data['title']= 'Mitarbeiter anlegen';

            $this->form_validation->set_rules('e-mail', 'Name', 'required|callback_check_email_exists');
            $this->form_validation->set_rules('password', 'Passwort', 'required');
            $this->form_validation->set_rules('password2', 'Passwort bestätigen', 'matches[password]');
            $this->form_validation->set_rules('vorname', 'Vorname', 'required');
            $this->form_validation->set_rules('name', 'Name', 'required');
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
                
                //Versenden der Email mit Benutzername und Passwort
				$receiver_email=$this->input->post('e-mail');
				$subject='Benutzerdaten für Seminarplatzvergabe-System';
				$pw=$this->input->post('password');
				$message="Ihre Logindaten für das Seminarplatzvegabe-System lauten wie folgt: Benutzername:".$receiver_email." Passwort: ".$pw;
				$this->Send_Mail($receiver_email, $subject, $message);
                redirect('startseite');
            }
       
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
		
		// Trägt Studenten in die Seminarzuteilungs-Tabelle ein
		
		public function verteilen(){
			$email=$this->input->post('E-Mail');
			$id=$this->input->post('SeminarID');

			if($this->student_model->zuweisen($email,$id)){
				
				$this->session->set_flashdata('zugewiesen', 'Zuweisung erfolgreich!');
				
			

				$this->load->view('templates/header');
				$this->load->view('pages/startseite_lehrstuhl');
				$this->load->view('templates/footer');

			}else{

				$this->session->set_flashdata('zugewiesen_nicht', 'Konnte nicht zuweisen, bitte Admin kontaktieren!');
			}
		


		}

		public function verteilen_anzeigen(){
            $email=$_SESSION['user_email'];
          //  $lehrstuhl=$this->Seminarvergabe_model->get_lehrstuhl($email);
          //  $seminare=$this->Seminarvergabe_model->get_seminare($lehrstuhl);
            $data= array(
               // 'lehrstuhl'=>$lehrstuhl,
                'seminarbewerbung'=>$this->Seminarvergabe_model->get_seminarbewerbung($email),




            );
            

			$this->load->view('templates/header');
			$this->load->view('users/seminarplatz_verteilen',$data);
            
            $data2= array(
                
                'seminarzuteilung'=>$this->Seminarvergabe_model->get_zuteilung($email),




            );
            
			$this->load->view('users/seminarplatz_loeschen', $data2);
			$this->load->view('templates/footer');

        }
        
        public function loeschen_anzeigen(){
            $email=$_SESSION['user_email'];
            $data= array(
                
                'seminarzuteilung'=>$this->Seminarvergabe_model->get_zuteilung($email),




            );
            
            $this->load->view('templates/header');
			$this->load->view('users/seminarplatz_loeschen', $data);
			$this->load->view('templates/footer');
        }

        public function loeschen(){
			$email=$this->input->post('E-Mail');
			$id=$this->input->post('SeminarID');

			if($this->Seminarvergabe_model->zuteilung_entfernen($email,$id)){
				
				$this->session->set_flashdata('entfernt', 'Zuweisung erfolgreich entfernt!');
				
			

				$this->load->view('templates/header');
				$this->load->view('pages/startseite_lehrstuhl');
				$this->load->view('templates/footer');

			}else{

				$this->session->set_flashdata('zugewiesen_nicht_entfernt', 'Konnte Zuweisung nicht aufheben, bitte Admin kontaktieren!');
			}
		


        }

        public function seminar_loeschen_anzeigen(){
            $email=$_SESSION['user_email'];
            $data= array(
                
                'seminar'=>$this->Seminarvergabe_model->get_seminare($email),

            );
            
            $this->load->view('templates/header');
			$this->load->view('users/seminar_loeschen', $data);
			$this->load->view('templates/footer');
        }
        // Löscht angelegte Seminare aus der Datenbank
		
		public function seminar_loeschen(){
			$id=$this->input->post('SeminarID');

			if($this->Seminarvergabe_model->seminar_entfernen($id)){
				
				$this->session->set_flashdata('entfernt', 'Seminar entfernt!');
				
			

				$this->load->view('templates/header');
				$this->load->view('pages/startseite_lehrstuhl');
				$this->load->view('templates/footer');

			}else{

				$this->session->set_flashdata('nicht_entfernt', 'Konnte Seminar nicht entfernen, bitte Admin kontaktieren!');
			}
		


        }

        public function startseite_anzeigen(){
            $email=$_SESSION['user_email'];
            $data= array(
                
                'seminar'=>$this->Seminarvergabe_model->get_seminare($email),

            );
            
            $this->load->view('templates/header');
			$this->load->view('pages/startseite_lehrstuhl', $data);
			$this->load->view('templates/footer');
        }

        public function seminar_bearbeiten(){
			$id=$this->input->post('SeminarID');

			if($this->Seminarvergabe_model->seminar_entfernen($id)){
				
				$this->session->set_flashdata('entfernt', 'Seminar entfernt!');
				
			

				$this->load->view('templates/header');
				$this->load->view('pages/startseite_lehrstuhl');
				$this->load->view('templates/footer');

			}else{

				$this->session->set_flashdata('nicht_entfernt', 'Konnte Seminar nicht entfernen, bitte Admin kontaktieren!');
			}
		


        }

        public function seminarpflege_anzeigen(){
            $id=$this->input->post('SeminarID');
            $data= array(
                
                'seminar'=>$this->Seminaranlegen_model->get_seminar($id),
                'id'=>$id,



            );
            
            $this->load->view('templates/header');
			$this->load->view('users/seminar_pflegen', $data);
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
			$config['mailtype'] = 'text';
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
		
	}