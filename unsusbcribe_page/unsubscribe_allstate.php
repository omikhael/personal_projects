<?php
	
	//set variables for database connection 
	$servername = "localhost";
	$username = "username";
	$password = "password";

	// try/catch connection to database based on the variables set
	// if connection is successful 
	//  display successful message
	// if connection is unsuccessful catch the exception 
	//  display error message
	try 
	{
	    $conn = new PDO("mysql:host=$servername;dbname=myDB", $username, $password);
	    // set the PDO error mode to exception
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    echo "Connected successfully"; 
	}
	catch(PDOException $e)
	{
	    echo "Connection failed: " . $e->getMessage();
	}
	//close connection
	$conn->close();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta charset="utf-8">
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<!-- JS VALIDATION-->
<!-- <script type="text/javascript" src="http://www.newsletter.allstate.ca/js/unsubscribeValidation.js"></script>
<!-- 
//	Version: 	1.0
// 	Date:		Jan 2013
// 	Authors: 	Olivia Mikhael
-->
<!-- CSS Styling-->
<link href="http://www.newsletter.allstate.ca/css/unsubscribe.css" rel="stylesheet">
<title>Allstate</title>
</head>
<body>
	<!-- header-->
	<div  class="mainTable2">
		<h1> <a href="http://www.allstate.ca/" target="_blank" class="div1Link"> <img src="http://www.newsletter.allstate.ca/images/20140512_allstate_01.png" alt="Allstate(R) Insurance" width="208" height="100"  hspace="0" vspace="0" border="0" class="mobileHide" style="display:block;" /></a></h1>
	</div>
	<!-- body-->
	<div class="mainTable">			
		<h1> <img class="width" src="http://www.newsletter.allstate.ca/images/mainImage_uns.jpg" alt="Preference Centre" width="598" border="0"  hspace="0" vspace="0" style="display:block;" /></h1>
		<form id="mainForm" onsubmit="return validateForm()" name="mainForm" class="form" action="http://www.newsletter.allstate.ca/unsubscribe.php" method="post" enctype="multipart/form-data">
			<div class="error"></div>
			<div class="div7"> We would love to continue to email you to keep you informed
				and also give you helpful tips and advice to protect the things most important
				to you. Please confirm your email address, adjust your email settings and click on Submit.</div>
			<div class="div1">
				<label for="email"><strong>Email Address:</strong></label>
				<br />
				<br />
				<input type="text" value="" name="email" id="email" align="left" />
			</div>
			<div class="div2">
				<div class="div-checkbox">
					<input type="checkbox" value="prospect" name="prospect" id="prospect" />
				</div>
				<label for="prospect"> <strong>Products and Services: </strong>I would like to receive
				emails about Allstate's products and services that Canadians have trusted
				for 60 years<br />
				<br />
				</label>
			</div>
			<div class="div2">
				<div class="div-checkbox">
					<input type="checkbox" value="advice" name="advice" id="advice" />
				</div>
				<label for="advice"> <strong>Advice:</strong> I would like to receive advice-based
				emails with helpful advice, safety tips and special weather advisories, including
				the Allstate newsletter<br />
				<br />
				</label>
			</div>
			<div class="div2">
				<div class="div-checkbox">
					<input type="checkbox" value="relationship" name="relationship" id="relationship" />
				</div>
				<label for="relationship"><strong> Relationship:</strong> I would like to
				receive emails about special events like birthdays, season's greetings or
				local events</label>
			</div>
			<div align="center" class="div8">
        		<div style="display: none; line-height: 0px; font-size: 1px; font-color: #ffffff;">
        			<label for="submit">Submit</label>
        		</div>
				<input type="image" id="submit" src="http://www.newsletter.allstate.ca/images/submit_1.jpg" alt="Submit" />
			</div>
			<div class="div3"> Or check the following box to stop receiving emails from
				Allstate altogether. We’re sorry to see you go. If you change your mind at
				any time, we’d love to have you back.<br />
				<br />
				<strong>Allstate customers only:</strong> please note you will continue to receive
				any emails specifically related to your policy. 
			</div>
			<div class="div4">
				<div class="div-checkbox">
					<input name="UnsubscribeAll" id="UnsubscribeAll" type="checkbox" value="unsubscribe" />
				</div>
				<label for="UnsubscribeAll"> I would like to unsubscribe from all of the
				above. </label>
			</div>
			<div id="radiobuttons" class="div5"><br />
				In order to help us serve you better in the future, please select
					the option that best describes your reason for unsubscribing:<br />
				<br />
				<div class="div2">
					<div class="div-checkbox">
						<input type="checkbox" value="reason1" name="UnsubsribeReason" id="reason1" />
					</div>
					<label for="reason1"> The content you send doesn't apply to
					me </label>
				</div>
				<div class="div2">
					<div class="div-checkbox">
						<input type="checkbox" value="reason2" name="UnsubsribeReason" id="reason2" />
					</div>
					<label for="reason2"> You send me too many emails</label>
				</div>
				<div class="div2">
					<div class="div-checkbox">
						<input type="checkbox" value="reason3" name="UnsubsribeReason" id="reason3" />
					</div>
					<label for="reason3"> I don’t find your information to be of
					any value to me</label>
				</div>
				<div class="div2">
					<div class="div-checkbox">
						<input type="checkbox" value="reason4" name="UnsubsribeReason" id="reason4" />
					</div>
					<label for="reason4"> I only provided my email address to win
					a contest</label>
				</div>
				<div class="div2">
					<div class="div-checkbox">
						<input type="checkbox" value="reason5" name="UnsubsribeReason" id="reason5" />
					</div>
					<label for="reason5"> I never subscribed to receive these emails </label>
				</div>
				<br />
				<br />
			</div>
			<div class="error"> </div>
			<div align="center" class="div6">
        		<div style="display: none; line-height: 0px; font-size: 1px; font-color: #ffffff;">
        			<label for="unsub">Unsubscribe</label>
        		</div>
				<input type="image" src="http://www.newsletter.allstate.ca/images/unsubscribe_1.jpg" id="unsub" alt="Unsubscribe" />
			</div>
		</form>
	</div>
	<!-- Footer-->
	<div class="legal"> Allstate Insurance Company of Canada<br />
		27 Allstate Parkway, <br />
		Suite 100<br />
		Markham, Ontario <br />
		L3R 5P8<br />
		905-477-6900<br />
		<br />
		Allstate Canada takes your privacy seriously. If you would like to view
		our privacy policy, please <a href="http://www.allstate.ca/Allstate/custcare/privacy-matters.aspx" target="_blank" class="legalLink">click
			here</a><br />
		<br />
	</div>
	<br />
	<br />

