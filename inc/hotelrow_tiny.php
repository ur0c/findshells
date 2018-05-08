

<div style="padding:2px 0px;">
<table width="100%">
<tr>
<td>
	<a target="_blank" href="<?=$hval['affiliate'][0]['link']?>">
	<img style="border-radius: 50%;" width=40 height=40 src="<?=$hval['img']?>" id="<?=$hID?>" onerror="standby(<?=$hID?>)" >
	</a>
</td>
<td width="100%" style="padding:3px 8px;border-bottom:1px solid #ddd;"">
	<?=$hval['hotel_name']?>
	<div style="font-size:11px; line-height:13px;">
		<?=$hval['city']?>, <?=$hval['region']?>
	</div>
</td>
<td style="border-bottom:1px solid #ddd;""> 
	<div class="dropdown">
		<a href="" id=""><i class="fa fa-cog" style="font-size:15px; color:#999;"></i></a>
		  <div class="dropdown-content">
			<div id="#list_del"><i class="fa fa-ban" style="font-size:12px;color:red;"></i>&nbsp;&nbsp;Eintrag l&ouml;schen</div>
			<div id="#list_pos"><i class="fa fa-list-ol" style="font-size:12px;color:#bbb;"></i>&nbsp;&nbsp;Position: 1</div>
		  </div>
	</div>
</td>
</tr>
</table>
</div>