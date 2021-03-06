﻿<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php

$this->config->load('standardwerte_config');
$this->load->helper('extended_form');

$orgroot=$this->config->item('orgroot');
$survey_verify=$this->config->item('survey_verify');
$dispatch_report=$this->config->item('dispatch_report');
$mail_instructor=$this->config->item('mail_instructor');
$min_response=$this->config->item('min_response');
$survey_period=$this->config->item('survey_period');
$sender_mail=$this->config->item('sender_mail');
$sender_name=$this->config->item('sender_name');
$tasktype_1=$this->config->item('tasktype_1');
$tasktype_2=$this->config->item('tasktype_2');
$tasktype_3=$this->config->item('tasktype_3');
$tasktype_4=$this->config->item('tasktype_4');
$taskdatetime_1=$this->config->item('taskdatetime_1');
$taskdatetime_2=$this->config->item('taskdatetime_2');
$taskdatetime_3=$this->config->item('taskdatetime_3');
$taskdatetime_4=$this->config->item('taskdatetime_4');
$taskmailtext_1=$this->config->item('taskmailtext_1');
$taskmailtext_2=$this->config->item('taskmailtext_2');
$taskmailsubject=$this->config->item('taskmailsubject');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$survey_period_value = @$_POST["survey_period_value"];
	$taskdatetime_1_value = @$_POST["taskdatetime_1_value"];
	$taskdatetime_2_value = @$_POST["taskdatetime_2_value"];
	$taskdatetime_3_value = @$_POST["taskdatetime_3_value"];
	$taskdatetime_4_value = @$_POST["taskdatetime_4_value"];
	$taskmailtext_1_value = @$_POST["taskmailtext_1_value"];
	$taskmailtext_2_value = @$_POST["taskmailtext_2_value"];
}

if (!empty($survey_period_value)){
	$file = './application/config/standardwerte_config.php';
	$current = file_get_contents($file);
	$current = str_replace($survey_period, $survey_period_value, $current);
	file_put_contents($file, $current);
	header("Location: standardwerte");
}
if (!empty($taskdatetime_1_value)){
	if(validateDateTime($taskdatetime_1_value)){
		if($taskdatetime_1_value <= $taskdatetime_2_value AND $taskdatetime_2_value <= $taskdatetime_4_value AND $taskdatetime_1_value <= $taskdatetime_3_value AND $taskdatetime_3_value <= $taskdatetime_4_value){
			$file = './application/config/standardwerte_config.php';
			$current = file_get_contents($file);
			$current = str_replace($taskdatetime_1, $taskdatetime_1_value, $current);
			file_put_contents($file, $current);
		}
	}
	header("Location: standardwerte");
	
}
if (!empty($taskdatetime_2_value)){
	if(validateDateTime($taskdatetime_2_value)){
		if($taskdatetime_1_value <= $taskdatetime_2_value AND $taskdatetime_2_value <= $taskdatetime_4_value AND $taskdatetime_1_value <= $taskdatetime_3_value AND $taskdatetime_3_value <= $taskdatetime_4_value){
			$file = './application/config/standardwerte_config.php';
			$current = file_get_contents($file);
			$current = str_replace($taskdatetime_2, $taskdatetime_2_value, $current);
			file_put_contents($file, $current);
		}
	}
	header("Location: standardwerte");
}
if (!empty($taskdatetime_3_value)){
	if(validateDateTime($taskdatetime_3_value)){
		if($taskdatetime_1_value <= $taskdatetime_2_value AND $taskdatetime_2_value <= $taskdatetime_4_value AND $taskdatetime_1_value <= $taskdatetime_3_value AND $taskdatetime_3_value <= $taskdatetime_4_value){
			$file = './application/config/standardwerte_config.php';
			$current = file_get_contents($file);
			$current = str_replace($taskdatetime_3, $taskdatetime_3_value, $current);
			file_put_contents($file, $current);
		}
	}
	header("Location: standardwerte");
}
if (!empty($taskdatetime_4_value)){
	if(validateDateTime($taskdatetime_4_value)){
		if($taskdatetime_1_value <= $taskdatetime_2_value AND $taskdatetime_2_value <= $taskdatetime_4_value AND $taskdatetime_1_value <= $taskdatetime_3_value AND $taskdatetime_3_value <= $taskdatetime_4_value){
			$file = './application/config/standardwerte_config.php'; 
			$current = file_get_contents($file);
			$current = str_replace($taskdatetime_3, $taskdatetime_3_value, $current);
			file_put_contents($file, $current);
		}
	}
	header("Location: standardwerte");
}
if (!empty($taskmailtext_1_value)){
	$file = './application/config/standardwerte_config.php'; 
	$current = file_get_contents($file);
	$current = str_replace($taskmailtext_1, $taskmailtext_1_value, $current);
	file_put_contents($file, $current);
	header("Location: standardwerte");
}
if (!empty($taskmailtext_2_value)){
	$file = './application/config/standardwerte_config.php'; 
	$current = file_get_contents($file);
	$current = str_replace($taskmailtext_2, $taskmailtext_2_value, $current);
	file_put_contents($file, $current);
	header("Location: standardwerte");
}


