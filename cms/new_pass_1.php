<? 

session_start();

$root = "../";

$nav = "index";

include($root . 'inc/scripts/db_connection.php');


if (isset($_POST['submit'])) {

	// TODO: Email Validation

	// Does the mail exist?
	$q = "SELECT * FROM tu_user WHERE email_user='".mysqli_real_escape_string($mysqli, $_POST['username'])."'";
	$result = $mysqli->query($q) or die("F2");
        if ($row = $result->fetch_assoc()) { 

		// Create key valid for 1 day 
		$key = md5(time());
		// Insert into DB
		$q = "INSERT INTO tu_reset_pass (user_id, insert_date, reset_key) VALUES ('".$row['id']."', NOW(), '".$key."')";
		$result = $mysqli->query($q);	
		
		// send mail
		$encoding = "utf-8";
		$mail_to = "p.weise@hotmail.com";
		$mail_subject = "Zurücksetzen des Passworts für deinen Account bei findshells.com";
		$mail_message = "Liebe/r Nutzer/in von findshells.com,\r\n\r\nzum Zurücksetzen Deines Passworts verwende bitte untenstehenden Link.\r\n\r\nSolltest Du das Zurücksetzen Deines Passworts nicht angefordert haben, kannst Du diese E-Mail ignorieren.\r\n\r\nhttp://www.findshells.com/cms/new_pass_2.php?re=".$key."\r\n\r\nViele Grüße von Deinem findshells.com Team!";
		$from_name = "findshells.com";
		$from_mail = "info@findshells.com";
	
		// Preferences for Subject field
		$subject_preferences = array(
			"input-charset" => $encoding,
			"output-charset" => $encoding,
			"line-length" => 76,
			"line-break-chars" => "\r\n"
		);

		// Mail header
		$header = "Content-type: text/plain; charset=".$encoding." \r\n";
		$header .= "From: ".$from_name." <".$from_mail."> \r\n";
		$header .= "MIME-Version: 1.0 \r\n";
		$header .= "Content-Transfer-Encoding: 8bit \r\n";
		$header .= "Date: ".date("r (T)")." \r\n";
		$header .= iconv_mime_encode("Subject", $mail_subject, $subject_preferences);

    		// Send mail
    		mail($mail_to, $mail_subject, $mail_message, $header);
		
		header('Location: new_pass_3.php');
		exit;


	
	} else {

		die('df');

	}


	
}



?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>findshells. Reisen!</title>

    <!-- Bootstrap -->
    <link href="/bstp/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/bstp/js/bootstrap.min.js"></script>



    <link href="/css/custom.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
	
	<link rel="stylesheet" type="text/css" href="/bstp/tooltipster/css/tooltipster.bundle.min.css" />
	<link rel="stylesheet" type="text/css" href="/bstp/tooltipster/css/plugins/tooltipster/sideTip/themes/tooltipster-sideTip-shadow.min.css" />

	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

	
	<script type="text/javascript" src="/bstp/tooltipster/js/tooltipster.bundle.min.js"></script>
	
	
	
	<script type="text/javascript">
	
		$(document).ready(function() {
            	return false;
		$('.dologin').tooltipster({
    			trigger: 'click',
    			contentAsHTML: true,
    			interactive: true,
    			theme: 'tooltipster-shadow',
    			content: 'Loading...',
    			// 'instance' is basically the tooltip. More details in the "Object-oriented Tooltipster" section.
    			functionBefore: function(instance, helper) {
        			var $origin = $(helper.origin);
        
        			// we set a variable so the data is only loaded once via Ajax, not every time the tooltip opens
        			if ($origin.data('loaded') !== true) {

            			$.get('/ajax/login_content.php', function(data) {

                			// call the 'content' method to update the content of our tooltip with the returned data.
                			// note: this content update will trigger an update animation (see the updateAnimation option)
                			instance.content(data);

                			// to remember that the data has been loaded
                			$origin.data('loaded', true);
            			});
        			}
    			}
			});

			$('.loginrequired').tooltipster({
				contentAsHTML: true,
				delay: 0,
    			content: '<span style="font-size:13px;">Bitte einloggen, um die<br>Funktion nutzen zu können.</span>',
				theme: 'tooltipster-shadow'
			});

        });


	</script>

</head>
<body>


	<? include($root . 'inc/header_content.php'); ?>
    
    
    	<section class="container p-t-30">

		<div class="row" style="margin-top:0px;">
		<div class="col-md-12">	  

			<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
			<div style="margin-top:100px;">
				<h2 style="margin-bottom:20px;">Passwort vergessen? </h2>
				<div style="font-size:14px; color:#999; margin-bottom:20px;">Bitte gib Deine E-Mail Adresse an und folge den Anweisungen in der Mail, um Dein Passwort zur&uuml;ckzusetzen.</div>
				<? if (isset($_GET['login'])) { ?>
					<div style="width:300px; font-size:14px; color:red; margin-bottom:20px;">Login fehlgeschlagen</div>
				<? } ?>
				<input style="width:300px" type="text" name="username" class="form-control" style="" placeholder="E-Mail" <? if (isset($_REQUEST['username'])) { echo 'value="'.$_REQUEST['username'].'"'; } ?> required>
				<br>
				<input type="submit" name="submit" class="btn btn-primary" type="button" style="" value="Neues Passwort anfordern">
			</div>
			</form>

		</div>
		</div>

	</section>

	<br><br><br><br><br><br><br><br><br><br><br>


	<? include($root."inc/footer.php"); ?>


  </body>
</html>
