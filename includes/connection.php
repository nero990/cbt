<?php require_once("constants.php"); ?>
<?php
	date_default_timezone_set("Africa/Lagos");
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if($mysqli->connect_errno){
		die("Database connection failed: " . $mysqli->connect_error);
	}
?>