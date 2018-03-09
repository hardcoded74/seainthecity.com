function getCheckoutUrl () {
	// get handle for form elements
	var donationform = document.getElementById('donationform');

	// get plugin values
	checkouturl_base = donationform.elements["posturl"].value;
	
	// get transaction values
	amount = parseFloat(donationform.elements["amount"].value).toFixed(2);
	article_id = donationform.elements["article_id"].value;
	postname = donationform.elements["postname"].value;
	recurring = (donationform.elements["recurring"].checked) ? '1':'0';
	recurring_period = donationform.elements["recurring_period"].value;
	subscription = donationform.elements["subscription"].value;
	
	// generate claim
	claimtoken = amount+postname;
	claim = createCheckoutClaim (claimtoken);

	// build checkouturl
	checkouturl = checkouturl_base;
	checkouturl = checkouturl + '?subscription=' + subscription;
	checkouturl = checkouturl + '&amount=' + amount; 
	checkouturl = checkouturl + '&article_id=' + article_id;
	checkouturl = checkouturl + '&postname=' + postname;
	checkouturl = checkouturl + '&recurring=' + recurring;
	checkouturl = checkouturl + '&recurring_period=' + recurring_period;
	checkouturl = checkouturl + '&claim=' + claim;
	
	return checkouturl;
}

function createCheckoutClaim (valuestosecure) {
	// valuestosecure is amount+postname
	securitystring = valuestosecure;
	return hex_md5(securitystring);
}

function gotocheckout () {
	var donationform = document.getElementById('donationform');
	if (donationform.elements["amount"].value == '') { // Insures amount value is not empty
            alert("Please enter the amount.");
	} else if (isNaN(Number(donationform.elements["amount"].value)))  { // Insures that the user is inputting a valid value
            alert("Please enter valid amount.");
        }
        else window.location = getCheckoutUrl();
	return false;
}
