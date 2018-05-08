<?

$mysqli = new mysqli("wp106.webpack.hosteurope.de", "db1073345-proje", "ur0cur0c", "db1073345-projects");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$mysqli->set_charset("utf8");

?>