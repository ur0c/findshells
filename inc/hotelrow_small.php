<?
// lastpriceuptdate higher than last hotel request => hotel was not in last list
if (!empty($lastpriceupdate) && $hval['last_request']<$lastpriceupdate-100) { 
	$price_text = "Aktuell in der Liste nicht verfügbar";
	if (!empty($hval['last_request'])) $price_text .= "(seit " . date("d.m.y H:i:s", $hval['last_request']) . ")";
	$hide_row = true;
} elseif (empty($hval['last_price'])) {
	$price_text = "n/a"; //"Aktuell in der Liste nicht verfügbar.";
	$hide_row = true;
} elseif (empty($lastpriceupdate)) {
	$price_text = "Bisher kein Preis ermittelt.";
	$hide_row = false;
} else {
	$price_text = $hval['last_price'] . " EUR";
	$hide_row = false;
}
?>

<div id="hrow<?=$hID?>">
<div class="row <? if ($hide_row) echo 'not_available'; ?>" style="margin-top:5px;margin-bottom:5px;">
	<div class="col-xs-12 col-md-1 rowedit" style="padding:5px 5px 5px 15px; width:30px; display:none;">
		<a href="" class="del_from_list" hotel_id="<?=$hval['id']?>"><i class="fa fa-ban" style="color:red;"></i></a>
	</div>
	<div class="col-xs-12 col-md-5" style="">
		<table width="100%" border="0">
		<tr>
		<td>
			<a target="_blank" href="<?=$hval['affiliate'][0]['link']?>">
			<img src="<?=$hval['img']?>" id="<?=$hID?>" onerror="standby(<?=$hID?>)">
			</a>
		</td>
		<td width="100%" style="padding-left:15px; vertical-align:top;">
			<?=$hval['hotel_name']?>
			<span style="color:#999;">
				<? for ($i=0;$i<$hval['tui_category'];$i++) echo "*"; ?>
			</span>
			<div style="font-size:11px; color:#999; line-height:13px;">
				<?=$hval['city']?>, <?=$hval['region']?>
			</div>
			<div style="font-size:11px; color:#999; line-height:13px; margin-top:5px;">
				<? foreach ($hval['affiliate'] as $val) {
					echo '<a href="'.$val['link'].'" target="_blank">' . $val['name'] . '</a>';
				}
				?>
			</div>
		</td>
		</tr>
		</table>
	</div>
	<div class="col-xs-12 col-md-2" style="font-size:14px;">
		<? if (isset($hval['rating']['tui'])) { ?>
			<?=$hval['rating']['tui']['rating']?>/6 <?=$hval['rating']['tui']['recommendation_rate']?>%<br>
			<?=$hval['rating']['tui']['rating_count']?> Bewertungen
		<? } ?>
		<? if (isset($hval['rating']['booking.com'])) { ?>			
			<?=$hval['rating']['booking.com']['rating']?>
		<? } ?>
		<? if (isset($hval['rating']['google'])) { ?>			
			<?=$hval['rating']['google']['rating']?>/5<br>
			<?=$hval['rating']['google']['rating_count']?> Bewertungen
		<? } ?>
	</div>

	<div class="col-xs-12 col-md-3 rowedit" style="font-size:14px;">
		<div>
			<? if (true) { ?><span style="display:inline;" class="sparklines" values="<?=$hval['prices']?>"></span><? } ?>
			<!--<span style="color:#999; font-size:11px;">Letzter Preis: <?=date("d.m.y", $hval['last_price_update'])?>-->
		</div>
		<div>
			<?=$price_text?>
		</div>
	</div>
	<div class="col-xs-12 col-md-2 rowedit" style="text-align:right;">
		<div class="shellsparent" id="rating<?=$hval['id']?>">
			<? $v = 1; ?>
			<? for ($i=1; $i<=$hval['hotel_rating']; $i++) { ?>
			<a href="" class="shells" value="<?=$v?>" hotelid="<?=$hval['id']?>" list="<?=$_SESSION['active_list']?>"><img src="/common-files/images/rate.png"></a>
			<? $v = $v + 1; } ?>
			<? for ($i=1; $i<=5-$hval['hotel_rating']; $i++) { ?>
			<a href="" class="shells" value="<?=$v?>" hotelid="<?=$hval['id']?>" list="<?=$_SESSION['active_list']?>"><img src="/common-files/images/rate_i.png"></a>
			<? $v = $v + 1; } ?>
		</div>
		<div style="margin-top:5px;">
			<a href="" class="showcomment" hid="<?=$hval['id']?>">Comments (<?=$hval['comm_count']?>)</a>
		</div>
	</div>
</div>

<div class="row <? if ($hide_row) echo 'not_available'; ?>">
	<div class="col-xs-12 commentparent" >  
	<div style="background-color:#eee; padding:10px; display:none;" id="comments<?=$hval['id']?>"></div>		
	</div>
</div>	

<div style="border-bottom:3px solid #ddd;"></div>
</div>
