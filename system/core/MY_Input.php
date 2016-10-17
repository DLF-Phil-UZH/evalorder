<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Input extends CI_Input {

	function __construct()
    {
        parent::__construct();
		log_message('debug', 'Using customized Input Class MY_Input.');
    }

	// --------------------------------------------------------------------

	/**
	* Clean Keys
	*
	* This is a helper function. To prevent malicious users
	* from trying to exploit keys we make sure that keys are
	* only named with alpha-numeric text and a few other items.
	*
	* @access	private
	* @param	string
	* @return	string
	*/
	function _clean_input_keys($str)
	{
		log_message('debug', 'Input Keys: ' . $str);
		if ( ! preg_match("/^[a-z0-9:_\/-]+$/i", $str))
		{
			exit('Disallowed Key Characters. String: ' . $str);
		}

		// Clean UTF-8 if supported
		if (UTF8_ENABLED === TRUE)
		{
			$str = $this->uni->clean_string($str);
		}

		return $str;
	}

}

/* End of file MY_Input.php */
/* Location: ./system/core/MY_Input.php */