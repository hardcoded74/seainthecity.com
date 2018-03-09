<?php

/*
 * Copyright 2010, Maintain Fit LLC, Daniel Watrous, All rights reserved
 * By using this software you agree to be bound by the terms
 * outlined in the License.txt file included with the software.
 *
 * If you still have questions please send them to helpdesk@danielwatrous.com
 *
 */

if ('authnet_checkout_settings.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('<h2>'.__('Direct File Access Prohibited','authnet').'</h2>');

if ($_GET['synctemplates'] == 'true') {
	authnet_synchronize_files();
}
$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$syncURL = add_query_arg('synctemplates', 'true', $url);


?>
<link rel="stylesheet" type="text/css" href="<?php echo get_plugin_url_authnet(); ?>/style.css" media="all" />

	<div class="wrap" style="width: 700px;">
		<h2>Authorize.net for WordPress Checkout Settings</h2>
<?php
		// Display warning message if plugin is being used without SSL installed
		echo get_use_ssl_warning('admin_page');
		if(isset($_GET['synctemplates']) && $_GET['synctemplates'] == 'true') {
			echo '<div class="updated"><p><strong>Template Files Synchronized</strong></p></div>';
		}

		if(isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true') {
			echo '<div class="updated"><p><strong>Settings Updated</strong></p></div>';
		}
                 
?>
		<div class="Settings-wrap">
			<div class="info-box">
				<div class="info-content">
                    The options that you set on this page affect the checkout process. Use the settings on this page to modify the look and feel of the plugin to match your brand, define security measures and identify what values should be collected.
				</div>
				<div class="Owner">
				This plugin was created by <a href="http://www.danielwatrous.com">Daniel Watrous</a>. Step by step videos are available on the <a href="http://www.danielwatrous.com/authorizenet-for-wordpress/plugin-training">training page</a>.
				</div>
			</div>
			<div class="settings-header">
				<ul>
					<li>
						<span>Checkout settings</span>
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
					<input type="hidden" name="page_options" value="authnet_usessl,authnet_checkoutpage,authnet_thankyoupage, authnet_include_shippinginfo, authnet_enable_creditcard, authnet_enable_echeck, authnet_include_userinfo,authnet_include_usernotes,authnet_require_company,authnet_require_phone,authnet_checkout_forms_css_override,authnet_checkout_header_brand,authnet_checkout_logo,authnet_checkout_text,authnet_checkout_headerhtml,authnet_checkout_footerhtml,authnet_checkout_guaranteehtml,authnet_checkout_copyright,authnet_checkout_buy_button,authnet_checkout_siteseal,authnet_recaptcha,authnet_recaptcha_publickey,authnet_recaptcha_privatekey" />
					<!-- ****************************************************** -->
					<div class="checkout_options">
						<h3>Checkout options:</h3>
						
						<label><b>Synchronize templates: </b></label>
						&nbsp;&nbsp;<a href="<?php echo $syncURL; ?>"><b>Synchronize now</b></a>
						<small><b>Click the link above to synchronize the checkout template to your current theme</b></small><br />
						
						<label for="authnet_usessl">USE SSL: </label>
						<?php authnet_checkbox("authnet_usessl", ''); ?>
						<small>This is for testing only.  If you uncheck this you assume all responsibility for lost or stolen financial data that results from orders on your site.</small>
						
						<label for="authnet_checkoutpage">Checkout Page: </label>
						<?php authnet_textbox("authnet_checkoutpage", 'checkout'); ?>
						<small>This must be an existing WordPress page that contains the shortcode "[authnetco]"</small>
						
						<label for="authnet_thankyoupage">Thank You Page: </label>
						<?php authnet_textbox("authnet_thankyoupage", 'thankyou'); ?>
						<small>This is a page in WordPress that contains a thankyou message & directing the customer to thankyou page. This is also default thankyou page for variable payment & multiple cart items.</small>

						<label for="authnet_enable_creditcard">Enable Credit/Debit Card: </label>
						<?php authnet_checkbox("authnet_enable_creditcard", ''); ?>
						<small>Enable this to ask the user to provide credit/debit card details on checkout page.</small> 

						<label for="authnet_enable_echeck">Enable Echeck: </label>
						<?php authnet_checkbox("authnet_enable_echeck", ''); ?>
						<small>Enable this to ask the user to provide bank account details on checkout page.</small> 
                                                
						<label for="authnet_include_shippinginfo">Ask for shipping information: </label>
						<?php authnet_checkbox("authnet_include_shippinginfo", ''); ?>
						<small>Enable this to ask the user to provide shipping information on checkout page.</small> 
						
						<label for="authnet_include_userinfo">Ask for username/password: </label>
						<?php authnet_checkbox("authnet_include_userinfo", ''); ?>
						<small>Enable this to ask the user for a username and password at checkout. Useful for integration with membership websites.</small>
						
						<label for="authnet_include_usernotes">Ask for comments: </label>
						<?php authnet_checkbox("authnet_include_usernotes", ''); ?>
						<small>Enable this to provide the user with a comment box at checkout. Helpful to gather donation designations.</small>
						
						<label for="authnet_require_company">Require company name: </label>
						<?php authnet_checkbox("authnet_require_company", ''); ?>
						<small>Require the user to provide a company name at checkout. If unchecked, this field will be optional.</small>
						
						<label for="authnet_require_phone">Require phone number: </label>
						<?php authnet_checkbox("authnet_require_phone", ''); ?>
						<small>Require the user to provide a phone number at checkout. If unchecked, this field will be optional.</small>
						
						<label for="authnet_checkout_forms_css_override">Checkout Forms CSS: </label>
						<?php authnet_textarea("authnet_checkout_forms_css_override", ''); ?>
						<small>This will effect the checkout forms by overriding the above styles.</small>

						<label for="authnet_recaptcha">Use reCAPTCHA: </label>
						<?php authnet_checkbox("authnet_recaptcha", ''); ?>
						<small>This is to prevent the system from "bot", You can get the below recaptcha's keys <a href="<?php echo "https://www.google.com/recaptcha/admin/create?domains=" . blog_domain() . "&app=wordpress"; ?>" target="_blank" title="Get your reCAPTCHA API Keys">here.</a> The public and private keys are not interchangeable, So please make sure to enter valid keys.</small>

						<label for="authnet_recaptcha_publickey">Public Key:</label>
						<?php authnet_textbox("authnet_recaptcha_publickey", '', 50); ?>
						<small>Public key will be required, if the above recaptcha is checked.</small>

						<label for="authnet_recaptcha_privatekey">Private Key: </label>
						<?php authnet_textbox("authnet_recaptcha_privatekey", '',50); ?>
						<small>Private key will be required, if the above recaptcha is checked.</small>
						
					</div>
					
					<div class="checkout_template_preferences">
						<h3>Checkout template preferences:</h3>
						
						<label for="authnet_checkout_header_brand">Header Brand Choice: </label>
						&nbsp;&nbsp;<?php authnet_radio("authnet_checkout_header_brand", Array("Logo"=>"logo", "Text"=>"text")); ?>
						<small>Please select whether you want to display logo or text on the checkout page.</small>
						
						<label for="authnet_checkout_logo">Checkout Logo: </label>
						<?php authnet_textbox("authnet_checkout_logo", '', 50); ?>
						<small>This is a URL to an image file that you want to display on the checkout page (253x57).</small>
						
						<label for="authnet_checkout_text">Checkout Text: </label>
						<?php authnet_textbox("authnet_checkout_text", '', 50); ?>
						<small>This would be the text that you want to display on the checkout page.</small>
						
						<label for="authnet_checkout_headerhtml">Header HTML: </label>
						<?php authnet_textarea("authnet_checkout_headerhtml", ''); ?>
						<small>This will appear in the header beside the logo.</small>
					
						<label for="authnet_checkout_footerhtml">Footer HTML: </label>
						<?php authnet_textarea("authnet_checkout_footerhtml", ''); ?>
						<small>This will appear in the footer near the copyright notice.</small>
						
						<label for="authnet_checkout_guaranteehtml">Guarantee HTML: </label>
						<?php authnet_textarea("authnet_checkout_guaranteehtml", ''); ?>
						<small>This will appear in the footer near the copyright notice.</small>
						
						<label for="authnet_checkout_copyright">Copyright notice: </label>
						<?php authnet_textbox("authnet_checkout_copyright", 'Copyright, All rights reserved.', 50); ?>
						<small>This will be displayed along the bottom of the template.</small>
						
						<label for="authnet_checkout_buy_button"><b>Buy button text:</b> </label>
						<?php authnet_textbox("authnet_checkout_buy_button", '', 50); ?>
						<small><b>This text will be displayed in the checkout button under the credit card details.</b></small>
						
						<label for="authnet_checkout_siteseal">Secure site seal: </label>
						<?php authnet_textarea("authnet_checkout_siteseal", ''); ?>
						<small>The site seal is provided by your SSL provider and builds confidence. This may include multple site seals and privacy assurances.</small>
						
						<label for="authnet_checkout_shortcode">Checkout shortcode: </label>
						<input type="text" readonly onclick="select()" value="[authnetco style=1]">
						<small>Valid styles are 1, 2 or 3. Copy and paste the above shortcode or modify the shortcode already in your checkout page.</small>
						
						<label for="authnet_thankyou_shortcode">Transaction summary shortcode: </label>
						<input type="text" readonly onclick="select()" value="[authnettransactionsummary]" style="width: 196px;">
						<small>Copy and paste the above shortcode or modify the shortcode already in your thank you page for transaction summary.</small>
						
						
						
					</div>
				</form>
			</div>
			<div class="update-send-buttons">
				<input type="submit" value="Update Settings" class="update-settings-btn" onClick="document['settings'].submit()" />
			</div>
		</div>
	</div>