<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_student_login(); ?>
<?php confirm_exam_state(); ?>
<?php
	unset($SESSION["cbt_ini_exam"]);
	unset($SESSION["cbt_exam_subj_id"]);
	$student_id = $_SESSION["cbt_student_id"];
	
	// change the exam state to false
	$query = "UPDATE cbt_students
					SET state = 0,
							subj_id = NULL,
							duration = NULL,
							start_time = NULL,
							stop_time = NULL,
							session_val = NULL
					WHERE student_id = '{$student_id}'
					LIMIT 1";
	$mysqli->query($query) or confirm_query();
	redirect_to("index.php");
?>