<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Integrates PHPExcel as a usable library
// PHPExcel: http://phpexcel.codeplex.com/
// Used version: 1.8.0 (March 2014)
require_once APPPATH . '/third_party/PHPExcel.php';
 
class Excel extends PHPExcel{
	
	public function __construct(){
		parent::__construct();
	}
	
}