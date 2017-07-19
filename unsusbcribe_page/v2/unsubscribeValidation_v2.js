// JavaScript Document
//		Version: 	1.0
// 	Date:			June 2014
// 	Authors: 	Olivia Mikhael
// ----- PREPROCESS -----

/*Tests if a given input value matches the pattern
for a given input type value; uses regular expressions
and returns true if the input matches the input type
pattern, otherwise returns false.*/
function isValid(inputType,input)
{
	var regularExpression;
	switch(inputType)
	{
		case "postalCode":
		regularExpression = /^[a-z|A-Z][0-9][a-z|A-Z]\s[0-9][a-|A-Z][0-9]$/;
		break;
		case "telephoneNumber":
		regularExpression = /^\d{3}[\.\-\/\s]\d{3}[\.\-\/\s]\d{4}$/;
		break;
		case "emailAddress":
		regularExpression = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*\.(\w{2}|(com))$/;
		break;
	}
	
	if(regularExpression.test(input.value))
	{
		return true;		
	}
	else
	{
		return false;
	}
}

/*Tests if a given input collection contains one checked = true value; 
returns true if it does, otherwise false.*/
function isChecked(input){
	if(input.checked){ 
		return true;
	}
		return false;
}

/* Testing function that applied both isValie and isChecked 
and displays the appropriate messages according to the errors*/
function validateForm()
{
	var e=document.forms["mainForm"]["email"];
	if(!isValid("emailAddress", e))
	{
	  error_message = "*Please enter a valid email<br/><br/>";
	  $('div.error').html(error_message);  
	  return false;
	}
	  
	if(isChecked(document.forms["mainForm"]["UnsubscribeAll"]))
	{
		var inputs = window.document.forms[0];		
		var reasonChecked = false;		
		for(var i = 0;i< inputs.length;i++) {
			
			if (inputs[i].name != 'unsubscribeReason') {
				continue;
			}
			
			if (inputs[i].checked) {
				reasonChecked = true;
				break;
			}
		}		
		
		if (!reasonChecked) {
			error_message = "*Please select the option that best describes your reason for unsubscribing<br/><br/>";
			$('div.error').html(error_message);
			return false;
		}
	}
}