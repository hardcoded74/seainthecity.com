<?php

/*
 * Copyright 2010, Maintain Fit LLC, Daniel Watrous, All rights reserved
 * By using this software you agree to be bound by the terms
 * outlined in the License.txt file included with the software.
 *
 * If you still have questions please send them to helpdesk@danielwatrous.com
 *
 */

if ('authnet_settings_general.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('<h2>'.__('Direct File Access Prohibited','authnet').'</h2>');

$silentposturl = get_plugin_url_authnet() . "/authnet_silentpost.php";
$surveys = json_decode(get_option("authnet_surveys"));

?>
<script type="text/javascript" src="<?php echo get_plugin_url_authnet(); ?>/javascript/javascript.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo get_plugin_url_authnet(); ?>/style.css"/>

	<div class="wrap" style="width: 700px;">
		<h2>Authorize.net for WordPress General Settings</h2>
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
				This plugin provides integration through the excellent Authorize.net gateway and is used to process credit card & echeck payments. Frequently this is used to collect membership dues alongside plugins such as MemberWing and WishList. It can also be used as a donation engine for charities, churches, politicians, etc.
				</div>
				<div class="Owner">
				This plugin was created by <a href="http://www.danielwatrous.com">Daniel Watrous</a>. Step by step videos are available on the <a href="http://www.danielwatrous.com/authorizenet-for-wordpress/plugin-training">training page</a>
				</div>
			</div>
			<div class="settings-header">
				<ul>
					<li>
						<span>General settings</span>
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
					<input type="hidden" name="page_options" value="authnet_transactionkey,authnet_apikey,authnet_usesandbox,authnet_securityseed,authnet_silentposthash,authnet_update_subscription, authnet_allow_refund, authnet_cc_transaction_type, authnet_cardtype_visa,authnet_cardtype_americanexpress,authnet_cardtype_mastercard,authnet_cardtype_discover,authnet_send_email_notices,authnet_email_subject_prefix,authnet_email_message_template,authnet_send_admin_email, authnet_alternate_admin_email"/>
					<!-- ****************************************************** -->
					<div class="authnet_details">
						<h3>Authorize.net Details:</h3>
						
						<label for="authnet_usesandbox">Use Authorize.net Sandbox: </label>
						<?php authnet_checkbox("authnet_usesandbox"); ?>
                        <small>Check this box to send requests to the <a href="https://developer.authorize.net/testaccount/" target="_blank">Authorize.net developer sandbox</a> for testing. <strong>NOTE: Leave unchecked if you're testing against your account in test mode.</strong></small>

						<label for="authnet_transactionkey">Transaction Key: </label>
						<?php authnet_textbox("authnet_transactionkey", '', 40); ?>
						
						<label for="authnet_apikey">API Key: </label>
						<?php authnet_textbox("authnet_apikey", '', 35); ?>

						<label for="authnet_securityseed">Security seed: </label>
						<?php authnet_textbox("authnet_securityseed", '', 50); ?>
						<small>This is a random value that is used to secure the checkout process. If you change this you must update all buy now links.</small>
						
						<label for="authnet_silentposturl">Silent Post URL: </label>
						<input type="text" id="authnet_silentposturl" size="50" value="<?php echo $silentposturl; ?>" onclick="select()" readonly />
						<small>Provide this value to Authorize.net for automatic updates of recurring transactions.</small>
						
						<label for="authnet_silentposthash">Silent Post MD5 Hash: </label>
						<?php authnet_textbox("authnet_silentposthash", '', 40); ?>
						<small>This corresponds to the MD5 value you set in your authorize.net account.</small>
						
						<label for="authnet_update_subscription">Update Subscription: </label>
						<?php authnet_checkbox("authnet_update_subscription"); ?>
                        <small>Allow user to either update or cancel his/her own subscriptions on user profile page.</small>
						
						<label for="authnet_allow_refund">Allow Refund: </label>
						<?php authnet_checkbox("authnet_allow_refund"); ?>
                        <small>Allow users to refund their own transactions on user profile page.</small>
						
					</div>
                                        
					<div class="cc_transaction_types">
						<h3>Credit Card Transaction Types:</h3>

						<label for="authnet_cc_transaction_type">Authorization And Capture: </label>
						<input type="radio" <?php echo ( get_option('authnet_cc_transaction_type') == 'auth_capture' )? 'checked':'' ?> value="auth_capture" name="authnet_cc_transaction_type" id="authnet_xtype_auth_capture">
						<small>This is the most common type of credit card transaction and is the default payment
						gateway transaction type. The amount is sent for authorization, and if approved, is
						automatically submitted for settlement.     
						</small>

						<label for="authnet_cc_transaction_type">Authorization Only: </label>
						<input type="radio" <?php echo ( get_option('authnet_cc_transaction_type') == 'auth_only' )? 'checked':'' ?> value="auth_only" name="authnet_cc_transaction_type" id="authnet_xtype_auth_only">
						<small>This transaction type is sent for authorization only. The transaction will not be sent for
						settlement until the credit card transaction type Prior Authorization and Capture is submitted.
						</small>
						<br>

					</div>
					
					<div class="card_type_options">
						<h3>Card Type Options:</h3>
						
						<label for="authnet_cardtype_visa">Visa: </label>
						<?php authnet_checkbox("authnet_cardtype_visa", ''); ?>
						<small></small>
						
						<label for="authnet_cardtype_americanexpress">American Express: </label>
						<?php authnet_checkbox("authnet_cardtype_americanexpress", ''); ?>
						<small></small>
						
						<label for="authnet_cardtype_mastercard">MasterCard: </label>
						<?php authnet_checkbox("authnet_cardtype_mastercard", ''); ?>
						<small></small>
						
						<label for="authnet_cardtype_discover">Discover: </label>
						<?php authnet_checkbox("authnet_cardtype_discover", ''); ?>
						<small></small>
					</div>
					
					<div class="email_settings">
						<h3>Email Settings:</h3>
						
						<label for="authnet_send_email_notices">Send email notices: </label>
						<?php authnet_checkbox("authnet_send_email_notices", ''); ?>
						<small></small>
						
						<div class="email-settings-help"></div> 
						
						<div id="email-help-content" style="display:none"> 
							<p><strong><u>Email Notifiaction Tokens:</u></strong></p> 
							<p> Tokens are used in email message, you can adjust them in your email template and are replaced with real values while sending email. <br /><br />
							{BLOGNAME}  = Your site/blog name <br /><br />
							{USERNAME} = Login user name. <br />
							{PASSWORD} = Login password. <br /><br />
							{FIRSTNAME} = First name of the person doing transaction. <br />
							{LASTNAME}  = Last name of the person doing transaction. <br />
							{BILLINGADDRESS}  = Billing address of the person doing transaction. <br />
							{PHONE}  = Phone # of the person doing transaction. <br /><br />
							{SUBSCRIPTION}  = Name of the item purchased or paid. <br />
							{PAYMENT-INTERVAL} = Interval/Period of payment.<br />
							{SUBSCRIPTION-NOTES}  = Notes & commentes collected on checkout page. <br /><br />
							{ACCOUNTLOGINURL}  = Login page URL to your site. <br />
						</div>
						
						<label for="authnet_email_subject_prefix">Email subject prefix: </label>
						<?php authnet_textbox("authnet_email_subject_prefix", '', 53); ?>
						<small></small>
						
						
						
						<label for="authnet_email_message_template">Email message template: </label>
						<?php authnet_textarea("authnet_email_message_template", ''); ?>
						<small></small>
						
						<label for="authnet_send_admin_email">Send admin email: </label>
						<?php authnet_checkbox("authnet_send_admin_email", ''); ?>
						 <small>Check this box to send a copy of email notification to site's admin.</small>
						
						<label for="authnet_alternate_admin_email">Alternate admin email: </label>
						<?php authnet_textbox("authnet_alternate_admin_email", '', 53); ?> <br />
						<small>Email notificaiton is normally sent to site admin and to the person doing the transaction. If you want to use an alternate email for admin you can enter it here. </small>
						
					</div>
				</form>
			</div>
			<div class="update-send-buttons">
				<input type="submit" value="Update Settings" class="update-settings-btn" onClick="document['settings'].submit()" />
			</div>
		</div>
		<div class="Settings-wrap">
			<div class="settings-header">
				<ul>
					<li>
						<span>Compatibility Test</span>
					</li>
				</ul>
			</div>
			
			<div class="settings-container">
				<form method="post">
					<ul>
						<li>
							<label>PHP Version:</label>
							<?php if (PHP_VERSION >= 5): ?>
							<code><?php echo PHP_VERSION; ?></code>
							<?php else: ?>
							<code style="color:red"><?php echo PHP_VERSION; ?></code>;
							<?php endif; ?>
							<span class="hint">(PHP5 is required)</span>
						</li>
						<li>
							<label>Web Server:</label>
							<?php if (stristr($_SERVER['SERVER_SOFTWARE'], 'apache') !== false): ?>
							<code>Apache</code>
							<?php elseif (stristr($_SERVER['SERVER_SOFTWARE'], 'LiteSpeed') !== false): ?>
							<code>Lite Speed</code>
							<?php elseif (stristr($_SERVER['SERVER_SOFTWARE'], 'nginx') !== false): ?>
							<code>nginx</code>
							<?php elseif (stristr($_SERVER['SERVER_SOFTWARE'], 'lighttpd') !== false): ?>
							<code>lighttpd</code>
							<?php elseif (stristr($_SERVER['SERVER_SOFTWARE'], 'iis') !== false): ?>
							<code>Microsoft IIS</code>
							<?php else: ?>
							<code>Not detected</code>
							<?php endif; ?>
						</li>
						<li>
							<label>cURL extension:</label>
							<?php if (function_exists('curl_init')): ?>
							<code>Installed</code>
							<?php else: ?>
							<code style="color:red">Not installed</code>
							<?php endif; ?>
							<span class="hint">(required)</span>
						</li>
						<li>
							<a name="compatbility"></a>
							<label>Mail function:</label>
<?php
							if( $_POST['emailtest'] == 'yes' ) {
								$to      = $_POST['emailaddress'];
								$subject = 'Authorize.net Email Test';
								$message = 'Congratulations. Your email was successfully sent by the Authorize.net for WordPress plugin.';
								$headers = 'From: ' . get_option( 'admin_email' ) . "\r\n" .
									'Reply-To: ' . get_option( 'admin_email' ) . "\r\n" .
									'X-Mailer: PHP/' . phpversion();

								if( mail($to, $subject, $message, $headers) ) {
?>
									<code>Test Successful</code>
<?php
								} else {
?>
									<code style="color:red">Test Unsuccessful</code>
<?php
								}
							} else {
?>
								<input type="hidden" name="emailtest" value="yes">
								<input type="text" name="emailaddress" value="Enter your email" class="hintTextbox">
								<input type="submit" value="Test Email">
<?php
							}
?>
						</li>
					</ul>
					
				</form>
			</div>
		</div>
	</div>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script language="javascript" src="<?php echo get_plugin_url_authnet(); ?>/javascript/jquery.tooltip.js" type="text/javascript"></script> 
<script type="text/javascript"> 
	$('.email-settings-help').tooltip({ 
		tooltipSourceID:'#email-help-content', 
		loader:1, 
		loaderImagePath:'', 
		loaderHeight:16, 
		loaderWidth:17, 
		width:'400px', 
		height:'360px', 
		tooltipSource:'inline', 
		borderSize:'1', 
		tooltipBGColor:'#efefef' 
	}); 
</script> 