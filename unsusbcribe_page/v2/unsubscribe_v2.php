<?php
//		Version: 	1.0
// 	Date:			Sept 2014
// 	Authors: 	Olivia Mikhael
// ----- PREPROCESS -----
$landingPage = "mainForm";
$dbName = "\\\\192.168.76.34\\inboxCRM\\allstate\\allstate_master97.mdb";
$db = new PDO(
    "odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$dbName; Uid=; Pwd=;"
);
if (!file_exists($dbName)) {
    die("Could not find database file.");
}
$source = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$dateTime = date('Y-m-d H:i:s');
$dateYYYYMMDD = date('Ymd');

$subscriptions = Array();
$subscriptions[0]["name_form"] = "advice";
$subscriptions[0]["name_db"] = "advisory";
$subscriptions[1]["name_form"] = "relationship";
$subscriptions[1]["name_db"] = "relationship";
$subscriptions[2]["name_form"] = "transactional";
$subscriptions[2]["name_db"] = "transactional";

$error_message = "";
$success = false;

if (isset($_POST['email'])) {
    $email = htmlentities($_POST['email']);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);

    if (empty($email)) {
        $error_message .= "* Please enter your email address.<br>";
    } elseif ($email == false) {
        $error_message .= "* Please enter a valid email address.<br>";
    }
} elseif (isset($_GET['email'])) {
    $email = htmlentities($_GET['email']);
}

if (isset($email)) {
    // grab all the users information if it exists
    try {
        $sth = $db->prepare("SELECT * FROM contacts WHERE email=:email;");
        $sth->bindValue(':email', $email);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }
}

