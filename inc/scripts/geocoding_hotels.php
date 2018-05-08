<?

error_reporting(E_ALL);
$root = "../../";
include($root . "inc/scripts/db_connection.php");


function get_web_page( $url ) {
        $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';
        $options = array(
            CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
            CURLOPT_POST           =>false,        //set to GET
            CURLOPT_USERAGENT      => $user_agent, //set user agent
            CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
            CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        );

        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );

        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;
        return $header;
}


$q = "SELECT *, h.id as hid FROM tu_hotels h, tu_geo_cities c WHERE h.city_id=c.id AND h.region_id=16 AND h.country_id=2 AND latitude!=0 AND hotel_name NOT LIKE '%(%' LIMIT 1000";
$result = $mysqli->query($q) or die($q);
while ($row = $result->fetch_assoc()) {
	
	// get google place ID -----------------------------------------------------------------------------------------------------------------------------
	
	// gibt es schon eine Adresse?
	$q3 = "SELECT * FROM tu_hotels_address WHERE hotel_id=" . $row['hid'];
	$result3 = $mysqli->query($q3);
	if ($row3 = $result3->fetch_assoc()) continue;

	
	$c = urlencode($row['hotel_name']);
	
	$url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=".$row['latitude'].",".$row['longitude']."&radius=10000&type=hotel&keyword=".$c."&key=AIzaSyA4iGEoDD1B9ynK2gYERZWV9ExPjzuahaU";
	$r = get_web_page( $url );
	$res = json_decode($r['content'], true);
	$res = $res['results'];

	echo $c;

	//var_dump($res);

	if (count($res)==0) {
		//die($url);
	} else {	
		echo "...";
		echo $res[0]['place_id']; // 
		echo "...";
		echo $res[0]['geometry']['location']['lat']; // 
		echo "...";
		echo $res[0]['geometry']['location']['lng']; // 
		$q2 = "INSERT INTO tu_hotels_address (hotel_id, google_place_id, latitude, longitude, result_found_at_google) VALUES (".$row['hid'].", '".$res[0]['place_id']."', ".$res[0]['geometry']['location']['lat'].", ".$res[0]['geometry']['location']['lng'].", ".count($res).") ON DUPLICATE KEY UPDATE google_place_id='".$res[0]['place_id']."'";
		//die($q2);
		$result2 = $mysqli->query($q2);

	} 
	echo "<br>";


	// get google details -----------------------------------------------------------------------------------------------------------------------------
	
	//https://maps.googleapis.com/maps/api/place/details/json?placeid=ChIJI08X60CrlRQRVsdFe1DzVFY&key=AIzaSyA4iGEoDD1B9ynK2gYERZWV9ExPjzuahaU

}








