<?php

/*
 * Copyright 2010, Maintain Fit LLC, Daniel Watrous, All rights reserved
 * By using this software you agree to be bound by the terms
 * outlined in the License.txt file included with the software.
 *
 * If you still have questions please send them to helpdesk@danielwatrous.com
 *
 */

if ('authnet_variable_payment_form.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('<h2>Direct File Access Prohibited</h2>');

include('authnet_purchase_content_template.php');
$variable_payment_term = get_option('authnet_variable_payments_term');
$variable_payment_label = get_option('authnet_variable_payments_label');

$variable_payment_template = <<<AUTHNETVARIABLETEMPLATE
	<script type="text/javascript">
		function clear_box_amount() {
		   if ( document.getElementById('variable_amount').value != '' )
			document.getElementById('variable_amount').value = ''; 
		}
		function clear_preset() {
			var preset_amounts = document.getElementsByName("preset_amount");  
			for( var i = 0; i < preset_amounts.length; i++ )
				preset_amounts[i].checked = false;
		}
	</script>
      <div class='authnet_variable_payment'>
            <fieldset>
                    <legend>Please enter a {$variable_payment_term} amount</legend>
                    {$preset_options}
                    <br />{AMOUNT_LABEL}	
                    <input name="variable_amount" id="variable_amount" type="text" value="{AMOUNT}" onkeyup = "clear_preset();"><br />
                    <label id = "recurring-period"> {$variable_payment_label}</label>&nbsp;
                    {$variable_payments_select}
                    <input type="hidden" name="payment_type" value="variable_payments">
                    <input type="hidden" name="payment_term" value="{$variable_payment_term}">
                    <label>&nbsp;</label>		
	</fieldset>
      </div>
AUTHNETVARIABLETEMPLATE;
$variable_amount_label = <<<AMOUNTLABEL
	<label id="single-amount">Amount $</label>
AMOUNTLABEL;
$other_amount_label = <<<OTHERAMOUNTLABEL
	<label id="other-amount">Other $</label>
OTHERAMOUNTLABEL;
    
    
?>
