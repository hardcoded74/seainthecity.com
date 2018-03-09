<?php

/*
 * Copyright 2010, Maintain Fit LLC, Daniel Watrous, All rights reserved
 * By using this software you agree to be bound by the terms
 * outlined in the License.txt file included with the software.
 *
 * If you still have questions please send them to helpdesk@danielwatrous.com
 *
 */

if ('authnet_render_log_file.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('<h2>'.__('Direct File Access Prohibited','authnet').'</h2>');

$link_to_log_file = WP_PLUGIN_DIR. '/'. plugin_basename(dirname(__FILE__)) . '/authnet_log.php';

$log_content = file_get_contents( $link_to_log_file );
$log_content = esc_textarea( $log_content );	

?>
<link rel="stylesheet" type="text/css" href="<?php echo get_plugin_url_authnet(); ?>/style.css" media="all" />

	<div class="wrap">
		
		<h2>Authorize.net for WordPress Log View</h2>
<?php
                 // Display warning message if plugin is being used without SSL installed
                echo get_use_ssl_warning('admin_page');
?>
		<div class="Settings-wrap">
			<div class="info-box">
				<div class="info-content">
                    All transaction processing is logged in Authorize.net for WordPress. Below you can view the log file and get additional details about Authorize.net responses and statuses. Information in the log below may also be useful when submitting help requests through the support desk.
				</div>
				<div class="Owner">
                    This plugin was created by <a href="http://www.danielwatrous.com">Daniel Watrous</a>. Step by step videos are available on the <a href="http://www.danielwatrous.com/authorizenet-for-wordpress/plugin-training">training page</a>.
				</div>
			</div>
			<div class="settings-header">
				<ul>
					<li>
						<span>Log View</span>
					</li>
				</ul>
			</div>
			<div class="settings-container">
				<div id="log-container">
					<textarea cols="70" rows="25" name="log-content" id="log-content" tabindex="1" readonly><?php echo $log_content ?>
					</textarea>
				</div>
			</div>
		</div>
	</div>