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
 * AuthnetProcessAIMPriorAuthorizationCapture is responsible for processing a PRIOR_AUTH_CAPTURE type transaction
 * for a given transaction ID
 *
 * @author Daniel Watrous <daniel@danielwatrous.com>
 */

require_once 'AuthnetProcessAIM.php';

//{{{PHP_ENCODE}}}
class AuthnetProcessAIMPriorAuthorizationCapture extends AuthnetProcessAIM {

    // declare class variables
    // valid transaction ID (x_trans_id) of an original, successfully authorized, Authorization Only transaction.
    protected $x_trans_id;
    
    function __construct($apiKey, $transactionKey) {
		// call parent constructor to set key values
		parent::__construct($apiKey, $transactionKey);
		// set the transaction type for this class
		$this->setX_type('PRIOR_AUTH_CAPTURE');
		// setup request values array
		$this->addRequestValueRequired('x_trans_id', true);
	}
	
	public function getX_trans_id() {
		return $this->x_trans_id;
	}

    public function setX_trans_id($x_trans_id) {
        $this->x_trans_id = $x_trans_id;
    }
}
//{{{/PHP_ENCODE}}}

?>
