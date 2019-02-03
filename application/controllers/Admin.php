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

            $this->form_validation->set_rules('e-mail', 'Name', 'required|callback_admin_check_email_exists|valid_email|callback_email_check');
            $this->form_validation->set_rules('password', 'Passwort', 'required|callback_valid_password');
            $this->form_validation->set_rules('password2', 'Passwort bestätigen', 'matches[password]');
            $this->form_validation->set_rules('vorname', 'Vorname', 'required');
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('rolle', 'Rolle', 'required');
			$this->form_validation->set_rules('inhaber', 'Inhaber', 'required');
			if($this->input->post('rolle')=='lehrstuhl'){
				$this->form_validation->set_rules('lehrstuhlname', 'LehrstuhlName', 'required');
			}
			

			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header');
				$this->load->view('admin/add_user', $data);
				$this->load->view('templates/footer');
			}
			//Überprüft Anzahl Benutzerkonten für Lehrstuhl 
			else{
				$anzahlmitarbeiter;
				$fehler=FALSE;
				if($this->input->post('rolle')=='lehrstuhl'){
					$lehrstuhlname=$this->input->post('lehrstuhlname');
					$get2=$this->Staff_model->get_anzahl_mitarbeiter($lehrstuhlname);
					$anzahl1 = $get2['0'];
					$anzahlmitarbeiter = $anzahl1['count(*)'];
					$get3=$this->Staff_model->get_anzahl_inhaber($lehrstuhlname);
					$anzahl2 = $get3['0'];
					$anzahlinhaber = $anzahl2['count(*)'];
					if($anzahlinhaber=='0' && $this->input->post('inhaber')=='2'){
						$this->load->view('templates/header');
						$this->load->view('admin/inhaber_fehlt');
						$this->load->view('templates/footer');
						$fehler=TRUE;
						}
					elseif($anzahlinhaber>'0' && $this->input->post('inhaber')=='1'){
						$this->load->view('templates/header');
						$this->load->view('admin/inhaber_zu_hoch');
						$this->load->view('templates/footer');
						$fehler=TRUE;
					}
				}

				//Überprüft Anzahl Benutzerkonten für Dekan
				if($this->input->post('rolle')=='dekan'){
					$get2=$this->Staff_model->get_anzahl_mitarbeiter_dekan();
					$anzahl1 = $get2['0'];
					$anzahlmitarbeiter = $anzahl1['count(*)'];
					$get3=$this->Staff_model->get_anzahl_inhaber_dekan();
					$anzahl2 = $get3['0'];
					$anzahlinhaber = $anzahl2['count(*)'];
					if($anzahlinhaber=='0' && $this->input->post('inhaber')=='2'){
						$this->load->view('templates/header');
						$this->load->view('admin/inhaber_fehlt');
						$this->load->view('templates/footer');
						$fehler=TRUE;
						}
					elseif($anzahlinhaber>'0' && $this->input->post('inhaber')=='1'){
						$this->load->view('templates/header');
						$this->load->view('admin/inhaber_zu_hoch');
						$this->load->view('templates/footer');
						$fehler=TRUE;
					}
				}
				
				if ($anzahlmitarbeiter < 2 && !$fehler) {
					
				
					//Encrypt password
					$enc_password = md5($this->input->post('password'));

					
					//Aufruf register methode
					$this->admin_model->add_user($enc_password);

					//Set confirm message
					$this->session->set_flashdata('user_added', 'Der Benutzer wurde angelegt.');

					//Versenden der Email mit Benutzername und Passwort
					$receiver_email=$this->input->post('e-mail');
					$subject='Benutzerdaten für Seminarplatzvergabe-System';
					$pw=$this->input->post('password');
					$message="Ihre Logindaten für das Seminarplatzvegabe-System lauten wie folgt: Benutzername:".$receiver_email." Passwort: ".$pw;
					$this->Send_Mail($receiver_email, $subject, $message);

					// linkname wird an die view übergeben und dort wird mit ok dieser link aufgerufen (hier wird zurückgeführt)
					$link['linkname']='admin/add_user';
					$this->load->view('templates/header');
					$this->load->view('pages/ok', $link);
					$this->load->view('templates/footer');
				}
				elseif(!$fehler) {
					$this->load->view('templates/header');
					$this->load->view('admin/mitarbeiteranzahl_zu_hoch');
					$this->load->view('templates/footer');
				}
			}	
			
       
		}
		
		//Überprüft ob die Email zur Uni gehört
        public function email_check($email) {
			$this->form_validation->set_message('email_check', 'Die E-Mail-Adresse muss mit @uni-passau.de enden.');
			return strpos($email, '@uni-passau.de') !== false;
			
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
		//Sucht Benutzer anhand von E-Mail Adresse in zeigt sie im view admin/search_user an
		public function search_user(){

			$data['user']= $this->user_model->get_users();


			$field  = 'E-Mail';
			$search = $this->input->post('search');
			if (!empty($search)) {
				$data['user'] = $this->user_model->getUserWhereLike($field, $search);
			} else {
				$data['user'] = $this->user_model->get_users();
			}

			$this->load->view('templates/header');
            $this->load->view('admin/search_user', $data);
			$this->load->view('templates/footer');

		}
		//Öffnet die Bestätigungsseite zum Löschen des Benutzers mit $email
		public function delete_user_index(){
			$data['email']=$this->input->post('email');
			$this->load->view('templates/header');
            $this->load->view('admin/delete_user', $data);
			$this->load->view('templates/footer');
		}

		//Löscht den Benutzer mit Array $user
		public function delete_user(){
			$email=$this->input->post('email');
			$user=$this->user_model->getUser($email);
			if($this->user_model->delete_user($email)){
				$this->session->set_flashdata('user_deleted', 'Der Benutzer wurde gelöscht.');
				if($user->Rolle=='student'){
					$this->user_model->delete_user_student($email);
				}
				elseif($user->Rolle=='dekan'){
					$this->user_model->delete_user_dekan($email);
				}
				elseif($user->Rolle=='lehrstuhl'){
					$this->user_model->delete_user_lehrstuhl($email);
				}
				$receiver_email=$email;
				$subject='Löschung Seminarplatzvergabe Benutzer';
				$message='Ihr Benutzeraccount vom Seminarplatzvergabe-System wurde vom Administrator gelöscht';
				$this->Send_Mail($receiver_email, $subject, $message);
			}
			else{
				$this->session->set_flashdata('user_deleted_failed', 'Der Benutzer konnte nicht gelöscht werden!');
			}
			redirect('admin/search_user');
		}

		//Entsperrt Benutzer
		public function unlock_user(){
			$email=$this->input->post('email');
			$user=$this->user_model->getUser($email);
			if($user->Loginsperre=='1'){
				$this->user_model->unlock_user($email);
				$this->session->set_flashdata('user_unlocked', 'Der Benutzer wurde entsperrt.');
			}
			elseif($user->Loginsperre=='2'){
				$this->session->set_flashdata('user_unlocked_failed', 'Der Benutzer ist nicht gesperrt.');
			}
			else{
				$this->session->set_flashdata('user_lock_error', 'Der Benutzer besitzt keinen gültigen Eintrag bei "Loginsperre" in der Datenbank.');
			}
			redirect('admin/search_user');
			
		}
		//Sperrt Benutzer
		public function lock_user(){
			$email=$this->input->post('email');
			$user=$this->user_model->getUser( $email);
			
			if($user->Loginsperre=='2'){
				$this->user_model->lock_user($email);
				$this->session->set_flashdata('user_locked', 'Der Benutzer wurde gesperrt.');
			}
			elseif($user->Loginsperre=='1'){
				$this->session->set_flashdata('user_unlocked_failed', 'Der Benutzer ist bereits gesperrt.');
			}
			else{
				$this->session->set_flashdata('user_lock_error', 'Der Benutzer besitzt keinen gültigen Eintrag bei "Loginsperre" in der Datenbank.');
			}
			redirect('admin/search_user');
		}
		//Durchsucht die Logdatei nach Emails
		public function search_log(){

			$data['log']= $this->admin_model->get_log();


			$field  = 'E-Mail';
			$search = $this->input->post('search');
			if (!empty($search)) {
				$data['log'] = $this->admin_model->getLogsWhereLike($field, $search);
			} else {
				$data['log'] = $this->admin_model->get_log();
			}

			$this->load->view('templates/header');
            $this->load->view('admin/search_log', $data);
			$this->load->view('templates/footer');

		}

		//Funktion zum Versänden von Mails
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
		//Lädt  das view zum Anzeigen der Semesterzeiten
		public function semesterzeiten_anzeigen(){

			$data['semester']= $this->admin_model->get_semesterzeiten();	
			$this->load->view('templates/header');
			$this->load->view('admin/add_semester', $data);
			$this->load->view('templates/footer');
		}
		//Ändert Fristen und überprüft Änderungen
		public function semester_edit(){

			$this->form_validation->set_rules('bezeichnung', 'Bezeichnung', 'required|callback_check_semester_exists');
			$this->form_validation->set_rules('anfang', 'Anfang', 'required');
			$this->form_validation->set_rules('ende', 'Ende', 'required|callback_check_bigger_semester['.$this->input->post('anfang').']');
			

			if($this->form_validation->run() === FALSE){

				$data1['semester']= $this->admin_model->get_semesterzeiten();	
                $this->load->view('templates/header');
                $this->load->view('admin/add_semester', $data1);
                $this->load->view('templates/footer');


			}
			else{

				$data= array (
					'bezeichnung'=>$this->input->post('bezeichnung'),
					'anfang'=>$this->input->post('anfang'),
					'ende'=>$this->input->post('ende')
				);
				
				if($this->admin_model->semster_edit($data)){

					$this->session->set_flashdata('semsterzeiten_success', 'Semester wurde eingetragen!');

					$data1['semester']= $this->admin_model->get_semesterzeiten();	

					$this->load->view('templates/header');
					$this->load->view('admin/add_semester', $data1);
					$this->load->view('templates/footer');

				}
				else{
			
				$this->session->set_flashdata('semsterzeiten_fail', 'Semester konnte nicht angelegt werden!');

				$data1['semester']= $this->admin_model->get_semsterzeiten();	

				$this->load->view('templates/header');
				$this->load->view('admin/add_semester', $data1);
				$this->load->view('templates/footer');

				}
			}
		}
		
		public function check_bigger_semester($datejetzt, $datevor){
			if ($datejetzt < $datevor){
				$this->form_validation->set_message('check_bigger_semester', 'Zeiträume müssen chronologisch korrekt geordnet sein!');
				return false;       
      		}else{

				return true;
			  }
			}

		public function check_semester_exists($bezeichnung){
			$this->form_validation->set_message('check_semester_exists', 'Dieses Semster existiert bereits. Bitte vorher löschen.');
	
			if($this->admin_model->check_semester_exists($bezeichnung)){
				return true;
			}
			else{
				return false;
			}
	
		}
		
		public function delete_semester(){
			$bezeichnung=$this->input->post('bezeichnung');
				if($this->admin_model->delete_semester($bezeichnung)){
					$this->session->set_flashdata('semester_deleted', 'Das Semester wurde gelöscht.');
				}
				else{
					$this->session->set_flashdata('semester_deleted_failed', 'Das Semester konnte nicht gelöscht werden!');
				}
				redirect('admin/semesterzeiten_anzeigen');
			}

			public function delete_semester_index(){
				$data['bezeichnung']=$this->input->post('bezeichnung');
				$this->load->view('templates/header');
				$this->load->view('admin/delete_semester', $data);
				$this->load->view('templates/footer');
			}

			public function studiengang_anzeigen(){

				$data['studiengang']= $this->admin_model->get_studiengaenge();	
				$this->load->view('templates/header');
				$this->load->view('admin/add_studiengang', $data);
				$this->load->view('templates/footer');
			}
			//Ändert Fristen und überprüft Änderungen
			public function studiengang_edit(){
	
				$this->form_validation->set_rules('bezeichnung', 'Bezeichnung', 'required|callback_check_studiengang_exists');
				
				
	
				if($this->form_validation->run() === FALSE){
	
					$data1['studiengang']= $this->admin_model->get_studiengaenge();	
					$this->load->view('templates/header');
					$this->load->view('admin/add_studiengang', $data1);
					$this->load->view('templates/footer');
	
	
				}
				else{

					$data= array (
						'bezeichnung'=>$this->input->post('bezeichnung'),
						
					);
					
					if($this->admin_model->studiengang_edit($data)){
	
						$this->session->set_flashdata('studiengang_success', 'Studiengang wurde eingetragen!');
	
						$data1['studiengang']= $this->admin_model->get_studiengaenge();	
	
						$this->load->view('templates/header');
						$this->load->view('admin/add_studiengang', $data1);
						$this->load->view('templates/footer');
	
					}
					else{
				
					$this->session->set_flashdata('studiengang_fail', 'Studiengang konnte nicht angelegt werden!');
	
					$data1['studiengang']= $this->admin_model->get_studiengaenge();	
	
					$this->load->view('templates/header');
					$this->load->view('admin/add_studiengang', $data1);
					$this->load->view('templates/footer');
	
					}
				}
			}

				//Überprüft ob Studiengang bereits existiert für Formvalidation
				public function check_studiengang_exists($bezeichnung){
					$this->form_validation->set_message('check_studiengang_exists', 'Dieser Studiengang existiert bereits.');
			
					if($this->admin_model->check_studiengang_exists($bezeichnung)){
						return true;
					}
					else{
						return false;
					}
			
				}

				public function delete_studiengang_index(){
					$data['bezeichnung']=$this->input->post('bezeichnung');
					$this->load->view('templates/header');
					$this->load->view('admin/delete_studiengang', $data);
					$this->load->view('templates/footer');
				}

				public function delete_studiengang(){
					$bezeichnung=$this->input->post('bezeichnung');
						if($this->admin_model->delete_studiengang($bezeichnung)){
							$this->session->set_flashdata('studiengang_deleted', 'Der Studiengang wurde gelöscht.');
						}
						else{
							$this->session->set_flashdata('studiengang_deleted_failed', 'Der Studiengang konnte nicht gelöscht werden!');
						}
						redirect('admin/studiengang_anzeigen');
					}

				
}


