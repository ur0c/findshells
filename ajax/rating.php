<?

session_start();


$mysqli = new mysqli("wp106.webpack.hosteurope.de", "db1073345-proje", "ur0cur0c", "db1073345-projects");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}


$user_id = (int)$_SESSION['user_id'];
$hotel_id = (int)$_REQUEST['hid'];
$rating = (int)$_REQUEST['rating'];
$list_id = (int)$_REQUEST['list'];

$q = "INSERT INTO tu_user_hotel_rating (user_id, hotel_id, hotel_rating, list_id) VALUES (".$user_id.", ".$hotel_id.", ".$rating.", ".$list_id.") ON DUPLICATE KEY UPDATE hotel_rating=".$rating."";
$result_reg = $mysqli->query($q) or die( mysqli_connect_error($mysqli));

$q = "SELECT hotel_rating FROM tu_user_hotel_rating WHERE user_id=".$user_id." AND hotel_id=".$hotel_id." AND list_id=" . $list_id;
$result_reg = $mysqli->query($q) or die( mysqli_connect_error($mysqli));
$row = $result_reg->fetch_assoc();

$v = 1;

?>

<? for ($i=1; $i<=$row['hotel_rating']; $i++) { ?>
<a href="" class="shells" value="<?=$v?>" hotelid="<?=$hotel_id?>"><img src="../common-files/images/rate.png"></a>
<? $v = $v + 1; } ?>


<? for ($i=1; $i<=5-$row['hotel_rating']; $i++) { ?>
<a href="" class="shells" value="<?=$v?>" hotelid="<?=$hotel_id?>"><img src="../common-files/images/rate_i.png"></a>
<? $v = $v + 1; } ?>