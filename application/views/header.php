<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php echo doctype('html5'); ?>
<html>
    <head>
        <title><?php echo $title; ?></title>
		<?php
		echo meta('Content-type', 'text/html; charset=utf-8', 'equiv');
		echo meta('description', 'Eva');
		echo link_tag(base_url('/assets/css/jquerysteps_modified.css')); // JQuery Steps, https://www.jquery-steps.com/Content/Examples?v=zY_RpLQAM_2YuBnTHKA2t9GIGyqXY4KhLU1OJRLrY8M1
		echo link_tag(base_url('/assets/css/jquery.fancybox.css')); // JQuery Fancybox
		echo link_tag(base_url('/assets/css/jquery.fancybox-thumbs.css')); // JQuery Fancybox Thumbnails
		echo link_tag(base_url('/assets/css/uzh.css')); // UZH standard, lower priority
		echo link_tag(base_url('/assets/css/oliv-common.css')); // Higher priority, customized
		if(isset($scripts)){
			foreach($scripts as $tag){
				echo '<script';
				if(isset($tag['type']) && is_string($tag['type']) && strlen($tag['type']) > 0){
					echo ' type="' . $tag['type'] . '"';
				}
				if(isset($tag['src']) && is_string($tag['src']) && strlen($tag['src']) > 0){
					echo ' src="' . $tag['src'] . '"';
				}
				echo '>';
				if(isset($tag['content']) && is_string($tag['content']) && strlen($tag['content']) > 0){
					echo $tag['content'];
				}
				echo '</script>';
			}
		}
		?>
   	</head>
    <body>
		<?php
			if(isset($width) && strcmp($width, 'small') === 0){
				echo '<div class="bodywidthsmall">'; // small body
			}
			else{
				echo '<div class="bodywidth">'; // allover body
			}
		?>
			<div id="topline">
                <?php
                if (isset($logged_in) && $logged_in) { 
                    echo '<p id="logout"><a href="' /* . site_url('/auth/logout') */ . '" >Abmelden</a></p>';
                } ?>
				<p>Evaluationsbestellung</p>
            </div>
			<div class="floatclear">
			</div>
			<div id="headerarea">
				<div id="uzhlogo">
					<a href="http://www.uzh.ch">
						<img alt="uzh logo" height="80" src="<?php echo base_url('/assets/images/uzh_logo_d_pos_web_main.jpg'); ?>" width="231" />
					</a>
                </div>
				<div id="olivlogo">
					<a href="http://www.phil.uzh.ch/fakultaet/dlf.html">
						<img alt="eva logo" height="80" src="<?php echo base_url('/assets/images/eva.gif'); ?>" width="133" />
					</a>
                </div>
               	<h1 style="clear:both">
					<a href="<?php echo site_url('welcome'); ?>">Eva</a>
				</h1>
			</div>
			<div class="floatclear">
			</div>
			<div class="endheaderline">
			</div>
			<?php
				if(isset($admin) && $admin === true){ ?>
					<div id="primarnav">
					<a class="namedanchor" name="primarnav"><!----></a>
					<?php
					if(strcmp($page, 'bestellungen') === 0){ ?>
						<a class="active" href="<?php echo site_url('admin/bestellungen'); ?>">Bestellungen</a>
					<?php }
					else{ ?>
						<a href="<?php echo site_url('admin/bestellungen'); ?>">Bestellungen</a>
					<?php } ?>
					<div class="linkseparator">&#8226;</div>
					<?php
					if(strcmp($page, 'standardwerte') === 0){ ?>
						<a class="active" href="<?php echo site_url('admin/standardwerte'); ?>">Standardwerte</a>
					<?php }
					else{ ?>
						<a href="<?php echo site_url('admin/standardwerte'); ?>">Standardwerte</a>
					<?php } ?>
					</div>
				<?php } ?>
			<div class="floatclear">
			</div>

<!-- End of file header.php -->
<!-- Location: ./application/views/header.php -->
