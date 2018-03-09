<?php
/*
 * Copyright 2010, Maintain Fit LLC, Daniel Watrous, All rights reserved
 * By using this software you agree to be bound by the terms
 * outlined in the License.txt file included with the software.
 *
 * If you still have questions please send them to helpdesk@danielwatrous.com
 *
 */

if ('authnet_transaction_summary1.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('<h2>Direct File Access Prohibited</h2>');
	
$transaction_summary = <<<AUTHNETTRANSACTIONSUMMARY
		<link href="AUTHNET_CSS" rel="stylesheet" type="text/css" />
		<div class="authnet_page">
			<div class="authnet_Container"> <!-- container Starts -->

						<div class="authnet_Header">	<!-- Header Starts -->
							<h2>Billing Details</h2>
						</div>	<!-- Header Ends -->
						<div class="authnet_Form">
							<div class="authnet_form_row"><!--FORMPART START-->
								<div class="authnet_label">First Name:</div>
								<div class="authnet_field">					  
								{BILLING_FIRST_NAME}
								</div>
							</div>
							<div class="authnet_form_row"><!--FORMPART START-->
							  <div class="authnet_label">Last Name:</div>
							  <div class="authnet_field">					  
								  {BILLING_LAST_NAME}
							  </div>
							</div>
							<div class="authnet_form_row"><!--FORMPART START-->
							  <div class="authnet_label">Email address:</div>
							  <div class="authnet_field">					  
								  {EMAIL}
							  </div>
							</div>
							<div class="authnet_form_row"><!--FORMPART START-->
							  <div class="authnet_label">Address:</div>
							  <div class="authnet_field">					  
								  {ADDRESS}
							  </div>
							</div>
							<div class="authnet_form_row"><!--FORMPART START-->
							  <div class="authnet_label">City:</div>
							  <div class="authnet_field">					  
								  {CITY}
							  </div>
							</div>
							<div class="authnet_form_row"><!--FORMPART START-->
							  <div class="authnet_label">State:</div>
							  <div class="authnet_field">					  
								  {STATE}
							  </div>
							</div>
							<div class="authnet_form_row"><!--FORMPART START-->
							  <div class="authnet_label">Zip code:</div>
							  <div class="authnet_field">					  
								  {ZIP}
							  </div>
							</div>
							<div class="authnet_form_row"><!--FORMPART START-->
							  <div class="authnet_label">Phone:</div>
							  <div class="authnet_field">					  
								  {PHONE}
							  </div>
							</div>
							<div class="authnet_form_row"><!--FORMPART START-->
							  <div class="authnet_label">Country:</div>
							  <div class="authnet_field">					  
								  {COUNTRY}
							  </div>
							</div>
						</div>
					</div>	<!-- container Ends -->
					<div class="authnet_Container"> <!-- container Starts -->

						<div class="authnet_Header">	<!-- Header Starts -->
						<h2>Transaction Details</h2>
						</div>	<!-- Header Ends -->
						<div class="authnet_Form">
							<div class="authnet_form_row"><!--FORMPART START-->
							  <div class="authnet_label">Login:</div>
							  <div class="authnet_field">					  
								   {LOGGEDIN}
							  </div>
							</div>
							<div class="authnet_form_row"><!--FORMPART START-->
							  <div class="authnet_label">Transaction Id:</div>
							  <div class="authnet_field">					  
								  {TRANSACTIONID}
							  </div>
							</div>                
							<div class="authnet_form_row"><!--FORMPART START-->
								<div class="authnet_label">Subscription Id:</div>
								<div class="authnet_field">					  
								  {SUBSCRIPTIONID}
								</div>
							</div>                
						</div>
					</div>
				</div>
				<div class="authnet_Container_purchase"> <!-- container Starts -->

						<div class="authnet_Header">	<!-- Header Starts -->
							<h2>Purchase Details</h2>
						</div>	<!-- Header Ends -->
						<div class="authnet_table">
							{PURCHASE_DETAIL}
						</div>
					</div>
{SURVEY}

					<div class="authnet_support">
						<p>
						<!-- support token should go here -->
						</p>
					</div>
					
AUTHNETTRANSACTIONSUMMARY;

$transaction_summary_survey = <<<AUTHNETTRANSACTIONSUMMARYSURVEY
<div class="authnet_Container_survey"> <!-- container Starts -->
        <div class="authnet_Header"><!-- Header Starts -->
                <h2>Survey Details</h2>
        </div>	<!-- Header Ends -->
        <div class="authnet_table">
                {SURVEY_DETAILS}
        </div>
</div>
AUTHNETTRANSACTIONSUMMARYSURVEY;
?>

