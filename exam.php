<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_student_login(); ?>
<?php confirm_exam_state(); ?>
<?php
	$student_ans = "";
	
	if(isset($_SESSION["cbt_exam_subj_id"])){
		$subj_id = $_SESSION["cbt_exam_subj_id"];
		$class_id = get_class_id($_SESSION["cbt_reg_no"]);
		$student_id = get_student_id($_SESSION["cbt_reg_no"]);
		
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
				$total_quest = get_total_quest($subj_id, $class_id);
				
				if(isset($_GET["quest_no"]) && is_numeric($_GET["quest_no"]) && $_GET["quest_no"] > 0 && $_GET["quest_no"] <= $total_quest){
					$quest_no = trim($_GET["quest_no"]);
				}else{ $quest_no = 1; }
				$next_quest = $quest_no + 1;
				$prev_quest = $quest_no - 1;
				
				$query = "SELECT * FROM cbt_questions
								WHERE subj_id = '{$subj_id}'
								AND class_id = '{$class_id}'
								ORDER BY quest_id ASC
								LIMIT $prev_quest, 1";
				$result = $mysqli->query($query) or confirm_query();
				if($row = $result->fetch_assoc()){
					$quest_id = stripslashes($row["quest_id"]);
				}
				
				// getting remaining time
				$query = "SELECT stop_time FROM cbt_students
								WHERE student_id = '{$student_id}'
								LIMIT 1";
				$students_set = $mysqli->query($query) or confirm_query();
				$students = $students_set->fetch_array();
				$stop_time = $students["stop_time"];
				$stop = strtotime($stop_time);
				
				$now = strtotime(date("Y-m-d H:i:s"));
								
				if($now < $stop){
					$time_left = $stop - $now;
					$time_left = date("H:i:s", $time_left-(60*60));
				}else{ redirect_to("process_result.php"); }
			}
		}
	}else{ redirect_to("index.php"); }
	
	if(isset($_POST["option"]) && isset($_POST["question"])){
		$student_ans = mysqli_prep(trim($_POST["option"]));
		$quest_id = mysqli_prep(trim($_POST["question"]));
		
		$query = "SELECT answer FROM cbt_questions 
						WHERE quest_id = '{$quest_id}'";
		$result = $mysqli->query($query) or confirm_query();
		if($row = $result->fetch_assoc()){
			if($row["answer"] == $student_ans){ // passed
				$remark = 1;
			}else { $remark = 0; } // failed
		}
		
		// check if student has answered this particular question
		$query = "SELECT student_ans_id, student_ans FROM cbt_students_answers
						WHERE student_id = '{$student_id}'
						AND subj_id = '{$subj_id}'
						AND class_id = '{$class_id}'
						AND quest_id = '{$quest_id}'";
		$result = $mysqli->query($query) or confirm_query();
		if($row = $result->fetch_assoc()){ // question has been answered. Therefore, do an update
			$student_ans_id = $row["student_ans_id"];
			
			$query = "UPDATE cbt_students_answers
							SET student_ans = '$student_ans',
									remark = '{$remark}'
							WHERE student_ans_id = '{$student_ans_id}'";
			$result = $mysqli->query($query) or confirm_query();
		}else{ // question hasn't been answered. Therefore, do an insert
			$query = "INSERT INTO cbt_students_answers (
							student_id, subj_id, class_id, quest_id, student_ans, remark
							) VALUES (
									'{$student_id}', '{$subj_id}', '{$class_id}', '{$quest_id}', '{$student_ans}', '{$remark}'
								)";
			$result = $mysqli->query($query) or confirm_query();
		}
	}else{
		// check if student has answered this particular question
		$query = "SELECT student_ans FROM cbt_students_answers
						WHERE student_id = '{$student_id}'
							AND subj_id = '{$subj_id}'
							AND quest_id = '{$quest_id}'";
		$result = $mysqli->query($query) or confirm_query();
		if($row = $result->fetch_assoc()){
			$student_ans = $row["student_ans"];
		}
	}
	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="css/style.css">
		
		<link rel="stylesheet" href="css/jquery-ui.min.css">
		<link rel="stylesheet" href="css/jquery-ui.structure.min.css">
		<link rel="stylesheet" href="css/jquery-ui.theme.min.css">
		<link rel="stylesheet" href="css/TimeCircles.css">
		
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery-ui.min.js"></script>
		<script src="js/TimeCircles.js"></script>
		<script src="js/jquery_validate/jquery.validate.min.js"></script>
		<script src="js/jquery_validate/additional-methods.min.js"></script>
		
		<script>
			$(document).ready(function(){
				$(".radio input[type='radio']").click(function(){
					$("#answer").submit();
				}); // end click
				
				$('#next').click(function(){
					var url = 'exam.php?quest_no=' + next_quest;
					$(location).attr('href', url);
				}); // end click
				
				$('#prev').click(function(){
					var url = 'exam.php?quest_no=' + prev_quest;
					$(location).attr('href', url);
				}); // end click
				
				$('#confirm-finish').dialog({
					autoOpen: false,
					modal: true,
					resizable: false,
					buttons: {
						"Yes" : function(){
							var url = 'process_result.php';
							$(location).attr('href', url);
						},
						"No" : function(){
							$(this).dialog('close');
						}
					}
				}); // end dialog
				
				$('#finish').click(function(){
					$('#confirm-finish').dialog('open');
				}); // end click
				
				$('#confirm-quit').dialog({
					autoOpen: false,
					modal: true,
					resizable: false,
					buttons: {
						"Yes" : function(){
							var url = 'quit_test.php';
							$(location).attr('href', url);
						},
						"No" : function(){
							$(this).dialog('close');
						}
					}
				}); // end dialog
				
				$('#quit').click(function(){
					$('#confirm-quit').dialog('open');
				}); // end click
				
				$('.timer').TimeCircles({
					time: {
						Days: { show: false}
					},
					count_past_zero: false
				});
			}); // end ready
		</script>
		
		<style>
			.confirm{
				display: none;
			}
		</style>
		<title>Computer Based Test</title>
	</head>
	<body>
		<div class="wrapper">
			<h1>Computer Based Test</h1>
			<table class="cand-details">
				<tr>
					<th>Candidate's name:</th>
					<td><?php echo get_student_name($_SESSION["cbt_reg_no"]); ?></td>
				</tr>
				<tr>
					<th>Registration No.:</th>
					<td><?php echo $_SESSION["cbt_reg_no"]; ?></td>
				</tr>
				<tr>
					<th>Subject:</th>
					<td><?php echo get_subj($subj_id); ?></td>
				</tr>
				<tr>
					<th>Class:</th>
					<td><?php echo get_student_class($_SESSION["cbt_reg_no"]); ?></td>
				</tr>
			</table>

			<div class="main">
				<div class="question">
					<p class="question-mark">?</p>
					<div class="question-box">
						<?php
							echo "<script>
											var next_quest = $next_quest
											var prev_quest = $prev_quest;
										</script>\n";
							
							$query = "SELECT * FROM cbt_questions
											WHERE subj_id = '{$subj_id}'
											AND class_id = '{$class_id}'
											ORDER BY quest_id ASC
											LIMIT $quest_no";
							$result = $mysqli->query($query) or confirm_query();
							while($row = $result->fetch_assoc()){
								$quest_id = stripslashes($row["quest_id"]);
								$question = stripslashes($row["question"]);
								$a = stripslashes($row["a"]);
								$b = stripslashes($row["b"]);
								$c = stripslashes($row["c"]);
								$d = stripslashes($row["d"]);
								
								$options = array($a, $b, $c, $d);
							}
							echo "<p>$question</p>\n";	
						?>
					</div>
				</div>
				
				<form method="POST" action="" class="answer" id="answer">
					<input type="hidden" name="question" value="<?php echo $quest_id ?>">
					<?php
						$opt = "ABCD";
						$i = 0;
						foreach($options as $option){
							echo "<div class='radio'>\n
											<input type='radio' id='$opt[$i]' name='option' value='$opt[$i]'";
							if($student_ans == $opt[$i]){ echo " checked"; }
							echo ">\n
											<label for='$opt[$i]'>$opt[$i]: $option</label>\n
										</div>\n";
							$i++;
						}
					?>
				</form>
				<div class="question-nav">
					<p class="header">Question Navigation</p>
					<div class="body">
						<?php
							// This colored all answered question
							$query = "SELECT quest_id FROM cbt_questions
											WHERE subj_id = '{$subj_id}'
											AND class_id = '{$class_id}'
											ORDER BY quest_id ASC";
							$questions_set = $mysqli->query($query) or confirm_query();
							$start = TRUE;
							while($questions = $questions_set->fetch_assoc()){
								 // This was done to force the array index to start from 1
								if($start == TRUE){ $quest_ids[1] = $questions["quest_id"]; }
								else{ $quest_ids[] = $questions["quest_id"]; }
								$start = FALSE;
							}
							
							$query = "SELECT * FROM cbt_students_answers
											WHERE student_id = '{$student_id}'
											AND subj_id = '{$subj_id}'
											AND class_id = '{$class_id}'";
							$students_answers_set = $mysqli->query($query) or confirm_query();
							while($students_answers = $students_answers_set->fetch_assoc())	{
								$ans_quest_ids[] = $students_answers["quest_id"];
							}
							if(isset($ans_quest_ids)){
								foreach($ans_quest_ids as $ans_quest_id){
									$ans_quests[] = array_search($ans_quest_id, $quest_ids);
								}
							}
							
							for($count=1; $count<=$total_quest; $count++){
								echo "<a href='?quest_no=$count' class='";
								if($count==$quest_no){ echo "cap";}
								if(isset($ans_quest_ids) && in_array($count, $ans_quests)){ echo " answered-quest";}
								echo "'>";
								if($count<10){ echo "0";}
								echo "$count</a>\n";
							}
						?>
					</div>
				</div>
				
				<div class="buttons">
					<button id="prev" accesskey="P" <?php if($quest_no==1){ echo "disabled"; } ?>>&laquo; Previous</button>
					<button id="next" accesskey="N" <?php if($quest_no==$total_quest){ echo "disabled"; } ?>>Next &raquo;</button>
				</div>
			</div>
			
			<div class="footer">
				<div class="timer" data-date="<?php echo $stop_time; ?>">
				<p>Time Remaining:</p>
				</div>
				
				<div class="buttons">
					<button id="quit">Quit Test</button>
					<button id="finish" accesskey="F">Finish Test</button>
				</div>
				
				<table>
					<tr>
						<th>Total Questions:</th>
						<td><?php echo $total_quest; ?></td>
						
						<th>Current Question:</th>
						<td><?php echo $quest_no; ?></td>
						
						<th>Answered questions:</th>
						<td><?php echo get_total_ans_quest($student_id, $subj_id, $class_id) . " / " . $total_quest; ?></td>
					</tr>
				</table>
				
				<div id="confirm-finish" title="Confirm Finish" class="confirm">
					<p>Are you sure you want to <strong>SUBMIT</strong> this test?</p>
				</div>
				<div id="confirm-quit" title="Confirm Quit" class="confirm">
					<p>Are you sure you want to <strong>QUIT</strong> this test?</p>
				</div>
			</div>
			<?php include_once("includes/footer.php"); ?>