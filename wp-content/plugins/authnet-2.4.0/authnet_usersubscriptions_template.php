<?php

/*
 * Copyright 2010, Maintain Fit LLC, Daniel Watrous, All rights reserved
 * By using this software you agree to be bound by the terms
 * outlined in the License.txt file included with the software.
 *
 * If you still have questions please send them to helpdesk@danielwatrous.com
 *
 */
if ('authnet_usersubscriptions_template.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('<h2>Direct File Access Prohibited</h2>');
include('authnet_checkout_common.php');

$user_subscriptions_main_template = <<<AUTHUSERSUBSCRIPTIONTABLE
<style type="text/css">
h3#user-sub-cc {
	border-bottom: 1px solid #E7E7E7;
	float: left;
	font-size: 1.1em;
	margin: 10px 0;
	padding: 7px 0;
	width: 100%;
}
.subscription_desc label {
	display: block;  /* block float the labels to left column, set a width */
	float: left;
	width: 180px;
	padding: 0;
	margin: 5px 0 0; /* set top margin same as form input - textarea etc. elements */
	text-align: right;
}
.subscription_desc .required{font-weight:bold;}
.subscription_desc input, .subscription_desc textarea, .subscription_desc select {
	width:auto;
	margin:5px 0 0 10px;
}
</style>
<link rel="stylesheet" href="{LINK_TO_CSS}" type="text/css">

<input type="hidden" id="update_script_url" value="{UPDATE_SCRIPT_URL}/authnet_process_update_subscription.php"/>
<input type="hidden" id="cancel_script_url" value="{CANCEL_SCRIPT_URL}/authnet_process_cancel_subscription.php"/>
<input type="hidden" id="refund_script_url" value="{REFUND_SCRIPT_URL}/authnet_process_refund_subscription.php"/>
<input type="hidden" id="void_script_url" value="{VOID_SCRIPT_URL}/authnet_process_void.php"/>
<input type="hidden" id="pending_capture_script_url" value="{PENDING_CAPTURE_SCRIPT_URL}/authnet_process_prior_auth_capture.php"/>

<table class="widefat post fixed" cellspacing="0">
	<thead>
		<tr class="thead">
			<th scope="col" id="firstname" class="manage-column column-firstname" style="width: 120px;">First Name</th> 
			<th scope="col" id="lastname" class="manage-column column-lastname" style="width: 120px;">Last Name</th> 
			<th scope="col" id="emailaddress" class="manage-column column-emailaddress" style="">Email address</th> 
			<th scope="col" id="address" class="manage-column column-address" style="">Address</th> 
			<th scope="col" id="phone" class="manage-column column-phone" style="">Phone</th> 
			<th scope="col" id="subscriptionnotes" class="manage-column column-subscriptionnotes" style="">Subscription Notes</th> 
			<th scope="col" id="startdate" class="manage-column column-startdate" style="width: 150px;">Start Date</th>
			<th scope="col" id="edit-cancle" class="manage-column column-edit-cancle" style="width: 150px;">Subscription</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th scope="col" class="manage-column column-firstname" style="">First Name</th> 
			<th scope="col" class="manage-column column-lastname" style="">Last Name</th> 
			<th scope="col" class="manage-column column-emailaddress" style="">Email address</th> 
			<th scope="col" class="manage-column column-address" style="">Address</th> 
			<th scope="col" class="manage-column column-phont" style="">Phone</th> 
			<th scope="col" class="manage-column column-subscriptionnotes" style="">Subscription Notes</th> 
			<th scope="col" class="manage-column column-startdate" style="">Start Date</th>
			<th scope="col" class="manage-column column-edit-cancel" style=""> Subscription</th>
		</tr>
	</tfoot>
	<tbody>
		<a href="#TB_inline?height=100&;width=500&;inlineId=subscription" class="thickbox"></a><div id="subscription" style="display:none"></div>
		{USERSUBSCRIPTONRECORDS}
	</tbody>
