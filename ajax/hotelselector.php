<?

$root = "../";

include($root . 'inc/scripts/db_connection.php');

$query = $_GET['q'];

$hotelarray = array();
$q = "SELECT *, h.id as hid FROM tu_hotels h, tu_geo_regions r WHERE r.id=h.region_id AND h.hotel_name LIKE '%".mysqli_real_escape_string($mysqli, $query)."%' LIMIT 10";
$result = $mysqli->query($q) or die("Fehler");
while ($row = $result->fetch_assoc()) {
	$hotelarray[] = '{ "pincode": "' . $row['hotel_name'] . ", " . $row['name_de'] . '", "hid": "'.$row['hid'].'" }';
}

$res = implode(", ", $hotelarray);

die("[ " . $res . " ]");





 


echo '[
    {
        "pincode": "110001"
    },
    {
        "pincode": "110002"
    },
    {
        "pincode": "110003"
    }
]
';
exit;

$items = array('a' => 'asdf', 'b' => 'jdfser');

echo json_encode($items);
