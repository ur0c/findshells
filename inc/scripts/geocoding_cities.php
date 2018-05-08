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


$q = "SELECT * FROM tu_geo_cities WHERE country_id=0 LIMIT 1000";
$result = $mysqli->query($q);
while ($row = $result->fetch_assoc()) {
	
	$c = urlencode($row['name_de']);
	
	$url = "https://maps.googleapis.com/maps/api/geocode/json?language=de&address=".$c.",+Griechenland&key=AIzaSyA4iGEoDD1B9ynK2gYERZWV9ExPjzuahaU";
	echo $url;
	exit;
	$r = get_web_page( $url );
	$res = json_decode($r['content'], true);
	$res = $res['results'];

	echo $c;

	//var_dump($res);

	if (count($res)!=0) {
		echo "...";
		echo $res[0]['geometry']['location']['lat']; // 
		echo "...";
		echo $res[0]['geometry']['location']['lng']; // 
		
		$q2 = "UPDATE tu_geo_cities SET geo_origin='google2', country_id=3, longitude=".$res[0]['geometry']['location']['lng'].", latitude=".$res[0]['geometry']['location']['lat']." WHERE id=" . $row['id'];
		//die($q2);
		$result2 = $mysqli->query($q2);

	}
	echo "<br>";


}

