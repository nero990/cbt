<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php 
	unset($_SESSION["cbt_student_id"]);
	unset($_SESSION["cbt_reg_no"]);
	unset($_SESSION["cbt_ini_exam"]);
	unset($_SESSION["cbt_ini_exam_subj_id"]);

	redirect_to("login.php");
?>