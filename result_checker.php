<?php require_once("includes/session.php") ?>
<?php require_once("includes/connection.php") ?>
<?php require_once("includes/functions.php") ?>
<?php confirm_student_login(); ?>
<?php check_exam_active(); ?>
<?php
	$student_id = $_SESSION["cbt_student_id"];
	$class_id = get_class_id($_SESSION["cbt_reg_no"]);
?>
<?php 
	$page = "result_checker";
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
		
		$('#correction').click(function(){
			var url = 'correction.php?subj_id=' + subj_id;
			$(location).attr('href', url);
		}); // end click
		
	}); // end ready
</script>
<div class="content">
	<h2>Result Checker</h2>
	<?php
		if(isset($_GET["result_id"]) || isset($_GET["subj_id"])){
			if(isset($_GET["subj_id"])){
				$subj_id = mysqli_prep($_GET["subj_id"]);
				if(!is_numeric($subj_id)){ redirect_to("result_checker.php"); }
				
				$query = "SELECT * FROM cbt_results
								WHERE subj_id = '{$subj_id}'
								AND student_id = '{$student_id}'
								AND class_id = '{$class_id}'";
			}else{
				$result_id = mysqli_prep($_GET["result_id"]);
				if(!is_numeric($result_id)){ redirect_to("result_checker.php"); }
				
				$query = "SELECT * FROM cbt_results
								WHERE result_id = '{$result_id}'
								AND student_id = '{$student_id}'";
			}
			
			$results_set = $mysqli->query($query) or confirm_query();
			if($results = $results_set->fetch_assoc()){
				$subj_id = $results["subj_id"];
				$subj = get_subj($results["subj_id"]);
				$total_quest = $results["total_question"];
				$answered_quest = $results["answered_quest"];
				$correct_ans = $results["total_valid_ans"];
				$wrong_ans = $results["total_wrong_ans"];
				$unanswered = $results["unanswered"];
				$score = $results["score"];
				$test_date = DateTime::createFromFormat('Y-m-d', $results["test_date"]);
				$test_date = $test_date->format('j-M-y');
					
				echo "<script>
								var subj_id = $subj_id
							</script>\n";
										
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
										<td>Correct Answers:</td>
										<td>{$correct_ans}</td>
									</tr>
									<tr>
										<td>Wrong Answers:</td>
										<td>{$wrong_ans}</td>
									</tr>
									<tr>
										<td>Unanswered Questions:</td>
										<td>{$unanswered}</td>
									</tr>
									<tr>
										<td>Score:</td>
										<td>{$correct_ans}/{$total_quest} ({$score}%)</td>
									</tr>
									<tr>
										<td>Test Date:</td>
										<td>{$test_date}</td>
									</tr>
								</table>
							</div>";
				
				echo "<div class='clear-fix'></div>
							<button id='correction'>View Correction</button>
							<button id='rewrite-test'>Rewrite Test</button>
							<button id='another-test'>Write Another Test</button>";
			}else { redirect_to("result_checker.php"); }
		}else{
	?>
	<p class="note">Select a subject to check result.</p>
	<ul>
		<?php 
			// get subj for selected class only
			$class_id = get_class_id($_SESSION["cbt_reg_no"]);
			$query = "SELECT * FROM cbt_subjs_classes sc
							NATURAL JOIN cbt_subjects s
							WHERE sc.class_id = '{$class_id}'
							ORDER BY s.subject ASC";
			$result= $mysqli->query($query) or confirm_query();
			while($row = $result->fetch_assoc()){
				$subj = $row["subject"];
				$subj_id = $row["subj_id"];
				
				echo "<li><a href='?subj_id=$subj_id'>$subj</a></li>\n";
			}
		?>
	</ul>
		<?php } ?>
</div>
<div class="footer">
	
</div>
<?php include_once("includes/footer.php"); ?>