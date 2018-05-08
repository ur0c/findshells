<?

session_start();

$salt="nz_o97z4nhal.83qnheo9wuehfndks&WJQH_R";


if (isset($_POST['passwd'])) {
	

	if (empty($_POST['passwd'])) {
		header('Location: ' . $_GET['ref']);
		exit;
	} else {

		include('../inc/scripts/db_connection.php');
		
		// GET Parameter
		$g = array();
		$params = "";
		if (!empty($_POST['getparams'])) {
			$json = utf8_encode(str_replace("'", '"', $_POST['getparams']));
			$get = json_decode($json, true);
			foreach ($get as $k=>$v)  $g[] = $k . "=" . $v;
			$params = "?" . implode("&", $g); 
		}	

		
		//$q = "SELECT * FROM tu_user WHERE id=".$_SESSION['user_id']." AND password='" . md5(mysqli_real_escape_string($mysqli, $salt.$_POST['passwd'])) . "'";
		$q = "SELECT * FROM tu_user WHERE email='".mysqli_real_escape_string($mysqli, $_POST['username'])."' AND password='" . md5(mysqli_real_escape_string($mysqli, $salt.$_POST['passwd'])) . "'";
		$result = $mysqli->query($q) or die("Fehler");
		if (!$row = $result->fetch_assoc()) {
			header('Location: ' . $_GET['ref'] . '?login=false' . str_replace("?", "&", $params));
			exit;
		}
		
		$_SESSION['user_id'] = $row['id'];
		$_SESSION['user_name'] = $row['email'];
		//$_SESSION['pw' . $row['user_id']] = true;
	
		header('Location: ' . $_GET['ref'] . $params);
		exit;
		
	}
	
}




?>