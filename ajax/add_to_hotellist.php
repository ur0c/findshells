<?

session_start();


$root = "../";

include($root . 'inc/scripts/db_connection.php');
include($root . 'inc/functions/get_hotel_list.php');


$hid = (int)$_REQUEST['hid'];
$lid = (int)$_REQUEST['lid'];
$sid = $_REQUEST['sid'];



if (empty($lid)) {
	// Liste suchen und ggf anlegen
	$q = "SELECT * FROM tu_user_lists WHERE session_id='".session_id()."'";
	$result_r = $mysqli->query($q) or die( 'F' );
	if ($row_r = $result_r->fetch_assoc()) {
		$lid = $row_r['id'];
	} else {
		$q = "INSERT INTO tu_user_lists (session_id, shortcut, create_date) ";
		$q.= "VALUES ('".session_id()."', '', NOW())";
		$result_r = $mysqli->query($q);
		$lid = $mysqli->insert_id;
	}
	
}



if (!empty($hid)) {

	// todo: Ist es der richtige User?

	$q = "INSERT INTO tu_user_lists_hotels (insert_date, user_id, list_id, hotel_id) ";
	$q.= "VALUES (NOW(), '".$_SESSION['user_id']."', ".$lid.", ".$hid.")";
	$result_r = $mysqli->query($q);

}

$hl = array();
$q = "SELECT * FROM tu_user_lists_hotels WHERE list_id=".$lid." ORDER BY insert_date DESC";
$result_r = $mysqli->query($q) or die( mysqli_connect_error($mysqli));
while ($row_r = $result_r->fetch_assoc()) $hl[] = $row_r['hotel_id'];

// get hotel details
if (!empty($hl)) {
	$hids = implode(",", $hl);
	$hll = get_hotel_list($hids, $lid);
}

if (!empty($hll)) {
	foreach ($hll AS $hID => $hval) { 
		include('../inc/hotelrow_small.php');
		$nohotels = false;
	} 
}


?>