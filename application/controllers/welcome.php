<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->library('shibboleth_authentication_service', NULL, 'shib_auth');
	}
	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index(){
		$user = $this->shib_auth->verify_user();
		$admin = false;
		/*if ($user !== false) {
			$admin = $user->isAdmin();
		}
		*/
		
		// Directly load order form if user already has logged in
		if($user !== false){
			log_message('debug', 'welcome->REDIRECT->evalorderform');
			redirect('evalorderform');
		}
		
		$this->load->view('header', array('title' => 'Eva',
										  'page' => 'Willkommen',
										  'width' => 'small',
										  'admin' => $admin,
										  'logged_in' => $this->shib_auth->verify_shibboleth_session(),
										  'access' => ($user !== false)));
		$this->load->view('welcome_message', array('access' => ($user !== false)));
		$this->load->view('footer');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
