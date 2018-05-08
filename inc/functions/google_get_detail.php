<?

include_once($root . 'inc/scripts/db_connection.php');
//include_once($root . 'inc/functions/get_webcontent.php');

function googe_get_detail($hotel_id) {
	
	global $mysqli;
	global $root;
	
	// hole PlaceID
	$q = "SELECT * FROM tu_hotels_address WHERE hotel_id=" . $hotel_id;
	$result = $mysqli->query($q) or die("Fehler");
	if ($row = $result->fetch_assoc()) {
		
		// Get hotel details from google
		$url = "https://maps.googleapis.com/maps/api/place/details/json";
		$url .= "?placeid=".$row['google_place_id']."&key=AIzaSyA4iGEoDD1B9ynK2gYERZWV9ExPjzuahaU";

		$r = get_webcontent( $url );

		$res = json_decode($r['content'], true);
		$res = $res['result'];
		
		return $res;
		
	} else { // versuche das Hotel zu holenelse return NULL;

		include_once($root . "inc/functions/google_api_places.php");
		
		// Hole Koordinaten
		$q = "SELECT city_id, hotel_name FROM tu_hotels WHERE id=" . $hotel_id;
		$result = $mysqli->query($q) or die("Fehler");
		$row_h = $result->fetch_assoc();
		
		if (empty($row_h['city_id'])) return NULL;
		
		$q = "SELECT latitude, longitude FROM tu_geo_cities WHERE id=" . $row_h['city_id'];
		$result = $mysqli->query($q) or die("Fehler");
		$row = $result->fetch_assoc();

		if (empty($row['longitude']) OR empty($row['latitude'])) return NULL;
		
		if ($res = google_api_places ($row['latitude'], $row['longitude'], $row_h['hotel_name']) ) {
			//var_dump($res['results'][0]['place_id']);
			//exit;

			// Insert Hotel Details
			$place_id = $res['results'][0]['place_id'];
			$lat = $res['results'][0]['geometry']['location']['lat'];
			$lng = $res['results'][0]['geometry']['location']['lng'];
			$q = "INSERT INTO tu_hotels_address (hotel_id, google_place_id, latitude, longitude) VALUES (".$hotel_id.", '".$place_id."', '".$lat."', '".$lng."')";
			//die($q);
			$result = $mysqli->query($q) or die("Fehler");

			// Rückgabe
			$url = "https://maps.googleapis.com/maps/api/place/details/json";
			$url .= "?placeid=".$place_id."&key=AIzaSyA4iGEoDD1B9ynK2gYERZWV9ExPjzuahaU";
			$r = get_webcontent( $url );
			$res = json_decode($r['content'], true);
			$res = $res['result'];
			return $res;

		} else return NULL;
		
		//var_dump($res);
		//exit;
	}

}