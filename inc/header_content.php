<!-- Navigation -->
<nav class="navbar navbar-default navbar-fixed-top" style="border:0px;">
	<div class="container-fluid">
			
		<table>
		<tr>
		<td nowrap style="padding:12px 0px 8px 2px;">
			<a href="/index.php">
				<span class="logo">find<img style="margin:0px 3px;" src="/img/logo_white_shell.png">shells.de</span>
				<? if (false) { ?><span class="logo" style="color:#fff869"><span style="padding:0px 3px;">/</span><?=$_SESSION['user_name']?></span><? } ?>
			</a>	
		</td>
		<td width="100%" align="right">
			<? if (!empty($_SESSION['user_id'])) { ?>
				<table>
				<tr>
				<td style="vertical-align:middle;">
					<a href="/home.php" style="color:#fff; font-size:12px;">Home</a>
				</td>
				<td style="font-size:28px; color:#aaa; padding:0px 10px;"><i class="fa fa-user"></i></td>
				<td style="vertical-align:middle;">
					<a href="/cms/logout_action.php" style="color:#fff; font-size:12px;">Log out</a>
				</td>
				</tr>
				</table>			
			<? } else { ?>
				<button type="button" class="btn btn-primary btn-sm dologin" title="Login">Anmelden</button>
			<? } ?>
		</td>
		</tr>
		</table>
			
	</div>
	<!-- /.container -->
</nav>





<? if (false) { ?>

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
			<a class="navbar-brand" href="/index.php" style="padding:12px 40px 8px 15px;">
				<span class="logo">find<img style="margin:0px 3px;" src="/img/logo_white_shell.png">shells.de</span><span class="logo" style="color:#fff869"><span style="padding:0px 3px;">/</span><?=$_SESSION['user_url']?></span>
			</a>
			
		</div>
		
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<? if (false && !empty($_SESSION['user_url'])) { ?>
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

<? } ?>