<script>

// hide and show the reasons for unsubcribing (radiobuttons/grey area) 
// based on which checkboxes is/are selected
$(function() {
	//initially hide radiobuttons
	$('#radiobuttons').hide();

	 // once unsucbscribeAll is selected do the following:
	 //  show radiobuttons 
	 //  uncheck prospect, advice and relationship checkboxs
	 //  set all the radiobuttons to false 
	 // else 
	 //  hide the radiobuttons 
	$('#UnsubscribeAll').on("click", function (){
		if($('#UnsubscribeAll').prop("checked")) {
			$('#radiobuttons').show(200);
			$('#prospect').prop('checked', false);
			$('#advice').prop('checked', false);
			$('#relationship').prop('checked', false);
			
			$('#reason1').prop('checked', false);
			$('#reason2').prop('checked', false);
			$('#reason3').prop('checked', false);
			$('#reason4').prop('checked', false);
			$('#reason5').prop('checked', false);
		} else {
			$('#radiobuttons').hide();
		}
	});
	
	// once clicked on prospect or advice or relationship checkboxes, do the following:
	//  if either of the buttons was checked
	//   hide the radiobuttons
	//   set unsubscribeAll to false (unchecked)
	//  else 
	//	 keep the radiobutton shown
	//   keep unsuscbribeAll set to true (checked)
	$('#prospect, #advice, #relationship').on("click", function (){
		if ($('#prospect').prop("checked") || $('#advice').prop("checked") || $('#relationship').prop("checked")){
			$('#radiobuttons').hide();
			$('#UnsubscribeAll').prop('checked', false);
		} else {
			$('#radiobuttons').show(200);
			$('#UnsubscribeAll').prop('checked', true);
		}
	});		
});	  
</script>

<!-- ****** START - Omniture SiteCatalyst ***********************-->
<!-- SiteCatalyst code version: H.22.1.
     Copyright 1996-2011 Adobe, Inc. All Rights Reserved
     More info available at http://www.omniture.com -->
<script language="JavaScript" type="text/javascript">
var s_account = "allstatecanadaglobal";
</script>
<script language="JavaScript" type="text/javascript" src="js/s_code.js"></script>
<script language="JavaScript" type="text/javascript"><!--
s.server = "InboxMarketer.Unsubscribe.ca";
s.channel = "vnInboxMarkerterUnsubscribeEn";
s.pageName = "/vn_InboxMarkerter_unsubscribe_en";
s.eVar24 = "En";
/************* DO NOT ALTER ANYTHING BELOW THIS LINE ! **************/
var s_code = s.t(); if (s_code) document.write(s_code)//--></script>
<script language="JavaScript" type="text/javascript"><!--
if (navigator.appVersion.indexOf('MSIE') >= 0) document.write(unescape('%3C') + '\!-' + '-')
//--></script>
<noscript>
<img src="http://allstate.122.2o7.net/b/ss/allstatedevelopment/1/H.22.1--NS/0" height="1"
     width="1" border="0" alt="" /></noscript><!--/DO NOT REMOVE/-->
<!-- End SiteCatalyst code version: H.22.1. -->
</body>
</html>
