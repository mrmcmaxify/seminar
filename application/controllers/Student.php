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

            /*
            $this->load->view('templates/header');
            $this->load->view('users/bewerbung_hinzufuegen', $data1);
            $this->load->view('templates/footer');
            */
            $this->form_validation->set_rules('e-mail', 'E-Mail', 'required');
            
            var_dump($this->form_validation->run());
            if($data1['msnotwendig'] === 1){
                if (empty($_FILES['ms']['e-mail'])){
            
                    $this->form_validation->set_rules('ms', 'MS', 'required');
                }

            }
                  
                     
            if($this->form_validation->run() === FALSE){
                $this->load->view('templates/header');
                $this->load->view('users/bewerbung_hinzufuegen', $data1);
                $this->load->view('templates/footer');
                var_dump($this->form_validation->run());
            }

            else{

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
                        //Set confirm message
                        $this->session->set_flashdata('bewerbung_hinzugefuegt', 'Die Bewerbung wurde hinzugefuegt!');
            
                        redirect('startseite_student');
                    }

                }
        
            }
    
        
        
        
        }
    }