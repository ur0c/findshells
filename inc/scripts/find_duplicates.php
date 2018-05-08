<?

$root = "../../";

$nav = "index";

include($root . 'inc/scripts/db_connection.php');

function del_hid ($del_hid, $new_hid) {

	global $mysqli;
	
	// sind wirklich noch beide auf inactive=0 gesetzt?
	$q2 = "SELECT * FROM tu_hotels WHERE inactive>0 AND id IN (".$del_hid.", ".$new_hid.")";
	$result2 = $mysqli->query($q2) or die("Fehler: " . $q2);
	if ($row2 = $result2->fetch_assoc()) die("Fehler");

	// Delete hotel
	$q = "UPDATE tu_hotels SET inactive=2 WHERE id=".$del_hid;
	$result = $mysqli->query($q) or die("Fehler: " . $q);
	
	// Update agency Hotel ID
	$q = "UPDATE tu_hotels_agency SET hotel_id=".$new_hid." WHERE id=".$del_hid;
	$result = $mysqli->query($q) or die("Fehler: " . $q);
	
	// Price adjustment
	
	// Rating adjustment
	
	// User comments
	$q = "UPDATE tu_user_hotel_comments SET hotel_id=".$new_hid." WHERE id=".$del_hid;
	$result = $mysqli->query($q) or die("Fehler: " . $q);
	
	// User rating
	$q = "UPDATE tu_user_hotel_rating SET hotel_id=".$new_hid." WHERE id=".$del_hid;
	$result = $mysqli->query($q) or die("Fehler: " . $q);
	
	// user Hotel lists
	$q = "UPDATE tu_user_lists_hotels SET hotel_id=".$new_hid." WHERE id=".$del_hid;
	$result = $mysqli->query($q) or die("Fehler: " . $q);
	
}




$q = "SELECT COUNT( * ) AS  c ,  `google_place_id`, group_concat(hotel_id) as hids FROM  `tu_hotels_address` GROUP BY  `google_place_id` HAVING c>1";
$result = $mysqli->query($q) or die("Fehler: " . $q);
while ($row = $result->fetch_assoc()) {

	// get hotels
	$harray = explode(",", $row['hids']);
	foreach ($harray as $hid) {
		$q2 = "SELECT * FROM tu_hotels WHERE id=" . $hid;
		$result2 = $mysqli->query($q2) or die("Fehler: " . $q2);
		$row2 = $result2->fetch_assoc();
		
		echo $row2['hotel_name'] . " ... ";
	}
	
	echo "<br>.";
}






//SELECT * FROM tu_hotels h1 WHERE h1.inactive=0 AND EXISTS (SELECT * FROM tu_hotels h2 WHERE h1.id!=h2.id AND h1.hotel_name=h2.hotel_name)

/*

$q = "SELECT * FROM tu_hotels WHERE inactive=0";
$result = $mysqli->query($q) or die("Fehler: " . $q);
while ($row = $result->fetch_assoc()) {
	echo ".";
	for($i = 0; $i < 40000; $i++) echo ' '; // extra spaces
    ob_flush();
    flush();
        
	$q2 = "SELECT * FROM tu_hotels WHERE inactive=0 AND id!=".$row['id']." AND hotel_name LIKE '%".mysqli_real_escape_string($mysqli, $row['hotel_name'])."%'";
	if ($row['hotel_name'] == 'Son Penya Petit Hotel')  echo "----------" . $row['hotel_name'] . "$q2<br><br>";
	$result2 = $mysqli->query($q2) or die("Fehler: " . $q2);
	if ($row2 = $result2->fetch_assoc()) {
	
		// hotel agency
		$ag = array();
		$agID = array();
		$q3 = "SELECT * FROM tu_hotels_agency WHERE hotel_id IN (".$row['id'].", ".$row2['id'].")";
		if (strstr($row['hotel_name'], 'Penya')) die($q3);
		$result3 = $mysqli->query($q3) or die("Fehler: " . $q3);
		while ($row3 = $result3->fetch_assoc()) {
			$agID[] = $row3['agency_id'];
			$ag[] = $row3['agency'];
		}
	
		// HotelagencyID => alterer Eintrag kann gelöscht werden
		if ($agID[0]==$agID[1]) 
			die("<br> GLEICHE AGENCY ID " . $row['id'] . ": " . $row['hotel_name'] . " (" .$agID[0] . ")  --- " . $row2['id'] . ": " . $row2['hotel_name'] . " (" .$agID[1] . ")");
		
		// unterschiedlicher Anbieter, genau gleicher Name, gleiche city => Hotel kann gelöscht werden
		elseif ($ag[0]!=$ag[1] && $row['city_id']==$row2['city_id'] && $row['hotel_name']==$row2['hotel_name']) {
			//del_hid ($row2['id'], $row['id']);
			//die("<br>" . $row['id'] . ": " . $row['hotel_name'] . " (" .$agID[0] . ")  --- " . $row2['id'] . ": " . $row2['hotel_name'] . " (" .$agID[1] . ")");
		}
		
		// unterschiedlicher Anbieter, enthaltener Name, gleiche city => Hotel anzeigen
		elseif ($ag[0]!=$ag[1] && $row['city_id']==$row2['city_id']) {
			//del_hid ($row['id'], $row2['id']);
			//echo "<br>" . $row['id'] . ": " . $row['hotel_name'] . " (" .$agID[0] . ")  --- " . $row2['id'] . ": " . $row2['hotel_name'] . " (" .$agID[1] . ")";
		}
		
		
	} 
	
}
*/