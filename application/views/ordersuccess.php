<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

	<div class="oliv_content">
		<?php
		if(isset($access) && $access === true){ ?>
			
			<h2>Eva &ndash; Bestellung eingegangen</h2>
			
			<p>Vielen Dank f&uuml;r Ihre Bestellung!</p>
			<?php
			if(isset($nolists) && $nolists === TRUE){ ?>
				<p><span class="warning bold">Achtung:</span> Tragen Sie uns von der DLF umgehend als Besitzer in Ihren OLAT-Kurs ein, damit wir Ihre Teilnehmerlisten herunterladen k&ouml;nnen:</p>
				<ol>
					<li>Starten Sie den Kurs.</li>
					<li>Klicken Sie rechts auf <span class="techterm">Detailansicht</span>.</li>
					<li>Klicken Sie rechts auf <span class="techterm">Besitzer verwalten</span>.</li>
					<li>Klicken Sie nun auf <span class="techterm">Importieren</span>.</li>
					<li>Geben Sie <span class="techterm">schornoc</span> und <span class="techterm">sodok_elk</span> auf je einer eigenen Zeile ins Textfeld ein und klicken Sie auf <span class="techterm">Weiter</span>.</li>
					<li>Klicken Sie auf <span class="techterm">Fertigstellen</span>.</li>
				</ol>
			<?php }
			?>
			<p>Drucken Sie diese Seite aus oder speichern Sie sie als PDF ab; sie enth&auml;lt wichtige Informationen, wie weiter vorzugehen ist.</p>
			<h3>Zeitlicher Ablauf der Online-Evaluation</h3>
			<p>21. November 2016: E-Mail-Versand der Teilnahmelinks an die Studierenden</p>
			<p>28. November 2016: E-Mail-Versand einer Erinnerung an Studierende, die noch nicht an der Evaluation teilgenommen haben</p>
			<p>05. Dezember 2016: E-Mail-Versand der anonymisierten Ergebnisse an die Dozierenden
			Beachten Sie: Bei Online-Evaluationen k&ouml;nnen Ihre Studierenden die Sprache (deutsch/englisch) selber w&auml;hlen.</p>
			<!--<p>Jede(r) Dozierende erh&auml;lt ebenfalls per E-Mail einen Teilnahmelink und eine Teilnahmeerinnerung, damit er/sie informiert ist, sobald die Umfrage er&ouml;ffnet ist.</p>-->
			<h3>Zeitlicher Ablauf der Papier-Evaluation</h3>
			<p>Ab 21. November 2016: Versand des Fragebogens per Mail an die Dozierenden &ndash; Sie drucken die Frageb&ouml;gen selbst aus, lassen Sie in der Lehrveranstaltung ausf&uuml;llen und senden die ausgef&uuml;llten B&ouml;gen an die Studienangebotsentwicklung zur&uuml;ck.</p>
			<p>Die anonymisierten Ergebnisse werden ca. eine Woche nach Eingang der ausgefüllten Fragebögen per Mail durch die Studienangebotsentwicklung an Sie versendet.</p>
			<p class="bold">Bitte informieren Sie Ihre Studierenden rechtzeitig &uuml;ber die Evaluation und den Zeitplan.</p>
			<p><?php echo anchor('evalorderform', 'Ich m&ouml;chte eine weitere Bestellung aufgeben.', 'class="buttonlike"'); ?></p>
		
		<?php }
		else{ ?>
			<p>Sie m&uuml;ssen sich anmelden, um auf Eva zugreifen zu k&ouml;nnen: <a href="<?php echo site_url('auth'); ?>">Anmelden</a>.</p>
		<?php } ?>
	</div>

<!-- End of file ordersuccess.php -->
<!-- Location: ./application/views/ordersuccess.php -->