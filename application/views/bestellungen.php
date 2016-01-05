<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
$this->load->database();

$dbhost = $this->db->hostname;
$dbuser = $this->db->username;
$dbpass = $this->db->password;
$dbname = $this->db->database;

$tableCourses = $this->config->item('table_courses');
$tableCoursesLecturers = $this->config->item('table_courses_lecturers');
$tableLecturers = $this->config->item('table_lecturers');

mysqli_connect($dbhost, $dbuser, $dbpass);
mysql_select_db($dbname);
mysql_query("set names utf8");

$this->config->load('standardwerte_config');
$survey_period=$this->config->item('survey_period');

$query = "SELECT * FROM " . $tableCourses . " WHERE semester='$survey_period'";

$var = mysql_query($query);
$num_rows = mysql_num_rows($var);

?>

	<div class="oliv_content">
		<p>Gefundene Bestellungen: <span class="bold"><?php echo $num_rows; ?></span></p>
		<p>Bestellungen f&uuml;r: <span class="bold"><?php echo $survey_period; ?></span></p>
		<div id="bestellungen">
			<?php echo form_open('admin/bestellungen'); ?>
				<?php
				echo "<table id=\"bestellungen_table\" class=\"tablesorter\">";
				echo "<thead>";
				echo "<tr class=\"even\"><th>Expor-<br/>tieren<span></span></th><th>Zuletzt exportiert<span></span></th><th>Bestellt am<span></span></th><th>Umfrage-<br/>typ<span></span></th><th>Dozent(en)<span></span></th>";
				echo "<th>Name<span></span></th><th>LV-Typ<span></span></th>";
				echo "<th>TN-Liste 1<span></span></th>";
				echo "<th>TN-Liste 2<span></span></th></tr>";
				echo "</thead>";
				echo "<tbody>";
				// $rownumber = 0;
				while ($result = mysql_fetch_array($var)){
					// $rownumber++;
					// Add different background color on every second row
					// if($rownumber % 2 == 0){
						// echo '<tr class="zebra">';
					// }
					// else{
						echo '<tr>';
					// }
					$surveyType = str_replace("umfrage", "", $result["surveyType"]); // Remove "umfrage" to save space
					echo "<td class=\"export\"><input type='checkbox' name='courses[]' value='$result[id]'></td><td>$result[lastExport]</td><td>$result[orderTime]</td><td>" . $surveyType . "</td>";
					
					$query2  = "SELECT " . $tableLecturers . ".surname, " . $tableLecturers . ".firstname, " . $tableCourses . ".name, " . $tableCourses . ".id AS id FROM " . $tableLecturers . " INNER JOIN";
					$query2 .= " " . $tableCoursesLecturers . " ON " . $tableLecturers . ".id = " . $tableCoursesLecturers . ".lecturer_id INNER JOIN";
					$query2 .= " " . $tableCourses . " ON " . $tableCoursesLecturers . ".course_id = " . $tableCourses . ".id";
					
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
					
					echo "<td>$result[name]</td><td>$result[type]</td>";
					
					// Participant list 1
					if($result["surveyType"] === "papierumfrage"){
						echo "<td>Keine Teilnehmerliste erforderlich (Papierumfrage).</td>";
					}
					else if($result['participantFile1']){
						echo "<td>$result[participantFile1]</td>";
					}
					else{
						echo "<td>";
						
						echo "<input type=\"text\" id=\"filecheck1_$result[id]\" class=\"filecheck\" value=\"\">\n
							<input type=\"file\" id=\"fileselect1_$result[id]\"><br/>\n
							<button type=\"button\" id=\"uploadbutton1_$result[id]\" class=\"uploadbutton\" onclick=\"uploadList(1, $result[id]);\">Hochladen</button>\n
							<span id=\"filefeedback1_$result[id]\"></span>";
						/*
						echo "<input type=\"text\" name=\"filecheck1\" id=\"filecheck1_$result[id]\" class=\"filecheck\" value=\"\">\n
							<input type=\"file\" id=\"fileselect1_$result[id]\" name=\"list1\"><br/>\n
							<button type=\"button\" id=\"uploadbutton1_$result[id]\" class=\"uploadbutton\" onclick=\"uploadList(1, $result[id]);\">Hochladen</button>\n
							<span id=\"filefeedback1_$result[id]\"></span>";
						*/
						
						echo "</td>";
					}
					
					// Participant list 2
					if($result["surveyType"] === "papierumfrage"){
						echo "<td>Keine Teilnehmerliste erforderlich (Papierumfrage).</td>";
					}
					else if($result['participantFile2']){
						echo "<td>$result[participantFile2]</td></tr>";
					}
					else{
						echo "<td>";
						
						echo "<input type=\"text\" id=\"filecheck2_$result[id]\" class=\"filecheck\" value=\"\">\n
							<input type=\"file\" id=\"fileselect2_$result[id]\"><br/>\n
							<button type=\"button\" id=\"uploadbutton2_$result[id]\" class=\"uploadbutton\" onclick=\"uploadList(2, $result[id]);\">Hochladen</button>\n
							<span id=\"filefeedback2_$result[id]\"></span>";
						
						/*
						echo "<input type=\"text\" name=\"filecheck2\" id=\"filecheck2_$result[id]\" class=\"filecheck\" value=\"\">\n
							<input type=\"file\" id=\"fileselect2_$result[id]\" name=\"list2\"><br/>\n
							<button type=\"button\" id=\"uploadbutton2_$result[id]\" class=\"uploadbutton\" onclick=\"uploadList(2, $result[id]);\">Hochladen</button>\n
							<span id=\"filefeedback2_$result[id]\"></span>";
						*/
						
						echo "</td></tr>";
					}
					
				}
				echo "</tbody>";
				echo "</table>";
				?>
			<?php
			echo "\n";
			echo form_submit('exportCourses', 'XML-Paket generieren und herunterladen');
			echo form_close();
			?>
		</div>
	</div>

<!-- End of file bestellungen.php -->
<!-- Location: ./application/views/bestellungen.php -->