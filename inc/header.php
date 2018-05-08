<!-- Navigation -->
<nav class="navbar navbar-default navbar-fixed-top" style="border:0px;">
	<div class="container-fluid">
		<div class="navbar-header">
		<!-- Brand and toggle get grouped for better mobile display -->
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/index.php" style="padding:8px 40px 8px 15px;">
				<img alt="find shells" src="/common-files/images/logo-white.png" width="100">
			</a>
			
		</div>
		
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<? if (!empty($_SESSION['user_url'])) { ?>
					<li <? if ($nav=='index') echo 'class="active"'; ?>><a href="/<?=$_SESSION['user_url']?>/index.php">Dashboard</a></li>
					<li <? if ($nav=='hotels') echo 'class="active"'; ?>><a href="/hotels.php">Hotels suchen</a></li>
				<? } ?>
			</ul>
			
			<ul class="nav navbar-nav navbar-right">
        		<li><a href="/impressum.php">Impressum</a></li>
        	</ul>
		</div>
	</div>
	<!-- /.container -->
</nav>