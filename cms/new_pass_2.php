<? 

session_start();

$root = "../";

$salt="nz_o97z4nhal.83qnheo9wuehfndks&WJQH_R";

$nav = "index";

include($root . 'inc/scripts/db_connection.php');


// gibt es einen gueltigen key?
if (empty($_REQUEST['re'])) { header('Location: '.$root.'index.php'); exit; }
$_REQUEST['re'] = str_replace(" ", "", $_REQUEST['re']);

$yesterday = date('Y-m-d H:i:s', time()-86400);

$q = "SELECT * FROM tu_reset_pass p INNER JOIN tu_user u ON p.user_id=u.id WHERE reset_key='".mysqli_real_escape_string($mysqli, $_REQUEST['re'])."' AND p.insert_date>'".$yesterday."' AND p.used_date=0";
$result = $mysqli->query($q) or die("F2");
if (!$row = $result->fetch_assoc()) {
	header('Location: new_pass_4.php'); exit;
} 


if (isset($_POST['submit'])) {

	// TODO: Email Validation

	// Does the mail exist?
	$q = "SELECT * FROM tu_user WHERE email_user='".mysqli_real_escape_string($mysqli, $_POST['username'])."'";
	$result = $mysqli->query($q) or die("F2");
        if ($row = $result->fetch_assoc()) { 
	
		// Update pass 
		$q = "UPDATE tu_reset_pass SET used_date=NOW() WHERE reset_key='".mysqli_real_escape_string($mysqli, $_POST['re'])."'";
echo $q;
		$result = $mysqli->query($q);	

		$q = "UPDATE tu_user SET password='".md5(mysqli_real_escape_string($mysqli, $salt.$_POST['passwd']))."'";
echo $q;
                $result = $mysqli->query($q);

		header('Location: login.php'); exit;
		
	} else {

		die('Mail does not exist.');

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
				<h2 style="margin-bottom:20px;">Passwort zur&uuml;cksetzen </h2>
				<div style="font-size:14px; color:#999; margin-bottom:20px;">Bitte gib Deine E-Mail Adresse und Dein neues Passwort an.</div>
				<input style="width:300px" type="text" name="username" class="form-control" style="" placeholder="E-Mail" <? if (isset($_REQUEST['username'])) { echo 'value="'.$_REQUEST['username'].'"'; } ?> required>
				<br>
				<input style="width:300px" type="password" name="passwd" class="form-control" style="" placeholder="Neues Passwort" required>
				<br>
				<input style="width:300px" type="password" name="password_2" class="form-control" style="" placeholder="Passwort wiederholen" reqired>
				
<br>
				<input type="submit" name="submit" class="btn btn-primary" type="button" style="" value="Neues Passwort setzen">
				<input type="hidden" name="re" value="<?=$_REQUEST['re']?>">
			</div>
			</form>

		</div>
		</div>

	</section>

	<br><br><br><br><br><br><br><br><br><br><br>


	<? include($root."inc/footer.php"); ?>


  </body>
</html>
