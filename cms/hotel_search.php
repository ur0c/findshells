<?

session_start();

$root = "../";

include($root . "inc/scripts/db_connection.php");
include($root . "inc/functions/google_api_places.php");
include($root . "inc/functions/get_regions.php");




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

<link href="/css/custom.css" rel="stylesheet">

<script type="text/javascript" src="http://cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="/bstp/js/bootstrap.min.js"></script>

<script type="text/javascript" src="http://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="http://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="http://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script type="text/javascript" src="/bstp/multiselect/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="/bstp/multiselect/bootstrap-multiselect.css" type="text/css"/>

</head>
<body>

	<? include('../inc/header_content.php'); ?>

	<section class="container" style="margin-bottom:200px;">
		
				
		<div class="row" style="margin-top:100px;">
		<div class="col-md-12">	 
			
			<h1>Hotel suchen</h1>
		
			<form action="hotel_search.php" method="POST" role="form" data-toggle="validator">
				
				<div style="padding:5px 0px;"> 
					<label for="sel1">Region wählen:</label>
					<div>
					<select class="form-control" name="region" id="regval" style="width:100%">
						<option value="">Bitte Region wählen</option>
						<? foreach (get_regions() as $rid => $rname) { ?>
							<option value="<?=$rid?>" <? if ($rid==$_POST['region']) echo "selected" ?>><?=$rname?></option>
						<? } ?>
					</select>
					</div>
				</div>
			
				<div style="padding:5px 0px;"> 
					<label for="example-text-input" class="col-2 col-form-label">Hotelname:</label>
					<input class="form-control" name="searchtext" type="text" data-minlength="5"  value="<?=htmlspecialchars($_POST['searchtext'])?>" id="" placeholder="" required="true">
				</div>
			
				<div style="padding:15px 0px;"> 
					<div>
						<button  type="submit" name="submit" class="btn btn-primary">Hotel suchen</button>
						&nbsp;&nbsp;
						<a href="/<?=$_SESSION['user_url']?>">
							<button name="submit" class="btn btn-primary">Abbrechen</button>
						</a>
					</div>
				</div>
			
			</form>
		
		</div>
		</div>


		<? if (isset($_POST['submit'])) { ?>		
		
			<div class="row" style="margin-top:30px;">
			<div class="col-md-12">	 
			
				<h1>Suchergebnisse:</h1>
				
				
				
				
				
				
				
				<h4 style="color:#999; margin-top:30px;">gefunden auf findshells.de</h2>
				<table class="table table-striped">
				<?
				$tr=0;
				$q = "SELECT *, h.id as hid, c.name_de as city, r.name_de as region FROM tu_hotels h LEFT JOIN tu_geo_regions r ON r.id=h.region_id LEFT JOIN tu_geo_cities c ON h.city_id=c.id WHERE h.region_id=".(int)$_POST['region']." AND h.hotel_name LIKE '%".mysqli_real_escape_string($mysqli, $_POST['searchtext'])."%' LIMIT 500";
				$result = $mysqli->query($q) or die("Fehler");
				while ($row = $result->fetch_assoc()) {
					$tr++;
					?>
					<tr>
						<td><button type="button" class="btn btn-success btn-xs take_findshells" id="<?=$row['hid']?>"><i class="fa fa-plus-circle" aria-hidden="true"></i> übernehmen</button></td>
						<td width="100%">
							<?=$row['hotel_name']?>
							<span style="color:#999; font-size:11px;"><?=$row['city']?>, <?=$row['region']?></span>
						</td>
					</tr>
				<? } ?>
				<? if (empty($tr)) { ?>
					<tr>
						<td>Keine Treffer</td>
					</tr>
				<? } ?>
				</table>
				
				
				
				
				
				
				
				
				<h4 style="color:#999; margin-top:30px;">gefunden bei google</h2>
				<table class="table table-striped">
				<?
				$tr=0;
				// get lat und long
				$q = "SELECT * FROM tu_geo_regions WHERE id=" . (int)$_POST['region'];
				$result = $mysqli->query($q) or die("Fehler");
				$row = $result->fetch_assoc();
				$latitude = ($row['lat_from']+$row['lat_to'])/2;
				$longitude = ($row['lng_from']+$row['lng_to'])/2;
				$result = array();

				
				$result = google_api_places($latitude, $longitude, $_POST['searchtext']);
				
				foreach ($result['results'] as $val) {
					$tr++; 
					$lat = "";
					$lng = "";
					$name ="";
					$reg = "";
					$place_id = "";
					
					
					?>
					<tr>
						<td>
							<button type="button" class="btn btn-success btn-xs take_google" id="<?=$val['place_id']?>"><i class="fa fa-plus-circle" aria-hidden="true"></i> übernehmen</button>
						</td>
						<td width="100%">
							<?=$val['name']?>
							<span style="color:#999; font-size:11px;"><?=$val['vicinity']?></span>
						</td>
					</tr>
				
				<? } ?>
				<? if (empty($tr)) { ?>
					<tr>
						<td>Keine Treffer</td>
					</tr>
				<? } ?>
				</table>
				
				
				<!-- <h4 style="color:#999; margin-top:30px;">Nichts gefunden?</h2> -->
				
				
				<?
				var_dump($result);
				?>
			
			</div>
			</div>
			
		<? } ?>
		
		
	</section>


	<? include($root."inc/footer.php"); ?>
	
	
	<script>
	
	
	
	$( ".take_findshells" ).click(function() {
  		$.get( "<?=$root?>ajax/add_to_hotellist.php", { hid: $(this).attr('id') }, function( data ) {
  			//alert( "" );
  			window.location.href = '/<?=$_SESSION['user_url']?>';
		});
	});
	
	$( ".take_google" ).click(function() {
		alert( $(this).attr('id') );
  		$.get( "<?=$root?>ajax/add_to_hotellist_new_google.php", { hid: $(this).attr('id'), region: $( "#regsel" ).val() }, function( data ) {
  			alert( data );
  			// window.location.href = '/<?=$_SESSION['user_url']?>';
		});
	});
	
	</script>
	
	
	

</body>
</html>












