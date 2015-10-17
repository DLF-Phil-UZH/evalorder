<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

	<div class="oliv_content">
		<h2>Willkommen auf Eva</h2>
		<?php
		if(isset($access) && $access === true){ ?>
			<p>Willkommen auf Eva</p>
		<?php }
		else{ ?>
			<p>Sie müssen sich anmelden, um auf Eva zugreifen zu können. <a href="<?php echo site_url('auth'); ?>">Anmelden</a>.</p>
		<?php } ?>
	</div>

<!-- End of file welcome_message.php -->
<!-- Location: ./application/views/welcome_message.php -->