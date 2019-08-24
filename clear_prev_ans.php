<?php require_once("includes/session.php") ?>
<?php require_once("includes/connection.php") ?>
<?php require_once("includes/functions.php") ?>
<?php confirm_student_login(); ?>
<?php
	if(isset($_GET["subj_id"])){
		$subj_id = mysqli_prep($_GET["subj_id"]);
		$student_id = $_SESSION["cbt_student_id"];
		
		// delete previous answers from the database
		$query = "DELETE FROM cbt_students_answers
						WHERE student_id = '{$student_id}'";
		$mysqli->query($query) or confirm_query();
		redirect_to("initialize_exam.php?subj_id=$subj_id");
	}else { redirect_to("index.php"); }
	
?>