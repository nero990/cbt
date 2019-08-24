<?php require_once("connection.php"); ?>
<?php
	$page = "";
	$sub_page = "";
	
	function confirm_query(){
		global $mysqli;
		die("Error in the consult.." . mysqli_error($mysqli));
	}
	
	function confirm_exam_state(){
		global $mysqli;
		if(isset($_SESSION["cbt_ini_exam"])){
			$session_val = $_SESSION["cbt_ini_exam"];
			$subj_id = $_SESSION["cbt_exam_subj_id"];
			
			$query = "SELECT surname FROM cbt_students
							WHERE session_val = '{$session_val}'
							LIMIT 1";
			$students_set = $mysqli->query($query) or confirm_query();
			if($students_set->num_rows == 0){ // if there is no exam going on
				redirect_to("result_checker.php?subj_id=$subj_id");
			}
		}else{ redirect_to("index.php"); }
	}
	
	function check_exam_active(){ // this function checks if an exam is going on
		global $mysqli;
		if(isset($_SESSION["cbt_ini_exam"])){
			$session_val = $_SESSION["cbt_ini_exam"];
			$subj_id = $_SESSION["cbt_exam_subj_id"];
			
			$query = "SELECT surname FROM cbt_students
							WHERE session_val = '{$session_val}'
							LIMIT 1";
			$students_set = $mysqli->query($query) or confirm_query();
			if($students_set->num_rows == 1){
				redirect_to("exam.php");
			}
		}
	}
	
	function mysqli_prep($value){
		global $mysqli;
		return $mysqli->real_escape_string($value);
	}
	
	function get_subj($subj_id){
		global $mysqli;
		
		$query = "SELECT subject FROM cbt_subjects
						WHERE subj_id='{$subj_id}'";
		$subjects_set = $mysqli->query($query) or confirm_query();
		$subjects = $subjects_set->fetch_assoc();
		return $subjects["subject"];
	}
	
	function get_class_name($class_id){
		global $mysqli;
		
		$query = "SELECT _class FROM cbt_classes
						WHERE class_id='{$class_id}'";
		$classes_set = $mysqli->query($query) or confirm_query();
		$classes = $classes_set->fetch_assoc();
		return $classes["_class"];
	}
	
	function get_student_id($reg_no){
		global $mysqli;
		
		$query = "SELECT * FROM cbt_students
						WHERE reg_no='{$reg_no}'";
		$students_set = $mysqli->query($query) or confirm_query();
		$students = $students_set->fetch_assoc();
		return $students["student_id"];
	}
	
	function get_student_name($reg_no){
		global $mysqli;
		
		$query = "SELECT * FROM cbt_students
						WHERE reg_no='{$reg_no}'";
		$students_set = $mysqli->query($query) or confirm_query();
		$students = $students_set->fetch_assoc();
		return $students["surname"] . " " . $students["other_names"];
	}
	
	function get_student_class($reg_no){
		global $mysqli;
		
		$query = "SELECT c._class FROM cbt_students s
						NATURAL JOIN cbt_classes c
						WHERE s.reg_no='{$reg_no}'";
		$students_set = $mysqli->query($query) or confirm_query();
		$students = $students_set->fetch_assoc();
		return $students["_class"];
	}
	
	function get_class_id($reg_no){
		global $mysqli;
		
		$query = "SELECT c.class_id FROM cbt_students s
						NATURAL JOIN cbt_classes c
						WHERE s.reg_no='{$reg_no}'";
		$students_set = $mysqli->query($query) or confirm_query();
		$students = $students_set->fetch_assoc();
		return $students["class_id"];
	}
	
	function redirect_to($location=NULL){
		header("Location: $location");
		exit;
	}
	
	function get_total_quest($subj_id, $class_id){
		global $mysqli;
		
		$query = "SELECT COUNT(*) FROM cbt_questions
						WHERE class_id = '{$class_id}'
						AND subj_id = '{$subj_id}'";
		$questions_set = $mysqli->query($query) or confirm_query();
		$questions = $questions_set->fetch_array();
		return $questions[0];
	}
	
	function get_total_ans_quest($student_id, $subj_id, $class_id){
		global $mysqli;
		
		$query = "SELECT COUNT(*) FROM cbt_students_answers
						WHERE student_id = '{$student_id}'
						AND subj_id = '{$subj_id}'
						AND class_id = '{$class_id}'";
		$result = $mysqli->query($query) or confirm_query();
		$row = $result->fetch_array();
		return $row[0];
	}

	function get_username($user_id){
		global $mysqli;
		
		$query = "SELECT username FROM cbt_users
						WHERE user_id = '{$user_id}'
						LIMIT 1";
		$result = $mysqli->query($query) or confirm_query();
		if($row = $result->fetch_assoc()){
			return $row["username"];
		}
	}
	
	function process_result($student_id, $class_id, $subj_id){
		global $mysqli;
		$wrong_ans = $correct_ans = 0;
		
		$total_quest = get_total_quest($subj_id, $class_id);
		
		$query = "SELECT * FROM cbt_students_answers
						WHERE student_id = '{$student_id}'
						AND subj_id = '{$subj_id}'
						AND class_id = '{$class_id}'";
		$result = $mysqli->query($query) or confirm_query();
		while($row = $result->fetch_assoc()){ // getting total correct and wrong answers
			if($row["remark"] == 0){
				$wrong_ans++;
			}elseif($row["remark"] == 1){
				$correct_ans++;
			}
		}
		$answered_quest = $correct_ans + $wrong_ans; // calculating answered questions
		$unanswered = $total_quest - $answered_quest; // calculating unanswered questions
		$score = ($correct_ans / $total_quest) * 100; // calculating score in percentage
		$test_date = date("Y-m-d");
		
		// check if result exist, if true, delete result before performing insertion
		$query = "SELECT * FROM cbt_results
						WHERE student_id ='{$student_id}'
						AND subj_id = '{$subj_id}'
						AND class_id = '{$class_id}'";
		$results_set = $mysqli->query($query) or confirm_query();
		if($results_set->num_rows != 0){
			$query = "DELETE FROM cbt_results
								WHERE student_id ='{$student_id}'
								AND subj_id = '{$subj_id}'
								AND class_id = '{$class_id}'";
			$mysqli->query($query) or confirm_query();
		}
		
		// Inserting result into database
		$query = "INSERT INTO cbt_results (
								student_id, subj_id, class_id, total_question, answered_quest, total_valid_ans, total_wrong_ans, unanswered, score, test_date
							) VALUES (
								'{$student_id}', '{$subj_id}', '{$class_id}', '{$total_quest}', '{$answered_quest}', '{$correct_ans}', '{$wrong_ans}', '{$unanswered}', '{$score}', '{$test_date}'
							)";
		$mysqli->query($query) or confirm_query();
		$result_id = $mysqli->insert_id;
		
		if(isset($_SESSION["cbt_ini_exam"]) && isset($_SESSION["cbt_exam_subj_id"])){
			unset($_SESSION["cbt_ini_exam"]); // unsetting $_SESSION["cbt_ini_exam"] variable
		}
		
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
		return $result_id;
	}
?>