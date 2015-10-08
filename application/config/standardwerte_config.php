<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['orgroot'] = 'PR GSW / Hochschuldidaktik';
$config['survey_verify'] = '1';
$config['dispatch_report']='1';
$config['survey_period'] = 'HS 2015'; //Semester, Datum anpassen
$config['sender_mail'] = 'admin@hochschuldidaktik.uzh.ch';
$config['sender_name'] = 'Hochschuldidaktik UZH';
$config['tasktype_1'] = 'dispatch_pswd';
$config['tasktype_2'] = 'remind_pswd';
$config['tasktype_3'] = 'close_survey';
$config['taskdatetime_1'] = '2015-10-30 06:00'; // Umfrage starten, Datum anpassen
$config['taskdatetime_2'] = '2015-11-07 06:00'; // Umfrage Reminder, Datum anpassen
$config['taskdatetime_3'] = '2015-11-16 00:00'; // Umfrage geschlossen, Datum anpassen
$config['taskmailtext_1'] = 'Liebe Studentin, lieber Student\n\n
Die Lehrveranstaltung "[COURSENAME]", die Sie gebucht haben, wird im Auftrag der verantwortlichen Dozentin, des verantwortlichen Dozenten im Herbstsemester 2015 evaluiert.
Wir möchten Sie freundlich bitten, sich kurz Zeit zu nehmen und den Online-Fragebogen auszufüllen.
Sie benötigen dafür etwa 10 Minuten.
Damit erhalten die Dozierenden unmittelbar Rückmeldungen zur Qualität ihrer Lehrveranstaltung und somit die Möglichkeit, ihre Lehrqualität zu optimieren.\n\n
Bitte folgen Sie dem untenstehenden Link zu Ihrem Fragebogen:\n[DIRECT_ONLINE_LINK]\n\n
Die Befragung erfolgt anonym. 
Bitte füllen Sie den Fragebogen bis am Sonntag, 15. November 2015 um 23.59 Uhr aus.\n\n
Herzlichen Dank für Ihre Unterstützung!\n\n\n
Freundliche Grüsse\n\n
Digitale Lehre und Forschung PhF / Hochschuldidaktik Universität Zürich';  //Datum anpassen
$config['taskmailtext_2'] = 'Liebe Studierende\nDies ist ein Reminder für die Umfrage zur Lehrveranstaltung &quot;[COURSENAME]&quot;.\n\nFreundliche Grüsse\n\nDigitale Lehre und Forschung PhF / Hochschuldidaktik Universität Zürich';
$config['taskmailsubject'] = 'Lehrveranstaltungsbeurteilung [COURSENAME]';

/* End of file standardwerte_config.php */
/* Location: ./application/config/standardwerte_config.php */
