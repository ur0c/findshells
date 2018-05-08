<? 

session_start();

$root = "../";

$nav = "index";

include($root . 'inc/scripts/db_connection.php');

function generateRandomString($length = 6) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

if ($_POST['submit']) {
		
	$shortcut = generateRandomString();
	$user = (int)$_SESSION['user_id'];
	
	$q = "INSERT INTO tu_user_lists (user_id, shortcut, create_date, list_name) ";
	$q .= "VALUES (".$user.", '" . $shortcut . "', NOW(), '" . mysqli_real_escape_string($mysqli,$_POST['listname']) . "')";
	$result = $mysqli->query($q) or die("Fehler");

	header('Location: /list/' . $shortcut);
	exit;
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
	
	
	<script>
		function standby(id) {
    		document.getElementById(id).src = '/tui_images/default.png';
		}
	</script>
	
	<script type="text/javascript">
		function booking(d, sc, u) {
			var s = d.createElement(sc), p = d.getElementsByTagName(sc)[0];
			alert(p);
			s.type = 'text/javascript';
			s.async = true;
			s.src = u + '?v=' + (+new Date());
			p.parentNode.insertBefore(s,p);
		}

	
	
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
    
	<!--<div style="margin-top:50px; background-color:#ff5a00; padding:5px 15px;">
		<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;&nbsp;
		<span style="font-size:15px;">Bitte melde Dich an, da sonst jeder Deine Liste verändern kann.</span>
		<a href=""><strong>Login</strong></a>
	</div>-->
    
    <section class="container p-t-30">

		<div class="row" style="margin-top:0px;">
		<div class="col-md-12">	  

			<!--<div style="margin-top:40px;">
				<span style="font-size:14px;">Link zu Deiner Liste:</span>
				<span style="font-weight:bold; font-size:14px;">http://findshells.de/sA8i75vbphsy</span>
			</div>-->
			<form action="new.php" method="post">
			<div style="margin-top:100px;">
				<h3 style="margin-bottom:40px;">Bitte gib den Namen Deiner Hotelliste an </h3>
				<input type="text" name="listname" class="form-control" style="" placeholder="z.B.: Meine liebsten Wellness Hotels"  maxlength="200" required>
				<bR>
				<input type="submit" name="submit" class="btn btn-primary" type="button" style="" value="Weiter">
			</div>
			</form>
			<!--<div class="row" style="margin-top:30px;">
				<div class="col-md-12">	  
					Hotel hinzufügen:
					<select name="searchhotel" id="searchhotel" style="width:100%">
					</select>
				</div>
			</div>
			<!--<div style="margin-bottom:40px;margin-top:10px;font-size:12px;">
				<a href="/cms/hotel_search.php">Hotel nicht gefunden? Zur erweiterten Suche</a>
			</div>-->

		</div>
		</div>

	</section>

	<br><br><br><br><br><br><br><br><br><br><br>


	<? include($root."inc/footer.php"); ?>


	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

	<script>

		$('#searchhotel').select2({
			minimumInputLength: 3,

			ajax: {
				type: 'get',
				url: '/ajax/hotelselector.php',
				dataType: "json",
				data: function (params) {
					return {
						q: params.term
					};
				},
				processResults: function (data, params) {
					return {
						results: $.map(data, function (item) {
							return {
								text: item.pincode,
								id: item.hid,
								data: item
							};
						})
					};
				}
			}
		});

	</script>
  </body>
</html>