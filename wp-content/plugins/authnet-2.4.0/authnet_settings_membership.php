<?php

/*
 * Copyright 2010, Maintain Fit LLC, Daniel Watrous, All rights reserved
 * By using this software you agree to be bound by the terms
 * outlined in the License.txt file included with the software.
 *
 * If you still have questions please send them to helpdesk@danielwatrous.com
 *
 */

if ('authnet_membership_settings.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('<h2>'.__('Direct File Access Prohibited','authnet').'</h2>');

?>
<link rel="stylesheet" type="text/css" href="<?php echo get_plugin_url_authnet(); ?>/style.css" media="all" />

	<div class="wrap" style="width: 700px;">
		<h2>Authorize.net for WordPress Membership Settings</h2>
<?php
                // Display warning message if plugin is being used without SSL installed
                echo get_use_ssl_warning('admin_page');
                
		if(isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true') {
			echo '<div class="updated"><p><strong>Settings Updated</strong></p></div>';
		}
?>
		<div class="Settings-wrap">
			<div class="info-box">
				<div class="info-content">
                    Integration with WishList and MemberWing is easy with Authorize.net for WordPress. Update the settings below to indicate whether or not to use the membership plugin integration. If you have questions about integrating, go watch the step by step training videos at the link below.
				</div>
				<div class="Owner">
                    This plugin was created by <a href="http://www.danielwatrous.com">Daniel Watrous</a>. Step by step videos are available on the <a href="http://www.danielwatrous.com/authorizenet-for-wordpress/plugin-training">training page</a>.
				</div>
			</div>
			<div class="settings-header">
				<ul>
					<li>
						<span>Membership settings</span>
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
					<input type="hidden" name="page_options" value="authnet_memberwingcallback, authnet_wishlistinstalldirectory, authnet_processwishlist,authnet_wishlistapikey,authnet_submcallback,authnet_submsecretkey" />
					<!-- ****************************************************** -->
					<div class="memberwing_options">
						<h3>MemberWing options:</h3>
						
						<label for="authnet_memberwingcallback">MemberWing callback URL: </label>
						<?php authnet_textbox("authnet_memberwingcallback", '', 45); ?>
						<small>Get this in your MemberWing settings to automate account management with payments.</small>
						
					</div>
					<div class="wishlist_options">
						<h3>WishList options:</h3>
						
						<label for="authnet_wishlistinstalldirectory">WishList Install Directory: </label>
						<?php authnet_textbox("authnet_wishlistinstalldirectory", '', 25); ?>
						<small>This must be existing install directory of WishList plugin.</small> <br />
						
<?php 
						 
						if (is_plugin_active( get_option('authnet_wishlistinstalldirectory') . '/wpm.php')) { //plugin is activated 
?>
							<label for="authnet_processwishlist">Process WishList Transactions: </label>
							<?php authnet_checkbox("authnet_processwishlist", ''); ?>
							<small>Check this option to process memberships on each transaction.</small>
							
							<label >API Key: </label>
							<?php authnet_textbox("authnet_wishlistapikey", '', 45); ?>
							<small>This is probably the value you're looking for: <strong><?php echo WLMAPI::GetOption("WLMAPIKey"); ?></strong>.</small>
							
							<p>
								<strong>Membership Level names and SKUs</strong>
							</p>
<?php 						foreach (WLMAPI::GetOption("wpm_levels") as $sku => $membership_level) { 
?>
							<label ><?php echo $membership_level["name"]; ?> <i>level</i>: </label>
							<input id="pwc_wishlist_callbackurl" type="text" size="20" value="<?php echo (isset($membership_level["wpm_newid"])) ? $membership_level["wpm_newid"]:$sku; ?>" onclick="select()" readonly><br />
<?php 
							} 
?>
<?php 
						} else { 
?>
							<b>WishList Member Not Installed</b>
<?php 
						} 
?>
					</div>
					<div class="subm_options">
						<h3>Subscription Mate options:</h3>
						
					<label for="authnet_submcallback">Subscription Mate callback URL: </label>
					<?php authnet_textbox("authnet_submcallback", '', 45); ?>
					<br /><small>Get this in your Subscription Mate settings to automate account management with payments.</small>

					<label for="authnet_submsecretkey">Subscription Mate Secret Key: </label>
					<?php authnet_textbox("authnet_submsecretkey", '', 18); ?>
					<br /><small>Get this key in Subscription Mate settings.</small>
				
					</div>
				</form>
			</div>
			<div class="update-send-buttons">
				<input type="submit" value="Update Settings" class="update-settings-btn" onClick="document['settings'].submit()" />
			</div>
		</div>	
	</div>