<?
// lastpriceuptdate higher than last hotel request => hotel was not in last list
if (!empty($lastpriceupdate) && $hval['last_request']<$lastpriceupdate-100) { 
	$price_text = "Aktuell in der Liste nicht verfügbar";
	if (!empty($hval['last_request'])) $price_text .= "(seit " . date("d.m.y H:i:s", $hval['last_request']) . ")";
	$hide_row = true;
} elseif (empty($hval['last_price'])) {
	$price_text = "Aktuell in der Liste nicht verfügbar.";
	$hide_row = true;
} elseif (empty($lastpriceupdate)) {
	$price_text = "Bisher kein Preis ermittelt.";
	$hide_row = false;
} else {
	$price_text = $hval['last_price'] . " EUR";
	$hide_row = false;
}
?>

		
<div class="row <? if ($hide_row) echo 'not_available'; ?>" style="margin-top:10px;">
	<div class="col-xs-12 col-md-4" style="margin-bottom:10px;">
		<table width="100%" border="0">
		<tr>
		<td>
			<a target="_blank" href="http://www.tui.com/pauschalreisen/suchen/angebote/xxx/<?=$hval['giata_id']?>/<?=$hval['agency_id']?>/offer/hotelDescription?useExtendedFilterDefaultValues=true&contentid=ibe:pt3_ut_kreta_HER41041_pic&departureAirports=FMM;MUC&childs=<?=str_replace(",",";",$hval['req_children'])?>&startDate=<?=$hval['req_start']?>&endDate=<?=$hval['req_end']?>&duration=7-&links=1&departureAirportsOffer=FMM&departureAirportsOffer=MUC&showTotalPrice=true">
			<div style="display:block; text-align:center; padding:10px 5px; font-weight:bold; font-size:18px; color:#333; background-image:url('/img/thumb_hotel.png'); width:70px; height:70px;">
				<?
				$k = substr($hval['hotel_name'], 0, 3);
				if (strpos($hval['hotel_name'], "TUI MAGIC LIFE ") !== false) $k = "ML<br>" . substr(str_replace("TUI MAGIC LIFE ", "", $hval['hotel_name']), 0, 3);
				if (strpos($hval['hotel_name'], "ROBINSON CLUB ") !== false) $k = "ROB<br>" . substr(str_replace("ROBINSON CLUB ", "", $hval['hotel_name']), 0, 3);
			
				echo strtoupper($k);
				?>
			</div>
			</a>
			</div>
		</td>
		<td width="100%" style="padding-left:15px; vertical-align:top;">
			<?=$hval['hotel_name']?> <span style="color:#999;"><? for ($i=0;$i<$hval['tui_category'];$i++) echo "*"; ?></span>
			<div style="font-size:11px; color:#999; line-height:13px;"><?=$hval['region']?></div></td>
		</tr>
		</table>
	</div>
	<div class="col-xs-12 col-md-2"><?=$hval['rating']?>/6 <?=$hval['recommendation_rate']?>% (<?=$hval['rating_count']?>)</div>
	<div class="col-xs-12 col-md-2">	
		<strong><?=$price_text?></strong><br>
	</div>
	<div class="col-xs-12 col-md-2">
		<? if (false) { ?><span style="display:inline;" class="sparklines" values="<?=$hval['prices']?>"></span><br><? } ?>
		<span style="color:#999; font-size:11px;">Letzter Preis: <?=date("d.m.y", $hval['last_price_update'])?></div>
	<div class="col-xs-12 col-md-2" style="text-align:right;">
		<div class="shellsparent" id="rating<?=$hval['id']?>">
			<? $v = 1; ?>
			<? for ($i=1; $i<=$hval['hotel_rating']; $i++) { ?>
			<a href="" class="shells" value="<?=$v?>" hotelid="<?=$hval['id']?>" list="<?=$_SESSION['active_list']?>"><img src="/common-files/images/rate.png"></a>
			<? $v = $v + 1; } ?>
			<? for ($i=1; $i<=5-$hval['hotel_rating']; $i++) { ?>
			<a href="" class="shells" value="<?=$v?>" hotelid="<?=$hval['id']?>" list="<?=$_SESSION['active_list']?>"><img src="/common-files/images/rate_i.png"></a>
			<? $v = $v + 1; } ?>
		</div>
		<a href="" class="showcomment" hid="<?=$hval['id']?>">Comments (<?=$hval['comm_count']?>)</a>
	</div>
		
</div>

<div class="row <? if ($hide_row) echo 'not_available'; ?>" style="border-bottom:1px solid #ccc; padding-bottom:10px; margin-bottom:30px;">
	<div class="col-xs-12 commentparent"  id="comments<?=$hval['id']?>">  		
	</div>
</div>	