</table>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript"> 
	$(document).ready( function() {
		$('.submitUpate').click(function() {
		
			var update_param = {};
			if (this.name == "updatSubmitCC") {
			
				$('#subscription_details_' + this.id).children().each(function () {
					if ( this.name == 'subscription_id' ) update_param[this.name] = $(this).val();
					if ( this.name == 'user' ) update_param[this.name] = $(this).val();
					if ( this.name == 'creditCardNumber' ) update_param[this.name] = $(this).val();
					if ( this.name == 'cc_name' ) update_param[this.name] = $(this).val();
					if ( this.name == 'exp_year' ) update_param[this.name] = $(this).val();
					if ( this.name == 'exp_month' ) update_param[this.name] = $(this).val();
					if ( this.name == 'CreditCardCCV' ) update_param[this.name] = $(this).val();
					if ( this.name == 'paymentMethod' ) update_param[this.name] = $(this).val();
					update_param['id'] = this.id;
				});
			}
			
			if (this.name == "updatSubmitEcheck") {
			
				$('#subscription_details_' + this.id).children().each(function () {
					if ( this.name == 'subscription_id' ) update_param[this.name] = $(this).val();
					if ( this.name == 'user' ) update_param[this.name] = $(this).val();
					if ( this.name == 'bankRoutingNumber' ) update_param[this.name] = $(this).val();
					if ( this.name == 'bankAccountNumber' ) update_param[this.name] = $(this).val();
					if ( this.name == 'bankName' ) update_param[this.name] = $(this).val();
					if ( this.name == 'bankAccountType' ) update_param[this.name] = $(this).val();
					if ( this.name == 'bankAccountName' ) update_param[this.name] = $(this).val();
					if ( this.name == 'paymentMethod' ) update_param[this.name] = $(this).val();
					update_param['id'] = this.id;
				});
			}
			
			$('#' + this.id).attr("disabled", true);
			$('#' + this.id).val('Updating...');
			$.ajax({
					type: 'POST',
					url: $('#update_script_url').val(),
					data: jQuery.param(update_param),
					success: function(respnose) 	{
						$('#' + update_param['id']).attr("disabled", false);
						$('#' + update_param['id']).val('Update');
						if ( respnose == 'SUCCESS' ) {
							window.alert("Subscription Id #" + update_param['subscription_id'] + " updated successfully."); 
							location.reload();
						} else {
							window.alert(respnose);
							location.reload();
						}
					}
			});
		});
		
		$('.submitCancel').click(function() {
			var cancel_param = {};
			$('#subscription_details_' + this.id).children().each(function () {
				if ( this.name == 'subscription_id' ) cancel_param[this.name] = $(this).val();
				if ( this.name == 'user' ) cancel_param[this.name] = $(this).val();
				cancel_param['id'] = this.id;
			});
			$('#' + this.id).attr("disabled", true);
			$('#' + this.id).val('Cancelling...');
			$.ajax({
					type: 'POST',
					url: $('#cancel_script_url').val(),
					data: jQuery.param(cancel_param),
					success: function(respnose) 	{
						$('#' + cancel_param['id']).attr("disabled", false);
						$('#' + cancel_param['id']).val('Cancel');
						if ( respnose == 'SUCCESS' ) {
                                                         $('#' + cancel_param['id']).attr("disabled", true);
                                                        $('#' + cancel_param['id']).val('Canceled');
							window.alert("Subscription Id #" + cancel_param['subscription_id'] + " cancelled successfully."); 
							location.reload();
						} else {
							window.alert(respnose);
                                                        location.reload();
						}
					}
			});
		});
		
		$('.submitRefund').click(function() {
			var refund_param = {};
			$('#tranasction_details_' + this.id).children().each(function () {
                        
				if ( this.name == 'transaction_id' ) refund_param[this.name] = $(this).val();
					if ( this.name == 'user' ) refund_param[this.name] = $(this).val();
					if ( this.name == 'refund_amount' ) refund_param[this.name] = $(this).val();
					refund_param['id'] = this.id;
			});
			$('#' + this.id).attr("disabled", true);
			$('#' + this.id).val('Refunding...');
			$.ajax({
					type: 'POST',
					url: $('#refund_script_url').val(),
					data: jQuery.param(refund_param),
					success: function(respnose) 	{
						$('#' + refund_param['id']).attr("disabled", false);
						$('#' + refund_param['id']).val('Refund');
						if ( respnose == 'SUCCESS' ) {
                                                        $('#' + refund_param['id']).attr("disabled", true);
                                                        $('#' + refund_param['id']).val('Refunded');
							window.alert("Transaction Id #" + refund_param['transaction_id'] + " refunded successfully."); 
							location.reload();
						} else {
							window.alert(respnose);
							location.reload();
						}
					}
			});
		});
		
		$('.submitVoid').click(function() {
			var void_param = {};
			$('#tranasction_details_' + this.id).children().each(function () {
                        
				if ( this.name == 'transaction_id' ) void_param[this.name] = $(this).val();
				if ( this.name == 'user' ) void_param[this.name] = $(this).val();
				void_param['id'] = this.id;
			});
			$('#' + this.id).attr("disabled", true);
			$('#' + this.id).val('Processing...');
			$.ajax({
					type: 'POST',
					url: $('#void_script_url').val(),
					data: jQuery.param(void_param),
					success: function(respnose) 	{
						$('#' + void_param['id']).attr("disabled", false);
						$('#' + void_param['id']).val('Void');
						if ( respnose == 'SUCCESS' ) {
                                                $('#' + void_param['id']).attr("disabled", true);
						$('#' + void_param['id']).val('Voided');
							window.alert("Transaction Id #" + void_param['transaction_id'] + " voided successfully."); 
							location.reload();
						} else {
							window.alert(respnose);
						}
					}
			});
		});
		
		
		$('.submitPendingCapture').click(function() {
			var pending_capture_param = {};
			$('#tranasction_details_' + this.id).children().each(function () {
                        
				if ( this.name == 'transaction_id' ) pending_capture_param[this.name] = $(this).val();
				if ( this.name == 'user' ) pending_capture_param[this.name] = $(this).val();
				pending_capture_param['id'] = this.id;
			});
			$('#' + this.id).attr("disabled", true);
			$('#' + this.id).val('Processing...');
			$.ajax({
					type: 'POST',
					url: $('#pending_capture_script_url').val(),
					data: jQuery.param(pending_capture_param),
					success: function(respnose) 	{
						$('#' + pending_capture_param['id']).attr("disabled", false);
						$('#' + pending_capture_param['id']).val('Capture');
						if ( respnose == 'SUCCESS' ) {
                                                $('#' + pending_capture_param['id']).attr("disabled", true);
						$('#' + pending_capture_param['id']).val('Captured');
							window.alert("Transaction Id #" + pending_capture_param['transaction_id'] + " captured successfully."); 
							location.reload();
						} else {
							window.alert(respnose);
                                                        location.reload();
						}
					}
			});
		});
		
		
	});
