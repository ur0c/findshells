<? 

session_start();

$root = "../";

$nav = "index";

include($root . 'inc/scripts/db_connection.php');


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

		<div class="row" style="margin-top:100px;">
		<div class="col-md-12">	  

			<table><tr><td><i class="fa fa-exclamation-triangle" style="color:red; font-size:30px;"></i></td><td style="padding-left:15px;"><b>Der Link ist leider ungültig.</b></td></tr></table>
			<br><br>
			Der Link zum Zur&uuml;cksetzen des Passworts ist leider ung&uuml;ltig.<br>
			Bitte beachte, dass der Link nach 24 Stunden seine G&uuml;ltigkeit verliert.
			<br><br>
			<a href="login.php">neuen Link anfordern</a>

		</div>
		</div>

	</section>

	<br><br><br><br><br><br><br><br><br><br><br>


	<? include($root."inc/footer.php"); ?>


  </body>
</html>
