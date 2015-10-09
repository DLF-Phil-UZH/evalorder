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
		<p>Gefundene Bestellungen: <?php echo $num_rows;?></p>
		<div id="bestellungen">
			<?php
			echo "<table id=\"bestellungen\">";
			echo "<tr class=\"zebra\"><th class=\"export\">Exportieren</th><th>Umfragetyp</th><th>Dozent(en)</th>";
			echo "<th>Name</th><th>Veranstaltungstyp</th><th>Semester</th>";
			echo "<th>TN-Liste 1</th>";
			echo "<th>TN-Liste 2</th></tr>";
			$rownumber = 0;
			while ($result = mysql_fetch_array($var)){
				$rownumber++;
				// Add different background color on every second row
				if($rownumber % 2 == 0){
					echo '<tr class="zebra">';
				}
				else{
					echo '<tr>';
				}
				echo "<td class=\"export\"><input type='checkbox' name='courses[]' value='$result[id]'></td><td>$result[surveyType]</td>";
				
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
				if($result['participantFile1']){
					echo "<td>$result[participantFile1]</td>";
				}
				else{
					echo "<td>";
					
					echo "<input type=\"text\" name=\"filecheck1\" id=\"filecheck1_$result[id]\" class=\"filecheck\" value=\"\">\n
						<input type=\"file\" id=\"fileselect1_$result[id]\" name=\"list1\"><br/>\n
						<button type=\"button\" id=\"uploadbutton1_$result[id]\" onclick=\"uploadList(1, $result[id]);\">Hochladen</button>\n
						<span id=\"filefeedback1_$result[id]\"></span>";
					
					echo "</td>";
				}
				
				if($result['participantFile2']){
					echo "<td>$result[participantFile2]</td></tr>";
				}
				else{
					echo "<td>";
					
					echo "<input type=\"text\" name=\"filecheck2\" id=\"filecheck2_$result[id]\" class=\"filecheck\" value=\"\">\n
						<input type=\"file\" id=\"fileselect2_$result[id]\" name=\"list2\"><br/>\n
						<button type=\"button\" id=\"uploadbutton2_$result[id]\" onclick=\"uploadList(2, $result[id]);\">Hochladen</button>\n
						<span id=\"filefeedback2_$result[id]\"></span>";
					
					echo "</td></tr>";
				}
				
			}
			echo "</table>";
			?>
		</div>
	</div>

<!-- End of file bestellungen.php -->
<!-- Location: ./application/views/bestellungen.php -->