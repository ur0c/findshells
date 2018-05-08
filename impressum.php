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

	    <link href="path/to/bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet">
    <script src="path/to/bootstrap-editable/js/bootstrap-editable.min.js"></script>

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


	</style>


  </head>
  <body>
  
  	<? include('inc/header.php'); ?>

    <div class="page-header"style="background-image:url('/img/p_about_beach.jpg'); background-repeat:repeat-x; margin-top:-30px; padding:225px 0px;">

	</div>
    
    
    
    <section class="container">
      <div class="row">
      <div class="col-md-12 p-t-30 p-b-60" style="margin-bottom:200px;">



	  
	  
	  <h3 style="margin-top:30px;">Impressum</h3>

			
		<b>siteworld GmbH</b><br>
		Gleichweg 58<br>
		80999 Muenchen<br>
		E-Mail: info&#64;findshells.de<br>
		Registergericht: Amtsgericht Muenchen<br>
		HRB: 12345<br>
		USt-ID: DE 123456789<br>
		Inhaltlich verantwortlich: siteworld GmbH	
				        
          
      </div>
      </div>    
    </section>



    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bstp/js/bootstrap.min.js"></script>


	<!-- Theme JavaScript -->
    <script src="https://blackrockdigital.github.io/startbootstrap-clean-blog/js/clean-blog.min.js"></script>
    <script src="/common-files/js/jquery.sparkline.min.js"></script>
	
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
    
    </script>
    
  </body>
</html>