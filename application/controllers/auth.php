<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

	private $table_user_requests = "oliv_user_requests"; // Name of database table

	public function __construct() {
		parent::__construct();
		$this->load->library('shibboleth_authentication_service', NULL, 'shib_auth');
	}

	/**
     * 
	 */
	public function index(){
        if ($user = $this->shib_auth->verify_user() !== false) {
			// if there is a user and he has access, redirect to
			// the manager page
			log_message('debug', 'auth->REDIRECT->welcome');
			redirect('welcome');
		}

		// If user has already logged in over AAI
		if($this->shib_auth->verify_shibboleth_session()){
			/*
			$this->load->view('header', array('title' => 'Oliv: Zugang beantragen',
										  'page' => 'request_access',
										  'width' => 'small',
                                          'logged_in' => $this->shib_auth->verify_shibboleth_session(),
										  'access' => ($this->shib_auth->verify_user() !== false)));
			$this->load->view('request_access');
			*/
			log_message('debug', 'auth->REDIRECT->welcome');
			redirect('welcome');
		}
		// If user hasn't logged in over AAI yet, send him to login page
		else{
			$this->load->view('header', array('title' => 'EvalOrder: Authentifizierung',
										  'page' => 'authentification',
										  'width' => 'small',
                                          'logged_in' => false,
										  'access' => false));
			$return_url = site_url();
			$this->load->view('login', array('return_url' => $return_url));
		}
		$this->load->view('footer');
	}

	/**
	 *
	 */
	/*
    public function logout() {
        if (!$this->shib_auth->verify_shibboleth_session()) {
            redirect('auth');
            return;
		}

        $user = $this->shib_auth->verify_user();
        if ($user != false) {
            // TODO: clean up locks
            // $this->shib_auth->log_out();
            $user_id = $user->getId();

            $this->load->library('Grocery_CRUD');
            $grocery_crud = new Grocery_CRUD($user);
            $success = $grocery_crud->unlock_all_records();
            if (!$success) {
                // TODO: log some error message
            }
        }

        // TODO: Display, login link / hide logout link in Header
        $this->load->view('header', array('title' => 'Oliv: Abgemeldet',
                                      'page' => 'logout',
                                      'width' => 'small',
                                      'logged_in' => false,
                                      'access' => false));
        $this->load->view('logout');
        $this->load->view('footer');

    }
	*/
	
}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */

