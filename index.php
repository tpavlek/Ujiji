<?php 
session_start();
require_once('page.php');

if (!isset($_SESSION['db_user'])) {
	echo "<script> window.location = 'dbInfo.php'; </script>";
} else if (isset($_GET['page'])) {
	switch ($_GET['page']) {
	case 'register': $currentPage = 'register.php'; break;
	default: $currentPage = 'user.php'; break;
	}
} else {
	$currentPage = 'user.php';
}
print_r($_SESSION);
$page = new Page($_SESSION['db_url'], $_SESSION['db_user'], $_SESSION['db_pass']);

?>

<html>
	<head>
		<title>Ujiji</title>
	</head>
	<body>
	<?php
		include('views/' . $currentPage );
	?>
	</body>

<?php



?>
