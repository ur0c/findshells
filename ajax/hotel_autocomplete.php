<?

$root = "../";

include($root . 'inc/scripts/db_connection.php');
include($root . 'inc/functions/google_get_images.php');

$query = $_REQUEST['hid'];

$hotelarray = array();
//$q = "SELECT *, h.id as hid FROM tu_hotels h, tu_geo_regions r WHERE r.id=h.region_id AND h.hotel_name LIKE '%".mysqli_real_escape_string($mysqli, $query)."%' LIMIT 10";
$q = "SELECT *, h.id as hid FROM tu_hotels h INNER JOIN tu_geo_regions r ON r.id=h.region_id LEFT JOIN tu_hotels_google_images i ON h.id=i.hotel_id WHERE h.hotel_name LIKE '%".mysqli_real_escape_string($mysqli, $query)."%' GROUP BY hid LIMIT 10";
//die($q);
$result = $mysqli->query($q) or die("Fehler");
while ($row = $result->fetch_assoc()) {
	$hotelarray[] = $row;
}




foreach ($hotelarray as $key => $val) {
	// get Images
	//$img = google_get_images($val['hid']);
	if (empty($val['reference'])) { 
		$img = "/tui_images/default.png";
		exec("php ../inc/scripts/google_get_images.php ".$val['hid']." > testoutput.php 2>&1 & echo $!", $output);
	} else $img = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=90&photoreference=".$val['reference']."&sensor=false&key=AIzaSyA4iGEoDD1B9ynK2gYERZWV9ExPjzuahaU";
	echo '<table style="padding:2px;"><tr><td style="padding-bottom:5px;"><img style="border-radius: 50%; float:left;" src="'.$img.'" height="40" width="40"></td>' . '<td style="line-height:15px;padding-left:5px;"><a href="" id="addhotel" hid="'.$val['hid'].'">' . $val['hotel_name'] . '</a><br><span style="font-size:11px;color:#444;">'.$val['group_de'].', '.$val['name_de'].'</span></td></tr></table>';
}


exit;
$res = implode(", ", $hotelarray);
die("[ " . $res . " ]");


