<?php

/**
 * Copyright 2010, Maintain Fit LLC, Daniel Watrous, All rights reserved
 * By using this software you agree to be bound by the terms
 * outlined in the License.txt file included with the software.
 *
 * If you still have questions please send them to helpdesk@danielwatrous.com
 *
 */

/**
 * AuthnetProcessAIMRefund is responsible for processing a Refund/Credit type transaction
 * for a given transaction ID
 *
 * @author Daniel Watrous <daniel@danielwatrous.com>
 */

require_once 'AuthnetProcessAIM.php';

//{{{PHP_ENCODE}}}
class AuthnetProcesAIMRefund extends AuthnetProcessAIM {

    // declare class variables
    // valid transaction ID (x_trans_id) of an original, successfully settled transaction
    protected $x_trans_id;
    // less than or equal to the original settled amount.
    protected $x_amount; 
    // full credit card number or last four digits only here
    protected $x_card_num;
    
    function __construct($apiKey, $transactionKey) {
		// call parent constructor to set key values
		parent::__construct($apiKey, $transactionKey);
		// set the transaction type for this class
		$this->setX_type('CREDIT');
		// setup request values array
		$this->addRequestValueRequired('x_trans_id', true);
		$this->addRequestValueRequired('x_card_num', true);
		$this->addRequestValueRequired('x_amount', true);
	}
	
	public function getX_trans_id() {
		return $this->x_trans_id;
	}

    public function setX_trans_id($x_trans_id) {
        $this->x_trans_id = $x_trans_id;
    }
    
	public function getX_card_num() {
		return $this->x_card_num;
	}

    public function setX_card_num($x_card_num) {
        $this->x_card_num = $x_card_num;
    }
    public function getX_amount() {
        return $this->x_amount;
    }

    public function setX_amount($x_amount) {
        $this->x_amount = $x_amount;
    }
}
//{{{/PHP_ENCODE}}}

?>
