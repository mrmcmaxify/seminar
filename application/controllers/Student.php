<?php

    class Student extends CI_Controller{
        function __construct(){
            parent::__construct();
            $email=$_SESSION['user_email'];
            $sperre = $this->user_model->get_loginsperre($email);
            $get_sperre = $sperre['0'];
            $loginsperre = $get_sperre['Loginsperre'];
			if($this->session->userdata('rolle') == 'student' && $this->session->userdata('logged_in') == true && $loginsperre == 2){
			}
			elseif($this->session->userdata('logged_in') == true){
				redirect('users/logout');
			}
			else{
				redirect('users/login');
			}
		}

        //Aufruf der Startseite vom Student
		public function startseite_student(){
			$this->load->view('templates/header');
            $this->load->view('pages/startseite_student');
			$this->load->view('templates/footer');
        }


        //Beschreibung des speziellen Seminars anzeigen
        public function seminar_info(){
            //$email = $this->input->post('E-Mail');
			//$email='test';


            $beschreibung=array(
                'beschreibung'=>$this->input->post('Beschreibung')
            );

            $seminarid=array(
                'seminarid'=>$this->input->post('SeminarID')
            );

			$this->load->view('templates/header');
			$this->load->view('users/seminar_info', $beschreibung);
			$this->load->view('templates/footer');
        }



        //Bewerbung eines Studenten für ein Seminar
        public function bewerben(){
             //$email = $this->input->post('E-Mail');
			//$email='test';


            $seminarID=array(
                'seminarID'=>$this->input->post('SeminarID')
            );

			$this->load->view('templates/header');
			$this->load->view('users/bewerbunghinzufuegen', $seminarID);
			$this->load->view('templates/footer');
        }






        //Bewerbung eines Studenten für ein Seminar hinzufügen
        public function bewerbung_hinzufuegen(){
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
                $this->load->view('pages/ausserhalb_frist_student');
                $this->load->view('templates/footer');
            }
            else{
                $data1=array(
                    'seminarid'=>$this->input->post('SeminarID'),
                    'beschreibung'=>$this->input->post('Beschreibung'),
                    'msnotwendig'=>$this->input->post('MSNotwendig'),
                    'e-mail'=> $this->session->userdata('user_email')
                );
                
                $id=$this->input->post('SeminarID');
                $data= array(
                    'seminar'=>$this->seminar_model->get_seminar($id),
                );

                $anzahlbewerbungen = $this->seminar_model->get_anzahl_bewerbungen($this->session->userdata('user_email'));
            
                if ($anzahlbewerbungen[0]['#Bewerbung'] < 5){
                    
                    if($data1['msnotwendig'] === '1'){

                        
                        
                    
                        
                            if (empty($_FILES['ms']['e-mail'])){
                        
                                $this->form_validation->set_rules('ms', 'MS', 'required');
                            }

                       
                            
                                
                        if($this->form_validation->run() === FALSE){
                            $this->load->view('templates/header');
                            $this->load->view('users/bewerbung_hinzufuegen', $data);
                            $this->load->view('templates/footer');
                            
                        }

                        else{
                            
                            
                                //File Upload
                                $config['upload_path']          = './uploads/';                
                                $config['allowed_types']        = 'pdf';
                                $config['max_size']             = 2048;
                                

                                $filename = time().$_FILES['ms']['e-mail'];
                                $config['file_name'] = $filename;
                                
                            
                                $this->load->library('upload', $config);

                                if ( ! $this->upload->do_upload('ms'))
                                {
                                        $error = array('error' => $this->upload->display_errors());
                                        
                                        $this->session->set_flashdata('upload', 'Dateiupload fehlgeschlagen!');
                                }
                            
                                else{
                            
                                    
                                    $data = array('upload_data' => $this->upload->data());
                                

                                   
                                    $this->seminar_model->bewerbung_hinzufuegen($data1['msnotwendig'], $data1['seminarid']);
                                    $var = $anzahlbewerbungen[0]['#Bewerbung'];
                                    $var++;
                                    
                                    $anzahlbewerbungen[0]['#Bewerbung'] = $var;
                                    
                                    $this->seminar_model->bewerbungen_erhoehen($this->session->userdata('user_email'), $var);
                                    $this->user_model->add_log($data1['e-mail'], 1, $data['seminar'][0]['SeminarName']);
                        

                                    //Set confirm message
                                    $this->session->set_flashdata('bewerbung_hinzugefuegt', 'Die Bewerbung wurde hinzugefuegt!');
                        
                                    redirect('startseite_student');
                                

                                }
                    
                        }

                    }

                    else{
                        $this->load->view('templates/header');
                        $this->load->view('users/bewerbung_hinzufuegen', $data);
                        $this->load->view('templates/footer');

                    }
                }

                else{
                    $this->load->view('templates/header');
                    $this->load->view('pages/bewerbungsanzahl_zu_hoch', $data);
                    $this->load->view('templates/footer');
                }
            }
        }


        public function bewerbung_hinzufuegen1(){

            $data1=array(
                'seminarid'=>$this->input->post('SeminarID'),
                'beschreibung'=>$this->input->post('Beschreibung'),
                'msnotwendig'=>$this->input->post('MSNotwendig'),
                'e-mail'=> $this->session->userdata('user_email')
            );

            $data= array(
                'seminar'=>$this->seminar_model->get_seminar($data1['seminarid']),
            );

            $anzahlbewerbungen = $this->seminar_model->get_anzahl_bewerbungen($this->session->userdata('user_email'));
            $this->seminar_model->bewerbung_hinzufuegen($data1['msnotwendig'], $data1['seminarid']);
            $var = $anzahlbewerbungen[0]['#Bewerbung'];
            $var++;
            
            $anzahlbewerbungen[0]['#Bewerbung'] = $var;
            
            $this->seminar_model->bewerbungen_erhoehen($this->session->userdata('user_email'), $var);
            $this->user_model->add_log($data1['e-mail'], 1, $data['seminar'][0]['SeminarName']);


            //Set confirm message
            $this->session->set_flashdata('bewerbung_hinzugefuegt', 'Die Bewerbung wurde hinzugefuegt!');

            redirect('startseite_student');
        }


        public function bewerbung_loeschen(){
            $data=array(
                'seminarid'=>$this->input->post('SeminarID'),
                'beschreibung'=>$this->input->post('Beschreibung'),
                'msnotwendig'=>$this->input->post('MSNotwendig'),
                'e-mail'=> $this->session->userdata('user_email')
            );

            $this->load->view('templates/header');
            $this->load->view('users/bewerbung_loeschen', $data);
            $this->load->view('templates/footer');

        }

        public function bewerbung_loeschen1(){

            $data=array(
                'seminarid'=>$this->input->post('SeminarID'),
                'beschreibung'=>$this->input->post('Beschreibung'),
                'msnotwendig'=>$this->input->post('MSNotwendig'),
                'e-mail'=> $this->session->userdata('user_email')
            );

            $data3= array(
                'seminar'=>$this->seminar_model->get_seminar($data['seminarid']),
            );
            
            $data1 =$this->seminar_model->bewerbung_loeschen($data['seminarid'], $this->session->userdata('user_email'));
            $anzahlbewerbungen = $this->seminar_model->get_anzahl_bewerbungen($this->session->userdata('user_email'));
            $var = $anzahlbewerbungen[0]['#Bewerbung'];
            $var--;  
            $this->seminar_model->bewerbungen_verkleinern($this->session->userdata('user_email'), $var);
            $this->user_model->add_log($data['beschreibung'], 2, $data3['seminar'][0]['SeminarName']);

            redirect('startseite_student');
            
        }

        //Detail-Ansicht für Seminare
		public function show_seminar(){
			$id=$this->input->post('SeminarID');
			$data= array(
				'seminar'=>$this->seminar_model->get_seminar($id),
			);

			$this->load->view('templates/header');
			$this->load->view('pages/show_seminar', $data);
			$this->load->view('templates/footer');
        }
        
        //Zugesagtes Seminar ablehnen
        public function seminar_ablehnen(){

            $fristname = '1. Annahme-/Rücktrittsphase';
            $von = $this->Fristen_model->get_frist_start($fristname);
            $frist_start = $von['0'];
            $startdatum = $frist_start['Von'];
            $bis = $this->Fristen_model->get_frist_ende($fristname);
            $frist_ende = $bis['0'];
            $enddatum = $frist_ende['Bis'];

            $fristname1 = '2. Annahme-/Rücktrittsphase';
            $von1 = $this->Fristen_model->get_frist_start($fristname1);
            $frist_start1 = $von1['0'];
            $startdatum1 = $frist_start1['Von'];
            $bis1 = $this->Fristen_model->get_frist_ende($fristname1);
            $frist_ende1 = $bis1['0'];
            $enddatum1 = $frist_ende1['Bis'];

            $heute = date("Y-m-d");

            if ( (($heute >= $startdatum) && ($heute <= $enddatum))||(($heute >= $startdatum1) && ($heute <= $enddatum1))) {
                $data=array(
                    'seminarid'=>$this->input->post('SeminarID'),
                    'beschreibung'=>$this->input->post('Beschreibung'),
                    'msnotwendig'=>$this->input->post('MSNotwendig'),
                    'e-mail'=> $this->session->userdata('user_email')
                );

                $this->load->view('templates/header');
                $this->load->view('users/seminar_ablehnen', $data);
                $this->load->view('templates/footer');
            } 

            else{
                
                $this->load->view('templates/header');
                $this->load->view('pages/ausserhalb_frist_student');
                $this->load->view('templates/footer');
        }

        }

        public function seminar_ablehnen1(){

            $id=$this->input->post('SeminarID');
			$data= array(
				'seminar'=>$this->seminar_model->get_seminar($id),
            );
            
            $this->seminar_model->bewerbung_loeschen($data['seminar'][0]['SeminarID'], $this->session->userdata('user_email'));
            $this->user_model->add_log($this->session->userdata('user_email'), 4, $data['seminar'][0]['SeminarName']);

            redirect('startseite_student');
        }

        //Zugesagtes Seminar zusagen
        public function seminar_zusagen(){
            $fristname = '1. Annahme-/Rücktrittsphase';
            $von = $this->Fristen_model->get_frist_start($fristname);
            $frist_start = $von['0'];
            $startdatum = $frist_start['Von'];
            $bis = $this->Fristen_model->get_frist_ende($fristname);
            $frist_ende = $bis['0'];
            $enddatum = $frist_ende['Bis'];

            $fristname1 = '2. Annahme-/Rücktrittsphase';
            $von1 = $this->Fristen_model->get_frist_start($fristname1);
            $frist_start1 = $von1['0'];
            $startdatum1 = $frist_start1['Von'];
            $bis1 = $this->Fristen_model->get_frist_ende($fristname1);
            $frist_ende1 = $bis1['0'];
            $enddatum1 = $frist_ende1['Bis'];

            $heute = date("Y-m-d");

            

            if ( (($heute >= $startdatum) && ($heute <= $enddatum))||(($heute >= $startdatum1) && ($heute <= $enddatum1))) {
                $id=$this->input->post('SeminarID');

                $data= array(
                    'seminar'=>$this->seminar_model->get_seminar($id),
                );

                $anzahlzusagen = $this->seminar_model->get_anzahl_zusagen($this->session->userdata('user_email'));
    
                $var = $anzahlzusagen[0]['#Annahmen'];
                if($var < 3){
    
                    $var++;
                    
                    if (($heute >= $startdatum) && ($heute <= $enddatum)){
                    
                        $this->seminar_model->seminar_zusagen($id, $this->session->userdata('user_email'), 2);
                    }
                    else{
                        $this->seminar_model->seminar_zusagen($id, $this->session->userdata('user_email'), 4);
                    }
                    $this->seminar_model->zusagen_erhoehen($this->session->userdata('user_email'), $var);
                    $this->user_model->add_log($this->session->userdata('user_email'), 3, $data['seminar'][0]['SeminarName']);
                    $anzahlteilnehmer = $this->seminar_model->get_anzahl_teilnehmer($id);
                    $var1 = $anzahlteilnehmer[0]['Ist-Teilnehmerzahl'];
                    $var1++;
                    $this->seminar_model->teilnehmer_erhoehen($id, $var1);
                    var_dump($anzahlteilnehmer);
    
                    redirect('startseite_student');
                    }
                    
                else{
                    $this->load->view('templates/header');
                    $this->load->view('pages/zusagenanzahl_zu_hoch');
                    $this->load->view('templates/footer');
                }
            } 

            
            else{

                $this->load->view('templates/header');
                $this->load->view('pages/ausserhalb_frist_student');
                $this->load->view('templates/footer');
           
            }
        }

        //Studenten-Abschluss ändern
        public function abschluss_aendern(){
            $data['title']= 'Abschluss ändern';
            $this->form_validation->set_rules('ba/ma', 'BA/MA', 'required');

            if($this->form_validation->run() === FALSE){
                $this->load->view('templates/header');
                $this->load->view('daten_aendern', $data);
                $this->load->view('templates/footer');
            }

            else{
                //Aufruf register methode
                $this->seminar_model->abschluss_aendern($this->session->userdata('user_email'));

                //Set confirm message
                $this->session->set_flashdata('user_registered', 'Sie haben Ihren Abschluss geändert!');

                redirect('startseite_student');
            }
            
        }

        //Studenten-Vornamen ändern
        public function vorname_aendern(){
            $data['title']= 'Vorname ändern';
            $this->form_validation->set_rules('vorname', 'Vorname', 'required');

            if($this->form_validation->run() === FALSE){
                $this->load->view('templates/header');
                $this->load->view('pages/daten_aendern', $data);
                $this->load->view('templates/footer');
            }

            else{
                //Aufruf register methode
                $this->seminar_model->vorname_aendern($this->session->userdata('user_email'));

                //Set confirm message
                $this->session->set_flashdata('user_registered', 'Sie haben Ihren Vornamen geändert!');

                redirect('startseite_student');
            }
            
        }

        //Studenten-Nachnamen ändern
        public function nachname_aendern(){
            $data['title']= 'Nachname ändern';
            $this->form_validation->set_rules('name', 'Name', 'required');

            if($this->form_validation->run() === FALSE){
                $this->load->view('templates/header');
                $this->load->view('pages/daten_aendern', $data);
                $this->load->view('templates/footer');
            }

            else{
                //Aufruf register methode
                $this->seminar_model->nachname_aendern($this->session->userdata('user_email'));

                //Set confirm message
                $this->session->set_flashdata('user_registered', 'Sie haben Ihren Nachnamen geändert!');

                redirect('startseite_student');
            }
            
        }

    }