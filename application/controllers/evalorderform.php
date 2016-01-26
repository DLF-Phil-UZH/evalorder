<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Evalorderform extends CI_Controller {

	public function __construct() {
		parent::__construct();
		log_message('debug', 'evalorderform_00');
		$this->load->library('shibboleth_authentication_service', NULL, 'shib_auth');
		log_message('debug', 'evalorderform_01');
		$this->load->helper(array('form', 'extended_form', 'excel'));
		$this->load->library('form_validation');
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
		$jQueryValidate = array('type' => 'text/javascript',
								'src' => 'https://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.js');
		$jQueryValidateMessages = array('type' => 'text/javascript',
							 'src' => base_url('/assets/js/messages_de.js'));
		$jQuerySteps = array('type' => 'text/javascript',
							 'src' => base_url('/assets/js/jquery.steps.js'));
		$jQueryFancybox = array('type' => 'text/javascript',
						  'src' => base_url('/assets/js/jquery.fancybox.js'));
		$jQueryFancyboxThumbs = array('type' => 'text/javascript',
									  'src' => base_url('/assets/js/jquery.fancybox-thumbs.js'));  
		$orderformLibrary = array('type' => 'text/javascript',
								  'src' => base_url('/assets/js/orderform_library.js'));
		$orderform = array('type' => 'text/javascript',
						   'src' => base_url('/assets/js/orderform.js'));
		log_message('debug', 'evalorderform_E');
		$this->load->view('header', array('title' => 'Eva',
										  'page' => 'Bestellen',
										  'width' => 'small',
										  'admin' => $admin,
										  'logged_in' => $this->shib_auth->verify_shibboleth_session(),
										  'access' => ($user !== false),
										  'scripts' => array($jQuery, $jQueryValidate, $jQueryValidateMessages, $jQuerySteps, $jQueryFancybox, $jQueryFancyboxThumbs, $orderformLibrary, $orderform)));
		log_message('debug', 'evalorderform_F');
		// Customize error messages of default rules
		$this->form_validation->set_message('required', 'Das Feld "%s" darf nicht leer sein.');
		$this->form_validation->set_message('valid_email', 'Das Feld "%s" muss eine g&uuml;ltige E-Mail-Adresse enthalten.');
		$this->form_validation->set_message('is_natural_no_zero', 'Das Feld "%s" darf nur nat&uuml;rliche Zahlen enthalten, die gr&ouml;sser als 0 sind.');
		log_message('debug', 'evalorderform_G');
		// --- Validation of user inputs ---
		
		// Lehrveranstaltung
		$this->form_validation->set_rules('lehrveranstaltung', 'Name der Lehrveranstaltung', 'trim|required');
		//$this->form_validation->set_rules('typ_lehrveranstaltung', 'Typ der Lehrveranstaltung', 'trim|required|callback_checkLVTyp');
		
		// Dozenten
		$this->form_validation->set_rules('anzahlDozenten', 'Anzahl Dozenten', 'trim|callback_checkAnzahlDozenten');
		$anzahlDozenten = $this->input->post('anzahlDozenten');
		
		// Iterate through every submitted lecturer
		for($dozent = 1; $dozent <= $anzahlDozenten; $dozent++){
			$this->form_validation->set_rules('nachname_dozent_' . $dozent, 'Nachname Dozent ' . $dozent, 'trim|required');
			$this->form_validation->set_rules('vorname_dozent_' . $dozent, 'Vorname Dozent ' . $dozent, 'trim|required');
			$this->form_validation->set_rules('geschlecht_dozent_' . $dozent, 'Geschlecht Dozent ' . $dozent, 'trim|required|callback_checkGeschlecht[' . $dozent . ']');
			$this->form_validation->set_rules('titel_dozent_' . $dozent, 'Titel Dozent ' . $dozent, 'trim');
			$this->form_validation->set_rules('email_dozent_' . $dozent, 'E-Mail-Adresse Dozent ' . $dozent, 'trim|required');
		}
		
		/*
		echo "POST<br/><br/>";
		print_r($this->input->post());
		echo "<br/><br/>POST ENDE";
		*/
		
		// Umfrage
		// Datei validieren ODER
		// Teilnehmeranzahl validieren
		
		$this->form_validation->set_rules('lvtyp', 'Typ der Lehrveranstaltung', 'trim|required|callback_checkLVTyp');
		
		$this->form_validation->set_rules('umfrageart', 'Umfrageart', 'trim|required|callback_checkUmfrageart');
		
		// Language only needed for paper survey
		if($this->input->post('umfrageart') === 'papierumfrage'){
			$this->form_validation->set_rules('sprache', 'Sprache', 'trim|required|callback_checkSprache');
		}
		
		$this->form_validation->set_rules('teilnehmeranzahl', 'Teilnehmeranzahl', 'trim|is_natural_no_zero');
		
		$validationResult = $this->form_validation->run($this);
		
		// Text/option inputs are not valid
		if($validationResult == FALSE){
			$this->load->view('orderform', array('access' => ($user !== false)));
		}
		
		// Text/option inputs are valid and paper survey was selected -> no upload needed
		elseif($validationResult == TRUE && strcmp($this->input->post('umfrageart'), 'papierumfrage') == 0){
			
			// echo "POST<br/><br/>";
			// print_r($this->input->post());
			// echo "<br/><br/>POST ENDE";
			
			// $lecturers = $this->_prepareLecturers($anzahlDozenten);
			
			// $this->load->model('Course_model');
			// $order = new Course_model(
				// $this->input->post('lehrveranstaltung'),
				// $this->input->post('lvtyp'),
				// $lecturers,
				// $this->input->post('umfrageart'),
				// $_SERVER['HTTP_GIVENNAME'],
				// $_SERVER['HTTP_SURNAME'],
				// $_SERVER['HTTP_MAIL'],
				// $_SERVER['HTTP_UNIQUEID']
			// );
			
			$course = $this->_prepareCourse($anzahlDozenten);
			$course->setTurnout(intval($this->input->post('teilnehmeranzahl')));
			$course->setLanguage($this->input->post('sprache'));
			// Write to database
			$this->load->model('Course_mapper');
			$this->Course_mapper->storeOrder($course);
			
			$this->load->view('ordersuccess', array('access' => ($user !== false),
													'nolists' => FALSE));
		}
		
		// Text/option inputs are valid and online survey was selected -> check upload of participant list now
		else{
			/*
			echo "POST<br/><br/>";
			print_r($this->input->post());
			echo "<br/><br/>POST ENDE";
			*/
			// log_message('debug', 'evalorderform_0.6');
			// // Upload configuration
			// $config['upload_path'] = './uploads/'; // In root folder of application
			// $config['allowed_types'] = 'xls'; // Only Excel 97-2003 files
			// $config['max_size'] = '500'; // KB
			
			// // Rename uploaded file
			// $filename = preg_replace('/\s+/', '_', htmlspecialchars_decode($this->input->post('lehrveranstaltung'))); // Decode HTML entities and replace spaces with underscores
			// $filename = substr($filename, 0, 20); // Reduce to first 20 characters
			// $filename = preg_replace("/[^a-z0-9]+/i", "", $filename); // Remove non-alphanumerical characters
			// $filename = $filename . '_' . $_SERVER['HTTP_SURNAME'] . '_'; // Add orderers surname
			// $filename = $filename . date('Y-m-d_H-i', time()); // Add timestamp
			// log_message('debug', 'evalorderform_0.7');
			// $config['file_name'] = $filename;
			// log_message('debug', 'evalorderform_0.8');
			// $this->load->library('upload', $config);
			// log_message('debug', 'evalorderform_0.9');
			$this->load->helper('excel');
			
			log_message('debug', 'evalorderform_1');
			
			// // Upload of participant list not successful
			// if(!$this->upload->do_upload('teilnehmerdatei')){
				
				// log_message('debug', 'evalorderform_2');
				
				// echo "UPLOADDATA<br/><br/>";
				// print_r($this->upload->data());
				// echo "<br/><br/>UPLOADDATA";
				
				// log_message('debug', 'evalorderform_3');
				
				// $uploadError = array('error' => $this->upload->display_errors());
				// log_message('debug', 'evalorderform_4');
				// //$this->load->view('upload_form', $error);
				// $this->load->view('orderform', array('access' => ($user !== false),
													 // 'uploadError' => $uploadError));
				// log_message('debug', 'evalorderform_5');
			// }
			
			// // Upload successful
			// else{
				// log_message('debug', 'evalorderform_7');
				// // TODO: Load success view, process input data/file
				
				// // $data = array('upload_data' => $this->upload->data());
				// // $this->load->view('upload_success', $data);
				
				// echo "UPLOADDATA<br/><br/>";
				// print_r($this->upload->data());
				// echo "<br/><br/>UPLOADDATA";
				
			// echo "POST<br/><br/>";
			// print_r($this->input->post());
			// echo "<br/><br/>POST";
			
			// log_message('debug', 'evalorderform_8');
			
			// $uploadData = $this->upload->data();
			
			// log_message('debug', 'evalorderform_9');
			
			// Create course object
			$course = $this->_prepareCourse($anzahlDozenten);
			$turnout = 0;
			
			if($this->input->post('filecheck1') != FALSE){ // If set AND string is not empty
				
				$fullPath1 = $this->config->item('xls_folder') . $this->input->post('filecheck1');
				$participantFileValidation1 = checkParticipantFile($fullPath1);
				// $participantFileValidation1 = checkParticipantFile($uploadData['full_path']);
				log_message('debug', 'evalorderform_10');
			
				if($participantFileValidation1[0] === FALSE){
					
					log_message('debug', 'evalorderform_10.5');
					$fileError = array('fileError' => $participantFileValidation1[1]);
					//$this->load->view('upload_form', $error);
					$this->load->view('orderform', array('access' => ($user !== false),
														 'uploadError' => $fileError));
				}
				else if($participantFileValidation1[0] === TRUE){
					
					log_message('debug', 'evalorderform_10.6.1');
					$participantFile1 = $this->input->post('filecheck1');
					$course->setParticipantFile1($participantFile1);
					
					// Count participants
					log_message('debug', 'evalorderform_10.6.2');
					$turnout += countParticipantAddresses($fullPath1, $participantFileValidation1[1]);
					log_message('debug', 'evalorderform_10.6.3---turnout = ' . $turnout);
				}
				
			}
			
			/* Unused, user is allowed to not upload a participant list
			
			// At least one list must have been uploaded
			else{
				log_message('debug', 'evalorderform_10.7');
				$fileError = array('fileError' => 'Die 1. Teilnehmerliste konnte nicht gefunden werden.');
				//$this->load->view('upload_form', $error);
				$this->load->view('orderform', array('access' => ($user !== false),
													 'uploadError' => $fileError));
			}
			
			*/
			
			if($this->input->post('filecheck2') != FALSE){ // If set AND string is not empty
				
				$fullPath2 = $this->config->item('xls_folder') . $this->input->post('filecheck2');
				$participantFileValidation2 = checkParticipantFile($fullPath2);
				// $participantFileValidation2 = checkParticipantFile($uploadData['full_path']);
				log_message('debug', 'evalorderform_11');
			
				if($participantFileValidation2[0] === FALSE){
					
					log_message('debug', 'evalorderform_11.5');
					$fileError = array('fileError' => $participantFileValidation2[1]);
					//$this->load->view('upload_form', $error);
					$this->load->view('orderform', array('access' => ($user !== false),
														 'uploadError' => $fileError));
				}
				else if($participantFileValidation2[0] === TRUE){
					
					$participantFile2 = $this->input->post('filecheck2');
					$course->setParticipantFile2($participantFile2);
					
					// Count participants
					$turnout += countParticipantAddresses($fullPath2, $participantFileValidation2[1]);
				}
				
			}
			
			// else if($participantFileValidation[0] === TRUE){
				// log_message('debug', 'evalorderform_12');
				// $emailColumn = $participantFileValidation[1];
				
				// $participantAddresses = extractParticipantAddresses($uploadData['full_path'], $emailColumn);
			
				// echo "participantAddresses<br/><br/>";
				// print_r($participantAddresses);
				// echo "<br/><br/>participantAddresses";
				
				// // $lecturers = $this->_prepareLecturers($anzahlDozenten);
		
				// // $this->load->model('Course_model');
				// // $order = new Course_model(
					// // $this->input->post('lehrveranstaltung'),
					// // $this->input->post('lvtyp'),
					// // $lecturers,
					// // $this->input->post('umfrageart'),
					// // $_SERVER['HTTP_GIVENNAME'],
					// // $_SERVER['HTTP_SURNAME'],
					// // $_SERVER['HTTP_MAIL'],
					// // $_SERVER['HTTP_UNIQUEID']
				// // );
				
				
				//$course->setParticipants($participantAddresses);
				
				log_message('debug', 'evalorderform_12');
				$course->setTurnout($turnout);
				
				log_message('debug', 'evalorderform_12.2');
				// Write to database
				$this->load->model('Course_mapper');
				$this->Course_mapper->storeOrder($course);
				
				$this->load->view('ordersuccess', array('access' => ($user !== false),
														// True if no list has been uploaded by user
														'nolists' => !($this->input->post('filecheck1') != FALSE || $this->input->post('filecheck2') != FALSE)));
			
			log_message('debug', 'evalorderform_13');
				
			// }
			
		}
		
		$this->load->view('footer');
	}
	
	// Callback for checking field of course type (Lehrveranstaltungstyp)
	public function checkLVTyp($pValue){
		log_message('debug', 'callback_checkLVTyp: pValue = ' . $pValue);
		if(strcmp($pValue, "vorlesung") == 0 ||
		   strcmp($pValue, "uebung") == 0 ||
		   strcmp($pValue, "seminar") == 0 ||
		   strcmp($pValue, "praktikum") == 0){
			return TRUE;
		}
		else{
			$this->form_validation->set_message('checkLVTyp', 'Der Lehrveranstaltungstyp ist ung&uuml;ltig');
			return FALSE;
		}
	}
	
	// Callback for checking field of language (Sprache)
	// Italian not available yet
	public function checkSprache($pValue){
		log_message('debug', 'callback_checkSprache: pValue = ' . $pValue);
		if(strcmp($pValue, "englisch") == 0 ||
		   strcmp($pValue, "deutsch") == 0 /* ||
		   strcmp($pValue, "italienisch") == 0*/){
			return TRUE;
		}
		else{
			$this->form_validation->set_message('checkSprache', 'Die Sprache ist ung&uuml;ltig');
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
	
	// Handles file uploads requested by AJAX
	public function uploadfile($pCourseId = NULL, $pFileNumber = NULL){
		
		// TODO: Update turnout value
		log_message('debug', 'uploadfile_1: type(courseid) = ' . gettype($pCourseId) . ', type(filenumber) = ' . gettype($pFileNumber));
		$storeResult = array(
			'status' => '',
			'feedback' => ''
		);
		log_message('debug', 'uploadfile_2');
		if(!empty($_FILES["list1"])){
			log_message('debug', 'uploadfile_2.1');
			$storeResult = $this->_storeParticipantList($_FILES["list1"]);
			log_message('debug', 'uploadfile_3');
			//echo "list1";
		}
		log_message('debug', 'uploadfile_4');
		if(!empty($_FILES["list2"])){
			$storeResult = $this->_storeParticipantList($_FILES["list2"]);
			log_message('debug', 'uploadfile_5');
			//echo "list2";
		}
		log_message('debug', 'uploadfile_6');
		if(!($storeResult['status'] === 'success')){
			log_message('debug', 'uploadfile_7');
			echo json_encode($storeResult);
		}
		else{
			log_message('debug', 'uploadfile_8');
			$participantFileValidation = checkParticipantFile($storeResult['path']);
			log_message('debug', 'uploadfile_9');
			if($participantFileValidation[0] === FALSE){
				// log_message('debug', 'evalorderform_11');
				// $fileError = array('fileError' => $participantFileValidation[1]);
				//$this->load->view('upload_form', $error);
				//$this->load->view('orderform', array('access' => ($user !== false),
													 // 'uploadError' => $fileError));
				log_message('debug', 'uploadfile_10');
				echo json_encode(
					array(
						'status' => 'error',
						'feedback' => $participantFileValidation[1]
					)
				);
			}
			else if($participantFileValidation[0] === TRUE){
				log_message('debug', 'uploadfile_11');
				// log_message('debug', 'evalorderform_12');
				
				// If called from backend, set filename to course in database
				if($pCourseId && $pFileNumber){
					log_message('debug', 'uploadfile_12');
					if($this->_validatesAsInteger($pCourseId) && $this->_validatesAsInteger($pFileNumber)){
						log_message('debug', 'uploadfile_13');
						$this->load->database();
						
						$this->db->trans_start();
						
						$this->db->where('id', $pCourseId);
						$this->db->update($this->config->item('table_courses'), array('participantFile' . $pFileNumber => $storeResult['filename']));
						
						$this->db->trans_complete();
						log_message('debug', 'uploadfile_14');
						if($this->db->trans_status() === FALSE){
							log_message('error', 'uploadFile(course ' . $pCourseId . ', file number ' . $pFileNumber . '): Transaction failed.');
							
							echo json_encode(
								array(
									'status' => 'error',
									'feedback' => 'Datenbankfehler'
								)
							);
						}
						else{
							log_message('info', 'uploadFile(course ' . $pCourseId . ', file number ' . $pFileNumber . '): Transaction complete.');
							
							echo json_encode(
								array(
									'status' => 'success',
									'feedback' => $storeResult['filename']
								)
							);
						}
					}
					// Invalid URI segments
					else{
						log_message('debug', 'uploadfile_15');
						echo json_encode(
							array(
								'status' => 'error',
								'feedback' => 'Ung&uuml;ltige Kurs-ID oder Listennummer'
							)
						);
					}
					
				}
				
				// If called from order form by user
				else{
					log_message('debug', 'uploadfile_16');
					echo json_encode(
						array(
							'status' => 'success',
							'feedback' => $storeResult['filename']
						)
					);
				}
				
				
				// $emailColumn = $participantFileValidation[1];
				
				// $participantAddresses = extractParticipantAddresses($storeResult['path'], $emailColumn);
			
				//echo "participantAddresses<br/><br/>";
				// print_r($participantAddresses);
				// echo "<br/><br/>participantAddresses";
				
				// $lecturers = $this->_prepareLecturers($anzahlDozenten);
		
				// $this->load->model('Course_model');
				// $order = new Course_model(
					// $this->input->post('lehrveranstaltung'),
					// $this->input->post('lvtyp'),
					// $lecturers,
					// $this->input->post('umfrageart'),
					// $_SERVER['HTTP_GIVENNAME'],
					// $_SERVER['HTTP_SURNAME'],
					// $_SERVER['HTTP_MAIL'],
					// $_SERVER['HTTP_UNIQUEID']
				// );

			}
		
		}
	}

	private function _storeParticipantList($file){
		log_message('debug', '_storeParticipantList');
		$uploadDirectory = $this->config->item('xls_folder');
		log_message('debug', '_storeParticipantList');
		if($file["error"] !== UPLOAD_ERR_OK){
			log_message('debug', '_storeParticipantList');
			return array(
				'status' => 'error',
				'feedback' => 'Fehler beim Hochladen der Datei.'
			);
		}
		
		// Only allow xls(x) files
		$originalExtension = pathinfo($file["name"], PATHINFO_EXTENSION);
		if(!($originalExtension == "xls" || $originalExtension == "xlsx")){
			log_message('debug', '_storeParticipantList: Invalid file extension: ' . $originalExtension);
			return array(
				'status' => 'error',
				'feedback' => 'Fehler beim Hochladen der Datei: Nur xls(x)-Dateien sind erlaubt.'
			);
		}

		// ensure a safe filename
		$name = preg_replace("/[^A-Z0-9._-]/i", "_", $file["name"]);
		log_message('debug', '_storeParticipantList_1');
		// don't overwrite an existing file
		$i = 0;
		log_message('debug', '_storeParticipantList2');
		$parts = pathinfo($name);
		log_message('debug', '_storeParticipantList3');
		while(file_exists($uploadDirectory . $name)){
			$i++;
			$name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
		}
		log_message('debug', '_storeParticipantList4');
		// preserve file from temporary directory
		$success = move_uploaded_file($file["tmp_name"], $uploadDirectory . $name);
		log_message('debug', '_storeParticipantList5');
		if(!$success){
			log_message('debug', '_storeParticipantList6');
			return array(
				'status' => 'error',
				'feedback' => 'Datei konnte nicht gespeichert werden.'
			);
		}
		log_message('debug', '_storeParticipantList7');
		// set proper permissions on the new file
		chmod($uploadDirectory . $name, 0644);
		// echo json_encode(
		return array(
			'status' => 'success',
			'feedback' => 'Datei erfolgreich hochgeladen.',
			'path' => $uploadDirectory . $name,
			'filename' => $name
		);
		// );
		
	}
	
	
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
					// if(intval($teilnehmeranzahl) >= 10){
						return TRUE;
					// }
					// else{
						// $this->form_validation->set_message('checkUmfrageart', 'Die Anzahl Teilnehmer f&uuml;r eine Papierumfrage muss mindestens 10 betragen, um eine Evaluation durchf&uuml;hren zu k&ouml;nnen.');
						// return FALSE;
					// }
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
			$this->input->post('lvtyp'),
			$lecturers,
			$this->input->post('umfrageart'),
			$this->config->item('survey_period'),
			// $this->input->post('sprache'),
			$_SERVER['HTTP_GIVENNAME'],
			$_SERVER['HTTP_SURNAME'],
			$_SERVER['HTTP_MAIL'],
			$_SERVER['HTTP_UNIQUEID']
		);
		
		return $course;
		
	}
	
	// Returns true if a string is a valid integer, false if not (http://stackoverflow.com/a/2012271)
	private function _validatesAsInteger($pNumber){
		$pNumber = filter_var($pNumber, FILTER_VALIDATE_INT);
		return ($pNumber !== FALSE);
	}
	
}

/* End of file evalorderform.php */
/* Location: ./application/controllers/evalorderform.php */
