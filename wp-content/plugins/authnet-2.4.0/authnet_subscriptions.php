<?php

/*
 * Copyright 2010, Maintain Fit LLC, Daniel Watrous, All rights reserved
 * By using this software you agree to be bound by the terms
 * outlined in the License.txt file included with the software.
 *
 * If you still have questions please send them to helpdesk@danielwatrous.com
 *
 */

if ('authnet_subscriptions.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('<h2>'.__('Direct File Access Prohibited','authnet').'</h2>');

$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];

?>

<link rel="stylesheet" type="text/css" href="<?php echo get_plugin_url_authnet(); ?>/style.css" media="all" />
<script type="text/javascript">

    function validateSubscription() {

        if ( document.getElementById('name').value == '' ) {
            alert("Subscription name must be filled out.");
            return false;
        }
        if ( document.getElementById('processSinglePayment').checked == false && document.getElementById('processRecurringPayment').checked == false ) {
            alert("Please select payment procesing for this subscription.");
            return false;
        }
        if ( document.getElementById('processSinglePayment').checked == true && document.getElementById('initialAmount').value == '' && !(document.getElementById('variablePaymentTemplate').checked == true)  ) {
            alert("Please enter one-time amount for single payment.");
            return false;
        } else if ( document.getElementById('processSinglePayment').checked == true && !( document.getElementById('initialAmount').value > 0 ) && !(document.getElementById('variablePaymentTemplate').checked == true) ) {
            alert("Please enter valid one-time amount.");
            return false;
        }
        if ( document.getElementById('processRecurringPayment').checked == true && document.getElementById('recurringAmount').value == '' && !(document.getElementById('variablePaymentTemplate').checked == true) ) {
            alert("Please enter recurring amount for recurring payment.");
            return false;
        } else if ( document.getElementById('processRecurringPayment').checked == true && !( document.getElementById('recurringAmount').value > 0 ) && !(document.getElementById('variablePaymentTemplate').checked == true) ) {
            alert("Please enter valid recurring amount.");
            return false;
        }
        if ( document.getElementById('processRecurringPayment').checked == true && document.getElementById('recurringIntervalLength').value == '' ) {
            alert("Please enter recurring interval length.");
            return false;
        } else if ( document.getElementById('processRecurringPayment').checked == true && !( document.getElementById('recurringIntervalLength').value > 0 ) ) {
            alert("Please enter valid recurring interval length.");
            return false;
        }
        if (  document.getElementById('processRecurringPayment').checked == true && document.getElementById('recurringIntervalUnit').selectedIndex == 0 ) {
             alert("Please select recurring interval unit.");
             return false;
        }
        if ( document.getElementById('processRecurringPayment').checked == true && document.getElementById('recurringTotalOccurrences').value == '' ) {
            alert("Please enter total occurrences value.");
            return false;
        } else if ( document.getElementById('processRecurringPayment').checked == true && !( document.getElementById('recurringTotalOccurrences').value > 0 ) ) {
            alert("Please enter valid total occurrences.");
            return false;
        } else  if ( document.getElementById('processRecurringPayment').checked == true && document.getElementById('recurringTotalOccurrences').value > 9999 ) {
            alert("Please enter valid total occurrences, you can not enter value larger than 9999.");
            return false;
        } else  if (document.getElementById('variablePaymentTemplate').checked == true  && (document.getElementById('recurringAmount').value != ''|| document.getElementById('initialAmount').value != '') &&
					(document.getElementById('recurringAmount').value != 0|| document.getElementById('initialAmount').value != 0)) {
            alert("Please do not enter amounts for variable payment template.");
            return false;
        } 
        if ( document.getElementById('recurringSpecificStartDate').value != '' && document.getElementById('recurringXDaysDelayStartDate').value != '' ) {
            alert("You can provide either a specific start date or 'X' days delay for subscription start date. Please choose only one.");
            return false;
        }
        
        
        
        return true;
}
</script>
	
	<div class="wrap" style="width: 700px;">
