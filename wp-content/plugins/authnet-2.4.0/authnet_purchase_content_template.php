<?php

/*
 * Copyright 2010, Maintain Fit LLC, Daniel Watrous, All rights reserved
 * By using this software you agree to be bound by the terms
 * outlined in the License.txt file included with the software.
 *
 * If you still have questions please send them to helpdesk@danielwatrous.com
 *
 */
include('authnet_checkout_common.php');

$authnet_cart_content_detail= <<<AUTHCARTCONTENTDETAIL
            Purchase details:<br />
                <form id="cart" action="{$url_cart_checkout}?action=update" method="post">
                    <table class="authnet_shopcart_table">
                        <thead>
                            <tr>
                                <td width="66%">
                                        Item detail
                                </td>
                                <td width="10%">
                                        Unit Price
                                </td>
                                <td width="7%">
                                        Quantity
                                </td>
                                <td width="10%">
                                        Total
                                </td>
                                <td width="7%">
                                        Remove
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            {AUTHNET_CART_CONTENT}
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>
                                    <!--<a href="{HOMEURL}">Continue shopping</a>-->
                                </td>
                                <td colspan="2">
                                    <input type="submit" value="Update">
                                </td>

                                <td align="center" colspan="2">
                                    Cart Total:  {CART_TOTAL}
                                </td>
                            </tr> 
                        </tfoot>
                        
                    </table>
                </form>
AUTHCARTCONTENTDETAIL;

$authnet_item_detail = <<<AUTHITEMDETAIL
               
                        <tr>
                            <td>
                                {SUBSCRIPTION_NAME}<br />
                                {SUBSCRIPTION_DESC}<br />
                                {SUBSCRIPTION_PRICING}
                            </td>
                            <td style="text-align:center">
                               {UNIT_PRICE}
                            </td>
                            <td align="center">
                                <input type="text" name="qty{SUBSCRIPTION_ID}" value="{UNIT_QUANTITY}" size="2">
                                
                            </td>
                            <td style="text-align:center">
                                {UNIT_TOTAL}
                            </td>
                            <td align="center">
                                
                            <a href="{$url_cart_checkout}?action=delete&subscription={SUBSCRIPTION_ID}">[X]</a>
                                
                            </td>
                            
                        </tr>
                        
AUTHITEMDETAIL;
                                                                
$authnet_single_purchase_detail = <<<AUTHSINGLECONTENT
                        Purchase details:<br />
                        {SUBSCRIPTION_NAME}<br />
                        {SUBSCRIPTION_DESC}<br />
                        {SUBSCRIPTION_PRICING}<br />
AUTHSINGLECONTENT;

$authnet_sidebar_cart = <<<AUTHSIDEBARCART
                       <table width="100%" border="1" cellpadding="1" cellspacing="1">
                        <tr>
                            <td bgcolor="#7DB0CB" style = "text-align:center;text-decoration:underline">
                                    My Shopping Cart
                            </td>
                        </tr> 
                        <tr>
                            <td style = "text-align:center">
                            {TOTAL_CART_ITEMS} item(s):
                            </td>
                        </tr>
                        <tr>
                            <td style = "text-align:center">
                            {CART_TOTAL}
                            </td>
                        </tr>
                        <tr>
                            <td style = "text-align:center;text-decoration:underline">
                               <a href="{CHECKOUT_PAGE}"> Proceed to checkout </a>
                            </td>
                        </tr>
                    </table>
AUTHSIDEBARCART;
                                                                
$authnet_back_to_shop = <<<AUTHBACKTOSHOP
                <p>Cart is empty, click <a href="{BACK_TO_SHOP}"> back </a> and continue to shopping.</p>
AUTHBACKTOSHOP;
   
$authnet_confirm_to_shop_again = <<<AUTHCONFIRMTOSHOPAGAIN
                <p>You just completed a payment. Do you want to start purchasing again ( <a href="{YES_BACK_TO_SHOP}">Yes</a> / <a href="{NO_BACK_TO_SHOP}">No</a> )?</p>
AUTHCONFIRMTOSHOPAGAIN;

$transaction_summary_purchase_details = <<<PURCHASEDETAILS
		
