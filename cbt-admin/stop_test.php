<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/connection.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php confirm_staff_login(); ?>
<?php
	if(isset($_REQUEST["student"]) && isset($_REQUEST["_class"]) && isset($_REQUEST["subject"])){
		$student_id = mysqli_prep($_REQUEST["student"]);
		$class_id = mysqli_prep($_REQUEST["_class"]);
		$subj_id = mysqli_prep($_REQUEST["subject"]);
		
		process_result($student_id, $class_id, $subj_id);
		redirect_to("ongoing_test.php");
	}else{ redirect_to("ongoing_test.php"); }
?>