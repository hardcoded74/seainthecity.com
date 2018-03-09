<?php
/*
 * Copyright 2010, Maintain Fit LLC, Daniel Watrous, All rights reserved
 * By using this software you agree to be bound by the terms
 * outlined in the License.txt file included with the software.
 *
 * If you still have questions please send them to helpdesk@danielwatrous.com
 *
 */
if ('authnet_settings.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('<h2>'.__('Direct File Access Prohibited','authnet').'</h2>');

require_once('authnet_functions.php');
include('authnet_usersubscriptions_template.php');

?>
<link rel="stylesheet" type="text/css" href="<?php echo get_plugin_url_authnet(); ?>/authnet_css/pagination-style.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo get_plugin_url_authnet(); ?>/style.css" media="all" />

	<div class="wrap">
            
		<h2>Authorize.net for WordPress Pending Capture Transactions</h2>
<?php 		// Display warning message if plugin is being used without SSL installed
                echo get_use_ssl_warning('admin_page');
?>
		<div class="Settings-wrap">
			<div class="info-box">
				<div class="info-content">
                    The table below shows details about pending capture transactions that have processed through your website. You can use the search box to find a specific transaction or just click through each page of results to see all the details. Click on the first name to view the user profile within WordPress. <strong>NOTE:</strong> When you delete a user in WordPress, the transaction records are left. That means it's possible that some of the transactions below don't have a current user record associated with them.
				</div>
				<div class="Owner">
                    This plugin was created by <a href="http://www.danielwatrous.com">Daniel Watrous</a>. Step by step videos are available on the <a href="http://www.danielwatrous.com/authorizenet-for-wordpress/plugin-training">training page</a>.
				</div>
			</div>
			<div class="settings-header">
				<ul>
					<li>
						<span>Pending Capture </span>
					</li>
				</ul>
			</div>
                    
        </div> <!-- Settings-wrap ends -->
		
         
        <div id="search-box">
			<form>
				<p class="search-box">
					<input type="hidden" id="page" name="page" value="authnet_render_pending_capture">
					<input type="text" id="transaction-search-input" value="<?php echo (isset($_GET['transactionsearch'])) ? $_GET['transactionsearch'] : ''?>" name="transactionsearch">
					<input type="submit" class="button" value="Search Transaction">
				</p>
			</form>
		</div>
        
		<div id="subscriptions-container">
<?php
			$resultspage = (int) (!isset($_GET["resultspage"]) ? 1 : $_GET["resultspage"]);
			$resultspage = ($resultspage == 0 ? 1 : $resultspage); 
			$limit = 10;
			$startpoint = ($resultspage * $limit) - $limit;
                        
			
			$where_user_subscription = '';
			$where_payment = '';
			
			if (isset($_GET['transactionsearch']) & !empty($_GET['transactionsearch'])) {
				$transaction_search = trim($wpdb->escape($_GET['transactionsearch']));
				
				$where_user_subscription = '  AND (US.billingFirstName LIKE "%' . $transaction_search . '%" OR ';
				$where_user_subscription .= ' US.billingLastName LIKE "%' . $transaction_search . '%" OR ';
				$where_user_subscription .= ' US.billingCompany LIKE "%' . $transaction_search . '%" OR ';
				$where_user_subscription .= ' US.billingAddress LIKE "%' . $transaction_search . '%" OR ';
				$where_user_subscription .= ' US.billingCountry LIKE "%' . $transaction_search . '%" OR ';
				$where_user_subscription .= ' US.billingCity LIKE "%' . $transaction_search . '%" OR ';
				$where_user_subscription .= ' US.billingState LIKE "%' . $transaction_search . '%" OR ';
				$where_user_subscription .= ' US.billingZip LIKE "%' . $transaction_search . '%" OR ';
				$where_user_subscription .= ' US.xSubscriptionId LIKE "%' . $transaction_search . '%" OR ';
				$where_user_subscription .= ' US.emailAddress LIKE "%' . $transaction_search . '%")';
				
				$where_payment = ' AND (UP.xTransId LIKE "%' . $transaction_search . '%" OR ';
				$where_payment .= ' UP.xAuthCode LIKE "%' . $transaction_search . '%")';
			}
                        // get auth_only pending capture transactions (not expired)
                        $user_sub_query_auth_only = "SELECT  US.* FROM ". $authnet_user_subscription_table_name ." AS US
                                 JOIN ". $authnet_payment_table_name . " AS UP ON US.id = UP.user_subscription_id
                                 WHERE US.isRecurring IS NULL AND UP.xType = 'auth_only' AND UP.xTransStatus = 'Pending Capture' AND UP.expiryDate >= CURDATE() " . $where_user_subscription;
                       // get total for pagination
                        $auth_only_sub_total =  $wpdb->get_results($user_sub_query_auth_only);
                        $user_sub_query_auth_only .= " LIMIT " . $startpoint . "," . $limit . ";";
                        $usersubscriptions = $wpdb->get_results($user_sub_query_auth_only);
			// query authnet payments records
			$user_payment_query_auth_only = "SELECT * FROM " . $authnet_payment_table_name . " AS UP 
                                JOIN " . $authnet_user_subscription_table_name . " AS US ON US.id = UP.user_subscription_id
                                WHERE US.isRecurring IS NULL AND UP.xType = 'auth_only' AND UP.xTransStatus = 'Pending Capture' AND UP.expiryDate >= CURDATE() " . $where_payment;
                    
                        // get total for pagination
                        $auth_only_pay_total =  $wpdb->get_results($user_payment_query_auth_only);
                        $user_payment_query_auth_only .=" LIMIT " . $startpoint . "," . $limit . ";";
			$subscriptionpayments = $wpdb->get_results($user_payment_query_auth_only);
			
			$user_subscriptions_rows_result = "";
			if ($usersubscriptions) {
				$table_name = $authnet_user_subscription_table_name;
				$where = $where_user_subscription;
                                 $total = count($auth_only_sub_total);
				foreach ($usersubscriptions as $subscription) {
					$user_subscriptions_rows_result .= get_user_subscriptions($subscription, true, 'admin');
					// Get subscription detail
					$user_subscriptions_rows_result .= get_purchase_items_description($subscription);
					// query user payment record
					$user_payment_query = "SELECT * FROM " . $authnet_payment_table_name . " where user_subscription_id = " . $subscription->ID . ";";
					$subscriptionpayments = $wpdb->get_results($user_payment_query); 
					
					if ($subscriptionpayments) {
						foreach ($subscriptionpayments as $payment) {
							$user_subscriptions_rows_result .= get_user_payments($payment, $subscription->isRecurring, 'admin', true, false);
						}
					} else {
						$user_subscriptions_rows_result .= '<tr><td colspan="8"><hr></td></tr>';
					}
                                        
				}
			} elseif ($subscriptionpayments) {
					$table_name = $authnet_payment_table_name;
					$where = $where_payment;
                                        $total = count($auth_only_pay_total);
					foreach ($subscriptionpayments as $payment) {
						// query user subscriptions records
						$user_sub_query = "SELECT * FROM " . $authnet_user_subscription_table_name . " where id = " . $payment->user_subscription_id.";";
						$usersubscription = $wpdb->get_results($user_sub_query);
						$user_subscriptions_rows_result .= get_user_subscriptions($usersubscription[0], true, 'admin');
						// Get subscription detail
						$user_subscriptions_rows_result .= get_purchase_items_description($usersubscription[0]);
						$user_subscriptions_rows_result .= get_user_payments($payment, $usersubscription[0]->isRecurring, 'admin', true, false);
					}
			}
			$user_subscriptions_main_template = str_replace('{USERSUBSCRIPTONRECORDS}', $user_subscriptions_rows_result, $user_subscriptions_main_template);
			$user_subscriptions_main_template = str_replace('{LINK_TO_CSS}', '', $user_subscriptions_main_template);
			$user_subscriptions_main_template = str_replace('{_CHECKOUT_SELECT}', '', $user_subscriptions_main_template );
			$user_subscriptions_main_template = str_replace('{UPDATE_SCRIPT_URL}', get_plugin_url_authnet(), $user_subscriptions_main_template );
			$user_subscriptions_main_template = str_replace('{CANCEL_SCRIPT_URL}', get_plugin_url_authnet(), $user_subscriptions_main_template );
			$user_subscriptions_main_template = str_replace('{REFUND_SCRIPT_URL}', get_plugin_url_authnet(), $user_subscriptions_main_template );
			$user_subscriptions_main_template = str_replace('{VOID_SCRIPT_URL}', get_plugin_url_authnet(), $user_subscriptions_main_template );
			$user_subscriptions_main_template = str_replace('{PENDING_CAPTURE_SCRIPT_URL}', get_plugin_url_authnet(), $user_subscriptions_main_template );
			
			echo stripslashes($user_subscriptions_main_template);
                        
			echo get_user_subscriptions_pagination($table_name, $limit, $resultspage, $transaction_search, $where, $total, $accessed_by = 'pending_capture');
?>
		</div>
	</div>
