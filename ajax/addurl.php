<?

$mysqli = new mysqli("wp106.webpack.hosteurope.de", "db1073345-proje", "ur0cur0c", "db1073345-projects");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}


// Plausi

$url = strtolower($_REQUEST['path']);

if (preg_match('/[^0-9_a-zA-Z]/', $url)) {
  echo '<i class="fa fa-exclamation-triangle" style="color:red;font-size:18px;"></i> &nbsp;&nbsp;Leider ist Deine URL fehlerhaft. Bitte verwende keine Sonderzeichen.';
  exit;
}

if (strlen($url)>100) {
  echo '<i class="fa fa-exclamation-triangle" style="color:red;font-size:18px;"></i> &nbsp;&nbsp;Leider ist Deine URL zu lang.';
  exit;
}

$q = "SELECT * FROM tu_user where url_name='".$url."'";
$result = $mysqli->query($q) or die( mysqli_connect_error($mysqli));
if ($row = $result->fetch_assoc()) {
	echo '<i class="fa fa-exclamation-triangle" style="color:red;font-size:18px;"></i> &nbsp;&nbsp;Der Name existiert bereits. Bitte wähle einen anderen Namen.';
    exit;
}


if (file_exists("../" . $url)) {
	echo '<i class="fa fa-exclamation-triangle" style="color:red;font-size:18px;"></i> &nbsp;&nbsp;Die Url existiert bereits. Bitte wähle einen anderen Namen.';
    exit;	
}


// everything ok

// Datenbankeintrag
$q = "INSERT INTO tu_user (url_name) VALUES ('".mysqli_real_escape_string($mysqli, $url)."')";
$result = $mysqli->query($q) or die( mysqli_connect_error($mysqli));
$user_id = $mysqli->insert_id;


// create folder
if (!mkdir("../" . $url)) {
	echo "Leider ist ein Fehler aufgetreten, der nicht hätte auftreten dürfen.";
    exit;	
} else {
	chmod("../" . $url, 0755); 
}

// erstelle index Datei
if (!empty($url)) {
	
	$content = "<? " . chr(10);
	$content .= "session_start(); " . chr(10);
	$content .= "\$_SESSION['user_id'] = " . $user_id . "; " . chr(10);
	$content .= "\$_SESSION['user_url'] = '" . $url . "';" . chr(10);
	$content .= "include('../personal/content.php');" . chr(10);
	$content .= "?>";
	
	file_put_contents("../" . $url . "/index.php", $content);
	chmod("../" . $url . "/index.php", 0755); 

}




// gib das ergebnis zurück

echo '<i class="fa fa-check" style="color:green;font-size:18px;"></i> &nbsp;&nbsp;Deine persönliche URL wurde erzeugt: <a href="http://www.findshells.de/'.$url.'">http://www.findshells.de/'.$url.'</a>';



?>