<?php
		$show_update_msg = false;
		if (isset($_POST['action'])) {
			if ($_POST['action'] == 'edit' && isset($_POST['ID']) && is_numeric($_POST['ID'])) {
				$details = $wpdb->get_row("SELECT * FROM $authnet_subscription_table_name WHERE ID = ".intval($_POST['ID']));
				$action = 'edit';
				$safeID = intval($details->ID);
				$safeprocessSinglePayment = intval($details->processSinglePayment);
				$safeprocessRecurringPayment = intval($details->processRecurringPayment);
				$safeprocessVariablePaymentTemplate = intval($details->variablePaymentTemplate);
				$safename = $wpdb->escape($details->name);
				$safeinitialAmount = floatval($details->initialAmount);
				$safeinitialDescription = $wpdb->escape($details->initialDescription);
				$safeinitialInvoiceNum = $wpdb->escape($details->initialInvoiceNum);
				$saferecurringRefId = $wpdb->escape($details->recurringRefId);
				$saferecurringIntervalLength = intval($details->recurringIntervalLength);
				$saferecurringIntervalUnit = $wpdb->escape($details->recurringIntervalUnit);
				$saferecurringTotalOccurrences = intval($details->recurringTotalOccurrences);
				$saferecurringConcealTrial = intval($details->recurringConcealTrial);
				$saferecurringTrialOccurrences = intval($details->recurringTrialOccurrences);
				$saferecurringAmount = floatval($details->recurringAmount);
				$saferecurringTrialAmount = floatval($details->recurringTrialAmount);
				$safewishlistLevel = $wpdb->escape($details->wishlistLevel);
				$safesubmLevel = $wpdb->escape($details->submLevel);
				$recurring_specific_start_date = $wpdb->escape($details->specificStartDate);
				$recurring_xdays_delay_start_date = intval($details->xDaysDelayStartDate);
				$safesurvey = $wpdb->escape(stripslashes($details->survey));
				$safe_thankyoupage = $wpdb->escape($details->thankyou_page);
			} else if ($_POST['action'] == 'update' && isset($_POST['ID']) && is_numeric($_POST['ID'])) {
				$query = "UPDATE $authnet_subscription_table_name
							SET processSinglePayment = ".(($_POST['processSinglePayment'] == 'on') ? 1:0).",
							processRecurringPayment = ".(($_POST['processRecurringPayment'] == 'on') ? 1:0).",
							variablePaymentTemplate = ".(($_POST['variablePaymentTemplate'] == 'on') ? 1:0).",
							name = '".$wpdb->escape($_POST['name'])."',
							initialAmount = ".floatval($_POST['initialAmount']).",
							initialDescription = '".$wpdb->escape($_POST['initialDescription'])."',
							initialInvoiceNum = '".$wpdb->escape($_POST['initialInvoiceNum'])."',
							recurringRefId = '".$wpdb->escape($_POST['recurringRefId'])."',
							recurringIntervalLength = ".intval($_POST['recurringIntervalLength']).",
							recurringIntervalUnit = '".$wpdb->escape($_POST['recurringIntervalUnit'])."',
							recurringConcealTrial = ".(($_POST['recurringConcealTrial'] == 'on') ? 1:0).",
							recurringTotalOccurrences = ".intval($_POST['recurringTotalOccurrences']).",
							recurringTrialOccurrences = ".intval($_POST['recurringTrialOccurrences']).",
							recurringAmount = ".floatval($_POST['recurringAmount']).",
							recurringTrialAmount = ".floatval($_POST['recurringTrialAmount']).",
							wishlistLevel = '".$wpdb->escape($_POST['wishlistLevel'])."',
							submLevel = '". substr($wpdb->escape($_POST['submLevel']), 11 , 1)."',
							specificStartDate = '".$wpdb->escape($_POST['recurringSpecificStartDate'])."',
							xDaysDelayStartDate = '".intval($_POST['recurringXDaysDelayStartDate'])."',
							thankyou_page = '" . $wpdb->escape($_POST['thankyou_page'])."',
							survey = '".$wpdb->escape(stripslashes($_POST['survey']))."'
							WHERE ID = ".intval($_POST['ID']);
				$show_update_msg = $wpdb->query($query);
			} else if ($_POST['action'] == 'insert') {
				$query = "INSERT INTO $authnet_subscription_table_name
							SET processSinglePayment = ".(($_POST['processSinglePayment'] == 'on') ? 1:0).",
							processRecurringPayment = ".(($_POST['processRecurringPayment'] == 'on') ? 1:0).",
							variablePaymentTemplate = ".(($_POST['variablePaymentTemplate'] == 'on') ? 1:0).",
							name = '".$wpdb->escape($_POST['name'])."',
							initialAmount = ".floatval($_POST['initialAmount']).",
							initialDescription = '".$wpdb->escape($_POST['initialDescription'])."',
							initialInvoiceNum = '".$wpdb->escape($_POST['initialInvoiceNum'])."',
							recurringRefId = '".$wpdb->escape($_POST['recurringRefId'])."',
							recurringIntervalLength = ".intval($_POST['recurringIntervalLength']).",
							recurringIntervalUnit = '".$wpdb->escape($_POST['recurringIntervalUnit'])."',
							recurringConcealTrial = ".(($_POST['recurringConcealTrial'] == 'on') ? 1:0).",
							recurringTotalOccurrences = ".intval($_POST['recurringTotalOccurrences']).",
							recurringTrialOccurrences = ".intval($_POST['recurringTrialOccurrences']).",
							recurringAmount = ".floatval($_POST['recurringAmount']).",
							recurringTrialAmount = ".floatval($_POST['recurringTrialAmount']).",
							wishlistLevel = '".$wpdb->escape($_POST['wishlistLevel'])."',
							submLevel = '". substr($wpdb->escape($_POST['submLevel']), 11 , 1)."',
							specificStartDate = '".$wpdb->escape($_POST['recurringSpecificStartDate'])."',
							xDaysDelayStartDate = '".intval($_POST['recurringXDaysDelayStartDate'])."',
							thankyou_page = '" . $wpdb->escape($_POST['thankyou_page'])."',
							survey = '".$wpdb->escape(stripslashes($_POST['survey']))."'";
				$show_update_msg = $wpdb->query($query);
			} else if ($_POST['action'] == 'delete' && isset($_POST['ID']) && is_numeric($_POST['ID'])) {
				$query = "delete from $authnet_subscription_table_name
							WHERE ID = ".intval($_POST['ID']);
				$show_update_msg = $wpdb->query($query);
			}
		}
