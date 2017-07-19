<?php 
	//		Version: 	1.0
	// 	Date:			June 2014
	// 	Authors: 	Olivia Mikhael
	// 	Updated:	Fadi Mikael
	//	Notes:		- Added Internal Click Tracking
	// ----- PREPROCESS -----
	error_reporting(E_ERROR); // only display errors, and not warnings
	
	//set display to mainForm
	$landingPage = "mainForm";	
	//validate email address coming from the url 
	

	$email = htmlentities($_GET['email']);
	if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    	$email = "";
	}
	
	//Click Tracking
	session_start();	

	$DBClickTrackingConnection = new PDO("sqlsrv:Server=SQLC2AG1;Database=allstate", "usr_allstate", "GUdsG7FKjkU7aZby73qU");
	$clickTrackingSql = "INSERT INTO LandingPageClickTracking (sessionId, email, action, actionTimestamp, pageURL) VALUES (:sessionId, :email, :action, :actionTimestamp, :pageURL)";
	$clickTrackingQuery = $DBClickTrackingConnection->prepare($clickTrackingSql);
	
	if($_GET){
		$_SESSION['sessionId'] = session_id();
		$_SESSION['email'] = $email;
		$_SESSION['action'] = "start";
		$_SESSION['actionTimestamp'] = date('Y-m-d H:i:s');
		$_SESSION['pageURL'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";		
		
		$clickTrackingQuery->bindValue(':sessionId',$_SESSION['sessionId']);
		$clickTrackingQuery->bindValue(':email',$_SESSION['email']);
		$clickTrackingQuery->bindValue(':action',$_SESSION['action']);
		$clickTrackingQuery->bindValue(':actionTimestamp',$_SESSION['actionTimestamp']);
		$clickTrackingQuery->bindValue(':pageURL',$_SESSION['pageURL']);
		$clickTrackingQuery->execute();		
	}
	// Click Tracking
	
	//set error to false
	$error = false;		
	//capture values in the text boxes
	if ($_POST)
	{	
		$email = htmlentities($_POST["email"]);
		$prospect = htmlentities($_POST["prospect"]);
		$advice = htmlentities($_POST["advice"]);
		$relationship = htmlentities($_POST["relationship"]);
		$UnsubscribeAll = htmlentities($_POST["UnsubscribeAll"]);	
		$UnsubsribeReason = htmlentities($_POST["UnsubsribeReason"]);		
		//validate email value if its not empty or valid email 
		if(empty($email))
		{
			$error = true;
			$error_message .= "*Please enter an email<br /><br />";
		}
		elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$error = true;
			$error_message .= "*Please enter a valid email<br /><br />";
		}
		//check if any of the checkboxes are checked
		if (empty($prospect) && empty($advice) && empty($relationship) && empty($UnsubscribeAll))
		{
			$error = true;
			$error_message .= "*Please check which emails you would like to subscribe/unsubscribe<br /><br />";
		}				
		//if there is no error
		if (!($error)) 
		{		
			$email_permission = 'express';
			$email_permission_date = date('Ymd');
			$email_optin_from = 'http://www.newsletter.allstate.ca/unsubscribe.php';			
			$prospect_permission = 'express';
			$prospect_permission_date = date('Ymd');
			$prospect_permission_source = 'http://www.newsletter.allstate.ca/unsubscribe.php';			
			$advisory_newsletter_permission = 'express';
			$advisory_newsletter_permission_date = date('Ymd');
			$advisory_newsletter_optin_from = 'http://www.newsletter.allstate.ca/unsubscribe.php';			 
			$relationship_newsletter_permission = 'express';
			$relationship_newsletter_permission_date = date('Ymd');
			$relationship_newsletter_optin_from = 'http://www.newsletter.allstate.ca/unsubscribe.php';			
			$email_permission_casl = 'express';
			$email_permission_date_casl = date('Y-m-d H:i:s');
			$email_permission_source_casl = 'http://www.newsletter.allstate.ca/unsubscribe.php';			 
			$prospect_permission_casl = 'express';
			$prospect_permission_date_casl = date('Y-m-d H:i:s');
			$prospect_permission_source_casl = 'http://www.newsletter.allstate.ca/unsubscribe.php';			
			$advisory_permission_casl = 'express';
			$advisory_permission_date_casl = date('Y-m-d H:i:s');
			$advisory_permission_source_casl = 'http://www.newsletter.allstate.ca/unsubscribe.php';			
			$relationship_permission_casl = 'express';
			$relationship_permission_date_casl = date('Y-m-d H:i:s');
			$relationship_permission_source_casl = 'http://www.newsletter.allstate.ca/unsubscribe.php';			
			$last_updated = date('Y-m-d H:i:s');
			//set default values when nothing is being passed through the checkboxes	
			if (empty($prospect))
			{
				$unsubscribedList .= "- Products and Services<br />";
				$prospect_permission = 'unsubscribe';		
				$prospect_permission_date = date('Ymd');
				$prospect_permission_source = 'http://www.newsletter.allstate.ca/unsubscribe.php';
				$prospect_permission_casl = 'unsubscribe';
				$prospect_permission_date_casl = date('Y-m-d H:i:s');
				$prospect_permission_source_casl = 'http://www.newsletter.allstate.ca/unsubscribe.php';
				
				//Click Tracking
				$clickTrackingQuery = $DBClickTrackingConnection->prepare($clickTrackingSql);
				$clickTrackingQuery->bindValue(':sessionId', $_SESSION['sessionId']);
				$clickTrackingQuery->bindValue(':email', $_POST["email"]);
				$clickTrackingQuery->bindValue(':action', "unsubscribed from prospect");
				$clickTrackingQuery->bindValue(':actionTimestamp', date('Y-m-d H:i:s'));
				$clickTrackingQuery->bindValue(':pageURL', $_SESSION['pageURL']);
				$clickTrackingQuery->execute();
				// Click Tracking
			}		
			if (empty($advice))
			{
				$advisory_newsletter_permission = 'unsubscribe';
				$advisory_newsletter_permission_date = date('Ymd');
				$advisory_newsletter_optin_from = 'http://www.newsletter.allstate.ca/unsubscribe.php';	
				$advisory_permission_casl = 'unsubscribe';
				$advisory_permission_date_casl = date('Y-m-d H:i:s');
				$advisory_permission_source_casl = 'http://www.newsletter.allstate.ca/unsubscribe.php';	
				$unsubscribedList .= "- Advisory<br />";
				
				//Click Tracking
				$clickTrackingQuery = $DBClickTrackingConnection->prepare($clickTrackingSql);
				$clickTrackingQuery->bindValue(':sessionId', $_SESSION['sessionId']);
				$clickTrackingQuery->bindValue(':email', $_POST["email"]);
				$clickTrackingQuery->bindValue(':action', "unsubscribed from advice");
				$clickTrackingQuery->bindValue(':actionTimestamp', date('Y-m-d H:i:s'));
				$clickTrackingQuery->bindValue(':pageURL', $_SESSION['pageURL']);
				$clickTrackingQuery->execute();
				// Click Tracking				
			}	
			if (empty($relationship))
			{
				$relationship_newsletter_permission = 'unsubscribe';
				$relationship_newsletter_permission_date = date('Ymd');
				$relationship_newsletter_optin_from = 'http://www.newsletter.allstate.ca/unsubscribe.php';
				$relationship_permission_casl = 'unsubscribe';
				$relationship_permission_date_casl = date('Y-m-d H:i:s');
				$relationship_permission_source_casl = 'http://www.newsletter.allstate.ca/unsubscribe.php';	
				$unsubscribedList .= "- Relationship<br />";
				
				//Click Tracking
				$clickTrackingQuery = $DBClickTrackingConnection->prepare($clickTrackingSql);
				$clickTrackingQuery->bindValue(':sessionId', $_SESSION['sessionId']);
				$clickTrackingQuery->bindValue(':email', $_POST["email"]);
				$clickTrackingQuery->bindValue(':action', "unsubscribed from relationship");
				$clickTrackingQuery->bindValue(':actionTimestamp', date('Y-m-d H:i:s'));
				$clickTrackingQuery->bindValue(':pageURL', $_SESSION['pageURL']);
				$clickTrackingQuery->execute();
				// Click Tracking				
			}

			if (!empty($UnsubscribeAll))
			{
				$email_permission = 'unsubscribe';
				$email_permission_date = date('Ymd');
				$email_optin_from = 'http://www.newsletter.allstate.ca/unsubscribe.php';					
				$email_permission_casl = 'unsubscribe';
				$email_permission_date_casl = date('Y-m-d H:i:s');
				$email_permission_source_casl = 'http://www.newsletter.allstate.ca/unsubscribe.php';							
				$prospect_permission = 'unsubscribe';
				$prospect_permission_date = date('Ymd');
				$prospect_permission_source = 'http://www.newsletter.allstate.ca/unsubscribe.php';							
				$advisory_newsletter_permission = 'unsubscribe';
				$advisory_newsletter_permission_date = date('Ymd');
				$advisory_newsletter_optin_from = 'http://www.newsletter.allstate.ca/unsubscribe.php';						 
				$relationship_newsletter_permission = 'unsubscribe';
				$relationship_newsletter_permission_date = date('Ymd');
				$relationship_newsletter_optin_from = 'http://www.newsletter.allstate.ca/unsubscribe.php';					
				$prospect_permission_casl = 'unsubscribe';
				$prospect_permission_date_casl = date('Y-m-d H:i:s');
				$prospect_permission_source_casl = 'http://www.newsletter.allstate.ca/unsubscribe.php';							
				$advisory_permission_casl = 'unsubscribe';
				$advisory_permission_date_casl = date('Y-m-d H:i:s');
				$advisory_permission_source_casl = 'http://www.newsletter.allstate.ca/unsubscribe.php';							
				$relationship_permission_casl = 'unsubscribe';
				$relationship_permission_date_casl = date('Y-m-d H:i:s');
				$relationship_permission_source_casl = 'http://www.newsletter.allstate.ca/unsubscribe.php';	
				
				//Click Tracking
				$clickTrackingQuery = $DBClickTrackingConnection->prepare($clickTrackingSql);
				$clickTrackingQuery->bindValue(':sessionId', $_SESSION['sessionId']);
				$clickTrackingQuery->bindValue(':email', $_POST["email"]);
				$clickTrackingQuery->bindValue(':action', "unsubscribed from all");
				$clickTrackingQuery->bindValue(':actionTimestamp', date('Y-m-d H:i:s'));
				$clickTrackingQuery->bindValue(':pageURL', $_SESSION['pageURL']);
				$clickTrackingQuery->execute();
				// Click Tracking
			}						
			if (empty($UnsubsribeReason))
			{
				$UnsubsribeReason = NULL;
			}		
			if($UnsubsribeReason == "reason1"){
				$UnsubsribeReason = "The content you send doesn't apply to me";
			}
			if($UnsubsribeReason == "reason2"){
				$UnsubsribeReason = "You send me too many emails";
			}
			if($UnsubsribeReason == "reason3"){
				$UnsubsribeReason = "I don't find your information to be of any value to me";
			}
			if($UnsubsribeReason == "reason4"){
				$UnsubsribeReason = "I only provided my email address to win a contest";
			}
			if($UnsubsribeReason == "reason5"){
				$UnsubsribeReason = "I never subscribed to receive these emails ";
			}
			$fr_lang = 0;				
			$source = "Preference Page";	
			try 
			{
				//assign DB path to a variable
				$db_master = "D:\WWWUsers\inboxm\inboxmarketer_com\databases\inboxCRM\allstate\allstate_master97.mdb";
				//check if DB exists
				if (!file_exists($db_master))
				{
					die("Service is not avaiable at the moment. Please try again later!");
				}
				//assign connection to the DB to a new PDO variable
				$db = new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$db_master; Uid=; Pwd=;");					
				$sql = "UPDATE contacts SET source=(?),opt_out_reason=(?),french=(?),email_permission=(?),email_permission_date=(?),email_optin_from=(?),prospect_permission=(?),prospect_permission_date=(?),prospect_permission_source=(?),advisory_newsletter_permission=(?),advisory_newsletter_permission_date=(?),advisory_newsletter_optin_from=(?),relationship_newsletter_permission=(?),relationship_newsletter_permission_date=(?),relationship_newsletter_optin_from=(?),email_permission_casl=(?),email_permission_date_casl=(?),email_permission_source_casl=(?),advisory_permission_casl=(?),advisory_permission_date_casl=(?),advisory_permission_source_casl=(?),relationship_permission_casl=(?),relationship_permission_date_casl=(?),relationship_permission_source_casl=(?),prospect_permission_casl=(?),prospect_permission_date_casl=(?),prospect_permission_source_casl=(?),last_updated=(?) WHERE email=(?)";
				$query = $db->prepare($sql);
				$query->execute(array($source,$UnsubsribeReason,$fr_lang,$email_permission,$email_permission_date,$email_optin_from,$prospect_permission,$prospect_permission_date,$prospect_permission_source,$advisory_newsletter_permission,$advisory_newsletter_permission_date,$advisory_newsletter_optin_from,$relationship_newsletter_permission,$relationship_newsletter_permission_date,$relationship_newsletter_optin_from,$email_permission_casl,$email_permission_date_casl,$email_permission_source_casl,$advisory_permission_casl,$advisory_permission_date_casl,$advisory_permission_source_casl,$relationship_permission_casl,$relationship_permission_date_casl,$relationship_permission_source_casl,$prospect_permission_casl,$prospect_permission_date_casl,$prospect_permission_source_casl,$last_updated,$email));					
				$num_rows = $query->rowCount();							
				if($num_rows == 0)
				{	
					//query to create a new record for the new subscribed contact with the values collected via subscribe form			
					$sql2 = "INSERT INTO contacts (email,[date],source,opt_out_reason,french,email_permission,email_permission_date,email_optin_from,prospect_permission,prospect_permission_date,prospect_permission_source,advisory_newsletter_permission,advisory_newsletter_permission_date,advisory_newsletter_optin_from,relationship_newsletter_permission,relationship_newsletter_permission_date,relationship_newsletter_optin_from,email_permission_casl,email_permission_date_casl,email_permission_source_casl,prospect_permission_casl,prospect_permission_date_casl,prospect_permission_source_casl,advisory_permission_casl,advisory_permission_date_casl,advisory_permission_source_casl,relationship_permission_casl,relationship_permission_date_casl,relationship_permission_source_casl,last_updated) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";				
					$query2 = $db->prepare($sql2);
					$query2->execute(array($email,$email_permission_date,$source,$UnsubsribeReason,$fr_lang,$email_permission,$email_permission_date,$email_optin_from,$prospect_permission,$prospect_permission_date,$prospect_permission_source,$advisory_newsletter_permission,$advisory_newsletter_permission_date,$advisory_newsletter_optin_from,$relationship_newsletter_permission,$relationship_newsletter_permission_date,$relationship_newsletter_optin_from,$email_permission_casl,$email_permission_date_casl,$email_permission_source_casl,$prospect_permission_casl,$prospect_permission_date_casl,$prospect_permission_source_casl,$advisory_permission_casl,$advisory_permission_date_casl,$advisory_permission_source_casl,$relationship_permission_casl,$relationship_permission_date_casl,$relationship_permission_source_casl,$last_updated));						
					//close query2
					$query2->closeCursor();			
					unset($query2);	
				}
					//close query1
					$query->closeCursor();
					unset($query);		
			}
			//catch any errors
			catch (Exception $e)
			{
				$query2->closeCursor();
				unset($query2);
				$query->closeCursor();
				unset($query);				
				die($e);
			}
			//if no erros then proceed with the thank you page
			unset($db);
			$success = true;		
			//reset the display for the landing page if there are unsubscribed list or not
			if(empty($unsubscribedList))
			{
				$landingPage = "thankYouForm";
			}
			else if (!empty($unsubscribedList))
			{
				$landingPage = "unsubscirbeList";
			}
			else if (!empty($unsubscribedList) && !empty($UnsubscribeAll))
			{
				$landingPage = "unsubscirbeList2";
			}
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta charset="utf-8">
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<!-- JS VALIDATION-->
<!-- <script type="text/javascript" src="js/unsubscribeValidation.js"></script>
<!-- 
//	Version: 	1.0
// 	Date:		Jan 2013
// 	Authors: 	Olivia Mikhael
-->
<!-- CSS Styling-->
<link href="css/unsubscribe.css" rel="stylesheet">
<title>Allstate</title>
</head>
<body>

	<div  class="mainTable2">
		<h1> <a href="http://www.allstate.ca/" target="_blank" class="div1Link"> <img src="http://www.newsletter.allstate.ca/images/20140512_allstate_01.png" alt="Allstate(R) Insurance" width="208" height="100"  hspace="0" vspace="0" border="0" class="mobileHide" style="display:block;" /></a></h1>
	</div>
	<div class="mainTable">			
		<h1> <img class="width" src="http://www.newsletter.allstate.ca/images/mainImage_uns.jpg" alt="Preference Centre" width="598" border="0"  hspace="0" vspace="0" style="display:block;" /></h1>
		<?php  
			if($landingPage == "mainForm")
			{
			?>
		<form id="mainForm" onsubmit="return validateForm()" name="mainForm" class="form" action="unsubscribe.php" method="post" enctype="multipart/form-data">
			<div class="error"><?php echo $error_message;?></div>
			<div class="div7"> We would love to continue to email you to keep you informed
				and also give you helpful tips and advice to protect the things most important
				to you. Please confirm your email address, adjust your email settings and click on Submit.</div>
			<div class="div1">
				<label for="email"><strong>Email Address:</strong></label>
				<br />
				<br />
				<input type="text" value="<?php echo $email; ?>" name="email" id="email" align="left" />
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
        <div style="display: none; line-height: 0px; font-size: 1px; font-color: #ffffff;"><label for="submit">Submit</label></div>
				<input type="image" id="submit" src="images/submit_1.jpg" alt="Submit" />
			</div>
			<div class="div3"> Or check the following box to stop receiving emails from
				Allstate altogether. We’re sorry to see you go. If you change your mind at
				any time, we’d love to have you back.<br />
				<br />
				<strong>Allstate customers only:</strong> please note you will continue to receive
				any emails specifically related to your policy. </div>
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
			<div class="error"><?php echo $error_message;?> </div>
			<div align="center" class="div6">
        <div style="display: none; line-height: 0px; font-size: 1px; font-color: #ffffff;"><label for="unsub">Unsubscribe</label></div>
				<input type="image" src="images/unsubscribe_1.jpg" id="unsub" alt="Unsubscribe" />
			</div>
		</form>
	</div>
	<?php 
		} 			
			else if($landingPage == "unsubscirbeList")
			{  
		?>
				<div class="finalMessage">Thank you for updating your preferences. You have successfully been unsubscribed from the following subscriptions:<br /><br /> <?php echo $unsubscribedList;?> <br /><br /></div> 
				
				<?php 
			}	
			
			else if($landingPage == "unsubscirbeList2")
			{  
			?>
				<div class="finalMessage">We’re sorry to see you go. You have successfully been unsubscribed from the following subscriptions:<br /><br /> <?php echo $unsubscribedList;?> <br /><br /></div> 
			<?php 
			}	
			else if($landingPage == "thankYouForm")
			{
			?>
				<div class="finalMessage">Thank you for updating your preferences.<br /><br /></div>
			<?php 
			}				
		?>
	</div>
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
<!-- JQuery hide and unhide the grey area 
(radiobuttons) based on checkboxes selection-->
<script>
$(function() {
	$('#radiobuttons').hide();
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
