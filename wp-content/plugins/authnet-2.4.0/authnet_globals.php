<?php

/*
 * Copyright 2010, Maintain Fit LLC, Daniel Watrous, All rights reserved
 * By using this software you agree to be bound by the terms
 * outlined in the License.txt file included with the software.
 *
 * If you still have questions please send them to helpdesk@danielwatrous.com
 *
 */

// authnet tables prefix (dont see much reason to make this user editable)
$authnet_tables_prefix = "authnet_";

// define database table names and prefixes here
global $authnet_user_subscription_table_name, $authnet_subscription_table_name, $authnet_payment_table_name, $authnet_cancellation_table_name,
        $authnet_cart_items_table_name, $authnet_refund_table_name;
$authnet_user_subscription_table_name = $wpdb->prefix . $authnet_tables_prefix . "user_subscription";
$authnet_subscription_table_name = $wpdb->prefix . $authnet_tables_prefix . "subscription";
$authnet_payment_table_name = $wpdb->prefix . $authnet_tables_prefix . "payment";
$authnet_cancellation_table_name = $wpdb->prefix . $authnet_tables_prefix . "cancellation";
$authnet_cart_items_table_name = $wpdb->prefix . $authnet_tables_prefix . "cart_items";
$authnet_refund_table_name = $wpdb->prefix . $authnet_tables_prefix . "refund";

?>