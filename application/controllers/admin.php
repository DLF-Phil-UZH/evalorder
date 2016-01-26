<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'extended_form', 'url'));
		$this->load->library('shibboleth_authentication_service', NULL, 'shib_auth');
		$user = $this->shib_auth->verify_user();
		if ($user == false) {
			redirect('auth');
   		}
		$this->adminaccess = false;
		if ($_SERVER['HTTP_UNIQUEID']=="709336@vho-switchaai.ch" | $_SERVER['HTTP_UNIQUEID']=="252867@vho-switchaai.ch" | $_SERVER['HTTP_UNIQUEID']=="6D3130333234353501@uzh.ch"){
			$this->adminaccess = true;
		}
		$this->load->database();
	}

	public function index(){
		redirect(site_url('/admin/bestellungen'));
	}

	public function bestellungen(){
		if($this->adminaccess === true){
			try{
				
				$xmlFilename = '';
				$xmlError = '';
				
				// Courses have been selected to generate XML files and download package
				if($this->input->post('courses')){
					
					$courses = $this->input->post('courses');
					$this->load->model('Course_mapper');
					
					$xmlFilename = $this->Course_mapper->writeXMLImportFile($courses);
					
					// Error in XML generation
					if($xmlFilename === FALSE){
						$xmlFilename = '';
						$xmlError = 'Fehler beim Generieren der XML-Datei. Bitte versuchen Sie es nochmals.';
					}
					
					// Javascript files
					$jQuery = array('type' => 'text/javascript',
									'src' => 'https://code.jquery.com/jquery.min.js');
					$orderformLibrary = array('type' => 'text/javascript',
											  'src' => base_url('/assets/js/orderform_library.js'));
					$tablesorter = array('type' => 'text/javascript',
										 'src' => base_url('/assets/js/jquery.tablesorter.js'));
					$bestellungen = array('type' => 'text/javascript',
										  'src' => base_url('/assets/js/bestellungen.js'));
					
					// Load download view
					$this->load->view('header', array('title' => 'Administration',
												  'page' => 'bestellungen',
												  'width' => 'normal',
												  'logged_in' => $this->shib_auth->verify_shibboleth_session(),
												  'access' => ($this->shib_auth->verify_user() !== false),
												  'admin' => $this->adminaccess,
												  'scripts' => array($jQuery, $orderformLibrary, $tablesorter, $bestellungen)));
					$this->load->view('download', array('xmlError' => $xmlError,
														'xmlFilename' => $xmlFilename));
					$this->load->view('footer');
					
				}
				else{
				
					// Javascript files
					$jQuery = array('type' => 'text/javascript',
									'src' => 'https://code.jquery.com/jquery.min.js');
					$orderformLibrary = array('type' => 'text/javascript',
											  'src' => base_url('/assets/js/orderform_library.js'));
					$tablesorter = array('type' => 'text/javascript',
										 'src' => base_url('/assets/js/jquery.tablesorter.js'));
					$bestellungen = array('type' => 'text/javascript',
										  'src' => base_url('/assets/js/bestellungen.js'));
					
					// Load order table
					$this->load->view('header', array('title' => 'Administration',
												  'page' => 'bestellungen',
												  'width' => 'normal',
												  'logged_in' => $this->shib_auth->verify_shibboleth_session(),
												  'access' => ($this->shib_auth->verify_user() !== false),
												  'admin' => $this->adminaccess,
												  'scripts' => array($jQuery, $orderformLibrary, $tablesorter, $bestellungen)));
					$this->load->view('bestellungen');
					$this->load->view('footer');
					
				}
			}catch(Exception $e){
				
			}
		}
		// If user is not an admin
		else{
			$this->_access_denied();
		}
	}
	
	public function xmldownload($pFilename){

		log_message('debug', 'download_1');
		$this->load->helper('download');
		$fullPath = $this->config->item('xml_folder') . $pFilename;
		$data = file_get_contents($fullPath); // Read the file's contents
		log_message('debug', 'download_2');
		force_download($pFilename, $data);
		log_message('debug', 'download_3');
		
	}
	
	public function standardwerte(){
		if($this->adminaccess === true){
			try{
				$this->load->view('header', array('title' => 'Administration',
											  'page' => 'standardwerte',
											  'width' => 'small',
                                              'logged_in' => $this->shib_auth->verify_shibboleth_session(),
											  'access' => ($this->shib_auth->verify_user() !== false),
											  'admin' => $this->adminaccess));
				$this->load->view('standardwerte');
				$this->load->view('footer');
			}catch(Exception $e){
			
			}
		}
		// If user is not an admin
		else{
			$this->_access_denied();
		}
	}

    private function _access_denied() {
        $this->output->set_status_header('403');
		$this->load->view('header', array('title' => 'Zugriff verweigert',
										  'page' => 'access_denied',
										  'width' => 'small',
                                          'logged_in' => $this->shib_auth->verify_shibboleth_session(),
										  'access' => ($this->shib_auth->verify_user() !== false)));
		$this->load->view('access_denied');
		$this->load->view('footer');
	}

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
