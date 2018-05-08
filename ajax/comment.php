<?

session_start();

$user_id = (int)$_SESSION['user_id'];
$hotel_id = (int)$_REQUEST['hid'];

$mysqli = new mysqli("wp106.webpack.hosteurope.de", "db1073345-proje", "ur0cur0c", "db1073345-projects");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}



if (!empty($_REQUEST['comment'])) {


	$comment = htmlspecialchars($_REQUEST['comment']);
	$q = "INSERT INTO tu_user_hotel_comments (user_id, hotel_id, insert_date, comment_text) VALUES (".$user_id.", ".$hotel_id.", NOW(), '".mysqli_real_escape_string($mysqli, $comment)."') ON DUPLICATE KEY UPDATE insert_date=NOW(), comment_text='".mysql_real_escape_string($comment)."'";
	$result_reg = $mysqli->query($q) or die( mysqli_connect_error($mysqli));

}

?>

<h5>Comments:</h5>
				  		
<div class="form-group">
	<table border="0">
	<tr>
	<td><img src="/img/user-shape.png" style="margin-right:20px; margin-top:5px;"></td>
	<td width="100%"><textarea class="form-control comment" rows="1" id="comment<?=$_REQUEST['hid']?>" placeholder="Add comment"></textarea></td>
	</tr>
	</table>
	
	<div style="margin-top:10px; text-align:right;">
		<button type="button" class="btn btn-primary savecomment" hotelid="<?=$_REQUEST['hid']?>">Save</button>
		<button type="button" class="btn btn-secondary cancelcomment" hotelid="<?=$_REQUEST['hid']?>">Cancel</button>
	</div>
</div>
							
<?
$q = "SELECT * FROM tu_user_hotel_comments WHERE user_id=".$user_id." AND hotel_id=".$hotel_id." ORDER BY insert_date DESC";
$result_reg = $mysqli->query($q) or die( mysqli_connect_error($mysqli));
while ($row = $result_reg->fetch_assoc()) {
?>

<div class="row" style="background-color:#eee; border-radius:5px; padding:3px; margin:10px 0px 10px 0px;">
	<div class="col-xs-12">
		<span style="color:#999;"><?=$row['insert_date']?></span>
		<?=$row['comment_text']?>
	</div>
</div>

<? } ?>