<? 

session_start();

$root = "../";

$nav = "index";

include($root . 'inc/scripts/db_connection.php');


if (!empty($_SESSION['user_id'])) {
	if (!empty((int)$_GET['lid'])) {
		header('Location: save_list.php?lid=' . (int)$_GET['lid']);
		exit;
	} else {
		header('Location: ../home.php');
		exit;
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
		<div class="col-md-6">	  

			<form action="/cms/login_action.php?ref=/cms/login.php" method="post">
			<div style="margin-top:100px;">
				<h2 style="margin-bottom:20px;">Einloggen </h2>
				<div style="width:300px; font-size:14px; color:#999; margin-bottom:20px;">Wenn Du schon einen Account bei findshells hast, dann logge Dich bitte ein:</div>
				<? if (isset($_GET['login'])) { ?>
					<div style="width:300px; font-size:14px; color:red; margin-bottom:20px;">Login fehlgeschlagen</div>
				<? } ?>
				<input style="width:300px" type="text" name="username" class="form-control" style="" placeholder="E-Mail" <? if (isset($_REQUEST['username'])) { echo 'value="'.$_REQUEST['username'].'"'; } ?> required>
				<bR>
				<input style="width:300px" type="password" name="passwd" class="form-control" style="" placeholder="Passwort" <? if (isset($_REQUEST['username'])) { echo 'autofocus'; } ?> required>
				<bR>
				<input type="submit" name="submit" class="btn btn-primary" type="button" style="" value="Login">
				<input type="hidden" name="getparams" value="{ 'lid': '<?=$_GET['lid']?>' }">
			</div>
			</form>

		</div>

		<div class="col-md-6">	  

			<form action="/cms/register_action.php?ref=/cms/login.php" method="post">
			<div style="margin-top:100px;">
				<h2 style="margin-bottom:20px;">Registrieren </h2>
				<div style="width:300px; font-size:14px; color:#999; margin-bottom:20px;">Wenn Du noch keinen Account bei findshells hast, dann registriere Dich, um Deine eigenen Listen speichern zu können:</div>
				<? if (isset($_GET['reg'])) { ?>
					<div style="width:300px; font-size:14px; color:red; margin-bottom:20px;">E-Mail bereits registriert</div>
				<? } ?>
				<input style="width:300px" type="text" name="username" class="form-control" style="" placeholder="E-Mail" required>
				<bR>
				<input style="width:300px" type="password" name="passwd" class="form-control" style="" placeholder="Passwort" required>
				<bR>
				<input type="submit" name="submit" class="btn btn-primary" type="button" style="" value="Weiter">
				<input type="hidden" name="getparams" value="{ 'lid': '<?=$_GET['lid']?>' }">
			</div>
			</form>

		</div>
		</div>

	</section>

	<br><br><br><br><br><br><br><br><br><br><br>


	<? include($root."inc/footer.php"); ?>


  </body>
</html>