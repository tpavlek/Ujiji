<?php 
session_start();
require_once('page.php');

if (!isset($_SESSION['db_user'])) {
	echo "<script> window.location = 'dbInfo.php'; </script>";
} else if (!isset($_SESSION['email'])) {
    $currentPage = 'login.php';
} else if (isset($_GET['page'])) {
	switch ($_GET['page']) {
	case 'register': $currentPage = 'register.php'; break;
	default: $currentPage = 'user.php'; break;
	}
} else {
	$currentPage = 'user.php';
}
$page = new Page($_SESSION['db_url'], $_SESSION['db_user'], $_SESSION['db_pass']);
?>

<html>
	<head>
		<title>Ujiji</title>
        <link rel='stylesheet' type='text/css' href='css/bootstrap.css' />
	</head>
	<body>
        <div class="container">
            <div class="navbar navbar-fixed-top">
                <div class="navbar-inner">
                    <a class="brand" href="index.php">Ujiji</a>
                    <ul class="nav">
                        <li><a href="#">Post Ad</a></li>
                        <li><a href="#">My Ads</a></li>
                        <form class="navbar-search" action="process.php?type=search&method=ads">
                            <input type="text" name="search" class="search-query" placeholder="Search Ads">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Type:
                                    <span class="caret"></span>
                                </a>
                            </li>
                            <ul class="dropdown-menu">
                                <li>Users</li>
                                <li>Ads</li>
                            </ul>
                            <input type="submit" class='icon-search' />
                        </form>
                    </ul>
                </div>
            </div>
            <?php
                include('views/' . $currentPage );
            ?>
        </div>
	</body>
</html>

<?php



?>
