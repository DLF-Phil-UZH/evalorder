<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('produceNameIDTags')){

	function produceNameIDTags($pValue){
		return 'name="' . $pValue . '" id="' . $pValue . '"';
	}

}

if(!function_exists('setEncodedValue')){
	
	// Encode HTML special chars to HTML entities for HTML output, for example for repopulating input data
	function setEncodedValue($pValue, $pDefault = ''){
		if(strlen($pDefault) > 0){
			// Use built in function set_value()
			$fieldEntry = set_value($pValue, $pDefault);
		}
		else{
			$fieldEntry = set_value($pValue);
		}
		return htmlspecialchars($fieldEntry, ENT_QUOTES);
	}

}

if(!function_exists('setDecodedValue')){

	// Decode HTML entities for special chars for HTML output, for example for repopulating input data
	function setDecodedValue($pValue, $pDefault = ''){
		if(strlen($pDefault) > 0){
			// Use built in function set_value()
			$fieldEntry = set_value($pValue, $pDefault);
		}
		else{
			$fieldEntry = set_value($pValue);
		}
		return htmlspecialchars_decode($fieldEntry);
	}

}