<?php require_once("includes/session.php") ?>
<?php require_once("includes/connection.php") ?>
<?php require_once("includes/functions.php") ?>
<?php confirm_student_login(); ?>
<?php check_exam_active(); ?>

<?php 
	$page = "correction";
	include_once("includes/header.php"); 
	include_once("includes/header2.php");
?>
<script>
	$(document).ready(function(){
		$('#rewrite-test').click(function(){
			var url = 'clear_prev_ans.php?subj_id=' + subj_id;
			$(location).attr('href', url);
		}); // end click
		
		$('#another-test').click(function(){
			var url = 'index.php';
			$(location).attr('href', url);
		}); // end click
		
	}); // end ready
</script>
<div class="content">
	<h2>Test Correction</h2>
	<p class="note">Below is your test summary and correction.</p>
	
	<?php
		if(isset($_SESSION["cbt_exam_subj_id"])){
			$subj_id = $_SESSION["cbt_exam_subj_id"];
			$student_id = $_SESSION["cbt_student_id"];
			$class_id = get_class_id($_SESSION["cbt_reg_no"]);
			$query = "SELECT COUNT(*) FROM cbt_students_answers
							WHERE student_id = '{$student_id}'
							AND class_id = '{$class_id}'
							AND subj_id = '{$subj_id}'";
			$result = $mysqli->query($query) or confirm_query();
			$row = $result->fetch_array();
			if($row[0] == 0){ // There is no question
				redirect_to("index.php");
			}
			
			$query = "SELECT * FROM cbt_results
							WHERE subj_id = '{$subj_id}'
							AND student_id = '{$student_id}'
							AND class_id = '{$class_id}'";
			$results_set = $mysqli->query($query) or confirm_query();
			if($results = $results_set->fetch_assoc()){
				$subj = get_subj($subj_id);
				$total_quest = $results["total_question"];
				$answered_quest = $results["answered_quest"];
				$correct_ans = $results["total_valid_ans"];
				$wrong_ans = $results["total_wrong_ans"];
				$unanswered = $results["unanswered"];
				$score = $results["score"];

			echo "<div class='col-lg-12'>
							<table class='table table-bordered table-condensed result'>
								<tr>
									<td>Subject:</td>
									<td>{$subj}</td>
								</tr>
								<tr>
									<td>Total Questions:</td>
									<td>{$total_quest}</td>
								</tr>
								<tr>
									<td>Answered Questions:</td>
									<td>{$answered_quest}</td>
								</tr>
								<tr>
									<td>Unanswered Questions:</td>
									<td>{$unanswered}</td>
								</tr>
								<tr>
									<td>Score:</td>
									<td>{$correct_ans}/{$total_quest} ({$score}%)</td>
								</tr>
							</table>
						</div>
						<div class='clearfix'></div>";
						
				echo "<script>
								var subj_id = $subj_id
							</script>\n";
			}else{ redirect_to("index.php"); }
							
			$query = "SELECT * FROM cbt_questions q
							LEFT JOIN cbt_students_answers sa
								ON q.quest_id = sa.quest_id
								AND sa.student_id = '{$student_id}'
							WHERE q.class_id = '{$class_id}'
								AND q.subj_id = '{$subj_id}'
							ORDER BY q.quest_id ASC";
			$students_ans_set = $mysqli->query($query) or confirm_query();
			if($students_ans_set->num_rows >= 1){
				echo "<div class='correction'>
								<table class='table table-correction'>";
				$count = 1;
				$option1 = $option2 = $option3 = $option4 = "_not";
				$sel_ans_1 = $sel_ans_2 = $sel_ans_3 = $sel_ans_4 = "not_sel";
				while($students_ans = $students_ans_set->fetch_assoc()){
					$question = stripslashes($students_ans["question"]);
					$a = stripslashes($students_ans["a"]);
					$b = stripslashes($students_ans["b"]);
					$c = stripslashes($students_ans["c"]);
					$d = stripslashes($students_ans["d"]);
					$answer = $students_ans["answer"];
					$student_ans = $students_ans["student_ans"];
					
					switch($answer){
						case "A": 
								$option1 = "ans";
								break;
						case "B":
								$option2 = "ans";
								break;
						case "C":
								$option3 = "ans";
								break;
						case "D":
								$option4 = "ans";
								break;
					}
					
					switch($student_ans){
						case "A": 
								$sel_ans_1 = "sel_ans";
								break;
						case "B":
								$sel_ans_2 = "sel_ans";
								break;
						case "C":
								$sel_ans_3 = "sel_ans";
								break;
						case "D":
								$sel_ans_4 = "sel_ans";
								break;
					}
					
					if($answer == $student_ans){ $remark = "correct"; }
					else{ $remark = "wrong"; }
					
					echo "<tr>
									<th width='18%'>Question {$count}:</th>
									<td>$question</td>
								</tr>
								<tr class='$option1 $sel_ans_1'>
									<th>A:</th>
									<td>$a</td>
								</tr>
								<tr class='$option2 $sel_ans_2'>
									<th>B:</th>
									<td>$b</td>
								</tr>
								<tr class='$option3 $sel_ans_3'>
									<th>C:</th>
									<td>$c</td>
								</tr>
								<tr class='$option4 $sel_ans_4'>
									<th>D:</th>
									<td>$d</td>
								</tr>
								<tr class='end'>
									<td colspan='2' class='{$remark}'>" . ucfirst($remark) . "</td>
								</tr>";
				
					$count++;
					$option1 = $option2 = $option3 = $option4 = "_not";
					$sel_ans_1 = $sel_ans_2 = $sel_ans_3 = $sel_ans_4 = "not_sel";
				}
				echo "</table>
						</div>";
				
			}else{ redirect_to("index.php"); }
		}else{ redirect_to("index.php"); } // do a redirect
	?>
	
	<div style="margin-top: 20px;">
		<button id='rewrite-test'>Rewrite Test</button>
		<button id='another-test'>Write Another Test</button>
	</div>
</div>
<div class="footer">
	
</div>
<?php include_once("includes/footer.php"); ?>