var http_req = false;
function gcc_POSTRequest(url, parameters) 
{
	http_req = false;
	if (window.XMLHttpRequest) 
	{
		http_req = new XMLHttpRequest();
		if (http_req.overrideMimeType) 
		{
			http_req.overrideMimeType('text/html');
		}
	} 
	else if (window.ActiveXObject) 
	{
		try 
		{
			http_req = new ActiveXObject("Msxml2.XMLHTTP");
		} 
		catch (e) 
		{
			try 
			{
				http_req = new ActiveXObject("Microsoft.XMLHTTP");
			} 
			catch (e) {}
		}
	}
	if (!http_req) 
	{
		alert('Cannot create XMLHTTP instance');
		return false;
	}
	http_req.onreadystatechange = ConstantContactForm;
	http_req.open('POST', url, true);
	http_req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http_req.setRequestHeader("Content-length", parameters.length);
	http_req.setRequestHeader("Connection", "close");
	http_req.send(parameters);
}

function ConstantContactForm() 
{
	//alert(http_req.readyState);
	//alert(http_req.responseText);
	if (http_req.readyState == 4) 
	{
		if (http_req.status == 200) 
		{
			result = http_req.responseText;
			result = result.trim();
			if(result == "invalid-email")
			{
				alert("Invalid email address.");
				document.getElementById('gcc_msg').innerHTML = "Invalid email address.";   
			}
			else if(result == "empty-email")
			{
				alert("Please enter email address.");
				document.getElementById('gcc_msg').innerHTML = "Please enter email address.";   
			}
			else if(result == "username-password-error")
			{
				alert("Invalid Constant Contact login.");
				document.getElementById('gcc_msg').innerHTML = "Invalid Constant Contact login.";   
			}
			else if(result == "there-was-problem")
			{
				alert("There was a problem with the request.");
				document.getElementById('gcc_msg').innerHTML = "There was a problem with the request.";   
			}
			else if(result == "mail-sent-successfully")
			{
				alert("Subscribed successfully.");
				document.getElementById('gcc_msg').innerHTML = "Subscribed successfully.";   
				document.getElementById("gcc_txt_email").value = "";
			}
			else
			{
				alert("There was a problem with the request.");
				document.getElementById('gcc_msg').innerHTML = "There was a problem with the request.";   
			}
		} 
		else 
		{
			alert('There was a problem with the request.');
		}
	}
}

function gcc_submit_form(obj, url) 
{
	gcc_email=document.getElementById("gcc_txt_email");
    if(gcc_email.value=="")
    {
        alert("Please enter email address.");
        gcc_email.focus();
        return false;    
    }
	if(gcc_email.value!="" && (gcc_email.value.indexOf("@",0)==-1 || gcc_email.value.indexOf(".",0)==-1))
    {
        alert("Please enter valid email address.")
        gcc_email.focus();
        gcc_email.select();
        return false;
    }
	document.getElementById('gcc_msg').innerHTML = "Sending..."; 
	var date_now=new Date();
    var mynumber=Math.random();
	var str = "gcc_email=" + encodeURI( gcc_email.value ) + 
				"&timestamp=" + encodeURI( date_now ) + 
					"&action=" + encodeURI( mynumber );
	gcc_POSTRequest(url+'/?ccf=constant-contact', str);
}