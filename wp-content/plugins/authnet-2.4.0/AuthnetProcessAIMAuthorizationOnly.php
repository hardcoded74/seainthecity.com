<?php

/**
 * Copyright 2013, Maintain Fit LLC, Daniel Watrous, All rights reserved
 * By using this software you agree to be bound by the terms
 * outlined in the License.txt file included with the software.
 *
 * If you still have questions please send them to helpdesk@danielwatrous.com
 *
 */

/**
 * AuthnetProcessAIMAuthorizationOnly is responsible for processing AUTH_ONLY
 * type transactions using AIM
 *
 * @author Daniel Watrous <daniel@danielwatrous.com>
 */

//{{{PHP_ENCODE}}}
class AuthnetProcessAIMAuthorizationOnly extends AuthnetProcessAIM {
    // default values for a typical transaction
    protected $x_relay_response = 'FALSE';
    protected $x_method = 'CC';

    // transaction details
    protected $x_amount;
    protected $x_description;
    protected $x_invoice_num;

    // card details
    protected $x_card_num;
    protected $x_exp_date;
    protected $x_card_code;

    // cardholder details
    protected $x_first_name;
    protected $x_last_name;
    protected $x_company;
    protected $x_address;
    protected $x_city;
    protected $x_state;
    protected $x_zip;
    protected $x_phone;
    protected $x_country;
    protected $x_email;
    protected $x_fax;
    protected $x_cust_id;
    protected $x_customer_ip;
    
    // cardholder shipping details
    protected $x_ship_to_first_name;
    protected $x_ship_to_last_name;
    protected $x_ship_to_company;
    protected $x_ship_to_address;
    protected $x_ship_to_city;
    protected $x_ship_to_state;
    protected $x_ship_to_zip;
    protected $x_ship_to_country;
    
    // additional shipping information
    protected $x_tax;
    protected $x_freight;
    protected $x_duty;
    protected $x_tax_exempt;
    protected $x_po_num;
    
    // cardholder verification
    protected $x_authentication_indicator;
    protected $x_cardholder_authentication_value;

    // funcitonal
    protected $x_test_request;
    protected $x_duplicate_window;
    protected $x_line_item;
    
    // custom fields
    protected $anet_survey_response;
    
	function __construct($apiKey, $transactionKey) {
		// call parent constructor to set key values
		parent::__construct($apiKey, $transactionKey);
		// set the transaction type for this class
		$this->setX_type('AUTH_ONLY');
		// setup request values array
		$this->addRequestValueRequired('x_relay_response', true);
		$this->addRequestValueRequired('x_method', true);
		$this->addRequestValueRequired('x_amount', true);
		$this->addRequestValueRequired('x_description', false);
		$this->addRequestValueRequired('x_invoice_num', false);
                
		$this->addRequestValueRequired('x_card_num', true);
		$this->addRequestValueRequired('x_exp_date', true);
		$this->addRequestValueRequired('x_card_code', true);

		$this->addRequestValueRequired('x_first_name', true);
		$this->addRequestValueRequired('x_last_name', true);
		$this->addRequestValueRequired('x_company', false);
		$this->addRequestValueRequired('x_address', true);
		$this->addRequestValueRequired('x_city', true);
		$this->addRequestValueRequired('x_state', true);
		$this->addRequestValueRequired('x_zip', true);
		$this->addRequestValueRequired('x_phone', false);
		$this->addRequestValueRequired('x_country', true);
		$this->addRequestValueRequired('x_email', true);
		$this->addRequestValueRequired('x_fax', false);
		$this->addRequestValueRequired('x_cust_id', false);
		$this->addRequestValueRequired('x_customer_ip', false);
		$this->addRequestValueRequired('x_ship_to_first_name', false);
		$this->addRequestValueRequired('x_ship_to_last_name', false);
		$this->addRequestValueRequired('x_ship_to_company', false);
		$this->addRequestValueRequired('x_ship_to_address', false);
		$this->addRequestValueRequired('x_ship_to_city', false);
		$this->addRequestValueRequired('x_ship_to_state', false);
		$this->addRequestValueRequired('x_ship_to_zip', false);
		$this->addRequestValueRequired('x_ship_to_country', false);
		$this->addRequestValueRequired('x_tax', false);
		$this->addRequestValueRequired('x_freight', false);
		$this->addRequestValueRequired('x_duty', false);
		$this->addRequestValueRequired('x_tax_exempt', false);
		$this->addRequestValueRequired('x_po_num', false);
		$this->addRequestValueRequired('x_authentication_indicator', false);
		$this->addRequestValueRequired('x_cardholder_authentication_value', false);
		$this->addRequestValueRequired('x_test_request', false);
		$this->addRequestValueRequired('x_duplicate_window', false);
		$this->addRequestValueRequired('x_line_item', false);
		$this->addRequestValueRequired('anet_survey_response', false);
	}
    
