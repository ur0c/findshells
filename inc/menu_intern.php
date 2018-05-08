<nav class="navbar navbar-default" style="margin-top:50px; min-height:30px; background-color:#efefef;" >
  <div class="container">
  <div class="row">
	<div class="col-xs-6">
	  <ul class="nav navbar-nav navbar-left">
		<li class="dropdown" style="border-left:1px solid #ddd; border-right:1px solid #ddd; ">
		  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Meine Listen <span class="caret"></span></a>
		  <ul class="dropdown-menu">
			<? if (!empty($list)) { 
				foreach ($list as $key => $value) { ?>
					<li><a href="index.php?al=<?=$key?>"><?=htmlspecialchars($value['name'])?></a></li>
				<? } ?>
			<? } ?>
			<li role="separator" class="divider"></li>
			<? if (empty($_SESSION['pw' . $_SESSION['user_id']])) { ?>
				<li><a href="javascript:return false;" class="loginrequired">Listen verwalten ...</a></li>
			<? } else { ?>
				<li><a href="/cms/create_list.php">Listen verwalten ...</a></li>
			<? } ?>
		  </ul>
		</li>
	  </ul>
	</div>
  </div>
  </div> 
</nav>