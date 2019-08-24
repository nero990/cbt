<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_student_login(); ?>
<?php
	if(isset($_GET["subj_id"])){
		$student_id = $_SESSION["cbt_student_id"];
		$class_id = get_class_id($_SESSION["cbt_reg_no"]);
		$subj_id = mysqli_prep(trim($_GET["subj_id"]));
		
		$query = "SELECT COUNT(*) FROM cbt_subjs_classes
						WHERE subj_id = '{$subj_id}'
						AND class_id = '{$class_id}'";
		$result = $mysqli->query($query) or confirm_query();
		$row = $result->fetch_array();
		if($row[0] == 0){ redirect_to("index.php"); } // This ensures that the subject is been 
																									// offered by the selected class
		else{
			$query = "SELECT COUNT(*) FROM cbt_questions
							WHERE subj_id = '{$subj_id}'
							AND class_id = '{$class_id}'";
			$result = $mysqli->query($query) or confirm_query();
			$row = $result->fetch_array();
			if($row[0] == 0){ redirect_to("index.php"); } // To ensure that questions have been set for selected subject
			else{
				// getting duration
				$query = "SELECT max_time FROM cbt_subjs_classes
								WHERE subj_id = '{$subj_id}'
								AND class_id = '{$class_id}'
								LIMIT 1";
				$subjs_classes_set = $mysqli->query($query) or confirm_query();
				if($subjs_classes = $subjs_classes_set->fetch_assoc()){
					$duration = $subjs_classes["max_time"];
					
					if(is_null($duration) || $duration == '00:00:00'){
						$duration = '1970-01-01 01:30:00'; // use this as default time
					}else{
						$duration = strtotime("1970-01-01 " . $duration);
						$duration = date("Y-m-d H:i:s", $duration + (60*60)); // This was done to add 1 hr because the 1970-01-01 timestamp is in UTC
					}
					
					$duration = strtotime($duration); // converts duration to timestamp
					
					$start_time = strtotime(date("Y-m-d H:i:s")); // gets the current timestamp
					$stop_time = $start_time + $duration;
					
					$duration = date("H:i:s", $duration - (60*60)); // This substracts the 1hr which was added above
					$start_time = date("Y-m-d H:i:s", $start_time);
					$stop_time = date("Y-m-d H:i:s", $stop_time);
					
					do{ // create a session variable
					$session_val = sha1(mt_rand());
					$query = "SELECT * FROM cbt_students
										WHERE session_val = '{$session_val}'
										LIMIT 1";
						$students_set = $mysqli->query($query) or confirm_query();
					}while($students_set->num_rows == 1);
					
					$_SESSION["cbt_ini_exam"] = $session_val;
					$_SESSION["cbt_exam_subj_id"] = $subj_id;
					
					$query = "UPDATE cbt_students
									SET state = 1,
											subj_id = '{$subj_id}',
											duration = '{$duration}',
											start_time = '{$start_time}',
											stop_time = '{$stop_time}',
											session_val = '{$session_val}'
									WHERE student_id = '{$student_id}'
									LIMIT 1";
					$mysqli->query($query) or confirm_query();
					redirect_to("exam.php");
				}else{ redirect_to("index.php"); }
			}
		}
					}else{ redirect_to("index.php"); }
?>