<?

session_start();

$root = "../";

include($root . 'inc/scripts/db_connection.php');

$hid = (int)$_REQUEST['hid'];

if (!empty($hid)) {

	$q = "DELETE FROM tu_user_lists_hotels WHERE user_id=".$_SESSION['user_id']." AND list_id=".$_SESSION['active_list']." AND hotel_id=".$hid."";
	$result_r = $mysqli->query($q) or die('Fehler');
	
	die('ok');

}

die('Fehler');