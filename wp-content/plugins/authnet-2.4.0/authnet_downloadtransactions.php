<?php

/*
 * Copyright 2010, Maintain Fit LLC, Daniel Watrous, All rights reserved
 * By using this software you agree to be bound by the terms
 * outlined in the License.txt file included with the software.
 *
 * If you still have questions please send them to helpdesk@danielwatrous.com
 *
 */

if ('authnet_downloadtransactions.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('<h2>'.__('Direct File Access Prohibited','authnet').'</h2>');

require_once('authnet_functions.php');

if (isset($_POST['end_date'])) {
	$end_date = $_POST['end_date'];
} else {
	$end_date = date('Y-m-d');
}
if (isset($_POST['start_date'])) {
	$start_date = $_POST['start_date'];
} else {
	$start_date = date('Y-m-d', time()-(4*7*24*60*60));	// 28 days back
}

$form_action_url = get_plugin_url_authnet() . '/authnet_download.php';

?>

<link rel="stylesheet" type="text/css" href="<?php echo get_plugin_url_authnet(); ?>/style.css" media="all" />

	<div class="wrap">
		<h2>Authorize.net for WordPress Download Transactions</h2>
<?php
                 // Display warning message if plugin is being used without SSL installed
                echo get_use_ssl_warning('admin_page');
?>
		<div class="Settings-wrap">
			<div class="info-box">
				<div class="info-content">
                    Use the form below to select a date range and download transaction details. If any transactions in the selected range contain survey responses, those will be split into their own columns. Both CSV and TAB can be opened in a spreadsheet for further analysis.
				</div>
				<div class="Owner">
                    This plugin was created by <a href="http://www.danielwatrous.com">Daniel Watrous</a>. Step by step videos are available on the <a href="http://www.danielwatrous.com/authorizenet-for-wordpress/plugin-training">training page</a>.
				</div>
			</div>
			
			<div class="settings-header">
				<ul>
					<li>
						<span>Download Transactions</span>
					</li>
				</ul>
			</div>
			<div class="settings-container">
				<form action="<?php echo  $form_action_url; ?>" method="post" name="download">
					Start Date	<input type="text" id="start-date" name="start_date" value="<?php echo  $start_date; ?>">
					End Date 	<input type="text" id="end-date" name="end_date" value="<?php echo  $end_date; ?>">
					Format 		<select name="delimiter">
									<option value="CSV" <?php echo  ($delimiter == ",") ? "selected":""; ?>>CSV</option>
									<option value="TAB" <?php echo  ($delimiter == "\t") ? "selected":""; ?>>TAB</option>
								</select>
					<br/><br/>
					<br/><br/>
					<input type="submit" id="download-transactions" name="submittxdl" value="Download Transactions">
				</form>
			</div>
			<!-- <textarea name="results" rows="20" cols="60"><?php echo  $downloadresults; ?></textarea> -->
		</div>
	</div>
	
