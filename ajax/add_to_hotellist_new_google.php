<?

session_start();


$root = "../";

include($root . 'inc/scripts/db_connection.php');
include($root . 'inc/functions/get_webcontent.php');

$hid = $_REQUEST['hid'];
$region = (int)$_REQUEST['region'];

// Get hotel details from google
$url = "https://maps.googleapis.com/maps/api/place/details/json";
$url .= "?placeid=".$hid."&key=AIzaSyA4iGEoDD1B9ynK2gYERZWV9ExPjzuahaU";


$r = get_webcontent( $url );

$res = json_decode($r['content'], true);
$res = $res['result'];

//var_dump($res);

$formatted_address = $res['formatted_address'];
$phone = $res['international_phone_number'];
$lat = $res['geometry']['location']['lat'];
$lng = $res['geometry']['location']['lng'];
$name = $res['name'];
$affili = $res['url'];
$rating = $res['rating']; // 4,3 z.B.
$rating_count = count($res['reviews']); // 4,3 z.B.
$web = $res['website']; // 4,3 z.B.
$photo_references = array();
for ($i=0; $i<count($res['photos']); $i++) {
	$photo_references[$i]['ref'] = $res['photos'][$i]['photo_reference'];
	$photo_references[$i]['height'] = (int)$res['photos'][$i]['height'];
	$photo_references[$i]['width'] = (int)$res['photos'][$i]['width'];
}

$city = '';
foreach ($res['address_components'] as $val) {
	if ($val['types'][0]=='locality') $city = $val['long_name']; 
} 


if (!empty($name)) {

	// Get country
	$q = "SELECT * FROM tu_geo_regions WHERE id=" . $region;
	$result = $mysqli->query($q);
	$row = $result->fetch_assoc();
	$country = $row['country_id'];	
	
	// Get city
	$q = "SELECT * FROM tu_geo_cities WHERE country_id=".$country." AND name_de='".$city."'";
	$result = $mysqli->query($q);
	$row = $result->fetch_assoc();
	$city_id = $row['id'];	
	
	$q = "INSERT INTO tu_hotels (insert_date, hotel_name, city_id, region_id, country_id) ";
	$q .= "VALUES (NOW(), '" . mysqli_real_escape_string($mysqli, $name) . "', " . $city_id . ", ".$region.", ".$country.")";
	$mysqli->query($q);
	$hotel_id = $mysqli->insert_id;
	//echo $q . "<br>";
	
	
	$q = "INSERT INTO tu_hotels_address (hotel_id, google_place_id, latitude, longitude, hotel_url) ";
	$q .= "VALUES (".$hotel_id.", '" . mysqli_real_escape_string($mysqli, $hid) . "', ".$lat.", ".$lng.", '" . mysqli_real_escape_string($mysqli, $web) . "')";
	$mysqli->query($q);
	//echo $q . "<br>";
	
	$q = "INSERT INTO tu_hotels_agency (hotel_id, agency, agency_id, affiliate_link) ";
	$q .= "VALUES (".$hotel_id.", 'google', '" . mysqli_real_escape_string($mysqli, $hid) . "', '" . mysqli_real_escape_string($mysqli, $affili) . "')";
	$mysqli->query($q);
	//echo $q . "<br>";
	
	
	foreach ($photo_references as $val) {
		$q = "INSERT INTO tu_hotels_google_images (hotel_id, reference, width, height) ";
		$q .= "VALUES (".$hotel_id.", '" . mysqli_real_escape_string($mysqli, $val['ref']) . "', " . $val['height'] . ", " . $val['width'] . ")";
		$mysqli->query($q);
		//echo $q . "<br>";
	}
	
	$q = "INSERT INTO tu_hotels_rating (hotel_id, agency_id, rating, rating_count) ";
	$q .= "VALUES (".$hotel_id.", '3', '" . mysqli_real_escape_string($mysqli, $rating) . "', '" . mysqli_real_escape_string($mysqli, $rating_count) . "')";
	$mysqli->query($q);
	//echo $q . "<br>";
	
	// insert into userlist
	$q = "INSERT INTO tu_user_lists_hotels (insert_date, user_id, list_id, hotel_id) ";
	$q .= "VALUES (NOW(), ".$_SESSION['user_id'].", ".$_SESSION['active_list'].", ".$hotel_id.")";
	$mysqli->query($q);
	//echo $q . "<br>";
	

}

echo "ok";

exit;
