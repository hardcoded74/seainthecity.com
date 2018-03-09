<?php

/*
 * Copyright 2010, Maintain Fit LLC, Daniel Watrous, All rights reserved
 * By using this software you agree to be bound by the terms
 * outlined in the License.txt file included with the software.
 *
 * If you still have questions please send them to helpdesk@danielwatrous.com
 *
 */

if ('authnet_checkout_form2.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('<h2>Direct File Access Prohibited</h2>');

include('authnet_checkout_common.php');

$countrySelectBilling = str_replace('{COUNTRYSELECT}', 'billingCountry' , $countryselect);
if ($billingCountry == '') $billingCountry = 'US';
$countrySelectBilling = str_replace ($billingCountry."'", $billingCountry."' selected", $countrySelectBilling);

$countrySelectShipping = str_replace('{COUNTRYSELECT}', 'shippingCountry' , $countryselect);
if ($shippingCountry == '') $shippingCountry = 'US';
$countrySelectShipping = str_replace ($shippingCountry."'", $shippingCountry."' selected", $countrySelectShipping);

$checkoutform = <<<AUTHNETCO
		{$open_div}
		{$authnet_toggle_fields}
		<link href="AUTHNET_CSS" rel="stylesheet" type="text/css" />
		<script language="JavaScript">
		<!-- Begin
		function popUp(URL) {
		day = new Date();
		id = day.getTime();
		eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=256,height=435');");
		}
		// End -->
		</script>
		{$authnet_redirect}
		{$authnet_hide_shipping_fields}
	AUTHNET_OVERRIDE_CSS
		<div class="authnet_contain_area">
                {USE_SSL_WARNING}
			{CART_PAYMENT_FORM}
			<form action="{$post_url_process}" method="post">
                         {SINGLE_PAYMENT_FORM}
				<div class="authnet_page2">
					<div class="page_contain_bg2">
						<div class="authnet_pay_pal_box2">
							AUTHNET_CC_DETAILS
							AUTHNET_ECHECK_DETAILS
							AUTHNET_ENABLE_ECHECK_PAYMENT
							<div class="authnet_billing_box2" style="border: 0px;">	
								<div class="authnet_recaptcha">
										AUTHNET_RECAPTCHA   
								</div>
							</div>
							<div class="cc_restrictions">
								<div class="authnet_pay_now_bt">
									<input type="submit" value="AUTHNET_FORM_BUTTON_TEXT" class="authnet_pay_now_image">                  	
								</div>
							</div>
							&nbsp;<br />
							<div class="authnet_billing_box2">
							AUTHNET_GUARANTEE_HTML
							</div>
						</div>
						<div class="authnet_heading2"><h2>Billing Details</h2></div>
						<div class="authnet_billing_box2">						
							<div class="content">Please enter your billing information as it would appear on your credit card statement. Accurate information will prevent delays in your order.</div>
							<div class="authnet_billing_box2_form">
								<div class="authnet_form_part"><!--FORMPART START-->
									<div class="authnet_label_container">First Name*</div>
									<div class="form3_input_area">
										<input type="text" id="billingFirstName" name="billingFirstName" value="{$billingFirstName}" class="authnet_input" />
									</div>
								</div>                             
								<div class="authnet_form_part">
									<div class="authnet_label_container">Last Name*</div>
									<div class="form3_input_area">
										<input type="text" id="billingLastName" name="billingLastName" title="last name" value="{$billingLastName}" class="authnet_input" />
									</div>
								</div> 
								<div class="authnet_form_part">
									<div class="authnet_label_container">Company{$company_required}</div>
									<div class="form3_input_area">
										<input type="text" id="billingCompany" name="billingCompany" title="billingCompany" value="{$billingCompany}" class="authnet_input" />
									</div>
								</div>
								<div class="authnet_form_part">
									<div class="authnet_label_container">Email address*</div>
									<div class="form3_input_area">
										<input type="text" id="email" name="email" title="email" value="{$email}" class="authnet_input" />
									</div>
								</div>
								<div class="authnet_form_part"><!--FORMPART START-->
									<div class="authnet_label_container">Address*</div>
									<div class="form3_input_area">					  
										<textarea name="billingAddress" rows="2" cols="30" id="billingAddress" title="address" class="authnet_input" style="height: 26px;">{$billingAddress}</textarea>
									</div>
								</div>
								<div class="authnet_form_part">
									<div class="authnet_label_container">City*</div>
									<div class="form3_input_area">					  
										<input type="text" id="billingCity" name="billingCity" title="city" value="{$billingCity}" class="authnet_input" />
									</div>
								</div>
								<div class="authnet_form_part">
									<div class="authnet_label_container">State*</div>
									<div class="form3_input_area">					  
										<input type="text" id="billingState" name="billingState" title="state" value="{$billingState}" class="authnet_input" />
									</div>
								</div>
								<div class="authnet_form_part">
									<div class="authnet_label_container">Zip code*</div>
									<div class="form3_input_area">					  
										<input type="text" id="billingZip" name="billingZip" title="zip" value="{$billingZip}" class="authnet_input" />
									</div>
								</div>
								<div class="authnet_form_part">
									<div class="authnet_label_container">Phone{$phone_required}</div>
									<div class="form3_input_area">					  
										<input type="text" id="billingPhone" name="billingPhone" title="phone" value="{$billingPhone}" class="authnet_input" />
									</div>
								</div>
								<div class="authnet_form_part"><!--FORMPART START-->
									<div class="authnet_label_container">Country*<br></div>
									<div class="authnet_list_area">
										{$countrySelectBilling}
									</div>
								</div>
							</div>
                        </div>

SHIPPINGINFORMATION

SURVEY

USERINFORMATION

USERNOTES

					</div>
				</div>
				<input type="hidden" name="subscription" value="{$subscription}">
				<input type="hidden" value="{REQUIREDSURV}" name="required_survey"> 
				<input type="hidden" name="action" value="checkout">
			</form>
		</div>
		{$close_div}

AUTHNETCO;

// additional information
$userinfo_form = <<<AUTHNETUSERINFO

                        <div class="authnet_heading2"><h2>Access Details</h2></div>
                        <div class="authnet_billing_box2">							
							<div class="authnet_form_part">
								<div class="authnet_label_container">Desired Username*</div>
								<div class="form3_input_area">					  
									<input type="text" id="desiredUsername" name="desiredUsername" title="desired username" value="{$desiredUsername}" class="authnet_input" />
								</div>
							</div>
							<div class="authnet_form_part">
								<div class="authnet_label_container">Desired Password*</div>
								<div class="form3_input_area">					  
									<input type="text" id="desiredPassword" name="desiredPassword" title="desired password" value="{$desiredPassword}" class="authnet_input" />
								</div>
							</div>
							<div class="authnet_form_part">
								<div class="authnet_label_container"></div>
								<div class="form3_input_area" style="height:50px;">					  
									If left blank, a password will be generated for you.
								</div>
							</div>
						</div>

AUTHNETUSERINFO;

$usernotes_form = <<<AUTHNETUSERNOTES

                        <div class="authnet_heading2"><h2>Additional Information</h2></div>
                        <div class="authnet_billing_box2">							
							<div class="authnet_form_part">
								<div class="authnet_label_container">Comments</div>
								<div class="form3_input_area">					  
									<textarea id="subscriptionNotes" name="subscriptionNotes" cols="30" rows="2" class="authnet_input">{$subscriptionNotes}</textarea>
								</div>
							</div>
                        </div>

AUTHNETUSERNOTES;

// form field templates
global $surveyfield_text, $surveyfield_textarea, $surveyfield_select, $surveyfield_option, $survey_fieldset;

$surveyfield_text = <<<AUTHNETSURVEY

							<div class="authnet_form_part">
								<div class="authnet_label_container">FIELDNAME{REQUIRED-SURVEY-ITEM}</div>
								<div class="form3_input_area">					  
									<input type="text" id="FIELDNAME" value="{FIELDVALUE}" name="survey_FIELDNAME" class="authnet_input" />
								</div>
							</div>

AUTHNETSURVEY;

$surveyfield_textarea =  <<<AUTHNETSURVEY

							<div class="authnet_form_part">
								<div class="authnet_label_container">FIELDNAME{REQUIRED-SURVEY-ITEM}</div>
								<div class="form3_input_area">					  
									<textarea id="FIELDNAME" name="survey_FIELDNAME" cols="30" rows="4" class="authnet_input">{FIELDVALUE}</textarea>
								</div>
							</div>

AUTHNETSURVEY;

$surveyfield_select =  <<<AUTHNETSURVEY

							<div class="authnet_form_part">
								<div class="authnet_label_container">FIELDNAME{REQUIRED-SURVEY-ITEM}</div>
								<div class="form3_input_area">					  
									<select id="FIELDNAME" name="survey_FIELDNAME" class="authnet_select">OPTIONS</select>
								</div>
							</div>

AUTHNETSURVEY;

$surveyfield_option =  '<option value="OPTIONKEY" {SELECTED} >OPTIONKEY</option>';

$survey_fieldset = <<<AUTHNETSURVEY


					<div class="authnet_heading2"><h2>SURVEYNAME</h2></div>
                    <div class="authnet_billing_box2">                        

FIELDS
					</div>

AUTHNETSURVEY;

$shipping_information = <<<SHIPPINGINFORMATION
<div class="authnet_heading2"><h2>Shipping Information</h2></div>
	<div class="authnet_billing_box2">
		<input type="checkbox" id="same_billing_address" name="same_billing_address"/> 
		<label><b> Same as billing address.</b> </label> <br /><br />
		<div id="shipping_information_block" style="display:block;">
			<div class="authnet_form_part">
				<div class="authnet_label_container">First Name*</div>
				<div class="form3_input_area">					  
					<input type="text" id="shippingFirstName" name="shippingFirstName" title="shipping first name" value="{$shippingFirstName}" class="authnet_input" />
				</div>
			</div>
			<div class="authnet_form_part">
				<div class="authnet_label_container">Last Name*</div>
				<div class="form3_input_area">					  
					<input type="text" id="shippingLastName" name="shippingLastName" title="shipping last name" value="{$shippingLastName}" class="authnet_input" />
				</div>
			</div>
			<div class="authnet_form_part">
				<div class="authnet_label_container">Company{$company_required}</div>
				<div class="form3_input_area">					  
					<input type="text" id="shippingCompany" name="shippingCompany" title="shipping company" value="{$shippingCompany}" class="authnet_input" />
				</div>
			</div>
			<div class="authnet_form_part">
				<div class="authnet_label_container">Address*</div>
				<div class="form3_input_area">					  
					<input type="text" id="shippingAddress" name="shippingAddress" title="shipping address" value="{$shippingAddress}" class="authnet_input" />
				</div>
			</div>
			<div class="authnet_form_part">
				<div class="authnet_label_container">City*</div>
				<div class="form3_input_area">					  
					<input type="text" id="shippingCity" name="shippingCity" title="shipping city" value="{$shippingCity}" class="authnet_input" />
				</div>
			</div>
			<div class="authnet_form_part">
				<div class="authnet_label_container">State*</div>
				<div class="form3_input_area">					  
					<input type="text" id="shippingState" name="shippingState" title="shipping state" value="{$shippingState}" class="authnet_input" />
				</div>
			</div>
			<div class="authnet_form_part">
				<div class="authnet_label_container">Zip code*</div>
				<div class="form3_input_area">					  
					<input type="text" id="shippingZip" name="shippingZip" title="shipping zip" value="{$shippingZip}" class="authnet_input" />
				</div>
			</div>
			<div class="authnet_form_part"><!--FORMPART START-->
					<div class="authnet_label_container">Country*<br></div>
					<div class="authnet_list_area">
						{$countrySelectShipping}
					</div>
				</div>
			
		</div>
	</div>

SHIPPINGINFORMATION;
$enable_echeck_payment_option =<<<ENABLEECHECKPAYMENT
<div class="authnet_billing_box2" style="padding-top: 9px;margin-bottom: 2px;">				
    <input type="checkbox" id="enable_echeck_payment" name="processEcheck" {ENABLECHECKED}/> 
<label><b>Pay via Electronic check method.</b> </label> <br /><br />
</div>
ENABLEECHECKPAYMENT;
$echeck_form_template = <<<ECHECKFROMSTYLE

<div id ="authnet_bank_details" class="authnet_bank_details" style="display: {DISPLAYECHECK};">
    
    <div class="authnet_heading2"><h2>Bank Account Details</h2></div>
    <div class="authnet_billing_box2"> 
    <div class="form_part_right">

            <!-- Bank Routing Number -->
            <div class="authnet_form_part">
                    <div class="authnet_label_container">Routing Number*</div>
                    <div class="form3_input_area">
                            <input value="" type="text" id="bankRoutingNumber" name="bankRoutingNumber" title="Bank Routing Number" autocomplete="off" class="authnet_input" /> 
                            <a style="float:none;"title="Bank Routing/Account Number" href="javascript:popUp('{$check_image}')" class="whatsthis">What's this?</a>
                    </div>
            </div>
            <!-- End Bank Routing Number -->


            <!-- Bank Account Number -->
            <div class="authnet_form_part">
                    <div class="authnet_label_container">Account Number*</div>
                    <div class="form3_input_area">
                            <input value="" type="text" id="bankAccountNumber" name="bankAccountNumber" title="Bank Account Number" autocomplete="off" class="authnet_input" /> 
                    </div>
            </div>
            <!-- End Bank Account Number -->

            <!-- Bank Name -->
            <div class="authnet_form_part">
                    <div class="authnet_label_container">Bank Name</div>
                    <div class="form3_input_area">
                            <input value="" type="text" id="bankName" name="bankName" title="Bank Name" autocomplete="off" class="authnet_input" /> 
                    </div>
            </div>
            <!-- End Bank Name -->

            <!-- Bank account type -->
            <div class="authnet_form_part">
                    <div class="authnet_label_container">Bank Account Type*<br></div>
                    <div class="authnet_list_area">
                            {$bank_account_type_select}
                    </div>
            </div>     

            <!-- Bank account tpe -->


            <!-- Bank Account Name -->
            <div class="authnet_form_part">
                    <div class="authnet_label_container">Bank Account Name*<br></div>
                    <div class="form3_input_area">
                            <input value="" type="text" id="bankAccountName" name="bankAccountName" title="Name associated with the bank account" autocomplete="off" class="authnet_input" /> 
                    </div>
            </div>
            <!-- End Bank Account Name -->
    </div>

    </div>
</div>
   
ECHECKFROMSTYLE;
$cc_form_template = <<<CREDITCARDFROMSTYLE
<div id = "authnet_cc_details" class="authnet_cc_details" style="display: {DISPLAYCC};">                                           
<div class="authnet_heading2"><h2>Credit or Debit Card Details</h2></div>
							<div class="authnet_billing_box2">                    	
								<div class="authnet_form_part"><!--FORMPART START-->
									<div class="authnet_label_container">Card Type*<br></div>
									<div class="authnet_list_area">
										{$cc_select}
									</div>
								</div>                       
								<div class="form_part_right"><!--FORMPART START-->
									<div class="authnet_form_part">
										<div class="authnet_label_container">Card Number*</div>
										<div class="form3_input_area">
											<input value="" type="text" id="creditCardNumber" name="creditCardNumber" title="creditCardNumber" autocomplete="off" class="authnet_input" /> 
										</div>
									</div>
									<div class="authnet_form_part2">
										<div class="authnet_label_container">Expiration Date*</div>							
										<div class="authnet_list_area2">
											{$exp_month_select}
										</div>
										<div class="authnet_slash">/</div>
										<div class="authnet_list_area2">
											{$exp_year_select}
										</div>
									</div>
								</div>
								<div class="authnet_form_part">
									<div class="authnet_label_container">CCV*</div> 
									<div class="form3_input_area">
										<input type="text" name="CreditCardCCV" style="width: 70px;" autocomplete="off" class="authnet_input-small" />
										<a title="CVV2 codes location" href="javascript:popUp('{$ccv_image}')" class="whatsthis">What's this?</a>
									</div>
								</div>
							</div>
                                                        
                </div>
CREDITCARDFROMSTYLE;
                                
?>

