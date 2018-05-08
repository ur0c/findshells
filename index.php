<?

session_start();

$root = "";


if (!empty($_POST['username'])) {

	$_SESSION['user_id'] = null;
	$_SESSION['user_name'] = null;

	header('Location: cms/login.php?username=' . urlencode($_POST['username']));
	exit;

}

include($root . 'inc/scripts/db_connection.php');
include($root . 'inc/functions/get_hotel_list.php');
include($root . 'inc/functions/google_get_detail.php');
include($root . 'inc/functions/get_webcontent.php');




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
    <link href="bstp/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="/css/custom.css" rel="stylesheet">

	<style>
	@font-face {
	  font-family: 'shellfont';
	  src: url('bstp/fonts/SourceSansPro-Light.eot'); /* IE9 Compat Modes */
	  src: url('bstp/fonts/SourceSansPro-Light.eot?#iefix') format('embedded-opentype'), /* IE6-IE8 */
		   url('bstp/fonts/SourceSansPro-Light.woff2') format('woff2'), /* Super Modern Browsers */
		   url('bstp/fonts/SourceSansPro-Light.woff') format('woff'), /* Pretty Modern Browsers */
		   url('bstp/fonts/SourceSansPro-Light.ttf')  format('truetype'), /* Safari, Android, iOS */
		   url('bstp/fonts/SourceSansPro-Light.svg#SourceSansPro-Light') format('svg'); /* Legacy iOS */
	}
	
	body { font-family: 'shellfont' }
	
	.navbar-default { background:none; }
	.navbar-default .navbar-nav li  a { color:#fff; }
	
	.navbar {
		-webkit-transition: all 0.6s ease-out;
		-moz-transition: all 0.6s ease-out;
		-o-transition: all 0.6s ease-out;
		-ms-transition: all 0.6s ease-out;
		transition: all 0.6s ease-out;
	}

	.navbar.scrolled {
		background: rgb(0, 0, 0); //IE
		background: rgba(0, 0, 0, 1.0); //NON-IE
	}
	
	div { line-height:24px; }
	
	textarea.comment { height:35px; }

	h3 { color:#000; }


	</style>

	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

	<style>
.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
	left: -155px;
	top: 0px;
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    padding: 5px 5px;
    z-index: 1;
	font-size:14px;
}

.dropdown:hover .dropdown-content {
    display: block;
}
</style>

  </head>
  <body>
  
        <? include($root . "inc/header_content.php"); ?>


    <div class="page-header"style="text-align:center; background-image:url('/img/p_about_beach.jpg'); background-repeat:repeat-x; margin-top:-30px; padding:130px 5px 80px 5px;">
		<h3>Deine Merkliste f&uuml;r Hotels</h3>
		<div style="padding:20px 10px; margin-top:30px;">
			<h5 style="color:#000;margin-bottom:20px;">Wenn Du auch immer wieder von Neuem mit der Hotelsuche f&uuml;r Deinen Urlaub beginnst:</h5>
			<a href="/cms/new.php">
				<button class="btn btn-primary" type="button" id="submit" style="border-color:#000;">Starte jetzt Deine Hotel Merkliste</button>
			</a>
			<h5 style="color:#000; margin-top:30px;"><a style="color:#000;" href="#hilfe"><i class="fa fa-question-circle" style="color:#777;"></i> &nbsp;&nbsp;Brauchst Du Hilfe?</a></h5>
		</div>
	</div>
    
    <div style="margin-bottom:80px;" id="hilfe"></div>
    
    <section class="container">


		<? if ($_SERVER['REMOTE_ADDR']=="78.47.64.236") { ?>


		<div class="row">
		<div class="col-md-12">

			<form>
			<div class="form-group">
				<label for="exampleInputEmail1">Hotel suchen</label>
				<div>
					<input type="text" class="form-control" id="searchhotel" placeholder="Hotel Name">
					<div id="autocomplete_result" style="display:none; border-bottom:1px solid #ccc; border-left:1px solid #ccc; border-right:1px solid #ccc; position:absolute; left:18px; background:#fff; z-index:1; padding:5px 10px;">
						<br>
					</div>
				<div>
			</div>
			</form>

		</div>
		</div>

		<div class="row">
		<div class="col-md-12">	 
		<div id="hotellist" style="border-top:0px solid #ddd;">
		<?
		$q = "SELECT * FROM tu_user_lists WHERE session_id='".session_id()."'";
		$result_l = $mysqli->query($q) or die("Feh");
		if ($row_l = $result_l->fetch_assoc()) {
	
			?>
			
				<?
				// get hotels
				$hl = array();
				$q = "SELECT * FROM tu_user_lists_hotels WHERE list_id='".$row_l['id']."' ORDER BY insert_date DESC";
				$result_r = $mysqli->query($q) or die("F2");
				while ($row_r = $result_r->fetch_assoc()) $hl[] = $row_r['hotel_id'];
				
				// get hotel details
				if (!empty($hl)) {
					$hids = implode(",", $hl);
					$hll = get_hotel_list($hids, $row_l['id']);
				}
				
				if (!empty($hll)) {
					foreach ($hll AS $hID => $hval) { 
						include($roow.'inc/hotelrow_tiny.php');
						$nohotels = false;
					} 
				} else {
					echo "Noch keine Hotels";
				}
				?>
			
		<? } ?>
		</div>
		</div>

		</div> 

		<? } ?>


		<div class="row">
			<div class="col-md-12">
				<h3>Stelle systematisch und organisiert Deine favorisierten Hotels f&uuml;r den n&auml;chsten Urlaub zusammen</h3>
				Vielleicht geht es Dir genauso: man plant den n&auml;chsten Urlaub und sucht wochenlang nach dem richtigen Hotel. Daf&uuml;r fr&auml;st man sich durch dutzende Reiseseiten und liest etliche Bewertungen. Wenn man ein Hotel gefunden hat, schickt man es per Mail oder WhatsApp seinen Mitreisenden und sehr schnell hat man den &Uuml;berblick verloren, welche Hotels nun eigentlich in Frage kommen und hat vergessen, welches denn nun eigenltich welche Bewertungen hatte und wie teuer es war.
				<br><br>
				<b>findshells</b> hilft Dir, Deine Hotels in einer Liste zu sammeln und noch mehr: Du kannst jederzeit sehen, ob es im gefragten Zeitraum noch verf&uuml;gbar ist und zu welchem Preis. Du kannst Deine eigene Info hinterlassen die Hotels selbst bewerten.
			</div>
		</div>    
		

		<div class="row" style="margin-top: 40px;">
			<div class="col-md-12">
				<h3 style="margin-bottom:30px;">3 Schritte zur einfachen Urlaubssuche</h3>
			</div>
		</div>    


		<div class="row" style="margin-bottom:100px;">
			<div class="col-md-4 col-xs-12" style="padding:15px;">
				<div style="background-color:#efefef; border:1px solid #aaa; border-radius:5px; padding:10px;">
					Schritt 1
					<h4><i class="fa fa-list" style="color:#999;"></i>&nbsp;&nbsp;Urlaubsliste erstellen</h4>
					Du kannst Dir f&uuml;r jeden Urlaub eine eigene Liste erstellen (z.B. "Sommer 2017 mit Kindern" oder "Herbst Wellness" usw.).
				</div>
			</div>
			<div class="col-md-4 col-xs-12" style="padding:15px;">
				<div style="background-color:#efefef; border:1px solid #aaa; border-radius:5px; padding:10px;">
					Schritt 2
					<h4><i class="fa fa-bed" style="color:#999;"></i>&nbsp;&nbsp;Hotels zur Liste hinzuf&uuml;gen</h4>
					Zu jeder Liste kannst Du Deine Hotels hinzuf&uuml;gen, die Du beobachten m&ouml;chtest. <br> &nbsp;
				</div>
			</div>
			<div class="col-md-4 col-xs-12" style="padding:15px;">
				<div style="background-color:#efefef; border:1px solid #aaa; border-radius:5px; padding:10px;">
					Schritt 3
					<h4><i class="fa fa-user" style="color:#999;"></i>&nbsp;&nbsp;Account erstellen</h4>
					Wenn Du nicht m&ouml;chtest, dass andere Deine Liste ver&auml;ndern, dann speichere sie unter Deinem Account <br> &nbsp;
				</div>
			</div>
		</div>    

    </section>



	<? include($root."inc/footer.php"); ?>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bstp/js/bootstrap.min.js"></script>


	<!-- Theme JavaScript -->
    <script src="https://blackrockdigital.github.io/startbootstrap-clean-blog/js/clean-blog.min.js"></script>
	
    <script>
    
    $(function() {
    	//caches a jQuery object containing the header element
   	 	var header = $(".navbar");
   	 	$(window).scroll(function() {
        	var scroll = $(window).scrollTop();

        	if (scroll >= 100) {
            	header.removeClass('navbar').addClass("navbar scrolled");
        	} else {
            	header.removeClass("navbar scrolled").addClass('navbar');
        	}
    	});
	});
	
	$('button#submit').click(function(){
	  
		$('#addurlresult').load('/ajax/addurl.php', {'path': $('#urlname').val()},function(result){
			$('#addurlresult').slideDown();
		});
  
	
	});

	
	
	$( "#searchhotel" ).keyup(function() {
		if (!$("#searchhotel").val()) { $( "#autocomplete_result").hide(); }
		else $( "#autocomplete_result").show();
		$( "#autocomplete_result").load( "ajax/hotel_autocomplete.php", { hid: $("#searchhotel").val() }, function() {
		});

	});

	$( document.body ).on('click', '#addhotel', function() {
  		//alert($(this).attr('hid'));
		$( "#hotellist").load( "ajax/add_to_hotellist.php", { hid: $(this).attr('hid'), sid: '<?=session_id()?>' }, function() {
		});

		$( "#autocomplete_result").hide();

		return false;
		

	});



	// The function to insert a fallback image
	function imgNotFound() {
		//alert('sdf');
		$(this).unbind("error").attr("src", "/tui_images/default.png");
	};

	// Bind image error on document load
	$("img").error(imgNotFound);

	// Bind image error after ajax complete
	$(document).ajaxComplete(function(){
		$("img").on( "error", imgNotFound );
	});
		

	</script>
    
  </body>
</html>
