<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

	<div class="oliv_content">
		<?php
			if(isset($access) && $access === true){ ?>
			
			<h2>Eva &ndash; Download der XML-Importdatei</h2>
			
			<?php
				if(isset($xmlError) && strlen($xmlError) > 0){
					echo '<p style="color: red;">' . $xmlError . '</p>';
				}
				if(isset($xmlFilename) && strlen($xmlFilename) > 0){
					
					echo '<a href="' . site_url('admin/xmldownload') . '/' . $xmlFilename . '" class="buttonlike buttononly">XML-Importdatei herunterladen</a><br/>';
					
				}
				
				echo '<a href="' . site_url('admin/bestellungen') . '" class="buttonlike buttononly">Zur&uuml;ck zur Bestellungs&uuml;bersicht</a>';
			
			}
		else{ ?>
			<p>Sie m&uuml;ssen sich anmelden, um auf Eva zugreifen zu k&ouml;nnen: <a href="<?php echo site_url('auth'); ?>">Anmelden</a>.</p>
		<?php } ?>
	</div>

<!-- End of file ordersuccess.php -->
<!-- Location: ./application/views/ordersuccess.php -->