?>
<?php 
		if ($show_update_msg !== false) { 
?>
			<div id="message" class="updated" style="padding: 4px; font-weight: bold;">Subscription Settings Saved (scroll down to view)</div>
<?php 
		} 
?>      
		<h2>Authorize.net for WordPress Subscriptions </h2>
<?php
                // Display warning message if plugin is being used without SSL installed
                echo get_use_ssl_warning('admin_page');
?>
		<div class="Settings-wrap">
			<div class="info-box">
				<div class="info-content">
                    A Subscription is a template that defines how a transaction will process. Use the form below to create or edit subscription types for your site. The Available Subscriptions tab shows a summary of each subscription type and provides a <i>buy now link</i>. You can also edit a subscription at any time to affect all future transactions that reference that subscription.
				</div>
				<div class="Owner">
                    This plugin was created by <a href="http://www.danielwatrous.com">Daniel Watrous</a>. Step by step videos are available on the <a href="http://www.danielwatrous.com/authorizenet-for-wordpress/plugin-training">training page</a>.
				</div>
			</div>
			<div class="settings-header">
				<ul>
					<li>
						<span>Subscription Management</span>
					</li>
				</ul>
			</div>
			<div class="settings-container">
				<form action="" method="post" name="f" onsubmit=" return validateSubscription()">
					<p><b>Bold</b> fields are required.</p>
					<div class="subscription_details">
						<h3>Subscription Details:</h3>
						
						<label for="name" class="required">Subscription Name: </label>
						<input value="<?php echo ($action=='edit') ? $safename:'' ?>" type="text" id="name" name="name" title="subscription name"><br>
						<small>This describes the subscription (e.g. Super Gold Membership).</small>
						
<?php 
						$surveys = json_decode(get_option("authnet_surveys"));
						if ($surveys != NULL && count($surveys)>0) {
?>
							<label for="survey">Survey: </label>
							<select id="survey" name="survey">
							<option value="">-- Choose Survey --</option>
<?php 							foreach ($surveys as $survey) { 
?>
									<option value="<?php echo $survey->surveyName; ?>" <?php if ($safesurvey == $survey->surveyName) echo "selected"; ?>><?php echo (get_option('authnet_default_survey')==$survey->surveyName)? stripslashes($survey->surveyName) .'(Default)': stripslashes($survey->surveyName); ?></option>
<?php 
								} // end foreach 
?>
							</select><br />
							
<?php 
						}// end if 