</script>
AUTHUSERSUBSCRIPTIONTABLE;

$user_subscription_fname_template = <<<AUTHUSERSUBFNAME
	<a class="row-title" href="{USER_EDIT}" title="View &#8220;{BILLING_FIRST_NAME}&#8221;">{BILLING_FIRST_NAME}</a>
AUTHUSERSUBFNAME;

$user_subscription_mailto_template = <<<AUTHUSERSUBMAILTO
	<a href='mailto:{EMAIL_ADDRESS}'>{EMAIL_ADDRESS}</a>
AUTHUSERSUBMAILTO;

$user_subscriptions_template = <<<AUTHUSERSUBSCRIPTIONSRECORDS
		<tr id='user_{USER_ID}' class='alternate author-self status-publish iedit' valign="top"> 
			<td class="firstname column-firstname">
				<strong>{USER_SUB_FNAME}</strong> 
			</td> 
			<td class="lastname column-lastname"><strong>{BILLING_LAST_NAME}</strong></td> 
			<td class="emailaddress column-emailaddress">{USER_SUB_MAILTO}</td> 
			<td class="address column-address"><strong>{BILLING_ADDRESS}</strong>, {BILLING_CITY} {BILLING_STATE}, {BILLING_ZIP}, <em>{BILLING_COUNTRY}</em></td> 
			<td class="phone column-phone">{BILLING_PHONE}</td> 
			<td class="subscriptionnotes column-subscriptionnotes">{SUBSCRIPTION_NOTES}</td> 
			<td class="startdate column-startdate">{START_DATE}</td>
			<td class="manage-column column-edit-cancle">
			<span class="update-cancel-subscription" style="margin-left:15px;"> <b>{SUBSCRIPTIONID}</b></span><br />
			{UPDATE}{CANCEL}<span style="margin-left:12px;"><b>{SUBSCRIPTION-STATUS}</b></span>
			</td>
		</tr>				
AUTHUSERSUBSCRIPTIONSRECORDS;
$user_payments_template = <<<AUTHUSERPAYMENTS
		<tr>
			<td colspan="8">
				<b>Auth code:</b>{xAUTH_CODE} &nbsp;|&nbsp;
				<b>Transaction ID:</b>{xTRANSACTION_ID} &nbsp;|&nbsp;
				<b>Amount:</b>{xAMOUNT}&nbsp;|&nbsp;
				<b>Sub ID:</b>{xSUBSCRIPTION_ID} - {xSUBSCRIPTION_PAYNAME} &nbsp;|&nbsp;
				<b>Date:</b>{xPAYMENT_DATE} &nbsp;|&nbsp;
				{xREFUND}<span style="margin-left:12px;"><b>{REFUND-STATUS}</b></span>
                                {xVOID}{xCAPTURE}
                                <b>{xVOIDED}</b><b>{xExpired}</b>
				<hr>
			</td>
			
		</tr>
AUTHUSERPAYMENTS;

