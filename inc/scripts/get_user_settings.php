<?

$q = "SELECT * FROM tu_user_settings WHERE user_id=" . $_SESSION['user_id'];
$result_set = $mysqli->query($q) or die( mysqli_connect_error($mysqli));
while ($row_set = $result_set->fetch_assoc()) {
	$setting[$row_set['setting']] = $row_set['setting_value'];
}


?>