<div class="authnet_table_row_total"><!--FORMPART START-->
    <div class="authnet_product"> 
        <div style="float:left;font-style:italic;text-align:center;text-decoration:underline;width: 410px;">Item detail</div>
        <div style="float:left;font-style:italic;text-decoration:underline;width: 100px;"> Unit Price </div>
        <div style="float:left;font-style:italic;text-decoration:underline;width: 100px;"> Quantity</div>
        <div style="float:left;font-style:italic;text-decoration:underline;width: 90px;"> Total</div>
    
    </div>
</div>
    {AUTHNET_CART_CONTENT}
<div class="authnet_table_row_total"><!--FORMPART START-->
    <div class="authnet_product">Cart Total:</div>
    <div class="authnet_price" style="margin-right:21px;">{TOTAL}</div>
</div>  	
PURCHASEDETAILS;

$transaction_summary_survey_details = <<<SURVEYDETAILS
    {AUTHNET_SURVEY}
SURVEYDETAILS;


$transaction_summary_survey_row = <<<SURVEYROW
    <div class="authnet_table_row"><!--FORMPART START-->
        <div class="authnet_product">
            <div style="font-style:italic;color:black;">
                Q: {SURVEYQUERY}
            </div>
            <div> 
                A:  {SURVEYANSWER} 
            </div>
        </div>
    </div>
SURVEYROW;



$transaction_summary_item_details = <<<AUTHITEMDETAIL
   <div class="authnet_table_row"><!--FORMPART START-->
    <div class="authnet_product"> 
   
        <div style="float:left;width: 410px">
            {SUBSCRIPTION_NAME}<br />
            {SUBSCRIPTION_DESC}<br />
            {SUBSCRIPTION_PRICING}
        </div>
        <div style="float:left;width: 100px">{UNIT_PRICE}</div>
        <div style="float:left;width: 100px">{UNIT_QUANTITY}</div>
        <div style="float:left;width: 90px;">{UNIT_TOTAL}</div>
    
    </div>
    </div>
AUTHITEMDETAIL;
$summary_single_purchase_detail = <<<SUMSINGLECONTENT
    <div class="authnet_table_row"><!--FORMPART START-->
    <div class="authnet_product"> 
                        {PRICING}
        </div>
    </div>
SUMSINGLECONTENT;
$transaction_email_purchase_details = <<<PURCHASEDETAILS
    {AUTHNET_CART_CONTENT}
	<hr> 
	Cart Total: {TOTAL}
PURCHASEDETAILS;

$transaction_email_item_details = <<<AUTHITEMDETAIL
   <hr> 
    Name:{SUBSCRIPTION_NAME}
    Description:{SUBSCRIPTION_DESC}
    {SUBSCRIPTION_PRICING}
    Unit Price:{UNIT_PRICE}
    Qyt:{UNIT_QUANTITY}
    Unit Total:{UNIT_TOTAL} <br />
AUTHITEMDETAIL;
$purchase_details = <<<AUTHITEMDETAIL
Sub-{COUNT}: {SUBSCRIPTION_NAME} 
AUTHITEMDETAIL;

$checkout_payment_form = <<<AUTHNETCHECKOUTPAYMENTFORM
<div class="authnet_item_desc">
    <div style="float:left;">
            <p style="color: red;">{ERROR_MESSAGE}</p>
            {PAYMENT_FORM} 
    </div>
    <div class="authnet_seals">AUTHNET_SITE_SEAL</div>
</div>
AUTHNETCHECKOUTPAYMENTFORM;
$checkout_payment_form3= <<<AUTHNETCHECKOUTPAYMENTFORM
<div class="authnet_item_desc3">
    <div style="float:left;">
            <p style="color: red;">{ERROR_MESSAGE}</p>
            {PAYMENT_FORM} 
    </div>
    <div class="authnet_seals">AUTHNET_SITE_SEAL</div>
</div>
AUTHNETCHECKOUTPAYMENTFORM;
$use_ssl_warning = <<<AUTHNETUSESSLWARNING
<div class="{WARNING-CSS}">
    <p>
            <strong>
                ATTENTION! This site is not currently protected by SSL encryption. Any unprotected transactions that are processed on this site may represent a significant liability. It is highly recommended that no live transactions are processed until this site is secure. <a href="http://www.youtube.com/watch?v=8F8iPxs4naY">Learn how to secure a site with SSL</a>.
            </strong>
    </p>
</div>
AUTHNETUSESSLWARNING;
?>