$user_purchase_list_template = <<<AUTHUSERPURCHASELIST
		<tr>
			<td colspan="8">
				<b>Subscription(s):</b> {PURCHASED_SUBSCRIPTON_LIST}
			</td>
		</tr>
AUTHUSERPURCHASELIST;

$user_sub_update_template_echeck = <<<AUTHUSERSUBEDITECHECK
		
		<a href="#TB_inline?height=400&;width=450&;inlineId=updatesubscription{SUB-ID}" class="thickbox" title="Update Subscription">Update</a>
		<div id="updatesubscription{SUB-ID}" style="display:none">
			<div class="subscription_desc" id="subscription_desc" >
				<div class="subscription_details_update" id="subscription_details_update{SUB-ID}">
					<h3 id="user-sub-cc">Bank Account Details:</h3>
					<label class="required">Subscription Id:</label>
					<label class="required" style="width: 94px;"> {SUBSCRIPTION_ID} </label>
					<input type="hidden" name="subscription_id" value="{SUBSCRIPTION_ID}"><br />
					<label for="bankRoutingNumber" class="required">Bank Routing Number*: </label>
					<input type="text" id="bankRoutingNumber" name="bankRoutingNumber" autocomplete="off" title="Bank Routing Number"/><br>
					<label for="bankAccountNumber" class="required">Bank Account Number*: </label>
					<input type="text" id="bankAccountNumber" name="bankAccountNumber" autocomplete="off" title="Bank Routing Number"/><br>
					<label for="bankName" class="required">Bank Name: </label>
					<input type="text" id="bankName" name="bankName" autocomplete="off" title="Bank Name"/><br>
					<label for="bankAccountType" class="required">Bank Account Type*: </label>{$bank_account_type_select}<br />
					<label for="bankAccountName" class="required">Bank Account Name*: </label>
					<input type="text" id="bankAccountName" name="bankAccountName" title="Bank Account Name" ><br>
					<input type="hidden" name="user" value={LEVEL} />
					<input type="hidden" name="paymentMethod" value="updateEcheck">
					<input type="hidden" name="action" value="update">
					<h3 style= "border-bottom: 1px solid #E7E7E7;float: left;font-size: 1.1em;margin: 10px 0;padding: 7px 0;width: 100%"></h3>
					<input type="button" name ="updatSubmitEcheck" value="Update Subscription" id="update{SUB-ID}" class = "submitUpate" style="margin: 0 0 0 180px;"> 
				</div> 
			</div>
				<div> {USE_SSL_WARNING} </div>
		</div>
AUTHUSERSUBEDITECHECK;


$user_sub_update_template = <<<AUTHUSERSUBEDIT
		<a href="#TB_inline?height=300&;width=450&;inlineId=updatesubscription{SUB-ID}" class="thickbox" title="Update Subscription">Update</a>
		<div id="updatesubscription{SUB-ID}" style="display:none">
			<div class="subscription_desc" id="subscription_desc" >
				<div class="subscription_details_update" id="subscription_details_update{SUB-ID}">
					<h3 id="user-sub-cc">Credit Card Details:</h3>
					<label class="required">Subscription Id:</label>
					<label class="required" style="text-align: left;padding-left: 10px;"> {SUBSCRIPTION_ID} </label>
					<input type="hidden" name="subscription_id" value="{SUBSCRIPTION_ID}"><br />
					<label for="cc_name" class="required">Card Type*: </label>{$cc_select}<br />
					<label for="creditCardNumber" class="required">Card Number*: </label>
					<input type="text" id="creditCardNumber" name="creditCardNumber" autocomplete="off" title="creditCardNumber"/><br>
					<label for="exp_date" class="required">Expiration Date*: </label>{$exp_month_select} /{$exp_year_select}
					<label for="CreditCardCCV" class="required">CCV*: </label>
					<input type="text" id="ccv_code" name="CreditCardCCV" title="CCV" size="10"><br>
					<input type="hidden" name="user" value={LEVEL} /> 
					<input type="hidden" name="action" value="update">
					<input type="hidden" name="paymentMethod" value="updateCC">
					<h3 style= "border-bottom: 1px solid #E7E7E7;float: left;font-size: 1.1em;margin: 10px 0;padding: 7px 0;width: 100%"></h3>
					<input type="button" name= "updatSubmitCC" value="Update Subscription" id="update{SUB-ID}" class = "submitUpate" style="margin: 0 0 0 180px;"> 
				</div> 
			</div>
				<div> {USE_SSL_WARNING} </div>
		</div>
