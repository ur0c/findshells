<?

function get_regions() {

	global $mysqli;
	$reg = array();
	$q = "SELECT * from tu_geo_regions";
	$result = $mysqli->query($q) or die("Fehler");
	while ($row = $result->fetch_assoc()) {
		$reg[$row['id']] = $row['name_de'];
	}
	
	return $reg;

}

?>