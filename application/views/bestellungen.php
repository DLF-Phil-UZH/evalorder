<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
$this->load->database();

$dbhost = $this->db->hostname;
$dbuser = $this->db->username;
$dbpass = $this->db->password;
$dbname = $this->db->database;

mysqli_connect($dbhost, $dbuser, $dbpass);
mysql_select_db($dbname);
mysql_query("set names utf8");

$this->config->load('standardwerte_config');
$survey_period=$this->config->item('survey_period');

$query = "SELECT * FROM evalorder_courses WHERE semester='$survey_period'";

$var = mysql_query($query);
$num_rows = mysql_num_rows($var);

?>

	<div class="oliv_content">
		<p>Gefunden: <?php echo $num_rows;?></p>
		<?php
		echo "<table width='100%' border='1'>";
		echo "<tr><th style='width: 3%'></th><th style='width: 11%'>Umfragetyp</th><th style='width: 30%'>Dozent(en)</th>";
		echo "<th style='width: 20%'>Name</th><th style='width: 14%'>Veranstaltungstyp</th><th style='width: 10%'>Semester</th>";
		echo "<th style='width: 12%'>Teilnehmerliste</th></tr>";
		while ($result = mysql_fetch_array($var)){
			echo "<tr><td style='text-align: center;'><input type='checkbox' name='$result[id]' value='ausgewaehlt' id='check'></td><td>$result[surveyType]</td>";
			
			$query2  = "SELECT evalorder_lecturers.surname, evalorder_lecturers.firstname, evalorder_courses.name, evalorder_courses.id AS id FROM evalorder_lecturers INNER JOIN";
			$query2 .= " evalorder_courses_lecturers ON evalorder_lecturers.id = evalorder_courses_lecturers.lecturer_id INNER JOIN";
			$query2 .= " evalorder_courses ON evalorder_courses_lecturers.course_id = evalorder_courses.id";
			$var2 = mysql_query($query2);
			
			$dozenten = array();
			$i=1;

			while ($result2 = mysql_fetch_array($var2)){
				if ($result2['id']==$result['id']){
					$dozenten[$i] = $result2['firstname']." ".$result2['surname'];
					$i++;
				}
			}
			$comma_separated = implode(", ", $dozenten);
			echo "<td>$comma_separated</td>";
			
			echo "<td>$result[name]</td><td>$result[type]</td><td>$result[semester]</td>";
			if ($result['participantFile1']){echo "<td>$result[participantFile1]</td></tr>";}
			else {echo "<td><button type='button'>Hochladen</button></td></tr>";}
			
		}
		echo "</table>";
		?>
	</div>

<!-- End of file bestellungen.php -->
<!-- Location: ./application/views/bestellungen.php -->