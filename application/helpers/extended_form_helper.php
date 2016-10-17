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

if(!function_exists('isDigit')){
	
	/*
	All basic PHP functions which i tried returned unexpected results. I would just like to check whether some variable only contains numbers. For example: when i spread my script to the public i cannot require users to only use numbers as string or as integer. For those situation i wrote my own function which handles all inconveniences of other functions and which is not depending on regular expressions. Some people strongly believe that regular functions slow down your script.

	The reason to write this function:
	1. is_numeric() accepts values like: +0123.45e6 (but you would expect it would not)
	2. is_int() does not accept HTML form fields (like: 123) because they are treated as strings (like: "123").
	3. ctype_digit() excepts all numbers to be strings (like: "123") and does not validate real integers (like: 123).
	4. Probably some functions would parse a boolean (like: true or false) as 0 or 1 and validate it in that manner.

	My function only accepts numbers regardless whether they are in string or in integer format.
	*/

	/**
	 * Check input for existing only of digits (numbers)
	 * @author Tim Boormans <info@directwebsolutions.nl>
	 * @param $digit
	 * @return bool
	 */
	function isDigit($pDigit){
		if(is_int($pDigit)){
			return true;
		}
		elseif(is_string($pDigit)){
			return ctype_digit($pDigit);
		}
		else{
			// booleans, floats and others
			return false;
		}
	}

}

if(!function_exists('validateDateTime')){

	// Returns true if passed DateTime string is a valid date in passed format, false otherwise
	function validateDateTime($pDateTimeString, $pFormat = 'Y-m-d H:i'){
		$d = DateTime::createFromFormat($pFormat, $pDateTimeString);
		return $d && $d->format($pFormat) == $pDateTimeString;
	}

}