?>
							<label for="authnet_specific_thankyoupage">Thank You Page: </label>
							<input value="<?php echo ( $action == 'edit') ? $safe_thankyoupage : '' ?>" type="text" id="thankyou_page" name="thankyou_page" title="subscription specific thankyou page"> <br />
							<small>This is a page in WordPress that contains a specific thank-you message & directing the customer to subscription specific thank-you page.</small>
							
<?php 					if ( is_plugin_active('subscriptionmate/subscriptionmate.php') ) { //plugin is activated
?>
							<label for="submLevel">Subscription Mate Member Levels: </label>
							<select id="submLevel" name="submLevel" >
								<option value="">-- Choose Level --</option>
<?php 
									$SM_roles = '';
									$editable_roles = get_editable_roles();
									
									foreach ( $editable_roles as $role => $details ) {
										$name = translate_user_role($details['name'] );
										
										if ( !(strpos(esc_attr($role), 'subm_level') === 0) ) continue; 
										
										if (substr(esc_attr($role), 11 , 1) == $safesubmLevel )
											$SM_roles .= "\n\t<option selected='selected' value='" . esc_attr($role) . "'>$name</option>";
										else 
											$SM_roles .= "\n\t<option value='" . esc_attr($role) . "'>$name</option>";
									}
									echo $SM_roles;
                                    ?>
							</select>
							<small> Membership levels as defined in Subscription Mate.</small>
                                                        
<?php 
					}
?>

<?php 					if (is_plugin_active( get_option('authnet_wishlistinstalldirectory') . '/wpm.php')) { //plugin is activated 
?>
							<label for="wishlistLevel">WishList Member Level: </label>
							<select id="wishlistLevel" name="wishlistLevel" >
								<option value="">-- Choose Level --</option>

<?php 							
                                foreach (WLMAPI::GetOption("wpm_levels") as $sku => $membership_level) {
									$wlm_level = (isset($membership_level["wpm_newid"])) ? $membership_level["wpm_newid"]:$sku; 
?>
									<option value="<?php echo $wlm_level; ?>" <?php if ($safewishlistLevel == $wlm_level) echo "selected"; ?>><?php echo $membership_level["name"]; ?></option>
<?php 
								}
                                $query_payperpost_levels = "select * from ".$wpdb->prefix."wlm_contentlevels where level_id = 'PayPerPost'";
                                var_dump($query_payperpost_levels);
                                $payperpostlevels = $wpdb->get_results($query_payperpost_levels);
                                foreach ($payperpostlevels as $payperpostlevel) {
                                    $payperpostlevelname = "payperpost-".$payperpostlevel->content_id;
?>
									<option value="<?php echo $payperpostlevelname; ?>" <?php if ($safewishlistLevel == $payperpostlevelname) echo "selected"; ?>><?php echo $payperpostlevelname; ?></option>
<?php 
                                }
?>
							</select>
							<small>This is a membership level as defined in WishList Member.</small>
<?php 
						} 
