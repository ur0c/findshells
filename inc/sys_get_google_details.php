<?

$root = "../";

if (empty($_GET['hid'])) die('hid angeben!'); 

include('functions/google_get_detail.php');


$hid = (int)$_GET['hid'];
$erg = googe_get_detail($hid);

var_dump($erg);


?>