<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Workaround to make custom callbacks work in form validation.
 * Source: https://www.youtube.com/watch?v=fTztVbjwjmE (02.12.2014).
 */
class MY_Form_validation extends CI_Form_validation{

	function run($module = '', $group = ''){
		(is_object($module)) AND $this->CI = &$module;
			return parent::run($group);
	}

}