?>
						<label for="processSinglePayment">Process Single Payment: </label>
						<input <?php echo ($action=='edit' && $safeprocessSinglePayment>0) ? 'checked':'' ?> type="checkbox" id="processSinglePayment" name="processSinglePayment"  title="Process Single Payment"><br>
						<label for="processRecurringPayment">Process Recurring Payment: </label>
						<input <?php echo ($action=='edit' && $safeprocessRecurringPayment>0) ? 'checked':'' ?> type="checkbox" id="processRecurringPayment" name="processRecurringPayment" title="Process Recurring Payment"><br>
                        <label for="variablePaymentTemplate">Variable Payment Template: </label>
						<input <?php echo ($action=='edit' && $safeprocessVariablePaymentTemplate>0) ? 'checked':'' ?> type="checkbox" id="variablePaymentTemplate" name="variablePaymentTemplate"  title="Variable Payment Template"><br>
						<small>If you check this option then you will not be required to enter the amount since amount will be collected on variable payment form during checkout. You will be able to see this template on the variable payment page.</small>
					</div>

					<div class="initial_payment_details">
						<h3>Initial Payment Details:</h3>
						
						<label for="initialAmount">One-time Amount: </label>
						<input value="<?php echo ($action=='edit') ? $safeinitialAmount:'' ?>" type="text" id="initialAmount" name="initialAmount" title="amount"><br>
						<small>Required if Process Single Payment above is checked.  Amount in USD.</small>
							
						<label for="initialDescription" accesskey="c">Description: </label>
						<textarea name="initialDescription" rows="2" cols="23" id="initialDescription"  title="description"><?php echo ($action=='edit') ? $safeinitialDescription:'' ?></textarea><br>
					</div>

					<div class="reurring_payment_details">
						<h3>Recurring Payment Details:</h3>
						
						<label for="recurringAmount">Recurring Amount: </label>
						<input value="<?php echo ($action=='edit') ? $saferecurringAmount:'' ?>" type="text" id="recurringAmount" name="recurringAmount"  title="amount"><br>
						<small>Required if Process Recurring Payment above is checked.  Amount in USD.</small>
						
						<label for="recurringIntervalLength">Recurring interval length: </label>
						<input value="<?php echo ($action=='edit') ? $saferecurringIntervalLength:''; ?>" type="text" id="recurringIntervalLength" name="recurringIntervalLength"  title="Recurring interval length"><br>
						<small>Up to 3 digits.  If unit below is months, valid values are between 1 and 12.  If unit is days, valid values are between 7 and 365.</small>
						
						<label for="recurringIntervalUnit">Recurring interval unit: </label>
						<select  id="recurringIntervalUnit" name="recurringIntervalUnit"  title="Recurring interval length">
							<option value="">-- choose unit --</option>
							<option value="days" <?php echo ($action=='edit' && $saferecurringIntervalUnit=='days') ? 'selected':''; ?>>days</option>
							<option value="months" <?php echo ($action=='edit' && $saferecurringIntervalUnit=='months') ? 'selected':''; ?>>months</option>
						</select>
						<small>Use in association with length above to determine the interval between each billing occurrence.</small>
						
						<label for="recurringRefId">Reference ID (optional): </label>
						<input value="<?php echo ($action=='edit') ? $saferecurringRefId:''; ?>" type="text" id="recurringRefId" name="recurringRefId"  title="Reference ID"><br>
						
						<label for="recurringTotalOccurrences">Total occurrences: </label>
						<input value="<?php echo ($action=='edit') ? $saferecurringTotalOccurrences:''; ?>" type="text" id="recurringTotalOccurrences" name="recurringTotalOccurrences"  title="email"><br>
						<small>Number of billing occurrences.  9999 for ongoing subscriptions.</small>
                                                
                                               
						<label for="recurringConcealTrial">Conceal Trial At Checkout: </label>
						<input <?php echo ($action=='edit' && $saferecurringConcealTrial>0) ? 'checked':'' ?> type="checkbox" id="recurringConcealTrial" name="recurringConcealTrial" title="Conceal Trial Details"><br>
						<small>When checked, this option will prevent details about trial payments from being displayed to the user at checkout.</small>
						
						<label for="recurringTrialAmount">Trial Amount: </label>
						<input value="<?php echo ($action=='edit') ? $saferecurringTrialAmount:''; ?>" type="text" id="recurringTrialAmount" name="recurringTrialAmount"  title="email"><br>
						<small>Required if trial occurrences below is set.  The amount to be charged for each payment during a trial period.</small>
						
						<label for="recurringTrialOccurrences">Trial occurrences: </label>
						<input value="<?php echo ($action=='edit') ? $saferecurringTrialOccurrences:''; ?>" type="text" id="recurringTrialOccurrences" name="recurringTrialOccurrences"  title="email"><br>
						<small>Number of billing occurrences in the trial period.</small>
                                                
						<label for="recurringSpecificStartDate">Start Date: </label>
						<input value="<?php echo ($action=='edit') ? (($recurring_specific_start_date == '0000-00-00')? '': $recurring_specific_start_date ):''; ?>" type="text" id="recurringSpecificStartDate" name="recurringSpecificStartDate"  size="11" title="specific date"><label id="start-date-delay" >YYYY-MM-DD</label><br>
						<small>Please enter specific start date for your transaction processing, If not entered or expired date then transaction will be processed at normal date.</small>
                                                
                                                <label for="recurringXDaysDelayStartDate">Start after </label>
						<input value="<?php echo ($action=='edit') ? (($recurring_xdays_delay_start_date == '0')? '':$recurring_xdays_delay_start_date):''; ?>" type="text" id="recurringXDaysDelayStartDate" name="recurringXDaysDelayStartDate"  size="2" title="X days delay"><label id="start-date-delay" >days.</label><br>
						<small>Please enter number of days after you want the transaction should be processed, If not entered then transaction will be processed at normal date.</small>
                                                
						<h3></h3>
						
						<label for="kludge"></label>