    public function getX_amount() {
        return $this->x_amount;
    }

    public function setX_amount($x_amount) {
        $this->x_amount = $x_amount;
    }

    public function getX_description() {
        return $this->x_description;
    }

    public function setX_description($x_description) {
        $this->x_description = $x_description;
    }

    public function getX_invoice_num() {
        return $this->x_invoice_num;
    }

    public function setX_invoice_num($x_invoice_num) {
        $this->x_invoice_num = $x_invoice_num;
    }

    public function getX_card_num() {
        return $this->x_card_num;
    }

    public function setX_card_num($x_card_num) {
        $this->x_card_num = $x_card_num;
    }

    public function getX_exp_date() {
        return $this->x_exp_date;
    }

    public function setX_exp_date($x_exp_date) {
        $this->x_exp_date = $x_exp_date;
    }

    public function getX_card_code() {
        return $this->x_card_code;
    }

    public function setX_card_code($x_card_code) {
        $this->x_card_code = $x_card_code;
    }

    public function getX_first_name() {
        return $this->x_first_name;
    }

    public function setX_first_name($x_first_name) {
        $this->x_first_name = $x_first_name;
    }

    public function getX_last_name() {
        return $this->x_last_name;
    }

    public function setX_last_name($x_last_name) {
        $this->x_last_name = $x_last_name;
    }

    public function getX_company() {
        return $this->x_company;
    }

    public function setX_company($x_company) {
        $this->x_company = $x_company;
    }

    public function getX_address() {
        return $this->x_address;
    }

    public function setX_address($x_address) {
        $this->x_address = $x_address;
    }

    public function getX_city() {
        return $this->x_city;
    }

    public function setX_city($x_city) {
        $this->x_city = $x_city;
    }

    public function getX_state() {
        return $this->x_state;
    }

    public function setX_state($x_state) {
        $this->x_state = $x_state;
    }

    public function getX_zip() {
        return $this->x_zip;
    }

    public function setX_zip($x_zip) {
        $this->x_zip = $x_zip;
    }

    public function getX_phone() {
        return $this->x_phone;
    }

    public function setX_phone($x_phone) {
        $this->x_phone = $x_phone;
    }

    public function getX_country() {
        return $this->x_country;
    }

    public function setX_country($x_country) {
        $this->x_country = $x_country;
    }

    public function getX_email() {
        return $this->x_email;
    }

    public function setX_email($x_email) {
        $this->x_email = $x_email;
    }

    public function getX_fax() {
        return $this->x_fax;
    }

    public function setX_fax($x_fax) {
        $this->x_fax = $x_fax;
    }

    public function getX_cust_id() {
        return $this->x_cust_id;
    }

    public function setX_cust_id($x_cust_id) {
        $this->x_cust_id = $x_cust_id;
    }

    public function getX_customer_ip() {
        return $this->x_customer_ip;
    }

    public function setX_customer_ip($x_customer_ip) {
        $this->x_customer_ip = $x_customer_ip;
    }

