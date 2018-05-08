<?

include_once($root . "inc/functions/get_webcontent.php");

function google_api_places ($lat, $lng, $search) {

	$s = urlencode($search);
	$url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=".$lat.",".$lng."&radius=200000&type=hotel&keyword=".$s."&key=AIzaSyA4iGEoDD1B9ynK2gYERZWV9ExPjzuahaU";
				
	$r = get_webcontent( $url );

	$res = json_decode($r['content'], true);
	$result = $res;


	return $res;

}

?>