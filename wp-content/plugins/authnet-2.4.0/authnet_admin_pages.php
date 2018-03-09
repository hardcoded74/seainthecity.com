<?php

/*
 * Copyright 2010, Maintain Fit LLC, Daniel Watrous, All rights reserved
 * By using this software you agree to be bound by the terms
 * outlined in the License.txt file included with the software.
 *
 * If you still have questions please send them to helpdesk@danielwatrous.com
 *
 */

// render the admin menu(s)

if (!function_exists('authnet_render_settings_general')) {
    /**
     * display the general settings page.
     */
	function authnet_render_settings_general() {
		global $wpdb, $user_level, $wp_rewrite, $wp_version;
		global $authnet_user_subscription_table_name, $authnet_subscription_table_name, $authnet_payment_table_name, $authnet_cancellation_table_name;
		include 'authnet_settings_general.php';
	}
}
if (!function_exists('authnet_render_settings_variable_payments')) {
    /**
     * display the variable payments settings page.
     */
	function authnet_render_settings_variable_payments() {
		global $wpdb, $user_level, $wp_rewrite, $wp_version;
		global $authnet_user_subscription_table_name, $authnet_subscription_table_name, $authnet_payment_table_name, $authnet_cancellation_table_name;
		include 'authnet_settings_variable_payments.php';
	}
}
if (!function_exists('authnet_render_settings_checkout')) {
    /**
     * display the checkout settings page.
     */
	function authnet_render_settings_checkout() {
		global $wpdb, $user_level, $wp_rewrite, $wp_version;
		global $authnet_user_subscription_table_name, $authnet_subscription_table_name, $authnet_payment_table_name, $authnet_cancellation_table_name;
		include 'authnet_settings_checkout.php';
	}
}

if (!function_exists('authnet_render_settings_membership')) {
    /**
     * display the membership settings page.
     */
	function authnet_render_settings_membership() {
		global $wpdb, $user_level, $wp_rewrite, $wp_version;
		global $authnet_user_subscription_table_name, $authnet_subscription_table_name, $authnet_payment_table_name, $authnet_cancellation_table_name;
		include 'authnet_settings_membership.php';
	}
}

if (!function_exists('authnet_render_subscriptions')) {
    /**
     * display the general subscriptions page.
     */
	function authnet_render_subscriptions() {
		global $wpdb, $user_level, $wp_rewrite, $wp_version, $log;
		global $authnet_user_subscription_table_name, $authnet_subscription_table_name, $authnet_payment_table_name, $authnet_cancellation_table_name;
		include 'authnet_subscriptions.php';
	}
}

if (!function_exists('authnet_render_usersubscriptions')) {
    /**
     * display the general user subscriptions page.
     */
	function authnet_render_usersubscriptions() {
		global $wpdb, $user_level, $wp_rewrite, $wp_version;
		global $authnet_user_subscription_table_name, $authnet_subscription_table_name, $authnet_payment_table_name, $authnet_cancellation_table_name;
		include 'authnet_usersubscriptions.php';
	}
}

if (!function_exists('authnet_render_pending_capture')) {
    /**
     * display the pending capture trasactions
     */
	function authnet_render_pending_capture() {
		global $wpdb, $user_level, $wp_rewrite, $wp_version;
		global $authnet_user_subscription_table_name, $authnet_subscription_table_name, $authnet_payment_table_name, $authnet_cancellation_table_name;
		include 'authnet_user_pendingcapture.php';
	}
}

if (!function_exists('authnet_render_downloadtransactions')) {
    /**
     * display the general user subscriptions page.
     */
	function authnet_render_downloadtransactions() {
		global $wpdb, $user_level, $wp_rewrite, $wp_version;
		global $authnet_user_subscription_table_name, $authnet_subscription_table_name, $authnet_payment_table_name, $authnet_cancellation_table_name;
		include 'authnet_downloadtransactions.php';
	}
}

if (!function_exists('authnet_render_surveybuilder')) {
    /**
     * display the general user subscriptions page.
     */
	function authnet_render_surveybuilder() {
		global $wpdb, $user_level, $wp_rewrite, $wp_version;
		global $authnet_user_subscription_table_name, $authnet_subscription_table_name, $authnet_payment_table_name, $authnet_cancellation_table_name;
		include 'authnet_surveybuilder.php';
	}
}
if (!function_exists('authnet_render_log_file')) {
    /**
     * display the log file.
     */
	function authnet_render_log_file() {
		global $wpdb, $user_level, $wp_rewrite, $wp_version;
		global $authnet_user_subscription_table_name, $authnet_subscription_table_name, $authnet_payment_table_name, $authnet_cancellation_table_name;
		include 'authnet_render_log_file.php';
	}
}
?>