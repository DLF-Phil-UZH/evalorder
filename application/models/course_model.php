<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Course_model extends CI_Model{
	
	private $id;
	private $name;
	private $type;
	private $participantFile1; // File name of first Excel file
	private $participantFile2; // File name of second Excel file
	private $semester;
	private $lecturers; // Array of lecturer arrays
	private $surveyType; // 'onlineumfrage' or 'papierumfrage'
	private $language; // Language of survey form
	private $turnout; // Number of participants (paper survey)
	private $participants; // Array of e-mail adresses of participants (online survey)
	private $ordererFirstname;
	private $ordererSurname;
	private $ordererEmail;
	private $ordererUniqueId;
	private $orderTime;
	private $lastExport;
	
	// Database tables
	private $tableCourses = 'evalorder_courses';
	private $tableLecturers = 'evalorder_lecturers';
	private $tableParticipants = 'evalorder_participants';
	
	// Folder for uploaded XLS files
	private $fileDirPath;
	
	public function __construct(){
		// Call the Model constructor
		parent::__construct();
		
		$ci = &get_instance();
        $this->fileDirPath = $ci->config->item('xls_folder');
		$this->load->database();
	}
	
	// Pseudo constructor to avoid warnings (see http://stackoverflow.com/questions/22688203/codeigniter-php-constructor-missing-argument-even-if-it-is-present)
	public function initialSet($pName, $pType, $pLecturers, $pSurveyType, $pSemester, $pOrdererFirstname, $pOrdererSurname, $pOrdererEmail, $pOrdererUniqueId){
		$this->name = $pName;
		$this->type = $pType;
		$this->lecturers = $pLecturers;
		$this->surveyType = $pSurveyType;
		$this->semester = $pSemester;
		$this->ordererFirstname = $pOrdererFirstname;
		$this->ordererSurname = $pOrdererSurname;
		$this->ordererEmail = $pOrdererEmail;
		$this->ordererUniqueId = $pOrdererUniqueId;	
	}
	
	// Getters and setters
	
	public function getId(){
		return $this->id;
	}

	public function setId($pId){
		$this->id = $pId;
	}

	public function getName(){
		return $this->name;
	}

	public function setName($pName){
		$this->name = $pName;
	}

	public function getType(){
		return $this->type;
	}

	public function setType($pType){
		$this->type = $pType;
	}
	
	public function getParticipantFile1(){
		return $this->participantFile1;
	}
	
	public function setParticipantFile1($pParticipantFile){
		$this->participantFile1 = $pParticipantFile;
	}
	
	public function getParticipantFile2(){
		return $this->participantFile2;
	}
	
	public function setParticipantFile2($pParticipantFile){
		$this->participantFile2 = $pParticipantFile;
	}
	
	public function getSemester(){
		return $this->semester;
	}

	public function setSemester($pSemester){
		$this->semester = $pSemester;
	}

	public function getLecturers(){
		return $this->lecturers;
	}

	public function setLecturers($pLecturers){
		$this->lecturers = $pLecturers;
	}

	public function getSurveyType(){
		return $this->surveyType;
	}

	public function setSurveyType($pSurveyType){
		$this->surveyType = $pSurveyType;
	}
	
	public function getLanguage(){
		return $this->language;
	}

	public function setLanguage($pLanguage){
		$this->language = $pLanguage;
	}

	public function getTurnout(){
		return $this->turnout;
	}

	public function setTurnout($pTurnout){
		$this->turnout = $pTurnout;
	}
	
	public function getParticipants(){
		return $this->participants;
	}

	public function setParticipants($pParticipants){
		$this->participants = $pParticipants;
	}

	public function getOrdererFirstname(){
		return $this->ordererFirstname;
	}

	public function setOrdererFirstname($pOrdererFirstname){
		$this->ordererFirstname = $pOrdererFirstname;
	}

	public function getOrdererSurname(){
		return $this->ordererSurname;
	}

	public function setOrdererSurname($pOrdererSurname){
		$this->ordererSurname = $pOrdererSurname;
	}

	public function getOrdererEmail(){
		return $this->ordererEmail;
	}

	public function setOrdererEmail($pOrdererEmail){
		$this->ordererEmail = $pOrdererEmail;
	}

	public function getOrdererUniqueId(){
		return $this->ordererUniqueId;
	}

	public function setOrdererUniqueId($pOrdererUniqueId){
		$this->ordererUniqueId = $pOrdererUniqueId;
	}

	public function getOrderTime(){
		return $this->orderTime;
	}

	public function setOrderTime($pOrderTime){
		$this->orderTime = $pOrderTime;
	}
	
	public function getLastExport(){
		return $this->lastExport;
	}

	public function setLastExport($pLastExport){
		$this->lastExport = $pLastExport;
	}
	
	// Other methods
	
	// Returns full path of participant file 1 if existent or false if not
	public function getPathParticipantFile1(){
		if(file_exists($this->fileDirPath . $this->participantFile1)){
			return $this->fileDirPath . $this->participantFile1;
		}
		else{
			return false;
		}
	}
	
	// Returns full path of participant file 2 if existent or false if not
	public function getPathParticipantFile2(){
		if(file_exists($this->fileDirPath . $this->participantFile2)){
			return $this->fileDirPath . $this->participantFile2;
		}
		else{
			return false;
		}
	}
	
	// Adds a single lecturer to the existing ones (if any) or creates the array and adds it
	public function addLecturer($pLecturer){
		// If lecturers have not been initialized so far, initialize
		if(!(is_array($this->lecturers))){
			$this->lecturers = array();
		}
		array_push($this->lecturers, $pLecturer);
	}
	
	// Adds a single participant to the existing ones (if any) or creates the array and adds it
	public function addParticipant($pParticipant){
		// If participants have not been initialized so far, initialize
		if(!(is_array($this->participants))){
			$this->participants = array();
		}
		array_push($this->participants, $pParticipant);
	}
	
	// Returns true, if course has not been registered in database so far
	public function isNew(){
		$lIsNew = false;
		if($this->id == null){
			$lIsNew = true;
		}
		return $lIsNew;
	}
	
}