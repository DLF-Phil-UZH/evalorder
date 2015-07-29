<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

	<div class="oliv_content">
		<?php
		if(isset($access) && $access === true){ ?>
			
			<h2>Bestellung einer Evaluation Ihrer Lehrveranstaltung</h2>

			<p>Bestellen Sie hier bequem f&uuml;r Ihre Lehrveranstaltung an [der Philosophischen Fakult&auml;t] der Universit&auml;t Z&uuml;rich eine Evaluation, die wir f&uuml;r Sie zusammen mit der Hochschuldidaktik &uuml;ber die Evaluationssoftware EvaSys abwickeln.</p>
			<p>F&uuml;llen Sie dazu alle Felder komplett und korrekt (gem&auml;ss den Angaben aus dem <a target="_blank" href="http://www.vorlesungen.uzh.ch/">Vorlesungsverzeichnis</a>) aus, um einen reibungs- und fehlerlosen Ablauf der Evaluation zu gew&auml;hrleisten.</p>
			<p><strong>Wichtig:</strong> Damit eine Evaluation g&uuml;ltig ist, ist ein R&uuml;cklauf von mindestens 10 Studierenden Voraussetzung. Bei einer kleineren Anzahl Studierenden empfiehlt es sich eher, eine papierbasierte Umfrage durchzuf&uuml;hren, weil die R&uuml;cklaufquote in einer Sitzung erfahrungsgem&auml;ss h&ouml;her ausf&auml;llt und so die Chancen auf die Mindestanzahl h&ouml;her sind. Bei einer gen&uuml;gend grossen Anzahl Studierenden raten wir zu einer Online-Umfrage, da diese f&uuml;r Sie und die Studierenden komfortabel auf digitalem Weg abgewickelt wird.</p>

			<h3>Zeitlicher Ablauf</h3>

			<p>Bestellungen k&ouml;nnen bis am xx.xx.2015 &uuml;ber dieses Formular aufgegeben werden.</p>
			<p>Falls Sie Ihre Evaluation online durchf&uuml;hren m&ouml;chten, werden am xx.xx.2015 die Teilnahmelinks an alle Studierenden per E-Mail verschickt.<br/>Am xx.xx.2015 wird eine Erinnerung per E-Mail an diejenigen Studierenden geschickt, die noch nicht an der Evaluation teilgenommen haben.<br/>Am xx.xx.2015 um xx.xx Uhr wird die Evaluation geschlossen und ausgewertet. Die Dozierenden erhalten anschliessend die anonymisierten Ergebnisse per E-Mail zugeschickt.</p>
			<p>Falls Sie Ihre Evaluation papierbasiert durchf&uuml;hren m&ouml;chten, werden Sie am xx.xx.2015 mit der angegebenen Anzahl Umfrageb&ouml;gen durch die Hochschuldidaktik ausgestattet, die Sie in einer Ihrer Sitzungen an die Studierenden austeilen, ausgef&uuml;llt wieder einsammeln und an die Hochschuldidaktik retournieren.<br/>Sp&auml;testens am xx.xx.2015 werden Ihnen die anonymisierten Ergebnisse durch die Hochschuldidaktik zugestellt.</p>

			<?php
			// Display errors from text/option inputs
			echo validation_errors();
			?>
			
			<?php
			// Display errors from file upload if available
			if(isset($uploadError) && is_array($uploadError) === TRUE){
				foreach($uploadError as $errorElement){
					echo $errorElement;
				}
			}
			?>
			
			<?php echo form_open_multipart('evalorderform'); ?>

			<h2>Lehrveranstaltung</h2>
			
			<table>
				<tbody>
					<tr>
						<td><?php echo form_label('Name', 'lehrveranstaltung'); ?></td>
						<td><input type="text" <?php echo produceNameIDTags('lehrveranstaltung'); ?> value="<?php echo setEncodedValue('lehrveranstaltung'); ?>" size="50" /></td>
					</tr>
					<tr>
						<td><?php echo form_label('Typ (&quot;Kategorie&quot; im <a target="_blank" href="http://www.vorlesungen.uzh.ch/">Vorlesungsverzeichnis</a>)', 'typ_lehrveranstaltung'); ?></td>
						<td>
							<select <?php echo produceNameIDTags('typ_lehrveranstaltung'); ?>>
								<option value="vorlesung" <?php echo set_select('typ_lehrveranstaltung', 'vorlesung'); ?> >Vorlesung</option>
								<option value="uebung" <?php echo set_select('typ_lehrveranstaltung', 'uebung'); ?> >&Uuml;bung</option>
								<option value="seminar" <?php echo set_select('typ_lehrveranstaltung', 'seminar'); ?> >Seminar</option>
								<option value="kolloquium" <?php echo set_select('typ_lehrveranstaltung', 'kolloquium'); ?> >Kolloquium</option>
							</select>
						</td>
					</tr>
				</tbody>
			</table>

			<h2>Dozierende</h2>
			
			<input type="hidden" <?php echo produceNameIDTags('anzahlDozenten'); ?> value="<?php echo set_value('anzahlDozenten', '0'); ?>">
			
			<!-- Invisible template for one lecturer (Dozent), will be reproduced in browser at least once by Javascript -->
			<div id="dozent_" class="dozent_template">
				<h3></h3>
				<table>
					<tbody>
						<tr>
							<td><?php echo form_label('Nachname', 'nachname_dozent_'); ?></td>
							<td><input type="text" <?php echo produceNameIDTags('nachname_dozent_'); ?> size="50"/></td>
						</tr>
						<tr>
							<td><?php echo form_label('Vorname', 'vorname_dozent_'); ?></td>
							<td><input type="text" <?php echo produceNameIDTags('vorname_dozent_'); ?> size="50"/></td>
						</tr>
						<tr>
							<td>Geschlecht</td>
							<td>
								<input type="radio" value="maennlich" id="dozent_maennlich_" name="geschlecht_dozent_" <?php echo set_radio('geschlecht_dozent_', 'maennlich'); ?> ><?php echo form_label('m&auml;nnlich', 'dozent_maennlich_'); ?>
								<input type="radio" value="weiblich" id="dozent_weiblich_" name="geschlecht_dozent_" <?php echo set_radio('geschlecht_dozent_', 'weiblich'); ?> ><?php echo form_label('weiblich', 'dozent_weiblich_'); ?>
							</td>
						</tr>
						<tr>
							<td><?php echo form_label('Titel', 'titel_dozent_'); ?></td>
							<td><input type="text" <?php echo produceNameIDTags('titel_dozent_'); ?> size="50"/></td>
						</tr>
						<tr>
							<td><?php echo form_label('E-Mail-Adresse', 'email_dozent_'); ?></td>
							<td><input type="text" <?php echo produceNameIDTags('email_dozent_'); ?> size="50"/></td>
						</tr>
					</tbody>
				</table>
			</div>
			
			<!-- If form inputs have been submitted and must be revised, repopulate all lecturer elements with data -->
			<?php 
			$submittedDozenten = set_value('anzahlDozenten', '0');
			for($dozent = 1; $dozent <= $submittedDozenten; $dozent++){
			?>
			<div id="<?php echo 'dozent_' . $dozent; ?>">
				<h3><?php echo 'DozentIn ' . $dozent; ?></h3>
				<table>
					<tbody>
						<tr>
							<td><?php echo form_label('Nachname', 'nachname_dozent_' . $dozent); ?></td>
							<td><input type="text" <?php echo produceNameIDTags('nachname_dozent_' . $dozent); ?> value="<?php echo setEncodedValue('nachname_dozent_' . $dozent, ''); ?>" size="50"/></td>
						</tr>
						<tr>
							<td><?php echo form_label('Vorname', 'vorname_dozent_' . $dozent); ?></td>
							<td><input type="text" <?php echo produceNameIDTags('vorname_dozent_' . $dozent); ?> value="<?php echo setEncodedValue('vorname_dozent_' . $dozent, ''); ?>" size="50"/></td>
						</tr>
						<tr>
							<td>Geschlecht</td>
							<td>
								
								<input type="radio" value="maennlich" id="<?php echo 'dozent_maennlich_' . $dozent; ?>" name="<?php echo 'geschlecht_dozent_' . $dozent; ?>" <?php echo set_radio('geschlecht_dozent_' . $dozent, 'maennlich'); ?> ><?php echo form_label('m&auml;nnlich', 'dozent_maennlich_' . $dozent); ?>
								<input type="radio" value="weiblich" id="<?php echo 'dozent_weiblich_' . $dozent; ?>" name="<?php echo 'geschlecht_dozent_' . $dozent; ?>" <?php echo set_radio('geschlecht_dozent_' . $dozent, 'weiblich'); ?> ><?php echo form_label('weiblich', 'dozent_weiblich_' . $dozent); ?>
							</td>
						</tr>
						<tr>
							<td><?php echo form_label('Titel', 'titel_dozent_' . $dozent); ?></td>
							<td><input type="text" <?php echo produceNameIDTags('titel_dozent_' . $dozent); ?> value="<?php echo setEncodedValue('titel_dozent_' . $dozent, ''); ?>" size="50"/></td>
						</tr>
						<tr>
							<td><?php echo form_label('E-Mail-Adresse', 'email_dozent_' . $dozent); ?></td>
							<td><input type="text" <?php echo produceNameIDTags('email_dozent_' . $dozent); ?> value="<?php echo setEncodedValue('email_dozent_' . $dozent, ''); ?>" size="50"/></td>
						</tr>
					</tbody>
				</table>
			</div>
			<?php
			}
			
			?>
			
			<!-- Does not trigger form submission -->
			<button type="button" id="addDozent" onclick="addDozenten(1)">Dozent(in) hinzuf&uuml;gen</button>
			<button type="button" id="removeDozent" onclick="removeLastDozent()">Letzte(n) Dozent(in) l&ouml;schen</button>
			
			<h2>Umfrage</h2>
			
			<table>
				<tbody>
					<tr>
						<td>Gew&uuml;nschte Umfrageart</td>
						<td>
							<input type="radio" value="onlineumfrage" id="onlineumfrage" name="umfrageart" onclick="showHideUmfrageart()" <?php echo set_radio('umfrageart', 'onlineumfrage'); ?> ><?php echo form_label('Online (Automatischer Versand eines Teilnahmelinks an Studierende per E-Mail)', 'onlineumfrage'); ?><br/>
							<input type="radio" value="papierumfrage" id="papierumfrage" name="umfrageart" onclick="showHideUmfrageart()" <?php echo set_radio('umfrageart', 'papierumfrage'); ?> ><?php echo form_label('Papier (Austeilen von gedruckten Frageb&ouml;gen in einer Sitzung durch die Dozierenden)', 'papierumfrage'); ?>
						</td>
					</tr>
					<tr id="teilnehmerdatei_tr">
						<td colspan="2"><?php echo form_label('XLS-Teilnehmerdatei aus OLAT (<a href="">>> Anleitung zum Herunterladen Ihrer Teilnehmerliste</a>)', 'teilnehmerdatei'); ?><input type="file" <?php echo produceNameIDTags('teilnehmerdatei'); ?> size="50"></td>
					</tr>
					<tr id="teilnehmeranzahl_tr">
						<td colspan="2"><?php echo form_label('Anzahl Teilnehmer', 'teilnehmeranzahl'); ?><input type="text" <?php echo produceNameIDTags('teilnehmeranzahl'); ?> value="<?php echo setEncodedValue('teilnehmeranzahl'); ?>" size="4" maxlength="4"></td>
					</tr>
				</tbody>
			</table>
			
			<div><input type="submit" value="Bestellen" /></div>

			</form>
		<?php }
		else{ ?>
			<p>Sie m&uuml;ssen sich anmelden, um auf EvalOrder zugreifen zu k&ouml;nnen: <a href="<?php echo site_url('auth'); ?>">Anmelden</a>.</p>
		<?php } ?>
	</div>

<!-- End of file orderform.php -->
<!-- Location: ./application/views/orderform.php -->