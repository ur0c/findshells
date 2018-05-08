<?

function google_get_images ($hid) {

	global $mysqli;
	global $root;

	include_once($root . 'inc/functions/google_get_detail.php');
	$img = array();

	// get images
	$q = "SELECT * FROM tu_hotels_google_images WHERE hotel_id=".$hid." ORDER BY id";
	//echo $q . "<br>";
	$result_img = $mysqli->query($q) or die("Fehler 9");
	if ($row_img = $result_img->fetch_assoc()) {
		do {
			$img[] = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=90&photoreference=".$row_img['reference']."&sensor=false&key=AIzaSyA4iGEoDD1B9ynK2gYERZWV9ExPjzuahaU";
		} while ($row_img = $result_img->fetch_assoc());
	} else {
		// versuchen Fotoreferenz zu holen
		$res = googe_get_detail($hid);
		
		for ($i=0; $i<count($res['photos']); $i++) {
			$q_img = "INSERT INTO tu_hotels_google_images (insert_date, hotel_id, reference, width, height) VALUES (NOW(), ".$hid.", '".$res['photos'][$i]['photo_reference']."', '".$res['photos'][$i]['width']."', '".$res['photos'][$i]['height']."')";
			$mysqli->query($q_img) or die("Fehler 11");
			$img[] = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=90&photoreference=".$res['photos'][$i]['photo_reference']."&sensor=false&key=AIzaSyA4iGEoDD1B9ynK2gYERZWV9ExPjzuahaU";
		}
		
	}

	if (empty($img)) $img[0] = "/tui_images/default.png"; 
	
	return $img;

}