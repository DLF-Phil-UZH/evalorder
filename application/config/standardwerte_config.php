<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['orgroot'] = 'Digitale Lehre & Forschung';

// Survey form codes for existing forms in use at Studienangebotsentwicklung
// Course type and language keys map to equivalent database entry
// Language key 'none' used for online surveys which don't need language specification

$config['survey_form']['praktikum']['one_lecturer']['none'] = 'SFO_Pe8';
$config['survey_form']['praktikum']['one_lecturer']['deutsch'] = 'SFPe8';
$config['survey_form']['praktikum']['one_lecturer']['englisch'] = 'SFPe8e';
$config['survey_form']['praktikum']['multiple_lecturers']['none'] = 'SFO_Pm8';
$config['survey_form']['praktikum']['multiple_lecturers']['deutsch'] = 'SFPm8';
$config['survey_form']['praktikum']['multiple_lecturers']['englisch'] = 'SFPm8e';
$config['survey_form']['seminar']['one_lecturer']['none'] = 'SFO_Se8';
$config['survey_form']['seminar']['one_lecturer']['deutsch'] = 'SFSe8';
$config['survey_form']['seminar']['one_lecturer']['englisch'] = 'SFSe8e';
$config['survey_form']['seminar']['multiple_lecturers']['none'] = 'SFO_Sm8';
$config['survey_form']['seminar']['multiple_lecturers']['deutsch'] = 'SFSm8';
$config['survey_form']['seminar']['multiple_lecturers']['englisch'] = 'SFSm8e';
$config['survey_form']['uebung']['one_lecturer']['none'] = 'SFO_Ue8';
$config['survey_form']['uebung']['one_lecturer']['deutsch'] = 'SFUe8';
$config['survey_form']['uebung']['one_lecturer']['englisch'] = 'SFUe8e';
$config['survey_form']['uebung']['multiple_lecturers']['none'] = 'SFO_Um8';
$config['survey_form']['uebung']['multiple_lecturers']['deutsch'] = 'SFUm8';
$config['survey_form']['uebung']['multiple_lecturers']['englisch'] = 'SFUm8e';
$config['survey_form']['vorlesung']['one_lecturer']['none'] = 'SFO_Ve8';
$config['survey_form']['vorlesung']['one_lecturer']['deutsch'] = 'SFVe8';
$config['survey_form']['vorlesung']['one_lecturer']['englisch'] = 'SFVe8e';
$config['survey_form']['vorlesung']['multiple_lecturers']['none'] = 'SFO_Vm8';
$config['survey_form']['vorlesung']['multiple_lecturers']['deutsch'] = 'SFVm8';
$config['survey_form']['vorlesung']['multiple_lecturers']['englisch'] = 'SFVm8e';

$config['survey_verify'] = '1';
$config['dispatch_report']='1';
$config['mail_instructor']='1';
$config['min_response']='99';
$config['survey_period'] = 'HS 2016'; //Semester, Datum anpassen
$config['sender_mail'] = 'admin@hochschuldidaktik.uzh.ch'; // change
$config['sender_name'] = 'Studienangebotsentwicklung UZH'; // change
$config['tasktype_1'] = 'dispatch_pswd';
$config['tasktype_2'] = 'remind_pswd';
$config['tasktype_3'] = 'response_rate_mail';
$config['tasktype_4'] = 'close_survey';
$config['taskdatetime_1'] = '2016-11-21 06:00'; // Umfrage starten, Datum anpassen
$config['taskdatetime_2'] = '2016-11-28 06:00'; // Umfrage Reminder, Datum anpassen
$config['taskdatetime_3'] = '2016-11-28 05:00'; // Rücklaufquote, Datum anpassen
$config['taskdatetime_4'] = '2016-12-05 05:00'; // Umfrage geschlossen, Datum anpassen
$config['taskmailtext_1'] = 'Liebe Studentin, lieber Student\n\n
Die Lehrveranstaltung "[COURSENAME]", die Sie gebucht haben, wird im Auftrag der verantwortlichen Dozentin, des verantwortlichen Dozenten im Herbstsemester 2016 evaluiert.
Wir möchten Sie freundlich bitten, sich kurz Zeit zu nehmen und den Online-Fragebogen auszufüllen.
Sie benötigen dafür etwa 10 Minuten.
Damit erhalten die Dozierenden unmittelbar Rückmeldungen zur Qualität ihrer Lehrveranstaltung und somit die Möglichkeit, ihre Lehrqualität zu optimieren.\n\n
Bitte folgen Sie dem untenstehenden Link zu Ihrem Fragebogen:\n[DIRECT_ONLINE_LINK]\n\n
Die Befragung erfolgt anonym. 
Bitte füllen Sie den Fragebogen bis Sonntag, 04. Dezember 2016 um 23.00 Uhr aus.\n\n
Herzlichen Dank für Ihre Unterstützung!\n\n\n
Freundliche Grüsse\n\n
Digitale Lehre und Forschung PhF / Studienangebotsentwicklung Universität Zürich';  //Datum anpassen
$config['taskmailtext_2'] = 'Liebe Studierende\nDies ist ein Reminder für die Umfrage zur Lehrveranstaltung &quot;[COURSENAME]&quot;.\n\n
Sollten Sie die Umfrage noch nicht ausgefüllt haben, folgen Sie bitte dem untenstehenden Link zu Ihrem Fragebogen:\n[DIRECT_ONLINE_LINK]\n\n
Bitte füllen Sie den Fragebogen bis Sonntag, 04. Dezember 2016 um 23.00 Uhr aus.\n\n
Freundliche Grüsse\n\nDigitale Lehre und Forschung PhF / Studienangebotsentwicklung Universität Zürich';
$config['taskmailsubject'] = 'Evaluation der Lehrveranstaltung [COURSENAME]';

/*
If TRUE: Add every lecturer as participant as well when generating XML import file.
If FALSE: Lecturers will not be imported as participants and not receive participant e-mails.
Workaround for informing lecturers about the state of their survey/evaluation,
slightly distorts return rate.
*/
$config['lecturers_as_participants'] = FALSE;

/* End of file standardwerte_config.php */
/* Location: ./application/config/standardwerte_config.php */
