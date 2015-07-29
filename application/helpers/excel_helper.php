<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('checkParticipantFile')){

	function checkParticipantFile($pFullPath){
	
		log_message('debug', 'checkParticipantFile_1');
		
		$ci =& get_instance();
		$ci->load->library('excel');
		
		log_message('debug', 'checkParticipantFile_2');
		
		$readerObject = PHPExcel_IOFactory::createReaderForFile($pFullPath);
		$readerObject->setReadDataOnly(true);
		$excelObject = $readerObject->load($pFullPath);
		
		log_message('debug', 'checkParticipantFile_3');
		
		// $cell_collection = $excelObject->setActiveSheetIndex(0)->getCellCollection();
		
		// foreach($cell_collection as $cell){
			// $column = $excelObject->getActiveSheet()->getCell($cell)->getColumn();
			// $row = $excelObject->getActiveSheet()->getCell($cell)->getRow();
			// $data_value = $excelObject->getActiveSheet()->getCell($cell)->getValue();
		 
			// //header will/should be in row 1 only. of course this can be modified to suit your need.
			// if ($row == 1) {
				// $header[$row][$columns] = $data_value;
			// } else {
				// $arr_data[$row][$col] = $data_value;
			// }
		// }
		
		// Get first row (iterator count starts from 1, not from 0)
		$firstRow = $excelObject->setActiveSheetIndex(0)->getRowIterator(1)->current();
		log_message('debug', 'checkParticipantFile_4');
		$cellIterator = $firstRow->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(false);
		log_message('debug', 'checkParticipantFile_5');
		foreach($cellIterator as $cell){
			// echo 'row ' . $cell->getRow() . ' col ' . $cell->getColumn() . ':---' . $cell->getValue() . '---<br/>';
			log_message('debug', 'checkParticipantFile_6');
			if(strcmp($cell->getValue(), 'E-Mail') == 0){
				log_message('debug', 'checkParticipantFile_7');
				return array(TRUE, $cell->getColumn());
				
			}
		}
		log_message('debug', 'checkParticipantFile_8');
		return array(FALSE, 'Keine Spalte mit der &Uuml;berschrift &quot;E-Mail&quot; gefunden.');
		
	}
	
}

if(!function_exists('extractParticipantAddresses')){

	function extractParticipantAddresses($pFullPath, $pColumn){
	
		log_message('debug', 'extractParticipantAddresses_1');
		
		$ci =& get_instance();
		$ci->load->library('excel');
		$ci->load->helper('email');
		
		log_message('debug', 'extractParticipantAddresses_2');
		
		$readerObject = PHPExcel_IOFactory::createReaderForFile($pFullPath);
		$readerObject->setReadDataOnly(true);
		$excelObject = $readerObject->load($pFullPath);
		
		log_message('debug', 'extractParticipantAddresses_3');
		
		$firstWorksheet = $excelObject->setActiveSheetIndex(0);
		$lastRow = $firstWorksheet->getHighestRow();
		$emailAddresses = array();
		
		log_message('debug', 'extractParticipantAddresses_4');
		
		// Check every cell of given column on valid e-mail address and retrieve if valid
		for($row = 1; $row <= $lastRow; $row++){
			log_message('debug', 'extractParticipantAddresses_5');
			$cell = $firstWorksheet->getCell($pColumn . $row);
			// Remove whitespaces at beginning and end
			$email = trim($cell);
			if(valid_email($email)){
				log_message('debug', 'extractParticipantAddresses_6');
				array_push($emailAddresses, $email);
			}
		}
	
		return $emailAddresses;
	
	}

}