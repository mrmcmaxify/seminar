<?php

    class Lehrstuhl extends CI_Controller{

		//Seminar anlegen - Semesterüberprüfung nocht nicht geschehen
        public function seminaranlegen(){
           // $zustimmung=$this->input->post('Zustimmen');
            //var_dump($zustimmung);

            $data['title']= 'Seminar anlegen';
            $data['semester'] = $this->Fristen_model->getAllSemester();

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
                $bezeichnung = $this->input->post('semester');
                $data = $this->Seminaranlegen_model->get_semesteranfang($bezeichnung);
                $anfang = $data['0'];
                //berechnet Semesteranfang als Unix-Timestamp
                $semesteranfang = strtotime($anfang['anfang']);
                //berechnet aktuelle Zeit als Unix-Timestamp
                $heute = strtotime(date("Y-m-d"));
                $differenz = $semesteranfang - $heute;
                $sekunden_pro_zwei_semester = (60 * 60 * 24 * 365);
                //wenn gewähltes Semester mehr als zwei Semester in Zukunft liegt
                if ($differenz < $sekunden_pro_zwei_semester){
                    $this->Seminaranlegen_model->seminaranlegen();
                    //Set confirm message
                    $this->session->set_flashdata('seminar_angelegt', 'Das Seminar wurde angelegt!');
    
                    redirect('startseite');
                   
                }
                else {
                    $data1 = array(
                        'seminarname' => $this->input->post('seminarname'),
                        'lehrstuhlname' => $this->input->post('lehrstuhlname'),
                        'beschreibung' => $this->input->post('beschreibung'), 
                        'sollteilnehmerzahl' => $this->input->post('soll-teilnehmerzahl'),
                        'semester' => $this->input->post('semester'),
                        'BAMA' => $this->input->post('BA/MA'),
                        'msnotwendig' => $this->input->post('msnotwendig'),             
                    );
                    var_dump($data1);
                    $this->load->view('templates/header');
                    $this->load->view('pages/zwei_semester_in_zukunft', $data1);
                }
               
            }
        
        }
        //Seminaranlegen - Semesterüberprüfung schon geschehen
        public function seminaranlegen2(){
            
            $data['title']= 'Seminar anlegen';

            

            $this->Seminaranlegen_model->seminaranlegen();
            //Set confirm message
            $this->session->set_flashdata('seminar_angelegt', 'Das Seminar wurde angelegt!');

            redirect('startseite');
            
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
           
                $this->Seminaranlegen_model->seminar_pflegen($data1, $id);
                //Set confirm message
                $this->session->set_flashdata('aenderung_gespeichert', 'Die Änderungen wurden gespeichert!');

                redirect('startseite');
            //}
       
		}
		
		public function addstaff(){
            $email=$_SESSION['user_email'];
            $get1 = $this->Staff_model->get_lehrstuhl($email);
            $name = $get1['0'];
            $lehrstuhlname = $name['LehrstuhlName'];
            $get2 = $this->Staff_model->get_anzahl_mitarbeiter($lehrstuhlname);
            $anzahl = $get2['0'];
            $anzahlmitarbeiter = $anzahl['count(*)'];

            if ($anzahlmitarbeiter < 2) {
            
            $data['title']= 'Mitarbeiter anlegen';

            $this->form_validation->set_rules('e-mail', 'Name', 'required|valid_email|callback_check_email_exists|callback_email_check');
            $this->form_validation->set_rules('password', 'Passwort', 'required|callback_valid_password');
            $this->form_validation->set_rules('password2', 'Passwort bestätigen', 'matches[password]');
            $this->form_validation->set_rules('vorname', 'Vorname', 'required');
            $this->form_validation->set_rules('name', 'Name', 'required');
       
            if($this->form_validation->run() === FALSE){
                $this->load->view('templates/header');
                $this->load->view('users/addstaff', $data);
                $this->load->view('templates/footer');


            }else{
                //Encrypt password
                $enc_password = md5($this->input->post('password'));

                $this->Staff_model->addstaff($enc_password, $lehrstuhlname);

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
        else {
            $this->load->view('templates/header');
            $this->load->view('pages/mitarbeiteranzahl_zu_hoch');
            $this->load->view('templates/footer');
        }
       
        }

        public function email_check($email) {

            $this->form_validation->set_message('email_check', 'Die E-Mail-Adresse muss mit @uni-passau.de enden.');
            return strpos($email, '@uni-passau.de') !== false;
            
            
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
            $date = date("Y-m-d");
            $get = $this->Fristen_model->get_aktuelle_frist($date);
            $getid = $get['0'];
            $fristid = $getid['ID'];

			if($this->student_model->zuweisen_durch_lehrstuhl($email, $id, $fristid)){
				
				$this->session->set_flashdata('zugewiesen', 'Zuweisung erfolgreich!');
				
                $email=$_SESSION['user_email'];
                $data= array(
                    
                    'seminar'=>$this->Seminarvergabe_model->get_seminare($email),
    
                );

				$this->load->view('templates/header');
				$this->load->view('pages/startseite_lehrstuhl', $data);
				$this->load->view('templates/footer');

			}else{

				$this->session->set_flashdata('zugewiesen_nicht', 'Konnte nicht zuweisen, bitte Admin kontaktieren!');
            }
        

		}

		public function verteilen_anzeigen(){
           // $this->load->view('templates/header');

            $fristname = '1. Auswahlphase';
            $von = $this->Fristen_model->get_frist_start($fristname);
            $frist_start = $von['0'];
            $startdatum = $frist_start['Von'];
            $bis = $this->Fristen_model->get_frist_ende($fristname);
            $frist_ende = $bis['0'];
            $enddatum = $frist_ende['Bis'];
            $fristname2 = '2. Auswahlphase';
            $von2 = $this->Fristen_model->get_frist_start($fristname2);
            $frist_start2 = $von2['0'];
            $startdatum2 = $frist_start2['Von'];
            $bis2 = $this->Fristen_model->get_frist_ende($fristname2);
            $frist_ende2 = $bis2['0'];
            $enddatum2 = $frist_ende2['Bis'];
            $heute = date("Y-m-d");
            if ( (($heute < $startdatum) || ($heute > $enddatum)) && (($heute < $startdatum2) || ($heute > $enddatum2)) ) {
                $this->load->view('templates/header');
                $this->load->view('pages/ausserhalb_frist');
               
           
            }
            else {
            $email=$_SESSION['user_email'];
            $data= array(

                'seminarbewerbung'=>$this->Seminarvergabe_model->get_seminarbewerbung($email),




            );
            

			$this->load->view('templates/header');
			$this->load->view('users/seminarplatz_verteilen',$data);
        
            $email=$_SESSION['user_email'];
            $date = date("Y-m-d");
            $get = $this->Fristen_model->get_aktuelle_frist($date);
            $id = $get['0'];
            $fristid = $id['ID'];
            $data2= array(
                
                'seminarzuteilung'=>$this->Seminarvergabe_model->get_zuteilung($email, $fristid),




            );
            
			$this->load->view('users/seminarplatz_loeschen', $data2);
            $this->load->view('templates/footer');
        }

        }
        
        public function loeschen_anzeigen(){
            $email=$_SESSION['user_email'];
            $date = date("Y-m-d");
            $get = $this->Fristen_model->get_aktuelle_frist($date);
            $id = $get['0'];
            $fristid = $id['ID'];
            $data= array(
                
                'seminarzuteilung'=>$this->Seminarvergabe_model->get_zuteilung($email, $fristid),




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
				
                $email=$_SESSION['user_email'];
                $data= array(
                    
                    'seminar'=>$this->Seminarvergabe_model->get_seminare($email),
    
                );

				$this->load->view('templates/header');
				$this->load->view('pages/startseite_lehrstuhl', $data);
				$this->load->view('templates/footer');

			}else{

				$this->session->set_flashdata('zugewiesen_nicht_entfernt', 'Konnte Zuweisung nicht aufheben, bitte Admin kontaktieren!');
			}
		


        }

        public function seminar_loeschen_anzeigen(){
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
            $email=$_SESSION['user_email'];
            $data= array(
                
                'seminar'=>$this->Seminarvergabe_model->get_seminare($email),

            );
            
            $this->load->view('templates/header');
			$this->load->view('users/seminar_loeschen', $data);
            $this->load->view('templates/footer');
        }
        }
        // Löscht angelegte Seminare aus der Datenbank
		
		public function seminar_loeschen(){
			$id=$this->input->post('SeminarID');

			if($this->Seminarvergabe_model->seminar_entfernen($id)){
				
				$this->session->set_flashdata('entfernt', 'Seminar entfernt!');
				
                $email=$_SESSION['user_email'];
                $data= array(
                    
                    'seminar'=>$this->Seminarvergabe_model->get_seminare($email),
    
                );

				$this->load->view('templates/header');
				$this->load->view('pages/startseite_lehrstuhl', $data);
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
				
                $email=$_SESSION['user_email'];
                $data= array(
                    
                    'seminar'=>$this->Seminarvergabe_model->get_seminare($email),
    
                );

				$this->load->view('templates/header');
				$this->load->view('pages/startseite_lehrstuhl', $data);
				$this->load->view('templates/footer');

			}else{

				$this->session->set_flashdata('nicht_entfernt', 'Konnte Seminar nicht entfernen, bitte Admin kontaktieren!');
			}
		


        }

        public function seminarpflege_anzeigen(){
            $id=$this->input->post('SeminarID');
            $data= array(
                'semester' => $this->Fristen_model->getAllSemester(),
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
    
    //Download CSV Datei
    public function csv(){
        $report = $this->my_model->index();
        $new_report = $this->dbutil->csv_from_result($report);
        /*  Now use it to write file. write_file helper function will do it */
        write_file('csv_file.csv',$new_report);
        /*  Done    */
    }
		
	}