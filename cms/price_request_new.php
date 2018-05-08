<? 

session_start();

$root = "../";

include($root . 'inc/scripts/db_connection.php');

if (isset($_POST['submit'])) {
	//$q = "INSERT INTO tu_user_lists (user_id, shortcut, create_date, list_name) ";
	//$q .= "VALUES (".$user.", '" . $shortcut . "', NOW(), '" . mysqli_real_escape_string($mysqli,$_POST['listname']) . "')";
	//$result = $mysqli->query($q) or die("Fehler");

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
	<script type="text/javascript" src="http://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="http://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
	<link rel="stylesheet" type="text/css" href="http://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
	
	<script type="text/javascript" src="/bstp/multiselect/bootstrap-multiselect.js"></script>
	<link rel="stylesheet" href="/bstp/multiselect/bootstrap-multiselect.css" type="text/css"/>


  </head>
  <body>


  	<? include($root . 'inc/header_content.php'); ?>
    
    <section class="container p-t-30">

		<div class="row" style="margin-top:100px;">
		<div class="col-md-12">	  
		
		
			<h3 style="margin-bottom:40px;">Preisabfrage hinzufügen: </h3>
			
		
			<form action="price_request_new.php" method="POST"  role="form" data-toggle="validator">
			
			<div style="padding:5px 0px;"> 
				<label for="sel1">Reisezeitraum:</label>
				<input type="text" name="daterange" class="form-control" required />
			</div>

			<div style="padding:5px 0px;"> 
				<label for="sel1">Reisedauer:</label>
				<select name="duration" class="form-control" id="duration_select">
  					<option value="7" selected>Eine Woche</option>
				</select>
			</div>
			
			<div style="padding:5px 0px;"> 
				<label for="sel1">Flughafen:</label>
				<select name="airport" class="form-control" id="airport_select">
  					<option value="MUC" selected>München</option>
				</select>
			</div>
			
			<div style="padding:5px 0px;"> 
				<label for="sel1">Verpflegung:</label>
				<div>
				<select name="boardtype[]" id="boardtype" multiple="multiple" style="width:100%">
  					<option value="AI">All Inclusive</option>
  					<option value="AP">All Inclusive Plus</option>
  					<option value="FB">Vollpension</option>
  					<option value="FP">Vollpension Plus</option>
  					<option value="HB">Halbpension</option>
  					<option value="HP">Halppension Plus</option>
  					<option value="BB">Fr&uuml;hstück</option>
  					<option value="AO">Nur &Uuml;bernachtung</option>
				</select>
				</div>
			</div>
			<div style="padding:5px 0px;"> 
				<label for="sel1">Anzahl Erwachsene:</label>
				<select name="adults" class="form-control">
  					<option value="1">1</option>
  					<option value="2" selected>2</option>
				</select>
			</div>
			
			<div style="padding:5px 0px;"> 
				<label for="sel1">Anzahl Kinder:</label>
				<select name="children" class="form-control" id="kids_select">
  					<option value="0" selected>keine Kinder</option>
  					<option value="1">1</option>
  					<option value="2">2</option>
  					<option value="3">3</option>
  					<option value="4">4</option>
  					<option value="5">5</option>
				</select>
			</div>
			<? for ($i=1; $i<6; $i++) { ?>
			<div style="padding:5px 0px;display:none;" id="child<?=$i?>" class="kidsageselect"> 
				<select name="child[<?=$i?>]" class="form-control">
  					<option value="0" selected>Alter Kind <?=$i?></option>
  					<option value="1">1</option>
  					<option value="2">2</option>
  					<option value="3">3</option>
  					<option value="4">4</option>
  					<option value="5">5</option>
  					<option value="6">6</option>
  					<option value="7">7</option>
  					<option value="8">8</option>
  					<option value="9">9</option>
  					<option value="10">10</option>
  					<option value="11">11</option>
  					<option value="12">12</option>
  					<option value="13">13</option>
  					<option value="14">14</option>
  					<option value="15">15</option>
  					<option value="16">16</option>
  					<option value="17">17</option>
				</select>
			</div>
			<? } ?>

			<div style="padding:10px 0px;"> 
				<button class="btn btn-primary" type="submit" name="submit">Liste anlegen</button>
			</div>
			
			</form>
		
		
		
		</div>
		</div>

	</section>

	<br><br><br><br><br><br><br><br><br><br><br>
	
	<script type="text/javascript">
		$(function() {
			$('input[name="daterange"]').daterangepicker();
		});

		$("#kids_select").change(function() {
			var k = $("#kids_select").val()
			$(".kidsageselect").hide();
			for (i = 1; i <= k; i++) {
				$("#child" + i).show();
			}
		});
	
	


		$(document).ready(function() {
			$('#boardtype').multiselect();
		});




	</script>


	<? include($root."inc/footer.php"); ?>

  </body>
</html>