?>

	<div class="oliv_content">
	
		<h2>Eva &ndash; Standardwerte</h2>
	
		<?php
		echo "<b>Fixwerte:</b>";
		echo "<br>";
		echo "<table width='100%' border='1'>";
		echo "<tr><th width='15%'>Orgroot</th><td>$orgroot</td></tr>";
		echo "<tr><th>Survey Verify</th><td>$survey_verify</td></tr>";
		echo "<tr><th>Dispatch Report</th><td>$dispatch_report</td></tr>";
		echo "<tr><th>Mail Instructor</th><td>$mail_instructor</td></tr>";
		echo "<tr><th>Minimal Response</th><td>$min_response</td></tr>";
		echo "<tr><th>Sender Mail</th><td>$sender_mail</td></tr>";
		echo "<tr><th>Sender Name</th><td>$sender_name</td></tr>";
		echo "<tr><th>Task Type 1</th><td>$tasktype_1</td></tr>";
		echo "<tr><th>Task Type 2</th><td>$tasktype_2</td></tr>";
		echo "<tr><th>Task Type 3</th><td>$tasktype_3</td></tr>";
		echo "<tr><th>Task Type 4</th><td>$tasktype_4</td></tr>";
		echo "<tr><th>Task Mail Subject</th><td>$taskmailsubject</td></tr>";
		echo "</table>";
		echo "<br><br>";
		echo "<form accept-charset='UTF-8' method='post' action='standardwerte'>";
		echo "<b>Variable Werte:</b><input type='submit' value='&auml;ndern' style='margin-left:40px'>";
		echo "<br>";
		echo "<table width='100%' border='1'>";
		echo "<tr><th width='15%'>Survey Period</th><td>Format: \"[FS|HS] JJJJ\"<br/><input type='text' name='survey_period_value' value='$survey_period'></td></tr>";
		echo "<tr><th>Task Date Time 1</th><td>Versand der Teilnahmelinks<br/>Format: \"JJJJ-MM-TT HH:MM\"<br/><input type='text' name='taskdatetime_1_value' value='$taskdatetime_1'></td></tr>";
		echo "<tr><th>Task Date Time 2</th><td>Teilnahmeerinnerung<br/>Format: \"JJJJ-MM-TT HH:MM\"<br/><input type='text' name='taskdatetime_2_value' value='$taskdatetime_2'></td></tr>";
		echo "<tr><th>Task Date Time 3</th><td>Rücklaufquote<br/>Format: \"JJJJ-MM-TT HH:MM\"<br/><input type='text' name='taskdatetime_3_value' value='$taskdatetime_3'></td></tr>";
		echo "<tr><th>Task Date Time 4</th><td>Schliessung der Umfrage<br/>Format: \"JJJJ-MM-TT HH:MM\"<br/><input type='text' name='taskdatetime_4_value' value='$taskdatetime_4'></td></tr>";
		echo "<tr><th>Task Mail Text 1</th><td><textarea style='width: 98%; border: none;' name='taskmailtext_1_value'>$taskmailtext_1</textarea></td></tr>";
		echo "<tr><th>Task Mail Text 2</th><td><textarea style='width: 98%; border: none;' name='taskmailtext_2_value'>$taskmailtext_2</textarea></td></tr>";
		echo "</table>";
		echo "</form>"
		?>
	</div>

<!-- End of file standardwerte.php -->
<!-- Location: ./application/views/standardwerte.php -->