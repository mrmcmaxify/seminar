<?php

    class Dekan extends CI_Controller{
		//Zeigt Startseite des Dekans an
		public function startseite_dekan(){

			$data['seminar']= $this->seminar_model->get_seminare();
			$data['fristen']=$this->Fristen_model->get_fristen();
			$data['ba_ohne']=$this->student_model->get_ba_ohne();
			$data['ma_ohne']=$this->student_model->get_ma_ohne();

			$this->load->view('templates/header');
			$this->load->view('pages/startseite_dekan', $data);
			$this->load->view('templates/footer');


		}
		//Zeigt Zuweisen Funktionalität an
		public function zuweisen_anzeigen(){

			$email=$this->input->post('E-Mail');
			$abschluss=$this->input->post('BA/MA');

			if($abschluss==='BA'){
				$data=array(
					'email'=>$this->input->post('E-Mail'),
					'name'=>$this->input->post('Name'),
					'vorname'=>$this->input->post('Vorname'),
					'seminar'=>$this->seminar_model->get_seminare_ma(),
					'beworben'=>$this->seminar_model->get_seminare_beworben($email),
	
				);
			}else{
				$data=array(
					'email'=>$this->input->post('E-Mail'),
					'name'=>$this->input->post('Name'),
					'vorname'=>$this->input->post('Vorname'),
					'seminar'=>$this->seminar_model->get_seminare_ba(),
					'beworben'=>$this->seminar_model->get_seminare_beworben($email),
	
				);
			}

			
			
			$this->load->view('templates/header');
			$this->load->view('pages/zuweisen_anzeigen', $data);
			$this->load->view('templates/footer');

		}
		//Trägt Studenten in Seminarzuweisung-Tabelle ein
		public function zuweisen(){
			$email=$this->input->post('E-Mail');
			$id=$this->input->post('SeminarID');

			if($this->student_model->zuweisen($email,$id)){
				
				$this->session->set_flashdata('zugewiesen', 'Zuweisung erfolgreich!');
				
				$data['seminar']= $this->seminar_model->get_seminare();
				$data['fristen']=$this->Fristen_model->get_fristen();
				$data['ba_ohne']=$this->student_model->get_ba_ohne();
				$data['ma_ohne']=$this->student_model->get_ma_ohne();

				$this->load->view('templates/header');
				$this->load->view('pages/startseite_dekan', $data);
				$this->load->view('templates/footer');

			}else{

				$this->session->set_flashdata('zugewiesen_nicht', 'Konnte nicht zuweisen, bitte Admin kontaktieren!');
			}



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
		//Zeigt Fristen an, enthält Funktionalität zum ändern der Fristen
		public function fristen_anzeigen(){

			$data['fristen']= $this->Fristen_model->get_fristen();	

			$this->load->view('templates/header');
			$this->load->view('pages/fristen', $data);
			$this->load->view('templates/footer');
		}
		//Ändert Fristen und überprüft Änderungen
		public function fristen_edit(){

			$this->form_validation->set_rules('Von1', 'Anmeldephase', 'required');
			$this->form_validation->set_rules('Bis1', 'Anmeldephase', 'required|callback_check_bigger['.$this->input->post('Von1').']');
			$this->form_validation->set_rules('Von2', '1. Auswahlphase', 'required|callback_check_bigger['.$this->input->post('Bis1').']');
			$this->form_validation->set_rules('Bis2', '1. Auswahlphase', 'required|callback_check_bigger['.$this->input->post('Von2').']');            
			$this->form_validation->set_rules('Von3', '1. Annahme-/Rücktrittsphase', 'required|callback_check_bigger['.$this->input->post('Bis2').']');
			$this->form_validation->set_rules('Bis3', '1. Annahme-/Rücktrittsphase', 'required|callback_check_bigger['.$this->input->post('Von3').']');
			$this->form_validation->set_rules('Von4', '2. Auswahlphase', 'required|callback_check_bigger['.$this->input->post('Bis3').']');
			$this->form_validation->set_rules('Bis4', '2. Auswahlphase', 'required|callback_check_bigger['.$this->input->post('Von4').']');
			$this->form_validation->set_rules('Von5', '2. Annahme-/Rücktrittsphase', 'required|callback_check_bigger['.$this->input->post('Bis4').']');
			$this->form_validation->set_rules('Bis5', '2. Annahme-/Rücktrittsphase', 'required|callback_check_bigger['.$this->input->post('Von5').']');
			$this->form_validation->set_rules('Von6', 'Zuteilungsphase', 'required|callback_check_bigger['.$this->input->post('Bis5').']');
            $this->form_validation->set_rules('Bis6', 'Zuteilungsphase', 'required|callback_check_bigger['.$this->input->post('Von6').']');

			if($this->form_validation->run() === FALSE){

				$data1['fristen']= $this->Fristen_model->get_fristen();	
                $this->load->view('templates/header');
                $this->load->view('pages/fristen', $data1);
                $this->load->view('templates/footer');


            }else{

				$data= array (
					'von1'=>$this->input->post('Von1'),
					'bis1'=>$this->input->post('Bis1'),
					'von2'=>$this->input->post('Von2'),
					'bis2'=>$this->input->post('Bis2'),
					'von3'=>$this->input->post('Von3'),
					'bis3'=>$this->input->post('Bis3'),
					'von4'=>$this->input->post('Von4'),
					'bis4'=>$this->input->post('Bis4'),
					'von5'=>$this->input->post('Von5'),
					'bis5'=>$this->input->post('Bis5'),
					'von6'=>$this->input->post('Von6'),
					'bis6'=>$this->input->post('Bis6'),
				);
			
			if($this->Fristen_model->fristen_edit($data)){

				$this->session->set_flashdata('fristen_success', 'Fristen erfolgreich aktualisiert!');

				$data1['fristen']= $this->Fristen_model->get_fristen();	

				$this->load->view('templates/header');
				$this->load->view('pages/fristen', $data1);
				$this->load->view('templates/footer');

			}else{
			
				$this->session->set_flashdata('fristen_fail', 'Fristen konnten nicht aktualisiert werden!');

				$data1['fristen']= $this->Fristen_model->get_fristen();	

				$this->load->view('templates/header');
				$this->load->view('pages/fristen', $data1);
				$this->load->view('templates/footer');

			}

			

		}

		}
		//Callback Funktion, überprüft ob vorige Frist kleiner ist, siehe Formvalidation
		public function check_bigger($datejetzt, $datevor){
			if ($datejetzt < $datevor){
				$this->form_validation->set_message('check_bigger', 'Zeiträume müssen chronologisch korrekt geordnet sein!');
				return false;       
      		}else{

				return true;
			  }
      			
		}

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
            $this->load->view('users/search_log', $data);
			$this->load->view('templates/footer');

		}

		public function reset_index(){
			$fristname = 'Zuteilungsphase';
            $von = $this->Fristen_model->get_frist_start($fristname);
            $frist_start = $von['0'];
            $startdatum = $frist_start['Von'];
            $bis = $this->Fristen_model->get_frist_ende($fristname);
            $frist_ende = $bis['0'];
            $enddatum = $frist_ende['Bis'];
            $heute = date("Y-m-d");
            if (!($heute>$enddatum) ) {
                $this->load->view('templates/header');
                $this->load->view('pages/ausserhalb_frist');
                $this->load->view('templates/footer');
            }
            else {
			$this->load->view('templates/header');
			$this->load->view('dekan/reset_index');
			$this->load->view('templates/footer');
			}
		}

		public function reset_warning(){
			$fristname = 'Zuteilungsphase';
            $von = $this->Fristen_model->get_frist_start($fristname);
            $frist_start = $von['0'];
            $startdatum = $frist_start['Von'];
            $bis = $this->Fristen_model->get_frist_ende($fristname);
            $frist_ende = $bis['0'];
            $enddatum = $frist_ende['Bis'];
            $heute = date("Y-m-d");
            if (!($heute>$enddatum) ) {
                $this->load->view('templates/header');
                $this->load->view('pages/ausserhalb_frist');
                $this->load->view('templates/footer');
            }
            else {
			$this->load->view('templates/header');
			$this->load->view('dekan/reset_warning');
			$this->load->view('templates/footer');
			}
		}

		public function reset(){
			$fristname = 'Zuteilungsphase';
            $von = $this->Fristen_model->get_frist_start($fristname);
            $frist_start = $von['0'];
            $startdatum = $frist_start['Von'];
            $bis = $this->Fristen_model->get_frist_ende($fristname);
            $frist_ende = $bis['0'];
            $enddatum = $frist_ende['Bis'];
            $heute = date("Y-m-d");
            if (!($heute>$enddatum) ) {
                $this->load->view('templates/header');
                $this->load->view('pages/ausserhalb_frist');
                $this->load->view('templates/footer');
            }
            else {
			//Identifikation des aktuellen Semesters
			$fristname = '1. Auswahlphase';
			$von = $this->Fristen_model->get_frist_start($fristname);
			$frist_start = $von['0'];
			$startdatum = $frist_start['Von'];
			$cur_semester=$this->seminar_model->getCurSemester($startdatum);
			$semester=$cur_semester->bezeichnung;	
			
			//reset Prozess
			$erfolgreich=TRUE;
			
			if($cur_semester->reset=='2' && !($startdatum=='000-00-00')){
				if(!($this->seminar_model->save_seminare($semester))){
					$erfolgreich=FALSE;
				}
				$count_ba=$this->seminar_model->count_ba_ohne_zusagen();
				$count_ma=$this->seminar_model->count_ma_ohne_zusagen();
				if(is_null($count_ba)){
					$count_ba=0;
				}
				if(is_null($count_ma)){
					$count_ba=0;
				}

				$data1=array(
					'semester'=>$semester,
					'ba/ma'=>'BA',
					'kein_seminar'=>$count_ba
				);
				if(!($this->seminar_model->save_studenten_statistik($data1))){
					$erfolgreich=FALSE;
				}

				$data2=array(
					'semester'=>$semester,
					'ba/ma'=>'MA',
					'kein_seminar'=>$count_ma
				);
				if(!($this->seminar_model->save_studenten_statistik($data2))){
					$erfolgreich=FALSE;
				}

				if($erfolgreich){
					if(!($this->student_model->delete_students()) || !($this->student_model->delete_users_students())){
						$erfolgreich=FALSE;
					}
					if(!($this->seminar_model->delete_seminare($semester))){
						$erfolgreich=FALSE;
					}
					if(!($this->Fristen_model->delete_fristen())){
						$erfolgreich=FALSE;
					}
				}else{
					$this->session->set_flashdata('save_failed', 'Speicherung der Statistik fehlgeschlagen! Daten wurden nicht gelöscht. Bitte kontaktieren Sie den Administrator');
					
				}
				
				if($erfolgreich){
					$this->seminar_model->update_reset($semester);
					$this->session->set_flashdata('reset_success', 'Das System wurde erfolgreich zurückgesetzt!');
					redirect('dekan/startseite_dekan');
				}

				else{
					$this->session->set_flashdata('reset_failed', 'Bei dem Löschen der Daten trat ein Fehler auf! Bitte kontaktieren Sie den Administrator.');
					redirect('dekan/startseite_dekan');
				}
			}
			else{
				$this->session->set_flashdata('reset_done', 'Das System wurde bereits zurückgesetzt!');
				redirect('dekan/startseite_dekan');
			}

		}
		}
	}










    