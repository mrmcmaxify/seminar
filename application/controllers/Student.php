<?php

    class Student extends CI_Controller{


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
            


            
            $this->seminar_model->bewerbungen_erhoehen($this->session->userdata('user_email'));

            $this->form_validation->set_rules('e-mail', 'E-Mail', 'required');
            
           
            if($data1['msnotwendig'] === 1){
                if (empty($_FILES['ms']['e-mail'])){
            
                    $this->form_validation->set_rules('ms', 'MS', 'required');
                }

            }
                  
                     
            if($this->form_validation->run() === FALSE){
                $this->load->view('templates/header');
                $this->load->view('users/bewerbung_hinzufuegen', $data);
                $this->load->view('templates/footer');
                
            }

            else{
                $this->seminar_model->bewerbungen_erhoehen($this->session->userdata('user_email'));

                 if($data1['msnotwendig'] === '1'){
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
                }
                else{
                
                    if($data1['msnotwendig'] === '1'){
                        $data = array('upload_data' => $this->upload->data());
                    }

                    else{    
                        $this->seminar_model->bewerbung_hinzufuegen($data1['msnotwendig'], $data1['seminarid']);
                        $this->seminar_model->bewerbungen_erhoehen($this->session->userdata('user_email'));
                        $this->user_model->add_log($data1['e-mail'], 1);
            

                        //Set confirm message
                        $this->session->set_flashdata('bewerbung_hinzugefuegt', 'Die Bewerbung wurde hinzugefuegt!');
            
                        redirect('startseite_student');
                    }

                }
        
            }
    
        }

        public function bewerbung_loeschen(){
            $data=array(
                'seminarid'=>$this->input->post('SeminarID'),
                'beschreibung'=>$this->input->post('Beschreibung'),
                'msnotwendig'=>$this->input->post('MSNotwendig'),
                'e-mail'=> $this->session->userdata('user_email')
            );

            $data1 =$this->seminar_model->bewerbung_loeschen($data['seminarid'], $data['e-mail']);
            $this->user_model->add_log($data['e-mail'], 2);

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
            $id=$this->input->post('SeminarID');
			$data= array(
				'seminar'=>$this->seminar_model->get_seminar($id),
            );
            
            $this->seminar_model->bewerbung_loeschen($data['seminar'][0]['SeminarID'], $this->session->userdata('user_email'));
            $this->user_model->add_log($this->session->userdata('user_email'), 4);

            redirect('startseite_student');

        }

        //Zugesagtes Seminar zusagen
        public function seminar_zusagen(){
            $id=$this->input->post('SeminarID');

            $this->seminar_model->seminar_zusagen($id, $this->session->userdata('user_email'));
            

            redirect('startseite_student');
        }

    }