if ($_POST) {
    // if they select the unsubscribe all and they don't check the box
    if (isset($_POST['UnsubscribeAll']) == "yes" and empty($_POST['unsubscribeReason'])) {
        $error_message .= "*Please select the option that best describes your reason for unsubscribing<br>";
        $success = false;
    }

    // user is in the database
    if ($result['email'] == $email && $error_message == "") {

        if ($_POST['prospect'] == "yes") {
            $sqlArray[] = "prospect_permission = 'express'";
            $sqlArray[] = "prospect_permission_date = '$dateYYYYMMDD'";
            $sqlArray[] = "prospect_permission_source = '$source'";
            $sqlArray[] = "prospect_permission_casl = 'express'";
            $sqlArray[] = "prospect_permission_date_casl = '$dateTime'";
            $sqlArray[] = "prospect_permission_source_casl = '$source'";
        } else {
            $sqlArray[] = "prospect_permission = 'unsubscribe'";
            $sqlArray[] = "prospect_permission_date = '$dateYYYYMMDD'";
            $sqlArray[] = "prospect_permission_source = '$source'";
            $sqlArray[] = "prospect_permission_casl = 'unsubscribe'";
            $sqlArray[] = "prospect_permission_date_casl = '$dateTime'";
            $sqlArray[] = "prospect_permission_source_casl = '$source'";
        }

        if ($_POST['prospect'] == "yes" || $_POST['advice'] == "yes" || $_POST['relationship'] == "yes") {
            $sqlArray[] = "email_permission = 'express'";
            $sqlArray[] = "email_permission_date = '$dateYYYYMMDD'";
            $sqlArray[] = "email_optin_from = '$source'";
            $sqlArray[] = "email_permission_casl = 'express'";
            $sqlArray[] = "email_permission_date_casl = '$dateTime'";
            $sqlArray[] = "email_permission_source_casl = '$source'";
        } else {
            $sqlArray[] = "email_permission = 'unsubscribe'";
            $sqlArray[] = "email_permission_date = '$dateYYYYMMDD'";
            $sqlArray[] = "email_optin_from = '$source'";
            $sqlArray[] = "email_permission_casl = 'unsubscribe'";
            $sqlArray[] = "email_permission_date_casl = '$dateTime'";
            $sqlArray[] = "email_permission_source_casl = '$source'";
        }

        foreach ($subscriptions as $subscription) {
            if (isset($_POST[$subscription['name_form']]) and $_POST[$subscription['name_form']] == "yes" and $result[$subscription['name_db'] . "_newsletter_permission"] != 'express' and $result[$subscription['name_db'] . "_permission_casl"] != 'express') {
                $sqlArray[] = $subscription['name_db'] . "_newsletter_permission = 'express'";
                $sqlArray[] = $subscription['name_db'] . "_permission_casl = 'express'";
                $sqlArray[] = $subscription['name_db'] . "_newsletter_permission_date = '$dateYYYYMMDD'";
                $sqlArray[] = $subscription['name_db'] . "_permission_date_casl = '$dateTime'";
                $sqlArray[] = $subscription['name_db'] . "_newsletter_optin_from = '$source'";
                $sqlArray[] = $subscription['name_db'] . "_permission_source_casl = '$source'";
            } elseif (isset($_POST[$subscription['name_form']]) and ($_POST[$subscription['name_form']] == "no" 
					or (isset($_POST['UnsubscribeAll']) and $_POST['UnsubscribeAll'] == "yes")) and ($result[$subscription['name_db'] . "_newsletter_permission"] != 'unsubscribe' and $result[$subscription['name_db'] . "_permission_casl"] != 'unsubscribe')) {
                $sqlArray[] = $subscription['name_db'] . "_newsletter_permission = 'unsubscribe'";
                $sqlArray[] = $subscription['name_db'] . "_permission_casl = 'unsubscribe'";
                $sqlArray[] = $subscription['name_db'] . "_newsletter_permission_date = '$dateYYYYMMDD'";
                $sqlArray[] = $subscription['name_db'] . "_permission_date_casl = '$dateTime'";
                $sqlArray[] = $subscription['name_db'] . "_newsletter_optin_from = '$source'";
                $sqlArray[] = $subscription['name_db'] . "_permission_source_casl = '$source'";
            }
        }

        $sql = sprintf(
            "UPDATE contacts SET %s%s,last_updated=:last_updated,french=:french WHERE email=:email",
            implode(",", $sqlArray),
            (isset($_POST['UnsubscribeAll']) && $_POST['UnsubscribeAll'] === "yes" ? ',opt_out_reason=:opt_out_reason':'')
        );

        /** @var PDOStatement $query */
        $query = $db->prepare($sql);

        if (isset($_POST['UnsubscribeAll']) && $_POST['UnsubscribeAll'] === "yes") {
            $query->bindValue(':opt_out_reason', $_POST['unsubscribeReason']);
        }

        $query->bindValue(':last_updated', $dateTime);
        $query->bindValue(':email', $email);
        $query->bindValue(':french', 0);
        $query->execute();
        $success = true;
		}

        //insert a user if he doesnt exist and there are no errors
    if (empty($result['email']) && $error_message == "") {
        $sql = sprintf(
            "INSERT INTO contacts (email,source,[date],french,%semail_permission,email_permission_date,email_optin_from,email_permission_casl,email_permission_date_casl,email_permission_source_casl,prospect_permission,prospect_permission_date,prospect_permission_source,prospect_permission_casl,prospect_permission_date_casl,prospect_permission_source_casl",
            (isset($_POST['UnsubscribeAll']) && $_POST['UnsubscribeAll'] === "yes" ? "opt_out_reason,":'')
        );

        foreach ($subscriptions as $subscription) {
            $sql .= "," . $subscription['name_db'] . "_newsletter_permission";
            $sql .= "," . $subscription['name_db'] . "_permission_casl";
            $sql .= "," . $subscription['name_db'] . "_newsletter_permission_date";
            $sql .= "," . $subscription['name_db'] . "_permission_date_casl";
            $sql .= "," . $subscription['name_db'] . "_newsletter_optin_from";
            $sql .= "," . $subscription['name_db'] . "_permission_source_casl";
        }

        $sql = sprintf(
            "%s) VALUES (:email,:source,:date,:french,%s:email_permission,:email_date,:email_source,:email_permission_casl,:email_date_casl,:email_source_casl,:prospect_permission,:prospect_date,:prospect_source,:prospect_permission_casl,:prospect_date_casl,:prospect_source_casl",
            $sql,
            (isset($_POST['UnsubscribeAll']) && $_POST['UnsubscribeAll'] === "yes" ? ":opt_out_reason,":'')
        );

        foreach ($subscriptions as $subscription) {
            $sql .= ", :" . $subscription['name_db'] . "_newsletter_permission";
            $sql .= ", :" . $subscription['name_db'] . "_permission_casl";
            $sql .= ", :" . $subscription['name_db'] . "_newsletter_permission_date";
            $sql .= ", :" . $subscription['name_db'] . "_permission_date_casl";
            $sql .= ", :" . $subscription['name_db'] . "_newsletter_optin_from";
            $sql .= ", :" . $subscription['name_db'] . "_permission_source_casl";
        }

        $sql .= ")";

        $query = $db->prepare($sql);
        $query->bindValue(':email', $_POST['email']);
        $query->bindValue(':source', 'Preferences Page');
        $query->bindValue(':date', $dateYYYYMMDD);
        $query->bindValue(':french', 0);

        if (isset($_POST['unsubscribeReason']) ? $_POST['unsubscribeReason'] : '') {
            $query->bindValue(':opt_out_reason', $_POST['unsubscribeReason']);
        }

        if ($_POST['prospect'] == "yes" || $_POST['advice'] == "yes" || $_POST['relationship'] == "yes") {
            $query->bindValue(':email_permission', 'express');
            $query->bindValue(':email_source', $source);
            $query->bindValue(':email_date', $dateYYYYMMDD);
            $query->bindValue(':email_permission_casl', 'express');
            $query->bindValue(':email_source_casl', $source);
            $query->bindValue(':email_date_casl', $dateTime);
        } else {
            $query->bindValue(':email_permission', 'unsubscribe');
            $query->bindValue(':email_source', $source);
            $query->bindValue(':email_date', $dateYYYYMMDD);
            $query->bindValue(':email_permission_casl', 'unsubscribe');
            $query->bindValue(':email_source_casl', $source);
            $query->bindValue(':email_date_casl', $dateTime);
        }

        if ($_POST['prospect'] == "yes") {
            $query->bindValue(':prospect_permission', 'express');
            $query->bindValue(':prospect_source', $source);
            $query->bindValue(':prospect_date', $dateYYYYMMDD);
            $query->bindValue(':prospect_permission_casl', 'express');
            $query->bindValue(':prospect_source_casl', $source);
            $query->bindValue(':prospect_date_casl', $dateTime);
        } else {
            $query->bindValue(':prospect_permission', 'unsubscribe');
            $query->bindValue(':prospect_source', $source);
            $query->bindValue(':prospect_date', $dateYYYYMMDD);
            $query->bindValue(':prospect_permission_casl', 'unsubscribe');
            $query->bindValue(':prospect_source_casl', $source);
            $query->bindValue(':prospect_date_casl', $dateTime);
        }

        foreach ($subscriptions as $subscription) {
            if (isset($_POST[$subscription['name_form']]) and $_POST[$subscription['name_form']] == "yes" and (!isset($_POST['UnsubscribeAll']) or $_POST['UnsubscribeAll'] != "yes")) {
                $query->bindValue(':' . $subscription['name_db'] . '_newsletter_permission', 'express');
                $query->bindValue(':' . $subscription['name_db'] . '_permission_casl', 'express');
                $query->bindValue(':' . $subscription['name_db'] . '_newsletter_permission_date', $dateYYYYMMDD);
                $query->bindValue(':' . $subscription['name_db'] . '_permission_date_casl', $dateTime);
                $query->bindValue(':' . $subscription['name_db'] . '_newsletter_optin_from', '$source');
                $query->bindValue(':' . $subscription['name_db'] . '_permission_source_casl', $source);
            } elseif (isset($_POST[$subscription['name_form']]) and $_POST[$subscription['name_form']] == "no" or (isset($_POST['UnsubscribeAll']) and $_POST['UnsubscribeAll'] == "yes")) {
                $query->bindValue(':' . $subscription['name_db'] . '_newsletter_permission', 'unsubscribe');
                $query->bindValue(':' . $subscription['name_db'] . '_permission_casl', 'unsubscribe');
                $query->bindValue(':' . $subscription['name_db'] . '_newsletter_permission_date', $dateYYYYMMDD);
                $query->bindValue(':' . $subscription['name_db'] . '_permission_date_casl', $dateTime);
                $query->bindValue(':' . $subscription['name_db'] . '_newsletter_optin_from', '$source');
                $query->bindValue(':' . $subscription['name_db'] . '_permission_source_casl', $source);
            } else {
                $query->bindValue(':' . $subscription['name_db'] . '_newsletter_permission', 'unassigned');
                $query->bindValue(':' . $subscription['name_db'] . '_permission_casl', 'unassigned');
                $query->bindValue(':' . $subscription['name_db'] . '_newsletter_permission_date', $dateYYYYMMDD);
                $query->bindValue(':' . $subscription['name_db'] . '_permission_date_casl', $dateTime);
                $query->bindValue(':' . $subscription['name_db'] . '_newsletter_optin_from', '$source');
                $query->bindValue(':' . $subscription['name_db'] . '_permission_source_casl', $source);
            }
        }
        $query->execute();
        $success = true;
    }
    if (empty($unsubscribedList)) {
        $landingPage = "thankYouForm";
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <!-- JS VALIDATION-->
    <script type="text/javascript" src="js/unsubscribeValidation_v2.js"></script>
    <!--
    //	Version: 	1.0
    // 	Date:		Sept 2014
    // 	Authors: 	Olivia Mikhael
    -->
    <!-- CSS Styling-->
    <link href="css/unsubscribe_v2.css" rel="stylesheet">
    <title>Allstate</title>
</head>
<body bgcolor="#cce5f9">

<div class="mainTable2">
    <a href="http://www.allstate.ca/" target="_blank" class="div1Link"> 
	 	<img src="http://www.newsletter.allstate.ca/images/20140809_allstate_01.png" alt="Allstate(R) Insurance" width="211" height="87" hspace="0" vspace="0" border="0" style="display:block;"/></a>
</div>
<div class="mainTable3">
    <img src="http://www.newsletter.allstate.ca/images/20140809_allstate_02.png" alt="Preference Centre" class="preferenceImage" width="320" hspace="0" vspace="0" border="0" style="display:block;"/>
</div>
<div class="mainTable">

	<?php if ($landingPage == "mainForm") { ?>
    <form id="mainForm" onsubmit="return validateForm()" name="mainForm" class="form" action="unsubscribe_v2.php"
          method="post" enctype="multipart/form-data">
        <div class="error"><?php echo $error_message; ?></div>
        <div class="div7">
            We would love to continue to email you to keep you informed and also give you helpful
            tips and advice to protect the things most important to you.
            <strong>Please confirm your email address, adjust your email settings and <span style="color:#5fa737;">CLICK ON THE UPDATE BUTTON</span>
                to Submit.</strong></div>
        <div class="div1">
            <label for="email"><b>Email Address:</b></label>
            <br/>
            <br/>
            <input type="text" value="<?php echo (isset($email) ? $email : ''); ?>" name="email" id="email" align="left"/>
        </div>
        <div class="mainTable4">
            <div class="div2">
                <div class="div-checkbox">
                    <br/>
                </div>
                <div class="divText">
                    <label for="reason1"> <span style="color:#0077c0; font-weight:bold; font-size:14px;">Update Your Subscriptions</span><br/><br/>
                    </label>
                </div>
            </div>
            <div class="div3">
                <div class="div-checkbox">
                    <div class="div-radiobutton">
                        <?php
                        $subscribed = false;

                        if (isset($result)) {

                            if ($result["prospect_permission_casl"] == 'express' or
                                $result["prospect_permission"] == 'express' or
                                $result["prospect_permission"] == 'implied'
                            ) {
                                $subscribed = true;
                            }
                        }

                        ?>
                        <input type="radio" name="prospect" value="yes" <?php echo($subscribed ? 'checked' : ''); ?> /><span
                            style="color:#0077c0; font-weight:bold; font-size:15px;">YES</span>
                    </div>
                    <div class="div-radiobutton">
                        <input type="radio" name="prospect" value="no" <?php echo(!$subscribed ? 'checked' : ''); ?> /><span
                            style="color:#0077c0; font-weight:bold; font-size:15px;">NO</span>
                    </div>
                </div>
                <div class="divText">
                    <label for="prospect"> <strong>Products and Services: </strong>I would like to receive
                        emails about Allstate's products and services that Canadians have trusted
                        for 60 years<br/>
                        <br/>
                    </label>
                </div>
            </div>

            <div class="div3">
                <div class="div-checkbox">
                    <div class="div-radiobutton">
                        <?php
                        $subscribed = false;

                        if (isset($result)) {

                            if ($result[$subscriptions[0]["name_db"] . "_permission_casl"] == 'express' or
                                $result[$subscriptions[0]["name_db"] . "_newsletter_permission"] == 'express' or
                                $result[$subscriptions[0]["name_db"] . "_newsletter_permission"] == 'implied'
                            ) {
                                $subscribed = true;
                            }
                        }
                        ?>
                        <input type="radio" name="advice" value="yes" <?php echo($subscribed ? 'checked' : ''); ?> /><span
                            style="color:#0077c0; font-weight:bold; font-size:15px;">YES</span>
                    </div>
                    <div class="div-radiobutton">
                        <input type="radio" name="advice" value="no" <?php echo(!$subscribed ? 'checked' : ''); ?> /><span
                            style="color:#0077c0; font-weight:bold; font-size:15px;">NO</span>
                    </div>
                </div>
                <div class="divText">
                    <label for="advice"> <strong>Advice:</strong> I would like to receive advice-based emails with helpful
                        advice, safety tips and special weather advisories, including the Allstate newsletter. <br/>
                        <br/>
                    </label>
                </div>
            </div>
            <div class="div3">
                <div class="div-checkbox">
                    <div class="div-radiobutton">
                        <?php
                        $subscribed = false;

                        if (isset($result)) {

                            if ($result[$subscriptions[1]["name_db"] . "_permission_casl"] == 'express' or
                                $result[$subscriptions[1]["name_db"] . "_newsletter_permission"] == 'express' or
                                $result[$subscriptions[1]["name_db"] . "_newsletter_permission"] == 'implied'
                            ) {
                                $subscribed = true;
                            }
                        }
                        ?>
                        <input type="radio" name="relationship"
                               value="yes" <?php echo($subscribed ? 'checked' : ''); ?> /><span
                            style="color:#0077c0; font-weight:bold; font-size:15px;">YES</span>
                    </div>
                    <div class="div-radiobutton">
                        <input type="radio" name="relationship"
                               value="no" <?php echo(!$subscribed ? 'checked' : ''); ?> /><span
                            style="color:#0077c0; font-weight:bold; font-size:15px;">NO</span>
                    </div>
                </div>
                <div class="divText">
                    <label for="relationship"><strong> Relationship:</strong>I would like to receive emails about special
                        events like birthdays, season’s greetings or local events. <br/>
                        <br/></label>
                </div>
            </div>
            <div class="div3">
                <div class="div-checkbox">
                    <br/>
                </div>
                <div class="divText">
                    <label for="reason1"> <span style="color:#0077c0; font-weight:bold; font-size:14px;">Unsubscribe From All</span>
                        <br/><br/></label>
                </div>
            </div>
            <div class="div8" style="height: 50px;">
                <div class="div-checkbox">
                    <input name="UnsubscribeAll" id="UnsubscribeAll" type="checkbox" value="yes"/>
                </div>
                <div class="divText">
                    <label for="UnsubscribeAll"> I would like to unsubscribe from receiving all of the above email
                        communication. <br/>
                        <span style="color:#0077c0; font-style:italic; font-size:12px;">If you change your mind at any time, we’d love to have you back.</span><br/><br/></label>
                </div>
            </div>
        </div>
        <div id="radiobuttons" class="mainTable7">
            <div class="div3">
                <div class="div-checkbox">
                    <br/>
                </div>
                <div class="divText">
                    <label for="reason1">
						  	<span style="color:#60a836; font-weight:bold; font-size:14px;">In order to help us serve you better in the future, please select the option that best describes your reason for unsubscribing:</span><br/><br/>
                    </label>
                </div>
            </div>
            <div class="div3">
                <div class="div-checkbox2">
                    <input type="radio" value="The content you send doesn't apply to me" name="unsubscribeReason" id="reason1"/>
                </div>
                <div class="divText">
                    <label for="reason1"> The content you send doesn't apply to me<br/><br/></label>
                </div>
            </div>
            <div class="div3">
                <div class="div-checkbox2">
                    <input type="radio" value="You send me too many emails" name="unsubscribeReason" id="reason2"/>
                </div>
                <div class="divText">
                    <label for="reason2"> You send me too many emails<br/><br/></label>
                </div>
            </div>
            <div class="div3">
                <div class="div-checkbox2">
                    <input type="radio" value="I don't find your information to be of any value to me" name="unsubscribeReason" id="reason3"/>
                </div>
                <div class="divText">
                    <label for="reason3"> I don’t find your information to be of
                        any value to me<br/><br/></label>
                </div>
            </div>
            <div class="div3">
                <div class="div-checkbox2">
                    <input type="radio" value="I only provided my email address to win a contest" name="unsubscribeReason" id="reason4"/>
                </div>
                <div class="divText">
                    <label for="reason4"> I only provided my email address to win
                        a contest<br/><br/></label>
                </div>
            </div>
            <div class="div8">
                <div class="div-checkbox2">
                    <input type="radio" value="I never subscribed to receive these emails" name="unsubscribeReason" id="reason5"/>
                </div>
                <div class="divText">
                    <label for="reason5"> I never subscribed to receive these emails <br/><br/></label>
                </div>
            </div>
        </div>
        <div class="mainTable5">
            <div class="div5">
                <div class="div-checkbox">
                    <br/>
                </div>
                <div class="divText">
                    <label for="reason1"> 
						  		<span style="color:#0077c0; font-weight:bold; font-size:14px;">Allstate Customers Only</span><br/><br/>
                    </label>
                </div>
            </div>
            <div class="div9">
                <div class="div-checkbox">
                    <div class="div-radiobutton">
                        <?php
                        $subscribed = '';

                        if (isset($result)) {
                            if ($result[$subscriptions[2]["name_db"] . "_permission_casl"] == 'express'
                                or $result[$subscriptions[2]["name_db"] . "_newsletter_permission"] == 'express'
                                or $result[$subscriptions[2]["name_db"] . "_newsletter_permission"] == 'implied'
                            ) {
                                $subscribed = 'yes';
                            }

                            if ($result[$subscriptions[2]["name_db"] . "_permission_casl"] == 'unsubscribe'
                                or $result[$subscriptions[2]["name_db"] . "_newsletter_permission"] == 'unsubscribe'
                            ) {
                                $subscribed = 'no';
                            }
                        }
                        ?>
                        <input type="radio" name="transactional"
                               value="yes"  <?php echo($subscribed === 'yes' ? 'checked' : ''); ?>  /><span style="color:#0077c0; font-weight:bold; font-size:15px;">YES</span>
                    </div>
                    <div class="div-radiobutton">
                        <input type="radio" name="transactional"
                               value="no" <?php echo($subscribed === 'no' ? 'checked' : ''); ?> /><span style="color:#0077c0; font-weight:bold; font-size:15px;">NO</span>
                    </div>
                </div>
                <div class="divText">
                    <label for="reason1"> <strong>Transactional:</strong> As an Allstate Customer I would like to continue
                        to receive any emails specially related to my policy.<br/> <br/></label>
                </div>
            </div>
        </div>
        <div class="mainTable6">
            <div class="error"><?php echo $error_message; ?> </div>
            <div align="center" class="div6">
                <input type="image" src="images/20140809_allstate_03.png" alt="Update"/>
            </div>
        </div>
    </form>
    </div>
	<?php } else {
		 if ($landingPage == "unsubscirbeList") {
			  ?>
			  <div class="finalMessage">Thank you for updating your preferences. You have successfully been unsubscribed from
					the
					following subscriptions:<br/><br/> <?php echo $unsubscribedList; ?> <br/><br/></div>
	
		 <?php
		 } else {
			  if ($landingPage == "unsubscirbeList2") {
					?>
					<div class="finalMessage">We’re sorry to see you go. You have successfully been unsubscribed from the
						 following
						 subscriptions:<br/><br/> <?php echo $unsubscribedList; ?> <br/><br/></div>
			  <?php
			  } else {
					if ($landingPage == "thankYouForm") {
						 ?>
						 <div class="finalMessage">Thank you for updating your preferences.<br/><br/></div>
					<?php
					}
			  }
		 }
	}
	?>
</div>
<div class="legal"> Allstate Insurance Company of Canada<br/>
    27 Allstate Parkway, <br/>
    Suite 100<br/>
    Markham, Ontario <br/>
    L3R 5P8<br/>
    905-477-6900<br/>
    <br/>
    Allstate Canada takes your privacy seriously. If you would like to view
    our privacy policy, please <a href="http://www.allstate.ca/Allstate/custcare/privacy-matters.aspx" target="_blank"
                                  class="legalLink">click
        here</a><br/>
    <br/>
</div>
<br/>
<br/>
<!-- JQuery hide and unhide the grey area 
(radiobuttons) based on checkboxes selection-->
<script>
    $(function () {
        $('#radiobuttons').hide();
        $('#UnsubscribeAll').on("click", function () {

            if ($('#UnsubscribeAll').prop("checked")) {
                $('#radiobuttons').show(200);
                $('input[name=prospect][value=no]').prop("checked", true);
                $('input[name=advice][value=no]').prop("checked", true);
                $('input[name=relationship][value=no]').prop("checked", true);

                $('#reason1').prop('checked', false);
                $('#reason2').prop('checked', false);
                $('#reason3').prop('checked', false);
                $('#reason4').prop('checked', false);
                $('#reason5').prop('checked', false);
            } else {
                $('#radiobuttons').hide();
            }
        });

        $('input[name=prospect]:radio, input[name=advice]:radio, input[name=relationship]:radio').change(function () {
            if ($('input[name=prospect]:checked').val() == 'yes' || $('input[name=advice]:checked').val() == 'yes' || $('input[name=relationship]:checked').val() == 'yes') {
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
    var s_code = s.t();
    if (s_code) document.write(s_code)//--></script>
<script language="JavaScript" type="text/javascript"><!--
    if (navigator.appVersion.indexOf('MSIE') >= 0) document.write(unescape('%3C') + '\!-' + '-')
    //--></script>
<noscript>
    <img src="http://allstate.122.2o7.net/b/ss/allstatedevelopment/1/H.22.1--NS/0" height="1"
         width="1" border="0" alt=""/></noscript>
<!--/DO NOT REMOVE/-->
<!-- End SiteCatalyst code version: H.22.1. -->
</body>
</html>
