<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->library('shibboleth_authentication_service', NULL, 'shib_auth');
		$user = $this->shib_auth->verify_user();
		if ($user == false) {
			redirect('auth');
   		}
		//$this->adminaccess = false;
		//if ($_SERVER['HTTP_UNIQUEID']=="709336@vho-switchaai.ch" | $_SERVER['HTTP_UNIQUEID']=="252867@vho-switchaai.ch" | $_SERVER['HTTP_UNIQUEID']=="6D3130333234353501@uzh.ch"){
		$this->adminaccess = true;
		//}
		$this->load->database();
	}

	public function index(){
	    redirect(site_url('/admin/bestellungen'));	
	}

	public function bestellungen(){
		if($this->adminaccess === true){
			try{
				$this->load->view('header', array('title' => 'Oliv: Administration',
											  'page' => 'bestellungen',
											  'width' => 'small',
                                              'logged_in' => $this->shib_auth->verify_shibboleth_session(),
											  'access' => ($this->shib_auth->verify_user() !== false),
											  'admin' => $this->adminaccess));
				$this->load->view('bestellungen');
				$this->load->view('footer');
			}catch(Exception $e){
				$this->_handle_crud_exception($e);
			}
		}
		// If user is not an admin
		else{
			$this->_access_denied();
		}
	}

    private function _access_denied() {
        $this->output->set_status_header('403');
		$this->load->view('header', array('title' => 'Oliv: Zugriff verweigert',
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
