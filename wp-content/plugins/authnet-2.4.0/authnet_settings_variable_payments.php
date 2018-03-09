<?php

/*
 * Copyright 2010, Maintain Fit LLC, Daniel Watrous, All rights reserved
 * By using this software you agree to be bound by the terms
 * outlined in the License.txt file included with the software.
 *
 * If you still have questions please send them to helpdesk@danielwatrous.com
 *
 */

if ('authnet_settings_variable_payments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('<h2>'.__('Direct File Access Prohibited','authnet').'</h2>');

require_once('authnet_functions.php');
$surveys = json_decode(get_option("authnet_surveys"));

?>
<link rel="stylesheet" type="text/css" href="<?php echo get_plugin_url_authnet(); ?>/style.css"/>

	<div class="wrap" style="width: 700px;">
		<h2>Authorize.net for WordPress Variable Payments</h2>
<?php
		// Display warning message if plugin is being used without SSL installed
		echo get_use_ssl_warning('admin_page');
		if ( isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true' ) {
			echo '<div class="updated"><p><strong>Settings Updated</strong></p></div>';
		}
?>
		<div class="Settings-wrap">
			<div class="info-box">
				<div class="info-content">
				The options that you set on this page affect the variable payment form. Use the settings on this page to modify the look of variable payment form, choose style, payment term, set preset amounts and choose survey to be collected on variable payment form. 
				</div>
				<div class="Owner">
				This plugin was created by <a href="http://www.danielwatrous.com">Daniel Watrous</a>. Step by step videos are available on the <a href="http://www.danielwatrous.com/authorizenet-for-wordpress/plugin-training">training page</a>
				</div>
			</div>
			<div class="settings-header">
				<ul>
					<li>
						<span>Variable Payments Settings</span>
					</li>
				</ul>
				<div class="update-send-buttons">
					<input type="submit" value="Update Settings" class="update-settings-btn" onClick="document['settings'].submit()" />
				</div>
			</div>
			<div class="settings-container">
				<form name="settings" method="post" action="options.php">
					<?php wp_nonce_field('update-options'); ?>
					<input type="hidden" name="action" value="update" />
<?php
					/* You need to add each field in this area (separated by commas) that you want to update
					   every time you click "Save"
					 */
?>
					<input type="hidden" name="page_options" value="authnet_variable_payments_term, authnet_variable_payments_label, authnet_variable_payments_style, authnet_variable_payments_survey, authnet_allow_preset_amounts, authnet_preset_amounts_list"/>
					<!-- ****************************************************** -->
					<div class="variable_payments_options">
						
						<label for="authnet_variable_payments">Variable Payment Shortcode: </label>
						<input type="text" readonly value="[authnetvariablepayments]" onclick="select()" style="width:180px;" />
						<small>Copy the shortcode from this field and place it in any WordPress page to display a payment form.</small>
						
						<label for="authnet_variable_payments_term">Variable Payment Term: </label>
						<?php authnet_textbox("authnet_variable_payments_term", 'Payment'); ?>
						<small>This is shown on the payment form and checkout page. If you use it for donation then 'Donation' term would be more specific but for something other than donations (like payments) changing this can be more clear for your customers.</small>
						
						
						<label for="authnet_variable_payments_label">Variable Payment Label: </label>
						<?php authnet_textbox("authnet_variable_payments_label", 'Recurring period', 25); ?>
						<small>This is shown on the payment form along with dropdown. You can assign any label to dropdown.</small>
						
						<label for="authnet_variable_payments_style">Variable Payment Style: </label>
						<select name="authnet_variable_payments_style" style="width:45px;">
							<option value="1" <?php echo (get_option('authnet_variable_payments_style')== '1')?'selected':''?> >1</option>
							<option value="2" <?php echo (get_option('authnet_variable_payments_style')== '2')?'selected':''?> >2</option>
							<option value="3" <?php echo (get_option('authnet_variable_payments_style')== '3')?'selected':''?> >3</option>
						</select>
						<br /> 
						<small> You can choose the payment form style. Valid form styles are 1, 2 or 3. </small>
                                               
						<label for="authnet_variable_payments_survey">Variable Payment Survey: </label>
						<select id="authnet_variable_payments_survey" name="authnet_variable_payments_survey" >
						<option value="">-- Choose Survey --</option>
<?php 
						if ( $surveys != NULL && count($surveys)>0 ) {
							foreach ($surveys as $survey) { 
?>
								<option value="<?php echo $survey->surveyName; ?>" <?php if (get_option('authnet_variable_payments_survey') == $survey->surveyName) echo "selected"; ?>><?php echo (get_option('authnet_default_survey') == $survey->surveyName)? stripslashes($survey->surveyName) .'(Default)': stripslashes($survey->surveyName); ?></option>
<?php 
							}
						}
?>
						</select><br />
                                                
                                                
						<small>This survey will be collected for all variable payments.</small> <br />
						<h3>Preset Amounts Options:</h3>
						<label for="authnet_allow_preset_amounts">Allow Preset Amounts: </label>
						<?php authnet_checkbox("authnet_allow_preset_amounts", ''); ?>
						<small>If you allow preset amounts then below list of amounts will be shown as suggested amounts to users.</small>
						<label for="authnet_preset_amounts_list">Preset Amounts List: </label>
						<?php authnet_textarea("authnet_preset_amounts_list", ''); ?>
						<small>This is list of preset amounts. You can modify it by entering amounts but please make sure to enter valid amounts as per preset values.</small>
						
						
					</div>
				</form>
			</div>
                    <div class="update-send-buttons">
				<input type="submit" value="Update Settings" class="update-settings-btn" onClick="document['settings'].submit()" />
			</div>
			<div class="settings-header">
				<ul>
					<li>
						<span>Available Variable Payment Templates </span>
					</li>
				</ul>
			</div>
			<div class="settings-container">
				<table class="widefat">
					<thead>
						<tr>
							<th scope="col">Variable Payment Templates</th>
							<th scope="col">Billing Cycle</th>
						</tr>
					</thead>
<?php
					$query = "SELECT * FROM $authnet_subscription_table_name WHERE variablePaymentTemplate = '1' ORDER BY ID ASC";
					$subscriptions = $wpdb->get_results($query);

					foreach ($subscriptions as $subscription) { 
?>
							<tr align="left" valign="middle">
								<td><?php echo $subscription->name; ?></td>
								<td><?php echo ( ( $subscription->processRecurringPayment == 1  && $subscription->processSinglePayment != 1) ? 'every ' . $subscription->recurringIntervalLength . ' ' . $subscription->recurringIntervalUnit : '') . get_pricing($subscription)?></td>
							</tr>
<?php 
					} 
?>
				</table>
				<h3></h3>
				
				<small>Variable payment template provides more flexible way for settings your payments. The above table shows the available variable payment templates. You can add/modify variable payment template anytime by visiting subscription page <a href=" <?php echo (get_home_url() . '/wp-admin/admin.php?page=authnet_subscriptions.php');?>">here.</a> 
				</small>
			</div>
		</div>
			
	</div>