AUTHUSERSUBEDIT;
$user_sub_cancel_template = <<<AUTHUSERSUBCANCEL
		<a href="#TB_inline?height=500&;width=400&;inlineId=cancelsubscription{SUB-ID}" class="thickbox" title="Cancel Subscription"> / Cancel </a>
		<div id="cancelsubscription{SUB-ID}" style="display:none">
		<div class="subscription_desc" id="subscription_desc" >
				<div class="subscription_details_cancel" id="subscription_details_cancel{SUB-ID}">
				<h3 id="user-sub-cc" >Cancel Subscription #{SUBSCRIPTION_ID}</h3>
				<input type="hidden" name="subscription_id" value="{SUBSCRIPTION_ID}"><br>
				<input type="hidden" name="user" value={LEVEL} /> 
				<input type="hidden" name="action" value="cancle">
				<input type="button" value="Cancel Subscription"  id="cancel{SUB-ID}" class = "submitCancel" style="margin: 0 0 0 142px;"> 
				</div>
		</div>
			<div> {USE_SSL_WARNING} </div>
		</div>
AUTHUSERSUBCANCEL;

$user_sub_refund_template = <<<AUTHUSERSUBREFUND
		<a href="#TB_inline?height=300&;width=450&;inlineId=refundtransaction{TRX-ID}" class="thickbox" title="Refund Transaction"> Refund </a>
		<div id="refundtransaction{TRX-ID}" style="display:none">
		<div class="subscription_desc" id="subscription_desc">
			<div class="tranasction_details_refund" id="tranasction_details_refund{TRX-ID}">
				<h3 id="user-sub-cc"> Refund Transaction #{TRANSACTION_ID}</h3>
				<input type="hidden" name="transaction_id" value="{TRANSACTION_ID}">
				<input type="hidden" name="refund_amount" value="{REFUND_AMOUNT}">				
				<input type="hidden" name="user" value="{LEVEL}"> 
				<input type="hidden" name="action" value="refund">
				<input type="button" value="Refund Transaction"  id="refund{TRX-ID}" class = "submitRefund" style="margin: 0 0 0 142px;"> 
			</div>
		</div>
			<div> {USE_SSL_WARNING} </div>
		</div>
AUTHUSERSUBREFUND;

$user_sub_void_template = <<<AUTHUSERSUBVOID
		<a href="#TB_inline?height=100&;width=450&;inlineId=voidtransaction{TRX-ID}" class="thickbox" title="Void Transaction"> Void </a>
		<div id="voidtransaction{TRX-ID}" style="display:none">
		<div class="subscription_desc" id="subscription_desc">
			<div class="tranasction_details_void" id="tranasction_details_void{TRX-ID}">
				<h3 id="user-sub-cc"> Void Transaction #{TRANSACTION_ID}</h3>
				<input type="hidden" name="transaction_id" value="{TRANSACTION_ID}">
				<input type="hidden" name="user" value="{LEVEL}"> 
				<input type="hidden" name="action" value="void">
				<input type="button" value="Void Transaction"  id="void{TRX-ID}" class = "submitVoid" style="margin: 0 0 0 142px;"> 
			</div>
		</div>
			<div> {USE_SSL_WARNING} </div>
		</div>
AUTHUSERSUBVOID;

$user_sub_capture_template = <<<AUTHUSERSUBCAPTURE
		<a href="#TB_inline?height=100&;width=450&;inlineId=pending_capture_transaction{TRX-ID}" class="thickbox" title="Pending Capture"> Capture </a>
		<div id="pending_capture_transaction{TRX-ID}" style="display:none">
		<div class="subscription_desc" id="subscription_desc">
			<div class="tranasction_details_pending_capture" id="tranasction_details_pending_capture{TRX-ID}">
				<h3 id="user-sub-cc"> Pending Transaction #{TRANSACTION_ID}</h3>
				<input type="hidden" name="transaction_id" value="{TRANSACTION_ID}">
				<input type="hidden" name="user" value="{LEVEL}"> 
				<input type="hidden" name="action" value="pending_capture">
				<input type="button" value="Capture Transaction"  id="pending_capture{TRX-ID}" class = "submitPendingCapture" style="margin: 0 0 0 142px;"> 
			</div>
		</div>
			<div> {USE_SSL_WARNING} </div>
		</div>
AUTHUSERSUBCAPTURE;

$notify_pending_capture = <<<AUTHNETPENDINDCAPTURE
<div class="updated">
    <p>
            <strong>
                There are some pending transactions, which need to be captured before they expire. You can capture/void them <a href="{PENDING_CAPTURE_URL}">here.</a> 
            </strong>
    </p>
</div>
AUTHNETPENDINDCAPTURE;


?>


