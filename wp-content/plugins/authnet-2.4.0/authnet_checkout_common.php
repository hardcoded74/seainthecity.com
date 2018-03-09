<?php

/*
 * Copyright 2010, Maintain Fit LLC, Daniel Watrous, All rights reserved
 * By using this software you agree to be bound by the terms
 * outlined in the License.txt file included with the software.
 *
 * If you still have questions please send them to helpdesk@danielwatrous.com
 *
 */

if ('authnet_checkout_form.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('<h2>Direct File Access Prohibited</h2>');
global $wpdb, $authnet_subscription_table_name;

// build checkout process action url
$post_url_process = get_bloginfo ('wpurl') . preg_replace ('#^.*[/\\\\](.*?)[/\\\\].*?$#', "/wp-content/plugins/$1/authnet_process.php", __FILE__);
// build  process update subscription action url
$post_url_process_update_subscription = get_bloginfo ('wpurl') . preg_replace ('#^.*[/\\\\](.*?)[/\\\\].*?$#', "/wp-content/plugins/$1/authnet_process_update_subscription.php", __FILE__);
// build  process cancle subscription action url
$post_url_process_cancel_subscription = get_bloginfo ('wpurl') . preg_replace ('#^.*[/\\\\](.*?)[/\\\\].*?$#', "/wp-content/plugins/$1/authnet_process_cancel_subscription.php", __FILE__);
// build  cart process action url
$post_url_cart_process = get_bloginfo ('wpurl') . preg_replace ('#^.*[/\\\\](.*?)[/\\\\].*?$#', "/wp-content/plugins/$1/authnet_cart_process.php", __FILE__);
// build url for checkout page
$url_cart_checkout = get_bloginfo ('wpurl') .'/' . get_option('authnet_checkoutpage');

// update to use https based on option setting
if (get_option('authnet_usessl')) {
    
    $post_url_process = preg_replace('|^http://|', 'https://', $post_url_process);
    $post_url_process_update_subscription = preg_replace('|^http://|', 'https://', $post_url_process_update_subscription);
    $post_url_process_cancel_subscription = preg_replace('|^http://|', 'https://', $post_url_process_cancel_subscription);
    $post_url_cart_process = preg_replace('|^http://|', 'https://', $post_url_cart_process);
    $url_cart_checkout = preg_replace('|^http://|', 'https://', $url_cart_checkout);
}
$ccv_image = get_bloginfo ('wpurl') . preg_replace ('#^.*[/\\\\](.*?)[/\\\\].*?$#', "/wp-content/plugins/$1/images/cvv.jpg", __FILE__);
$check_image = get_bloginfo ('wpurl') . preg_replace ('#^.*[/\\\\](.*?)[/\\\\].*?$#', "/wp-content/plugins/$1/images/checks.gif", __FILE__);

// determine whether phone is required
$phone_required = (get_option('authnet_require_phone')) ? '*':'';

// determine whether company is required
$company_required = (get_option('authnet_require_company')) ? '*':'';

// get variable payment templates for payment form
$variable_payments_select = '<select name = "variable_subscription">';
$query = "SELECT * FROM $authnet_subscription_table_name WHERE variablePaymentTemplate = '1' ORDER BY ID ASC";
$variable_pay_templates = $wpdb->get_results($query);
foreach ($variable_pay_templates as $variable_pay_template) 
	$variable_payments_select .= '<option value =' . $variable_pay_template->ID . ' {'. $variable_pay_template->ID . '}>' . $variable_pay_template->name . '</option>';
$variable_payments_select .= '</select><br />';

// preset amounts select options 
if ( get_option('authnet_allow_preset_amounts') && get_option('authnet_preset_amounts_list') != '' ) {
    $preset_count = 1;
    $preset_amounts = trim( get_option('authnet_preset_amounts_list') );
    $preset_amount_select_options = explode("\n", $preset_amounts);
    $preset_options = '<div class="authnet_preset_amount">';
    foreach ($preset_amount_select_options as $preset_amount_select_option) {  
        $preset_options .= '<input type="radio" name = "preset_amount" id="preset_amount_' . $preset_count . '" value="' . rtrim($preset_amount_select_option) . '" onclick="clear_box_amount();"> $' . number_format($preset_amount_select_option, 2, '.', ',');
        $preset_count++;
    }
    $preset_options .= '</div>';
}
// get card type options
$cc_select = '<select name="cc_name" id="cc_name" class="authnet_select{_CHECKOUT_SELECT}">';
$cc_select .= '<option value="">-- Select Card Type --</option>';
if (get_option('authnet_cardtype_visa'))
	$cc_select .= '<option value="Visa">Visa</option>';
if (get_option('authnet_cardtype_americanexpress'))
	$cc_select .= '<option value="American Express">American Express</option>';
if (get_option('authnet_cardtype_mastercard'))
	$cc_select .= '<option value="MasterCard">MasterCard</option>';
if (get_option('authnet_cardtype_discover'))
	$cc_select .= '<option value="Discover">Discover</option>';
$cc_select .= '</select>';

$bank_account_type_select = '<select name="bankAccountType" id="bankAccountType" class="authnet_select_small" style="width:140px;">
								<option value="">-- Select --</option>
								<option value="checking">Personal Checking</option>
								<option value="businessChecking">Business Checking</option>
								<option value="savings"> Savings </option>
							</select>';

$exp_month_select = <<<AUTHNETCO
<select name="exp_month" id="exp_month" class="authnet_select_small{_USER}">
	<option value=''>- Month -</option>
	<option value='01'>01</option>
	<option value='02'>02</option>
	<option value='03'>03</option>
	<option value='04'>04</option>
	<option value='05'>05</option>
	<option value='06'>06</option>
	<option value='07'>07</option>
	<option value='08'>08</option>
	<option value='09'>09</option>
	<option value='10'>10</option>
	<option value='11'>11</option>
	<option value='12'>12</option>
</select>
AUTHNETCO;

// get drop down of expiration years
$current_year = date ('Y');
$latest_year = $current_year+15;
$ccexp_years = range ($current_year, $latest_year);
$exp_year_select = '<select name="exp_year" id="exp_month" class="authnet_select_small{_USER}"><option value="">- Year -</option>';
foreach ($ccexp_years as $year) {
	$exp_year_select .= "\n	".'<option value="'.$year.'">'.$year.'</option>';
}
$exp_year_select .= "\n</select>";


$countryselect = <<<AUTHNETCO
<select name="{COUNTRYSELECT}" id="{COUNTRYSELECT}" class="authnet_select">
	<option value='AD'>Andorra</option>
	<option value='AE'>United Arab Emirates</option>
	<option value='AG'>Antigua and Barbuda</option>
	<option value='AI'>Anguilla</option>
	<option value='AL'>Albania</option>
	<option value='AM'>Armenia</option>
	<option value='AN'>Netherlands Antilles</option>
	<option value='AO'>Angola</option>
	<option value='AR'>Argentina</option>
	<option value='AT'>Austria</option>
	<option value='AU'>Australia</option>
	<option value='AW'>Aruba</option>
	<option value='AZ'>Azerbaijan Republic</option>
	<option value='BA'>Bosnia and Herzegovina</option>
	<option value='BB'>Barbados</option>
	<option value='BE'>Belgium</option>
	<option value='BF'>Burkina Faso</option>
	<option value='BG'>Bulgaria</option>
	<option value='BH'>Bahrain</option>
	<option value='BI'>Burundi</option>
	<option value='BJ'>Benin</option>
	<option value='BM'>Bermuda</option>
	<option value='BN'>Brunei</option>
	<option value='BO'>Bolivia</option>
	<option value='BR'>Brazil</option>
	<option value='BS'>Bahamas</option>
	<option value='BT'>Bhutan</option>
	<option value='BW'>Botswana</option>
	<option value='BZ'>Belize</option>
	<option value='CA'>Canada</option>
	<option value='CD'>Democratic Republic of the Congo</option>
	<option value='CG'>Republic of the Congo</option>
	<option value='CH'>Switzerland</option>
	<option value='CK'>Cook Islands</option>
	<option value='CL'>Chile</option>
	<option value='CN'>China</option>
	<option value='CO'>Colombia</option>
	<option value='CR'>Costa Rica</option>
	<option value='CV'>Cape Verde</option>
	<option value='CY'>Cyprus</option>
	<option value='CZ'>Czech Republic</option>
	<option value='DE'>Germany</option>
	<option value='DJ'>Djibouti</option>
	<option value='DK'>Denmark</option>
	<option value='DM'>Dominica</option>
	<option value='DO'>Dominican Republic</option>
	<option value='DZ'>Algeria</option>
	<option value='EC'>Ecuador</option>
	<option value='EE'>Estonia</option>
	<option value='ER'>Eritrea</option>
	<option value='ES'>Spain</option>
	<option value='ET'>Ethiopia</option>
	<option value='FI'>Finland</option>
	<option value='FJ'>Fiji</option>
	<option value='FK'>Falkland Islands</option>
	<option value='FM'>Federated States of Micronesia</option>
	<option value='FO'>Faroe Islands</option>
	<option value='FR'>France</option>
	<option value='GA'>Gabon Republic</option>
	<option value='GB'>United Kingdom</option>
	<option value='GD'>Grenada</option>
	<option value='GF'>French Guiana</option>
	<option value='GI'>Gibraltar</option>
	<option value='GL'>Greenland</option>
	<option value='GM'>Gambia</option>
	<option value='GN'>Guinea</option>
	<option value='GP'>Guadeloupe</option>
	<option value='GR'>Greece</option>
	<option value='GT'>Guatemala</option>
	<option value='GW'>Guinea Bissau</option>
	<option value='GY'>Guyana</option>
	<option value='HK'>Hong Kong</option>
	<option value='HN'>Honduras</option>
	<option value='HR'>Croatia</option>
	<option value='HU'>Hungary</option>
	<option value='ID'>Indonesia</option>
	<option value='IE'>Ireland</option>
	<option value='IL'>Israel</option>
	<option value='IN'>India</option>
	<option value='IS'>Iceland</option>
	<option value='IT'>Italy</option>
	<option value='JM'>Jamaica</option>
	<option value='JO'>Jordan</option>
	<option value='JP'>Japan</option>
	<option value='KE'>Kenya</option>
	<option value='KG'>Kyrgyzstan</option>
	<option value='KH'>Cambodia</option>
	<option value='KI'>Kiribati</option>
	<option value='KM'>Comoros</option>
	<option value='KN'>St. Kitts and Nevis</option>
	<option value='KR'>South Korea</option>
	<option value='KW'>Kuwait</option>
	<option value='KY'>Cayman Islands</option>
	<option value='KZ'>Kazakhstan</option>
	<option value='LA'>Laos</option>
	<option value='LC'>St. Lucia</option>
	<option value='LI'>Liechtenstein</option>
	<option value='LK'>Sri Lanka</option>
	<option value='LS'>Lesotho</option>
	<option value='LT'>Lithuania</option>
	<option value='LU'>Luxembourg</option>
	<option value='LV'>Latvia</option>
	<option value='MA'>Morocco</option>
	<option value='MG'>Madagascar</option>
	<option value='MH'>Marshall Islands</option>
	<option value='ML'>Mali</option>
	<option value='MN'>Mongolia</option>
	<option value='MQ'>Martinique</option>
	<option value='MR'>Mauritania</option>
	<option value='MS'>Montserrat</option>
	<option value='MT'>Malta</option>
	<option value='MU'>Mauritius</option>
	<option value='MV'>Maldives</option>
	<option value='MW'>Malawi</option>
	<option value='MX'>Mexico</option>
	<option value='MY'>Malaysia</option>
	<option value='MZ'>Mozambique</option>
	<option value='NA'>Namibia</option>
	<option value='NC'>New Caledonia</option>
	<option value='NE'>Niger</option>
	<option value='NF'>Norfolk Island</option>
	<option value='NI'>Nicaragua</option>
	<option value='NL'>Netherlands</option>
	<option value='NO'>Norway</option>
	<option value='NP'>Nepal</option>
	<option value='NR'>Nauru</option>
	<option value='NU'>Niue</option>
	<option value='NZ'>New Zealand</option>
	<option value='OM'>Oman</option>
	<option value='PA'>Panama</option>
	<option value='PE'>Peru</option>
	<option value='PF'>French Polynesia</option>
	<option value='PG'>Papua New Guinea</option>
	<option value='PH'>Philippines</option>
	<option value='PL'>Poland</option>
	<option value='PM'>St. Pierre and Miquelon</option>
	<option value='PN'>Pitcairn Islands</option>
	<option value='PT'>Portugal</option>
	<option value='PW'>Palau</option>
	<option value='QA'>Qatar</option>
	<option value='RE'>Reunion</option>
	<option value='RO'>Romania</option>
	<option value='RU'>Russia</option>
	<option value='RW'>Rwanda</option>
	<option value='SA'>Saudi Arabia</option>
	<option value='SB'>Solomon Islands</option>
	<option value='SC'>Seychelles</option>
	<option value='SE'>Sweden</option>
	<option value='SG'>Singapore</option>
	<option value='SH'>St. Helena</option>
	<option value='SI'>Slovenia</option>
	<option value='SJ'>Svalbard and Jan Mayen Islands</option>
	<option value='SK'>Slovakia</option>
	<option value='SL'>Sierra Leone</option>
	<option value='SM'>San Marino</option>
	<option value='SN'>Senegal</option>
	<option value='SO'>Somalia</option>
	<option value='SR'>Suriname</option>
	<option value='ST'>Sao Tome and Principe</option>
	<option value='SV'>El Salvador</option>
	<option value='SZ'>Swaziland</option>
	<option value='TC'>Turks and Caicos Islands</option>
	<option value='TD'>Chad</option>
	<option value='TG'>Togo</option>
	<option value='TH'>Thailand</option>
	<option value='TJ'>Tajikistan</option>
	<option value='TM'>Turkmenistan</option>
	<option value='TN'>Tunisia</option>
	<option value='TO'>Tonga</option>
	<option value='TR'>Turkey</option>
	<option value='TT'>Trinidad and Tobago</option>
	<option value='TV'>Tuvalu</option>
	<option value='TW'>Taiwan</option>
	<option value='TZ'>Tanzania</option>
	<option value='UA'>Ukraine</option>
	<option value='UG'>Uganda</option>
	<option value='US'>United States</option>
	<option value='UY'>Uruguay</option>
	<option value='VA'>Vatican City State</option>
	<option value='VC'>Saint Vincent and the Grenadines</option>
	<option value='VE'>Venezuela</option>
	<option value='VG'>British Virgin Islands</option>
	<option value='VN'>Vietnam</option>
	<option value='VU'>Vanuatu</option>
	<option value='WF'>Wallis and Futuna Islands</option>
	<option value='WS'>Samoa</option>
	<option value='YE'>Yemen</option>
	<option value='YT'>Mayotte</option>
	<option value='ZA'>South Africa</option>
	<option value='ZM'>Zambia</option>
</select>
AUTHNETCO;

if ($billingCountry == '') $billingCountry = 'US';
$countryselect = str_replace ($billingCountry."'", $billingCountry."' selected", $countryselect);

$authnet_redirect = <<<AUTREDIRECT
<script language="JavaScript">
    window.onload = authBackToShop();
    function authBackToShop() {
        if(location.search.indexOf('back_to_shop=') >= 0) {
            window.location.replace('{$url_cart_checkout}?action={ACTX}&subscription={SUBIDX}');
        }
    }
</script>
AUTREDIRECT;

$authnet_toggle_fields = <<<AUTHHIDESHIPPINGINFO
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript"> 
	$(document).ready( function() {
		$('#same_billing_address').click(function() {
			if ( $(this).is(':checked') ) {
				$('#shipping_information_block').attr("style", "display:none");
			} else {
				$('#shipping_information_block').attr("style", "display:block");
			}	
		});
                
			$('#enable_echeck_payment').click(function() {
			if ( $(this).is(':checked') ) {
				$('#authnet_bank_details').attr("style", "display:block");
				$('#authnet_cc_details').attr("style", "display:none");
				$('#payment_method_headline h2').html("Bank Account Details");
			} else {
				$('#authnet_bank_details').attr("style", "display:none");
				$('#authnet_cc_details').attr("style", "display:block");
				$('#payment_method_headline h2').html("Credit or Debit Card Details");
			}	
		});

	});
</script>
AUTHHIDESHIPPINGINFO;

?>