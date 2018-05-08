<?

session_start();

$_SESSION['pw' . $_SESSION['user_id']] = false;
$_SESSION['user_id'] = false;
$_SESSION['user_name'] = false;

header('Location: /index.php');
exit;


?>