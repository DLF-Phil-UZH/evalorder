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
			
			<?php // echo form_open_multipart('evalorderform'); ?>

			<!--
			<h2>Lehrveranstaltung</h2>
			
			<table>
				<tbody>
					<tr>
						<td><?php // echo form_label('Name', 'lehrveranstaltung'); ?></td>
						<td><input type="text" <?php // echo produceNameIDTags('lehrveranstaltung'); ?> value="<?php // echo setEncodedValue('lehrveranstaltung'); ?>" size="50" /></td>
					</tr>
					<tr>
						<td><?php // echo form_label('Typ (&quot;Kategorie&quot; im <a target="_blank" href="http://www.vorlesungen.uzh.ch/">Vorlesungsverzeichnis</a>)', 'typ_lehrveranstaltung'); ?></td>
						<td>
							<select <?php // echo produceNameIDTags('typ_lehrveranstaltung'); ?>>
								<option value="vorlesung" <?php // echo set_select('typ_lehrveranstaltung', 'vorlesung'); ?> >Vorlesung</option>
								<option value="uebung" <?php // echo set_select('typ_lehrveranstaltung', 'uebung'); ?> >&Uuml;bung</option>
								<option value="seminar" <?php // echo set_select('typ_lehrveranstaltung', 'seminar'); ?> >Seminar</option>
								<option value="kolloquium" <?php // echo set_select('typ_lehrveranstaltung', 'kolloquium'); ?> >Kolloquium</option>
							</select>
						</td>
					</tr>
				</tbody>
			</table>
			-->

			<!--
			<h2>Dozierende</h2>
			-->
			
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
			
			<!--
			<h2>Umfrage</h2>
			
			<table>
				<tbody>
					<tr>
						<td>Gew&uuml;nschte Umfrageart</td>
						<td>
							<input type="radio" value="onlineumfrage" id="onlineumfrage" name="umfrageart" onclick="showHideUmfrageart()" <?php // echo set_radio('umfrageart', 'onlineumfrage'); ?> ><?php // echo form_label('Online (Automatischer Versand eines Teilnahmelinks an Studierende per E-Mail)', 'onlineumfrage'); ?><br/>
							<input type="radio" value="papierumfrage" id="papierumfrage" name="umfrageart" onclick="showHideUmfrageart()" <?php // echo set_radio('umfrageart', 'papierumfrage'); ?> ><?php // echo form_label('Papier (Austeilen von gedruckten Frageb&ouml;gen in einer Sitzung durch die Dozierenden)', 'papierumfrage'); ?>
						</td>
					</tr>
					<tr id="teilnehmerdatei_tr">
						<td colspan="2"><?php // echo form_label('XLS-Teilnehmerdatei aus OLAT (<a href="">>> Anleitung zum Herunterladen Ihrer Teilnehmerliste</a>)', 'teilnehmerdatei'); ?><input type="file" <?php // echo produceNameIDTags('teilnehmerdatei'); ?> size="50"></td>
					</tr>
					<tr id="teilnehmeranzahl_tr">
						<td colspan="2"><?php // echo form_label('Anzahl Teilnehmer', 'teilnehmeranzahl'); ?><input type="text" <?php // echo produceNameIDTags('teilnehmeranzahl'); ?> value="<?php // echo setEncodedValue('teilnehmeranzahl'); ?>" size="4" maxlength="4"></td>
					</tr>
				</tbody>
			</table>
			
			<div><input type="submit" value="Bestellen" /></div>
			-->
			
			</form>
			
			<!-- JQuery Steps -->
			<?php $attributes = array('id' => 'evalorderform'); ?>
			<?php echo form_open_multipart('evalorderform', $attributes); ?>
			<!-- <form id="evalorderform_new" action="#"> -->
				<div>
					<h2>Lehrveranstaltung</h2>
					<section>
						<label for="lehrveranstaltung" class="labelasheading">Name</label>
						<p class="explanation">Kopieren Sie m&ouml;glichst den genauen Namen Ihrer Lehrveranstaltung aus dem <a href="http://www.vorlesungen.uzh.ch/" target="_blank">Vorlesungsverzeichnis</a> oder <a href="https://www.olat.uzh.ch/" target="_blank">OLAT</a>.</p>
						<input id="lehrveranstaltung" name="lehrveranstaltung" type="text">
					</section>
					<h2>Dozierende</h2>
					<section>
						<input type="hidden" <?php echo produceNameIDTags('anzahlDozenten'); ?> value="<?php echo set_value('anzahlDozenten', '0'); ?>">
			
						<!-- Invisible template for one lecturer (Dozent), will be reproduced in browser at least once by Javascript -->
						<div id="dozent_" class="dozent_template">
							<h3></h3>
							<table>
								<tbody>
									<tr>
										<td class="inputlabel"><?php echo form_label('Nachname', 'nachname_dozent_'); ?></td>
										<td><input type="text" <?php echo produceNameIDTags('nachname_dozent_'); ?> size="50"/></td>
									</tr>
									<tr>
										<td class="inputlabel"><?php echo form_label('Vorname', 'vorname_dozent_'); ?></td>
										<td><input type="text" <?php echo produceNameIDTags('vorname_dozent_'); ?> size="50"/></td>
									</tr>
									<tr>
										<td class="inputlabel">Geschlecht</td>
										<td>
											<input type="radio" value="maennlich" id="dozent_maennlich_" name="geschlecht_dozent_" <?php echo set_radio('geschlecht_dozent_', 'maennlich'); ?> >
											<label for="dozent_maennlich_" class="notlast">m&auml;nnlich</label><?php // echo form_label('m&auml;nnlich', 'dozent_maennlich_'); ?>
											<input type="radio" value="weiblich" id="dozent_weiblich_" name="geschlecht_dozent_" <?php echo set_radio('geschlecht_dozent_', 'weiblich'); ?> >
											<label for="dozent_weiblich_">weiblich</label><?php // echo form_label('weiblich', 'dozent_weiblich_'); ?>
										</td>
									</tr>
									<tr>
										<td class="inputlabel"><?php echo form_label('Titel', 'titel_dozent_'); ?></td>
										<td><input type="text" <?php echo produceNameIDTags('titel_dozent_'); ?> size="50"/></td>
									</tr>
									<tr>
										<td class="inputlabel"><?php echo form_label('E-Mail-Adresse', 'email_dozent_'); ?></td>
										<td><input type="text" <?php echo produceNameIDTags('email_dozent_'); ?> size="50"/></td>
									</tr>
								</tbody>
							</table>
						</div>
						
						<!-- Does not trigger form submission -->
						<div class="buttonline">
							<button type="button" id="addDozent" onclick="addDozenten(1)">Weitere dozierende Person hinzuf&uuml;gen</button>
							<button type="button" id="removeDozent" onclick="removeLastDozent()">Letzte dozierende Person l&ouml;schen</button>
						</div>
						
					</section>
					<h2>Evaluation</h2>
					<section>
						<h3>Art der Evaluation</h3>
						<table>
							<tbody>
								<tr>
									<!-- <td>Art der Evaluation</td> -->
									<td>
										<input type="radio" value="onlineumfrage" id="onlineumfrage" name="umfrageart" onclick="showHideUmfrageart(); setNumberOfLists(1);" <?php echo set_radio('umfrageart', 'onlineumfrage'); ?> ><label for="onlineumfrage" class="notlast">Online: automatischer E-Mail-Versand von Teilnahmelinks an Studierende</label><?php // echo form_label('Online (Automatischer Versand eines Teilnahmelinks an Studierende per E-Mail)', 'onlineumfrage'); ?><br/>
										<input type="radio" value="papierumfrage" id="papierumfrage" name="umfrageart" onclick="showHideUmfrageart(); setNumberOfLists(0);" <?php echo set_radio('umfrageart', 'papierumfrage'); ?> ><label for="papierumfrage">Papier: Post-Versand von Frageb&ouml;gen (PDF); Sie drucken aus und senden die ausgef&uuml;llten B&ouml;gen zur Auswertung zur&uuml;ck</label><?php // echo form_label('Papier (Austeilen von gedruckten Frageb&ouml;gen in einer Sitzung durch die Dozierenden)', 'papierumfrage'); ?>
									</td>
								</tr>
								<!--
								<tr id="teilnehmerdatei_tr">
									<td colspan="2"><?php // echo form_label('XLS-Teilnehmerdatei aus OLAT (<a href="">>> Anleitung zum Herunterladen Ihrer Teilnehmerliste</a>)', 'teilnehmerdatei'); ?><input type="file" <?php // echo produceNameIDTags('teilnehmerdatei'); ?> size="50"></td>
								</tr>
								<tr id="teilnehmeranzahl_tr">
									<td colspan="2"><?php // echo form_label('Anzahl Teilnehmer', 'teilnehmeranzahl'); ?><input type="text" <?php // echo produceNameIDTags('teilnehmeranzahl'); ?> value="<?php // echo setEncodedValue('teilnehmeranzahl'); ?>" size="4" maxlength="4"></td>
								</tr>
								-->
							</tbody>
						</table>
						
						<h3 class="notfirst">Typ der Lehrveranstaltung</h3>
						<input type="radio" value="seminar" id="lvtyp_seminar" name="lvtyp">
						<label for="lvtyp_seminar" class="notlast">Seminar</label>
						<input type="radio" value="praktikum" id="lvtyp_praktikum" name="lvtyp">
						<label for="lvtyp_praktikum" class="notlast">Praktikum</label>
						<input type="radio" value="vorlesung" id="lvtyp_vorlesung" name="lvtyp">
						<label for="lvtyp_vorlesung" class="notlast">Vorlesung</label>
						<input type="radio" value="uebung" id="lvtyp_uebung" name="lvtyp">
						<label for="lvtyp_uebung">&Uuml;bung</label>
						
						<h3 class="notfirst">Sprache</h3>
						<input type="radio" value="deutsch" id="sprache_deutsch" name="sprache">
						<label for="sprache_deutsch" class="notlast">Deutsch</label>
						<input type="radio" value="englisch" id="sprache_englisch" name="sprache">
						<label for="sprache_englisch" class="notlast">Englisch</label>
						<input type="radio" value="italienisch" id="sprache_italienisch" name="sprache">
						<label for="sprache_italienisch">Italienisch</label>
						
						<h3 class="notfirst">Vorschau Fragebogen</h3>
						<p>Bild x (zum Vergr&ouml;ssern anklicken)</p>
					</section>
					<h2>Teilnehmer</h2>
					<section>

						<div id="teilnehmerdatei_tr">
							<h3>Teilnehmerlisten</h3>
							<p>Sie haben drei M&ouml;glichkeiten:</p>
							<div id="filenumber_block">
								<?php //echo form_label('XLS-Teilnehmerdatei aus OLAT (<a href="">>> Anleitung zum Herunterladen Ihrer Teilnehmerliste</a>)', 'teilnehmerdatei'); ?><!--<input type="file" <?php // echo produceNameIDTags('teilnehmerdatei'); ?> size="50">-->
								<!-- Number of lists to upload -->
								<input type="radio" name="filenumber" id="nofiles" value="Keine Teilnehmerliste(n) hochladen" onclick="setNumberOfLists(0);">
								<label for="nofiles" class="notlast"><span class="bold">Keine Teilnehmerlisten hochladen:</span> Laden Sie keine Teilnehmerliste hoch, aber tragen daf&uuml;r <i>schornoc</i>, <i>sodok_elk</i> und <i>shodel_elk</i> als Besitzer in Ihren OLAT-Kurs ein (&gt;&gt; <i>Detailansicht</i> &gt;&gt; <i>Besitzer verwalten</i> &gt;&gt; <i>Importieren</i> &gt;&gt; die drei Namen je auf eine Zeile &gt;&gt; <i>Weiter</i> &gt;&gt; <i>Abschliessen</i>).</label>
								<br/>
								<input type="radio" name="filenumber" id="file1" value="file1enable" onclick="setNumberOfLists(1);">
								<label for="file1" class="notlast"><span class="bold">1 Liste hochladen:</span> Laden Sie die Teilnehmerliste aus der Campusgruppe A hoch, falls Ihre Auditoren <i>nicht</i> an der Evaluation teilnehmen sollen.</label>
								<br/>
								<input type="radio" name="filenumber" id="file2" value="file2enable" onclick="setNumberOfLists(2);">
								<label for="file2"><span class="bold">2 Listen hochladen:</span> Laden Sie die Teilnehmerliste aus der Campusgruppe A und B hoch, falls Ihre Auditoren an der Evaluation teilnehmen sollen.</label>
							</div>
							
							<!-- List 1 -->
							<div class="fileupload_block">
								<input type="text" name="filecheck1" id="filecheck1" class="filecheck" value="">
								<input type="file" id="fileselect1" name="list1">
								<button type="button" id="uploadbutton1" class="uploadbutton" onclick="uploadList(1);">Hochladen</button>
								<span id="filefeedback1"></span>
							</div>
							
							<!-- List 2 -->
							<div class="fileupload_block">
								<input type="text" name="filecheck2" id="filecheck2" class="filecheck" value="">
								<input type="file" id="fileselect2" name="list2">
								<button type="button" id="uploadbutton2" class="uploadbutton" onclick="uploadList(2);">Hochladen</button>
								<span id="filefeedback2"></span>
							</div>
							
						</div>
						
						<div id="teilnehmeranzahl_tr">
							<label for="lehrveranstaltung" class="labelasheading">Ungef&auml;hre Anzahl Studierender</label>
							<?php // echo form_label('Ungef&auml;hre Anzahl Studierender', 'teilnehmeranzahl'); ?><input type="text" <?php echo produceNameIDTags('teilnehmeranzahl'); ?> value="<?php echo setEncodedValue('teilnehmeranzahl'); ?>" size="4" maxlength="4">
						</div>

					</section>
				</div>
			</form>
			
			<!-- JQuery Steps -->
			<script type="text/javascript">
				var form = $("#evalorderform");
				form.children("div").steps({
					headerTag: "h2",
					bodyTag: "section",
					transitionEffect: "slideLeft",
					onStepChanging: function (event, currentIndex, newIndex)
					{
						// Allways allow step back to the previous step even if the current step is not valid!
						if(currentIndex > newIndex)
						{
							return true;
						}
						form.validate().settings.ignore = ":disabled,:hidden";
						return form.valid();
					},
					onFinishing: function (event, currentIndex)
					{
						form.validate().settings.ignore = ":disabled";
						return form.valid();
					},
					onFinished: function (event, currentIndex)
					{
						form.submit();
						alert("Submitted!");
					},
					/* Labels in german */
					labels: {
						cancel: "Abbrechen",
						current: "Aktueller Schritt",
						pagination: "Pagination",
						finish: "Abschliessen",
						next: "Weiter",
						previous: "Zurück",
						loading: "Lädt..."
					}
				});
				form.validate({
					errorPlacement: function errorPlacement(error, element) { element.before(error); },
					rules: {
						// Step 1
						lehrveranstaltung: {
							required: true
						},
						// Step 2
						// Handled in orderform.js, dynamic addition and deletion of validation rules for lecturers
						// Step 3
						sprache: {
							required: true
						},
						lvtyp: {
							required: true
						},
						umfrageart: {
							required: true
						},
						// Step 4: Result(s) of list check (online surveys)
						filecheck1: {
							required: true
							// equals: "success"
						},
						filecheck2: {
							required: true
							// equals: "success"
						},
						// Step 4: Participant number (paper surveys)
						teilnehmeranzahl: {
							required: true,
							number: true,
							min: 10
						}
					}
				});
				
			</script>
			
		<?php }
		else{ ?>
			<p>Sie m&uuml;ssen sich anmelden, um auf EvalOrder zugreifen zu k&ouml;nnen: <a href="<?php echo site_url('auth'); ?>">Anmelden</a>.</p>
		<?php } ?>
	</div>

<!-- End of file orderform.php -->
<!-- Location: ./application/views/orderform.php -->