    public function getX_ship_to_first_name() {
        return $this->x_ship_to_first_name;
    }

    public function setX_ship_to_first_name($x_ship_to_first_name) {
        $this->x_ship_to_first_name = $x_ship_to_first_name;
    }

    public function getX_ship_to_last_name() {
        return $this->x_ship_to_last_name;
    }

    public function setX_ship_to_last_name($x_ship_to_last_name) {
        $this->x_ship_to_last_name = $x_ship_to_last_name;
    }

    public function getX_ship_to_company() {
        return $this->x_ship_to_company;
    }

    public function setX_ship_to_company($x_ship_to_company) {
        $this->x_ship_to_company = $x_ship_to_company;
    }

    public function getX_ship_to_address() {
        return $this->x_ship_to_address;
    }

    public function setX_ship_to_address($x_ship_to_address) {
        $this->x_ship_to_address = $x_ship_to_address;
    }

    public function getX_ship_to_city() {
        return $this->x_ship_to_city;
    }

    public function setX_ship_to_city($x_ship_to_city) {
        $this->x_ship_to_city = $x_ship_to_city;
    }

    public function getX_ship_to_state() {
        return $this->x_ship_to_state;
    }

    public function setX_ship_to_state($x_ship_to_state) {
        $this->x_ship_to_state = $x_ship_to_state;
    }

    public function getX_ship_to_zip() {
        return $this->x_ship_to_zip;
    }

    public function setX_ship_to_zip($x_ship_to_zip) {
        $this->x_ship_to_zip = $x_ship_to_zip;
    }

    public function getX_ship_to_country() {
        return $this->x_ship_to_country;
    }

    public function setX_ship_to_country($x_ship_to_country) {
        $this->x_ship_to_country = $x_ship_to_country;
    }

    public function getX_tax() {
        return $this->x_tax;
    }

    public function setX_tax($x_tax) {
        $this->x_tax = $x_tax;
    }

    public function getX_freight() {
        return $this->x_freight;
    }

    public function setX_freight($x_freight) {
        $this->x_freight = $x_freight;
    }

    public function getX_duty() {
        return $this->x_duty;
    }

    public function setX_duty($x_duty) {
        $this->x_duty = $x_duty;
    }

    public function getX_tax_exempt() {
        return $this->x_tax_exempt;
    }

    public function setX_tax_exempt($x_tax_exempt) {
        $this->x_tax_exempt = $x_tax_exempt;
    }

    public function getX_po_num() {
        return $this->x_po_num;
    }

    public function setX_po_num($x_po_num) {
        $this->x_po_num = $x_po_num;
    }

    public function getX_authentication_indicator() {
        return $this->x_authentication_indicator;
    }

    public function setX_authentication_indicator($x_authentication_indicator) {
        $this->x_authentication_indicator = $x_authentication_indicator;
    }

    public function getX_cardholder_authentication_value() {
        return $this->x_cardholder_authentication_value;
    }

    public function setX_cardholder_authentication_value($x_cardholder_authentication_value) {
        $this->x_cardholder_authentication_value = $x_cardholder_authentication_value;
    }

    public function getX_test_request() {
        return $this->x_test_request;
    }

    public function setX_test_request($x_test_request) {
        $this->x_test_request = $x_test_request;
    }

    public function getX_duplicate_window() {
        return $this->x_duplicate_window;
    }

    public function setX_duplicate_window($x_duplicate_window) {
        $this->x_duplicate_window = $x_duplicate_window;
    }

    public function getX_line_item() {
        return $this->x_line_item;
    }

    public function setX_line_item($x_line_item) {
        $this->x_line_item = $x_line_item;
    }

    public function getAnet_survey_response() {
        return $this->anet_survey_response;
    }

    public function setAnet_survey_response($anet_survey_response) {
        $this->anet_survey_response = $anet_survey_response;
    }
}
//{{{/PHP_ENCODE}}}
?>