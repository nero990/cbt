<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php 
	unset($_SESSION['cbt_user_id']);
	unset($_SESSION['cbt_username']);
	redirect_to("login.php");
?>