<?php 					if ($action=='edit') { 
?>
							<input type="hidden" name="ID" value="<?php echo $safeID; ?>">
<?php 
						} 
?>					
						<input type="hidden" name="action" value="<?php echo ($action=='edit') ? 'update':'insert'; ?>">
						<input type="submit" value="Submit" id="submit" > <INPUT type="reset" id="reset">
					</div>
				</form>
			</div>
		</div>
		
		<div class="Settings-wrap">
			<div class="settings-header">
				<ul>
					<li>
						<span>Available Subscriptions</span>
					</li>
				</ul>  
			</div>
			<div class="settings-container">
				<table class="widefat">
					<thead>
						<tr>
							<th scope="col">Name</th> 
							<th scope="col">Single</th> 
							<th scope="col">Recurring</th>
							<th scope="col">S:Amount</th>
							<th scope="col">R:Amount</th>
							<th scope="col">Billing cycle</th>
							<th scope="col">Edit</th>
							<th scope="col">Delete</th>
						</tr>
					</thead>
					<!-- stdClass Object ( [ID] => 1 [processSinglePayment] => 1 [processRecurringPayment] => 0 [name] => Single Post Purchase Template [initialAmount] => 0.00 [initialDescription] => Single Post Purchase Template [initialInvoiceNum] => [recurringRefId] => [recurringIntervalLength] => [recurringIntervalUnit] => [recurringTotalOccurrences] => [recurringTrialOccurrences] => [recurringAmount] => [recurringTrialAmount] => ) -->
<?php
					$query = "SELECT * FROM $authnet_subscription_table_name ORDER BY ID ASC";
					$log->LogDebug($query);
					$subscriptions = $wpdb->get_results($query);

					// Step through our list of subscriptions
					foreach ($subscriptions as $subscription) { 
?>
						<tr align="left" valign="middle">
							<td><?php echo $subscription->name; ?></td>
							<td align="center"><?php echo ($subscription->processSinglePayment==1) ? 'Yes':'No'; ?></td>
							<td align="center"><?php echo ($subscription->processRecurringPayment) ? 'Yes':'No'; ?></td>
							<td>$<?php echo ($subscription->initialAmount == '')? '0.00' : $subscription->initialAmount; ?></td>
							<td><?php echo ($subscription->processRecurringPayment==1) ? '$'. ( ($subscription->recurringAmount == '') ? '0.00' : $subscription->recurringAmount ):'--'; ?></td>
							<td><?php echo ($subscription->processRecurringPayment==1) ? 'every '.$subscription->recurringIntervalLength.' '.$subscription->recurringIntervalUnit:'--'; ?></td>
							<td>
								<form method="post" style="min-width: 60px; width: 60px;">
								<input type="hidden" name="ID" value = "<?php echo $subscription->ID; ?>">
								<input type="hidden" name="action" value = "edit">
								<input type="submit" value="Edit">
								</form>
							</td>
							<td>
								<form method="post" style="min-width: 22px; width: 22px;">
								<input type="hidden" name="ID" value = "<?php echo $subscription->ID; ?>">
								<input type="hidden" name="action" value = "delete">
								<input type="image" src="<?php echo get_bloginfo ('wpurl') . preg_replace ('#^.*[/\\\\](.*?)[/\\\\].*?$#', "/wp-content/plugins/$1/images/delete.png", __FILE__); ?>">
								</form>

							</td>
						</tr>
						<tr>
							<td colspan="8">
<?php                   		if( $subscription->variablePaymentTemplate == 1 ) {
?>
									<p> variable payment template </p>
<?php                           } else { 
?>
									Add To Cart Link: <input type="text" id="buy-now-link" value="<?php echo getSubscriptionLink($subscription); ?>" size="75" readonly onClick="select()">
<?php                            } 
?>   
									<hr>
							</td>
						</tr>
<?php 
					} 
?>
				</table>
			</div>
		</div>	
	</div>
