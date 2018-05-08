<?

$root = "/is/htdocs/wp1073345_7DMTTAAYVX/www/siteworld.de/";

include_once($root . 'inc/functions/google_get_detail.php');
include_once($root . 'inc/functions/get_webcontent.php');

$hid = (int)$_SERVER['argv'][1];

echo "asdf" . $hid;

$res = googe_get_detail($hid);
		
for ($i=0; $i<count($res['photos']); $i++) {
	$q_img = "INSERT INTO tu_hotels_google_images (insert_date, hotel_id, reference, width, height) VALUES (NOW(), ".$hid.", '".$res['photos'][$i]['photo_reference']."', '".$res['photos'][$i]['width']."', '".$res['photos'][$i]['height']."')";
	$mysqli->query($q_img) or die("Fehler 11");
	$img[] = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=90&photoreference=".$res['photos'][$i]['photo_reference']."&sensor=false&key=AIzaSyA4iGEoDD1B9ynK2gYERZWV9ExPjzuahaU";
}
