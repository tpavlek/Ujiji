<?php
session_start();

if (isset($_GET['process'])) {
	$_SESSION['db_user'] = $_POST['db_user'];
	$_SESSION['db_pass'] = $_POST['db_pass'];
	$_SESSION['db_url'] = $_POST['db_url'];
	echo "<script> window.location = 'index.php'; </script>";
} else {

?>

<h3>DB Connection Information</h3>

<form action="dbInfo.php?process=1" method="POST">
	<label for="db_url">URL</label>
	<input type="text" name="db_url" value="oci:dbname=//gwynne.cs.ualberta.ca:1521/CRS">
	<label for="db_user">Username:</label>
	<input type="text" name="db_user">
	<label for="db_pass">Password</label>
	<input type="password" name="db_pass">
	<input type="submit" value="Submit" />
</form>

<?php
}

?>
