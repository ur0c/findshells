<?

session_start();

$root = "../";

if (empty($_SESSION['user_id'])) {
	header('Location: '.$root.'index.php');
	exit; 
}

include($root . "inc/scripts/db_connection.php");

if (isset($_GET['del'])) {
	
	// ist das eine Liste des Users?
	$q = "SELECT * FROM tu_user_lists WHERE deleted=0 AND user_id=" . (int)$_SESSION['user_id'] . " AND id=" . (int)$_GET['del'];
	$result_l = $mysqli->query($q) or die( mysqli_connect_error($mysqli));
	if ($row_l = $result_l->fetch_assoc()) {
		
		// Liste löschen
		$q = "UPDATE tu_user_lists SET deleted=NOW() WHERE id=" . (int)$_GET['del'];
		$result = $mysqli->query($q) or die( mysqli_connect_error($mysqli));

		// Request ggf. deaktivieren, wenn kein anderer den Request nutzt
		$q = "SELECT * FROM tu_user_lists WHERE deleted=0 AND request_id=" . (int)$row_l['request_id'];
		$result = $mysqli->query($q) or die( mysqli_connect_error($mysqli));
		if (!$row = $result->fetch_assoc()) {
			
			$q = "UPDATE tu_requests SET deleted=NOW() WHERE id=" . (int)$row_l['request_id'];
			$result = $mysqli->query($q) or die( mysqli_connect_error($mysqli));

		}	
		
		header("Location: create_list.php");
		exit;
		
	} else die('Fehler');
	
}

if (isset($_POST['submit'])) {
	
	if (empty($_POST['listname'])) die("Name der Liste ist leer");

	if (strlen($_POST['listname'])>200) {
		echo "Leider ist Deine URL zu lang.";
		exit;
	}
	
	$adults = (int)$_POST['adults'];
	if (empty($adults)) die("Anzahl Erwachsene inkorrekt");

	$children = (int)$_POST['children'];
	$child = $_POST['child'];
	$childdata = array();
	if (!empty($children)) {
		for ($i=1; $i<=$children; $i++) {
			if (empty((int)$child[$i])) die("Bitte Alter von Kind " . $i . " angeben");
				$childdata[] = (int)$child[$i];
		}
	}
	if (empty($childdata)) $ages_kids = "";
	else $ages_kids = implode(",", $childdata);

	$dates = explode(" - ", $_POST['daterange']);
	$starta = explode("/", $dates[0]);
	$enda = explode("/", $dates[1]);
	$start = $starta[2] . "-" . $starta[0] . "-" . $starta[1];
	$end = $enda[2] . "-" . $enda[0] . "-" . $enda[1];
	
	$board_type_array = array('AI', 'AP', 'FB', 'FP', 'HB', 'HP', 'BB', 'AO');
	$board_type = implode(",", $_POST['boardtype']);
	$bt_str = "";
	
	foreach ($_POST['boardtype'] AS $bv) {
		if (!in_array($bv, $board_type_array)) die('Fehler');
		$bt_str .= "&boardTypes[]=" . $bv;
	}
	
	// insert request
	$re = "http://www.tui.com/api/hotel?useExtendedFilterDefaultValues=true";
	$re .= "&departureAirports[]=FMM&departureAirports[]=MUC";
	foreach ($childdata as $ch) $re .= "&childs[]=" . $ch;
	$re .= "&startDate=" . $start . "&endDate=" . $end;
	$re .= "&duration=7-";
	$re .= $bt_str ;
	
	$q = "INSERT INTO tu_requests (create_date, url) VALUES (NOW(), '".$re."')";
	$result_hreq = $mysqli->query($q) or die( mysqli_connect_error($mysqli));
	$request_id = $mysqli->insert_id;

	// insert list
	$q = "INSERT INTO tu_user_lists (user_id, create_date, list_name, airports, date_start, date_end, board_type, adults, ages_kids, request_id) VALUES ";
	$q .= "(".$_SESSION['user_id'].", NOW(), '".mysqli_real_escape_string($mysqli, $_POST['listname'])."', 'MUC', '";
	$q .= $start . "', '" . $end . "', '".$board_type."', " . (int)$_POST['adults'] . ", '" . $ages_kids . "', " . $request_id . ")";
	$result_hreq = $mysqli->query($q) or die( mysqli_connect_error($mysqli));

	// perform request at tui
	
	// redirect to Home
	header('Location: create_list.php?success=true');
	exit;
	
}


// get all lists
$q = "SELECT * FROM tu_user_lists WHERE deleted=0 AND user_id=" . (int)$_SESSION['user_id'];
$result = $mysqli->query($q) or die( mysqli_connect_error($mysqli));
while ($row = $result->fetch_assoc()) {
	$l[$row['id']]['name'] = $row['list_name'];
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


<? include('../inc/header.php'); ?>
<? include('../inc/menu_intern.php'); ?>


<section class="container" style="margin-bottom:200px;">
	
		
	<? if (isset($_GET['success'])) { ?>
		
		<i class="fa fa-check" style="color:green; font-size:34px;"></i> Deine Liste wurde angelegt
		<div style="margin-top:30px;">
			<a class="btn btn-default" href="/<?=$_SESSION['user_url']?>/index.php" role="button">Zur&uuml;ck zu meiner Seite</a>
		</div>
		
		<? } else { ?>
		
		<div class="row" style="margin-top:20px;">
		<div class="col-md-12">	 
		
		<form action="create_list.php" method="POST"  role="form" data-toggle="validator">
			
			<h3 style="margin-bottom:20px;">Neue Liste anlegen</h3>

		
			<div style="padding:5px 0px;"> 
				<label for="sel1">Name der Liste:</label>
				<input type="text" name="listname" class="form-control" placeholder="z.B. Sommerferien mit den Kindern"  maxlength="200" required>
				<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
				<div class="help-block with-errors"></div>
			</div>
			
			<h4 style="margin-top:20px;">Suchkriterien angeben</h4>
			<p>Geben Sie hier Ihre Suchkriterien an. Es werden dann Hotels in allen Regionen angezeigt.</p>



			<div style="padding:5px 0px;"> 
				<label for="sel1">Reisezeitraum:</label>
				<input type="text" name="daterange" class="form-control" required />
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
		
		
		<div class="row" style="margin-top:30px;">
		<div class="col-md-12">	 
			<h3 style="margin-bottom:20px;">Listen löschen</h3>
			<table class="table table-striped">
			<? foreach ($l AS $lid=>$lval) { ?>
			<tr>
			<td>
				<a href="create_list.php?del=<?=$lid?>" onclick="return confirm('Möchtest du die Liste <?=htmlspecialchars($lval['name'])?> wirklich löschen?');">
					<i class="fa fa-trash" style="color:red; font-size:18px;"></i>
				</a>
			</td>
			<td style="padding-left:10px;" width="100%"><?=htmlspecialchars($lval['name']);?>
			</td>
			</tr>
			<? } ?>
			</table>
		</div>
		</div>
		
	<? } // GET success?>
		
		
</section>
	
	
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