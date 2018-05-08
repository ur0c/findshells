<?

session_start();

//include('personal/content.php'); 
$root = "";

$nav = "index";

include($root . 'inc/scripts/db_connection.php');
include($root . 'inc/functions/get_hotel_list.php');
include($root . 'inc/functions/google_get_detail.php');
include($root . 'inc/functions/get_webcontent.php');


// get List Name
$q = "SELECT * FROM tu_user_lists WHERE shortcut='" . mysqli_real_escape_string($mysqli,$_GET['id']) . "' LIMIT 1";
$result = $mysqli->query($q) or die("Fehler");
if (!$row = $result->fetch_assoc()) {
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
    			content: '<span style="font-size:13px;">Bitte einloggen, um die<br>Funktion nutzen zu k�nnen.</span>',
				theme: 'tooltipster-shadow'
			});

        });


	</script>

  </head>
  <body>


  	<? include($root . 'inc/header_content.php'); ?>
    
    
    <section class="container p-t-30">
    
		<? //if ($row['user_id']==0 || $row['user_id']!=$_SESSION['user_id']) { ?>
		<div class="row" style="margin-top:100px;">
		<div class="col-md-12">	  
			<a href="/cms/login.php?lid=<?=$row['id']?>" style="font-size:14px;">
				<i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;&nbsp;Liste speichern ...
			</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="/cms/price_request_new.php?lid=<?=$row['id']?>" style="font-size:14px;">
				<i class="fa fa-eur" aria-hidden="true"></i></i>&nbsp;&nbsp;Preisabfrage starten ...
			</a>
		</div>
		</div>
		<div class="row" style="margin-top:0px;">
		<? //} else { ?>
		<? //<div class="row" style="margin-top:100px;"> ?>
		<? //} ?>
		
		
		
		<div class="col-md-12">	  

				<h3><?=htmlspecialchars($row['list_name'])?></h3>

				<div class="row" style="margin-top:30px;">
					<div class="col-md-12">	  
						Hotel hinzuf&uuml;gen:
						<select name="searchhotel" id="searchhotel" style="width:100%">
						</select>
					</div>
				</div>
		</div>
		</div>
		
		
		
		
		
		<div class="row" style="margin-top:40px;">
		<div class="col-md-12">	 
		<div id="hotellist" style="border-top:3px solid #ddd;">
			<?
			// get hotels
			$hl = array();
			$q = "SELECT * FROM tu_user_lists_hotels WHERE list_id=".$row['id']." ORDER BY insert_date DESC";
			$result_r = $mysqli->query($q) or die("Fehler");
			while ($row_r = $result_r->fetch_assoc()) $hl[] = $row_r['hotel_id'];
			
			// get hotel details
			if (!empty($hl)) {
				$hids = implode(",", $hl);
				$hll = get_hotel_list($hids, $row['id']);
			}
			
			if (!empty($hll)) {
				foreach ($hll AS $hID => $hval) { 
					include($roow.'inc/hotelrow_small.php');
					$nohotels = false;
				} 
			} else {
				echo "Noch keine Hotels";
			}
			?>
		</div>
		</div>
		</div>
		
		
		

	</section>

	<br><br><br><br><br><br><br><br><br><br><br>


	<? include($root."inc/footer.php"); ?>


	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

	<script>
	
	
    $( "#searchhotel" ).change(function() {
  		$( "#hotellist").load( "../ajax/add_to_hotellist.php", { hid: $("#searchhotel").val(), lid: '<?=$row['id']?>' }, function() {
		});
	});

	

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