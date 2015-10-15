<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Course_mapper extends CI_Model{
	
	// Database tables
	private $tableCourses = 'evalorder_courses';
	private $tableLecturers = 'evalorder_lecturers';
	private $tableParticipants = 'evalorder_participants';
	private $tableMapping = 'evalorder_courses_lecturers';
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('Course_model');
	}
	
	// Write evaluation order for course to database
	public function storeOrder(Course_model $pCourse){
		// Exit if survey type is invalid
		if(!(strcmp($pCourse->getSurveyType(), 'onlineumfrage') === 0 || strcmp($pCourse->getSurveyType(), 'papierumfrage') === 0)){
			log_message('error', 'storeOrder(): Invalid survey type.');
			show_error('Kritischer Fehler in der Verarbeitung Ihrer Eingaben [ung&uuml;ltiger Umfragetyp]. Bitte versuchen Sie es nochmals.');
		}
		
		$orderData = array(
			'name' => $pCourse->getName(),
			'type' => $pCourse->getType(),
			'surveyType' => $pCourse->getSurveyType(),
			'semester' => $pCourse->getSemester(),
			// 'language' => $pCourse->getLanguage(),
			'ordererFirstname' => $pCourse->getOrdererFirstname(),
			'ordererSurname' => $pCourse->getOrdererSurname(),
			'ordererEmail' => $pCourse->getOrdererEmail(),
			'ordererUniqueId' => $pCourse->getOrdererUniqueId()
		);
		
		// Do all database updates as transactions
		$this->db->trans_start();
		$this->db->insert($this->tableCourses, $orderData);
		$pCourse->setId($this->db->insert_id()); // Retrieve id for order generated by DBMS
		
		/*
		Unused, participant adresses will be extracted of Excel file during XML generation
		
		// Save e-mail addresses of participants and turnout if it is an online survey
		if(strcmp($pCourse->getSurveyType(), 'onlineumfrage') === 0){
			$participants = $pCourse->getParticipants();
			if(isset($participants) && is_array($participants) && (count($participants) > 0)){
				foreach($participants as $participant){
					$this->db->insert($this->tableParticipants, array(
						'email' => $participant,
						'courseId' => $pCourse->getId()
					));
				}
				$this->db->where('id', $pCourse->getId());
				$this->db->update($this->tableCourses, array('turnout' => count($participants)));
			}
			else{
				log_message('error', 'storeOrder(): Invalid participant array.');
				show_error('Kritischer Fehler in der Verarbeitung Ihrer Eingaben [ung&uuml;ltige Teilnehmer-Adressen]. Bitte versuchen Sie es nochmals.');
			}
		}
		
		// Save turnout if it is a paper survey
		elseif(strcmp($pCourse->getSurveyType(), 'papierumfrage') === 0){
			$turnout = $pCourse->getTurnout();
			if(isset($turnout) && is_int($turnout) && $turnout >= 10){
				$this->db->where('id', $pCourse->getId());
				$this->db->update($this->tableCourses, array('turnout' => $turnout));
			}
			else{
				log_message('error', 'storeOrder(): Invalid turnout.');
				show_error('Kritischer Fehler in der Verarbeitung Ihrer Eingaben [ung&uuml;ltige Teilnehmerzahl]. Bitte versuchen Sie es nochmals.');
			}
		}
		
		*/
		
		// Save turnout
		$turnout = $pCourse->getTurnout();
		//log_message('debug', 'turnout = '.$turnout.'---type = '.gettype($turnout));
		if(isset($turnout) && is_int($turnout)){
			// if(strcmp($pCourse->getSurveyType(), 'papierumfrage') === 0 && $turnout < 10){
				// log_message('error', 'storeOrder(): Invalid turnout.');
				// show_error('Kritischer Fehler in der Verarbeitung Ihrer Eingaben [zu wenig Teilnehmer f&uuml;r eine Papier-Umfrage]. Bitte versuchen Sie es nochmals.');
			// }
			$this->db->where('id', $pCourse->getId());
			$this->db->update($this->tableCourses, array('turnout' => $turnout));
		}
		else{
			log_message('error', 'storeOrder(): Invalid turnout.');
			show_error('Kritischer Fehler in der Verarbeitung Ihrer Eingaben [ung&uuml;ltige Teilnehmerzahl]. Bitte versuchen Sie es nochmals.');
		}
		
		// Save language if existent
		$language = $pCourse->getLanguage();
		if(isset($language) && is_string($language) && (strlen($language) > 0)){
			$this->db->where('id', $pCourse->getId());
			$this->db->update($this->tableCourses, array('language' => $language));
		}
		
		// Save participant file names if existent
		$participantFile1 = $pCourse->getParticipantFile1();
		if(isset($participantFile1) && is_string($participantFile1) && (strlen($participantFile1) > 0)){
			$this->db->where('id', $pCourse->getId());
			$this->db->update($this->tableCourses, array('participantFile1' => $participantFile1));
		}
		
		$participantFile2 = $pCourse->getParticipantFile2();
		if(isset($participantFile2) && is_string($participantFile2) && (strlen($participantFile2) > 0)){
			$this->db->where('id', $pCourse->getId());
			$this->db->update($this->tableCourses, array('participantFile2' => $participantFile2));
		}
		
		// Save lecturers
		$lecturers = $pCourse->getLecturers();
		if(isset($lecturers) && is_array($lecturers) && (count($lecturers) > 0)){
			foreach($lecturers as $lecturer){
				if(is_array($lecturer)){
					// Mandatory data per lecturer
					$lecturerData = array(
						'firstname' => $lecturer['firstname'],
						'surname' => $lecturer['surname'],
						'gender' => $lecturer['gender'], // 'm' or 'f'
						'email' => $lecturer['email'],
						// Id of inserted course
						'courseId' => $pCourse->getId()
					);
					// Add title if set (= entered by user)
					if(isset($lecturer['title'])){
						$lecturerData['title'] = $lecturer['title'];
					}
					$this->db->insert($this->tableLecturers, $lecturerData);
				}
				else{
					log_message('error', 'storeOrder(): Invalid lecturer in lecturer array.');
					show_error('Kritischer Fehler in der Verarbeitung Ihrer Eingaben [ung&uuml;ltige(r) Dozent(in)]. Bitte versuchen Sie es nochmals.');
				}
			}
		}
		else{
			log_message('error', 'storeOrder(): Invalid lecturer array.');
			show_error('Kritischer Fehler in der Verarbeitung Ihrer Eingaben [ung&uuml;ltige Dozenten]. Bitte versuchen Sie es nochmals.');
		}
		
		// Save lecturer-id and course-id in mapping-table
		$lecturerQuery = $this->db->get_where($this->tableLecturers, array('courseId' => $pCourse->getId()));
		if($lecturerQuery->num_rows() > 0){
			foreach($lecturerQuery->result_array() as $lecturer){
					$mappingData = array(
						'lecturer_id' => $lecturer['id'],
						'course_id' => $pCourse->getId()
					);
					$this->db->insert($this->tableMapping, $mappingData);	
			}
		}
		else{
			log_message('error', 'storeOrder(): Invalid lecturer array.');
			show_error('Kritischer Fehler in der Verarbeitung Ihrer Eingaben [ung&uuml;ltige Dozenten]. Bitte versuchen Sie es nochmals.');
		}
		
		$this->db->trans_complete();
		
		if($this->db->trans_status() === FALSE){
			log_message('error', 'storeOrder(): Transaction failed.');
			show_error('Kritischer Fehler in der Verarbeitung Ihrer Eingaben [Datenbankfehler]. Bitte versuchen Sie es nochmals.');
		}
		else{
			log_message('info', 'storeOrder(): Transaction complete. Course ' . $pCourse->getId() . ' stored.');
		}
	}
	
	public function getAllCourses(){
		$allCourses = array();
		$courseQuery = $this->db->get($this->tableCourses);
		
		if($courseQuery->num_rows() > 0){
			foreach($courseQuery->result() as $course){
				$tempCourse = new Course_model();
				
				$tempCourse->setId($course->id);
				$tempCourse->setName($course->name);
				$tempCourse->setType($course->type);
				$tempCourse->setSurveyType($course->surveyType);
				$tempCourse->setOrdererFirstname($course->ordererFirstname);
				$tempCourse->setOrdererSurname($course->ordererSurname);
				$tempCourse->setOrdererEmail($course->ordererEmail);
				$tempCourse->setOrdererUniqueId($course->ordererUniqueId);
				$tempCourse->setOrderTime($course->orderTime);
				
				// Retrieve linked lecturers
				$lecturerQuery = $this->db->get_where($this->tableLecturers, array('courseId' => $course->id));
				if($lecturerQuery->num_rows() > 0){
					foreach($lecturerQuery->result_array() as $lecturer){
						$tempCourse->addLecturer($lecturer);
					}
				}
				else{
					log_message('error', 'course_mapper->getAllCourses(): Corrupted lecturer data (course ID ' . $course->id . ').');
					show_error('Kritischer Fehler in der Verarbeitung Ihrer Eingaben [Datenbankfehler]. Bitte versuchen Sie es nochmals.');
				}
				
				// Paper survey
				if(strcmp($course->surveyType, 'papierumfrage') === 0){
					$tempCourse->setTurnout($course->turnout);
				}
				
				// Online survey
				elseif(strcmp($course->surveyType, 'onlineumfrage') === 0){
					// Retrieve linked participants
					$participantQuery = $this->db->get_where($this->tableParticipants, array('courseId' => $course->id));
					if($participantQuery->num_rows() > 0){
						foreach($participantQuery->result() as $participant){
							$tempCourse->addParticipant($participant->email);
						}
					}
					else{
						log_message('error', 'course_mapper->getAllCourses(): Corrupted participant data (course ID ' . $course->id . ').');
						show_error('Kritischer Fehler in der Verarbeitung Ihrer Eingaben [Datenbankfehler]. Bitte versuchen Sie es nochmals.');
					}
				}
				
				array_push($allCourses, $tempCourse);
			}
			
			return $allCourses;
			
		}
	}
	
}