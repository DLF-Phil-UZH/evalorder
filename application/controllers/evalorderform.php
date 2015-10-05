<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Evalorderform extends CI_Controller {

	public function __construct() {
		parent::__construct();
		log_message('debug', 'evalorderform_00');
		$this->load->library('shibboleth_authentication_service', NULL, 'shib_auth');
		log_message('debug', 'evalorderform_01');
	}

	function index(){
		$user = $this->shib_auth->verify_user();
		$admin = false;
		if ($_SERVER['HTTP_UNIQUEID']=="709336@vho-switchaai.ch" | $_SERVER['HTTP_UNIQUEID']=="252867@vho-switchaai.ch" | $_SERVER['HTTP_UNIQUEID']=="6D3130333234353501@uzh.ch"){
			$admin = true;
		}
		log_message('debug', 'evalorderform_A');
		// Send user to authentification if he has not logged in so far
		if($user == false){
			log_message('debug', 'evalorderform->REDIRECT->auth');
			redirect('auth');
		}
		log_message('debug', 'evalorderform_B');
		$this->load->helper(array('form', 'extended_form'));
		log_message('debug', 'evalorderform_C');
		$this->load->library('form_validation');
		// $this->load->library('upload');
		log_message('debug', 'evalorderform_D');
		// Javascript for form
		$jQuery = array('type' => 'text/javascript',
						'src' => 'https://code.jquery.com/jquery.min.js');
		$umfrageartScript = array('type' => 'text/javascript',
								  'src' => base_url('/assets/js/orderform.js'));
		log_message('debug', 'evalorderform_E');
		$this->load->view('header', array('title' => 'Oliv',
										  'page' => 'Willkommen',
										  'width' => 'small',
										  'admin' => $admin,
										  'logged_in' => $this->shib_auth->verify_shibboleth_session(),
										  'access' => ($user !== false),
										  'scripts' => array($jQuery, $umfrageartScript)));
		log_message('debug', 'evalorderform_F');
		// Customize error messages of default rules
		$this->form_validation->set_message('required', 'Das Feld "%s" darf nicht leer sein.');
		$this->form_validation->set_message('valid_email', 'Das Feld "%s" muss eine g&uuml;ltige E-Mail-Adresse enthalten.');
		$this->form_validation->set_message('is_natural_no_zero', 'Das Feld "%s" darf nur nat&uuml;rliche Zahlen enthalten, die gr&ouml;sser als 0 sind.');
		log_message('debug', 'evalorderform_G');
		// --- Validation of user inputs ---
		
		// Lehrveranstaltung
		$this->form_validation->set_rules('lehrveranstaltung', 'Name der Lehrveranstaltung', 'trim|required');
		$this->form_validation->set_rules('typ_lehrveranstaltung', 'Typ der Lehrveranstaltung', 'trim|required|callback_checkLVTyp');
		
		// Dozenten
		$this->form_validation->set_rules('anzahlDozenten', 'Anzahl Dozenten', 'trim|callback_checkAnzahlDozenten');
		$anzahlDozenten = $this->input->post('anzahlDozenten');
		
		// Iterate through every submitted lecturer
		for($dozent = 1; $dozent <= $anzahlDozenten; $dozent++){
			$this->form_validation->set_rules('nachname_dozent_' . $dozent, 'Nachname Dozent ' . $dozent, 'trim|required');
			$this->form_validation->set_rules('vorname_dozent_' . $dozent, 'Vorname Dozent ' . $dozent, 'trim|required');
			$this->form_validation->set_rules('geschlecht_dozent_' . $dozent, 'Geschlecht Dozent ' . $dozent, 'trim|required|callback_checkGeschlecht[' . $dozent . ']');
			$this->form_validation->set_rules('titel_dozent_' . $dozent, 'Titel Dozent ' . $dozent, 'trim|');
			$this->form_validation->set_rules('email_dozent_' . $dozent, 'E-Mail-Adresse Dozent ' . $dozent, 'trim|required|valid_email');
		}
		
		/*
		echo "POST<br/><br/>";
		print_r($this->input->post());
		echo "<br/><br/>POST ENDE";
		*/
		
		// Umfrage
		// Datei validieren ODER
		// Teilnehmeranzahl validieren
		
		$this->form_validation->set_rules('umfrageart', 'Umfrageart', 'trim|required|callback_checkUmfrageart');
		
		$this->form_validation->set_rules('teilnehmeranzahl', 'Teilnehmeranzahl', 'trim');
		
		$validationResult = $this->form_validation->run($this);
		
		// Text/option inputs are not valid
		if($validationResult == FALSE){
			$this->load->view('orderform', array('access' => ($user !== false)));
		}
		
		// Text/option inputs are valid and paper survey was selected -> no upload needed
		elseif($validationResult == TRUE && strcmp($this->input->post('umfrageart'), 'papierumfrage') == 0){
			
			echo "POST<br/><br/>";
			print_r($this->input->post());
			echo "<br/><br/>POST ENDE";
			
			// $lecturers = $this->_prepareLecturers($anzahlDozenten);
			
			// $this->load->model('Course_model');
			// $order = new Course_model(
				// $this->input->post('lehrveranstaltung'),
				// $this->input->post('typ_lehrveranstaltung'),
				// $lecturers,
				// $this->input->post('umfrageart'),
				// $_SERVER['HTTP_GIVENNAME'],
				// $_SERVER['HTTP_SURNAME'],
				// $_SERVER['HTTP_MAIL'],
				// $_SERVER['HTTP_UNIQUEID']
			// );
			
			$course = $this->_prepareCourse($anzahlDozenten);
			$course->setTurnout($this->input->post('teilnehmeranzahl'));
			// Write to database
			$this->load->model('Course_mapper');
			$this->Course_mapper->storeOrder($course);
			
			$this->load->view('ordersuccess');
		}
		
		// Text/option inputs are valid and online survey was selected -> check upload of participant list now
		else{
			/*
			echo "POST<br/><br/>";
			print_r($this->input->post());
			echo "<br/><br/>POST ENDE";
			*/
			log_message('debug', 'evalorderform_0.6');
			// Upload configuration
			$config['upload_path'] = './uploads/'; // In root folder of application
			$config['allowed_types'] = 'xls'; // Only Excel 97-2003 files
			$config['max_size'] = '500'; // KB
			
			// Rename uploaded file
			$filename = preg_replace('/\s+/', '_', htmlspecialchars_decode($this->input->post('lehrveranstaltung'))); // Decode HTML entities and replace spaces with underscores
			$filename = substr($filename, 0, 20); // Reduce to first 20 characters
			$filename = preg_replace("/[^a-z0-9]+/i", "", $filename); // Remove non-alphanumerical characters
			$filename = $filename . '_' . $_SERVER['HTTP_SURNAME'] . '_'; // Add orderers surname
			$filename = $filename . date('Y-m-d_H-i', time()); // Add timestamp
			log_message('debug', 'evalorderform_0.7');
			$config['file_name'] = $filename;
			log_message('debug', 'evalorderform_0.8');
			$this->load->library('upload', $config);
			log_message('debug', 'evalorderform_0.9');
			$this->load->helper('excel');
			
			log_message('debug', 'evalorderform_1');
			
			// Upload of participant list not successful
			if(!$this->upload->do_upload('teilnehmerdatei')){
				
				log_message('debug', 'evalorderform_2');
				
				echo "UPLOADDATA<br/><br/>";
				print_r($this->upload->data());
				echo "<br/><br/>UPLOADDATA";
				
				log_message('debug', 'evalorderform_3');
				
				$uploadError = array('error' => $this->upload->display_errors());
				log_message('debug', 'evalorderform_4');
				//$this->load->view('upload_form', $error);
				$this->load->view('orderform', array('access' => ($user !== false),
													 'uploadError' => $uploadError));
				log_message('debug', 'evalorderform_5');
			}
			
			// Upload successful
			else{
				log_message('debug', 'evalorderform_7');
				// TODO: Load success view, process input data/file
				
				// $data = array('upload_data' => $this->upload->data());
				// $this->load->view('upload_success', $data);
				
				echo "UPLOADDATA<br/><br/>";
				print_r($this->upload->data());
				echo "<br/><br/>UPLOADDATA";
				
				log_message('debug', 'evalorderform_8');
				
				$uploadData = $this->upload->data();
				
				log_message('debug', 'evalorderform_9');
				
				$participantFileValidation = checkParticipantFile($uploadData['full_path']);
				
				log_message('debug', 'evalorderform_10');
				
				if($participantFileValidation[0] === FALSE){
					log_message('debug', 'evalorderform_11');
					$fileError = array('fileError' => $participantFileValidation[1]);
					//$this->load->view('upload_form', $error);
					$this->load->view('orderform', array('access' => ($user !== false),
														 'uploadError' => $fileError));
				}
				else if($participantFileValidation[0] === TRUE){
					log_message('debug', 'evalorderform_12');
					$emailColumn = $participantFileValidation[1];
					
					$participantAddresses = extractParticipantAddresses($uploadData['full_path'], $emailColumn);
				
					echo "participantAddresses<br/><br/>";
					print_r($participantAddresses);
					echo "<br/><br/>participantAddresses";
					
					// $lecturers = $this->_prepareLecturers($anzahlDozenten);
			
					// $this->load->model('Course_model');
					// $order = new Course_model(
						// $this->input->post('lehrveranstaltung'),
						// $this->input->post('typ_lehrveranstaltung'),
						// $lecturers,
						// $this->input->post('umfrageart'),
						// $_SERVER['HTTP_GIVENNAME'],
						// $_SERVER['HTTP_SURNAME'],
						// $_SERVER['HTTP_MAIL'],
						// $_SERVER['HTTP_UNIQUEID']
					// );
					
					$course = $this->_prepareCourse($anzahlDozenten);
					$course->setParticipants($participantAddresses);
					// Write to database
					$this->load->model('Course_mapper');
					$this->Course_mapper->storeOrder($course);
					
					// TODO: Temporary until correct data processing is implemented
					$this->load->view('ordersuccess');
				}
				
				log_message('debug', 'evalorderform_13');
				
			}
			
		}
		
		$this->load->view('footer');
	}
	
	// Callback for checking field of course type (Lehrveranstaltungstyp)
	public function checkLVTyp($pValue){
		log_message('debug', 'callback_checkLVTyp: pValue = ' . $pValue);
		if(strcmp($pValue, "vorlesung") == 0 ||
		   strcmp($pValue, "uebung") == 0 ||
		   strcmp($pValue, "seminar") == 0 ||
		   strcmp($pValue, "kolloquium") == 0){
			return TRUE;
		}
		else{
			$this->form_validation->set_message('checkLVTyp', 'Der Lehrveranstaltungstyp ist ung&uuml;ltig');
			return FALSE;
		}
	}
	
	/*
	Unused.
	
	// Callback to encode HTML characters into entities
	public function encodeSpecialChars($pValue){
		log_message('debug', 'callback_encodeSpecialChars: pValue = ' . $pValue . ' encodeVal = ' . htmlspecialchars($pValue, ENT_QUOTES));
		//echo "rawVAlue: " . $pValue . "--<br/>";
		//echo "enocdeSC: " . htmlspecialchars($pValue, ENT_QUOTES) . "--<br/>";
		return htmlspecialchars($pValue, ENT_QUOTES);
	}
	*/
	
	// Callback for gender of lecturer (Geschlecht Dozent)
	public function checkGeschlecht($pValue, $pDozent){
		log_message('debug', 'callback_checkGeschlecht: pValue = ' . $pValue . ' pDozent = ' . $pDozent);
		// echo "CHECKGESCHLECHT: pValue = " . $pValue . " pDozent = " . $pDozent;
		if(strcmp($pValue, "maennlich") == 0 ||
		   strcmp($pValue, "weiblich") == 0){
			return TRUE;
		}
		else{
			$this->form_validation->set_message('checkGeschlecht', 'Das Geschlecht des Dozenten' . $pDozent . ' muss angegeben werden.');
			return FALSE;
		}
	}
	
	// Callback for checking hidden input "anzahlDozenten" that ensures correct lecturer (Dozent) processing
	public function checkAnzahlDozenten($pValue){
		log_message('debug', 'callback_checkAnzahlDozenten: pValue = ' . $pValue);
		// Shows error message if "anzahlDozenten" is not set, not numeric or less than 1, else returns true
		if($this->input->post('anzahlDozenten') == FALSE){
			log_message('error', 'Hidden input "anzahlDozenten" is not set. Redirected to welcome.php.');
			show_error('Kritischer Fehler in der Verarbeitung Ihrer Eingaben. Bitte versuchen Sie es nochmals.');
		}
		$anzahlDozenten = $this->input->post('anzahlDozenten');
		if(is_numeric($anzahlDozenten) == FALSE){
			log_message('error', 'Hidden input "anzahlDozenten" is not numeric. Redirected to welcome.php.');
			show_error('Kritischer Fehler in der Verarbeitung Ihrer Eingaben. Bitte versuchen Sie es nochmals.');
		}
		$anzahlDozenten = intval($anzahlDozenten);
		if($anzahlDozenten < 1){
			log_message('error', 'Hidden input "anzahlDozenten" is less than 1. Redirected to welcome.php.');
			show_error('Kritischer Fehler in der Verarbeitung Ihrer Eingaben. Bitte versuchen Sie es nochmals.');
		}
		return TRUE;
	}
	
	// Callback for checking survey type (Umfrageart) with its corresponding additional information (number of participants (Teilnehmeranzahl) or Excel table with recipient e-mail addresses)
	public function checkUmfrageart($pValue){
		log_message('debug', 'callback_checkUmfrageart: pValue = ' . $pValue);
		// Check submitted file if online survey is selected
		if(strcmp($pValue, "onlineumfrage") == 0){
			log_message('debug', 'callback_checkUmfrageart: onlineumfrage gewaehlt, datei pruefen.');
			// if(dateiprüfung erfolgreich){
				// - spaltenüberschrift "E-Mail"
				// - spalte mit (gültigen) e-mail-adressen
			
				// return TRUE;
			// }
			// else{
				// $this->form_validation->set_message('checkUmfrageart', 'Die hochgeladene Teilnehmerdatei erfüllt die Anforderugen nicht.');
				// return FALSE;
			// }
			// Temporary till file check is implemented
			return TRUE;
		}
		// Check if "teilnehmeranzahl" is set and if it is numeric and greater or equal 10
		else if(strcmp($pValue, "papierumfrage") == 0){
			if(($teilnehmeranzahl = $this->input->post('teilnehmeranzahl')) !== FALSE){
				if(is_numeric($teilnehmeranzahl) == TRUE){
					if(intval($teilnehmeranzahl) >= 10){
						return TRUE;
					}
					else{
						$this->form_validation->set_message('checkUmfrageart', 'Die Anzahl Teilnehmer f&uuml;r eine Papierumfrage muss mindestens 10 betragen, um eine Evaluation durchf&uuml;hren zu k&ouml;nnen.');
						return FALSE;
					}
				}
				else{
					$this->form_validation->set_message('checkUmfrageart', 'Das Feld "Anzahl Teilnehmer" darf nur nat&uuml;rliche Zahlen enthalten.');
					return FALSE;
				}
			}
			else{
				$this->form_validation->set_message('checkUmfrageart', 'Die Anzahl Teilnehmer muss f&uuml;r eine Papierumfrage angegeben werden.');
				return FALSE;
			}
		}
		else{
			$this->form_validation->set_message('checkUmfrageart', 'Die Umfrageart muss angegeben werden.');
			return FALSE;
		}
	}
	
	private function _prepareLecturers($numberOfLecturers){
		
		$allLecturers = array();
		$lecturer = array();
		
		for($currentLecturer = 1; $currentLecturer <= $numberOfLecturers; $currentLecturer++){
			// Check if information is complete (returns FALSE for every non set post variable, like isset() on custom variables)
			if(!($this->input->post('nachname_dozent_' . $currentLecturer) &&
				 $this->input->post('vorname_dozent_' . $currentLecturer) &&
				 $this->input->post('geschlecht_dozent_' . $currentLecturer) &&
				 $this->input->post('email_dozent_' . $currentLecturer))){
				log_message('error', 'Evalorderform->_prepareLecturers(): Lecturer ' . $currentLecturer . ' invalid.');
				show_error('Kritischer Fehler in der Verarbeitung Ihrer Eingaben [ung&uuml;ltige(r) Dozent(in) ' . $currentLecturer . ']. Bitte versuchen Sie es nochmals.');
			}
			
			$lecturer['surname'] = $this->input->post('nachname_dozent_' . $currentLecturer);
			$lecturer['firstname'] = $this->input->post('vorname_dozent_' . $currentLecturer);
			// Gender
			if(strcmp($this->input->post('geschlecht_dozent_' . $currentLecturer), 'maennlich') === 0){
				$lecturer['gender'] = 'm';
			}
			elseif(strcmp($this->input->post('geschlecht_dozent_' . $currentLecturer), 'weiblich') === 0){
				$lecturer['gender'] = 'f';
			}
			// Title (if set)
			if($this->input->post('titel_dozent_' . $currentLecturer) && (strlen($this->input->post('titel_dozent_' . $currentLecturer)) > 0)){
				$lecturer['title'] = $this->input->post('titel_dozent_' . $currentLecturer);
			}
			else{
				$lecturer['title'] = NULL;
			}
			$lecturer['email'] = $this->input->post('email_dozent_' . $currentLecturer);
			array_push($allLecturers, $lecturer);
		}
		
		return $allLecturers;
		
	}
	
	private function _prepareCourse($numberOfLecturers){
		
		$lecturers = $this->_prepareLecturers($numberOfLecturers);

		$this->load->model('Course_model');
		$this->config->load('standardwerte_config');
		$course = new Course_model();
		$course->initialSet(
			$this->input->post('lehrveranstaltung'),
			$this->input->post('typ_lehrveranstaltung'),
			$lecturers,
			$this->input->post('umfrageart'),
			$this->config->item('survey_period'),
			$_SERVER['HTTP_GIVENNAME'],
			$_SERVER['HTTP_SURNAME'],
			$_SERVER['HTTP_MAIL'],
			$_SERVER['HTTP_UNIQUEID']
		);
		
		return $course;
		
	}

}

/* End of file evalorderform.php */
/* Location: ./application/controllers/evalorderform.php */
