<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
	if(isset($_SESSION["cbt_exam_subj_id"])){
		$subj_id = $_SESSION["cbt_exam_subj_id"];
		$student_id = $_SESSION["cbt_student_id"];
		$class_id = get_class_id($_SESSION["cbt_reg_no"]);
		
		if(!is_numeric($subj_id) || !is_numeric($class_id)){ redirect_to("index.php"); }
		$result_id = process_result($student_id, $class_id, $subj_id);
		redirect_to("result_checker.php?result_id=$result_id");
	}else{ redirect_to("index.php"); }
?>