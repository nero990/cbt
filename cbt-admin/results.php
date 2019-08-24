<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/connection.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php confirm_staff_login(); ?>
<?php
		$subj_id = $class_id = "";
		
		if(isset($_REQUEST["_class"]) && !empty($_REQUEST["_class"]) 
			&& isset($_REQUEST["subject"]) && !empty($_REQUEST["subject"])){
			$subj_id = mysqli_prep(trim($_REQUEST["subject"]));
			$class_id = mysqli_prep(trim($_REQUEST["_class"]));
		}elseif(isset($_REQUEST["_class"]) && !empty($_REQUEST["_class"])){
			$class_id = mysqli_prep(trim($_REQUEST["_class"]));
		}
?>
<?php 
	$title = "Results";
	$page = "results";
	$sub_page = "results";
	include_once("../includes/admin_header.php");
?>
<script>
	$(document).ready(function(){
		$('#subj-form').validate({
			rules: {
				_class: {
					required: true
				}
			},
			messages: {
				_class: {
					required: "Please select a class."
				}
			}
		}); // end validate
		
		$('#_class').change(function(){
			if ($(this).val() != ''){
				$('#subj-form').submit();
			}
		}); // end change
		
		$('#subj').change(function(){
			if ($(this).val() != ''){
				$('#subj-form').submit();
			}
		}); // end change
		
		$('#print-button').click(function(){
			var winProps = 'height=900, width=1000, top=0, left=0, scrollbars=yes';
			var newWin = open($(this).attr('href'), 'aWin', winProps);
			newWin.focus();
			return false;
		}); // end click
	}); // end ready
</script>
<!-- This is the main content of the site -->
<div class="main">
	<h2>Results</h2>
	
	<p class="msg">Select class and subject to view students' results.</p>
	<form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="form-horizontal col-lg-6" id="subj-form">
		<div class="form-group">
			<label for="subject" class="col-lg-4 control-label">Class</label>
			<div class="col-lg-5">
				<select id="_class" name="_class" class="form-control">
					<option value="">--Select Class--</option>
					<?php
						$query = "SELECT * FROM cbt_classes
										ORDER BY class_id ASC";
						$result = $mysqli->query($query) or confirm_query();
						while($row=$result->fetch_assoc()){
							$db_class_id = $row["class_id"];
							$_class = $row["_class"];
							
							echo "<option value='$db_class_id'";
							if($db_class_id == $class_id){ echo " selected"; }
							echo ">$_class</option>\n";
						}
					?>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label for="subject" class="col-lg-4 control-label">Subject</label>
			<div class="col-lg-7">
				<select id="subj" name="subject" class="form-control">
					<option value="">--Select Subject--</option>
					<?php
						if(isset($_REQUEST["_class"]) && !empty($_REQUEST["_class"])){
							$class_id = mysqli_prep(trim($_REQUEST["_class"]));
			
							$query = "SELECT * FROM cbt_subjects s
											NATURAL JOIN cbt_subjs_classes sc
											WHERE sc.class_id = '{$class_id}'
											ORDER BY subject ASC";
							$result = $mysqli->query($query) or confirm_query();
							while($row=$result->fetch_assoc()){
								$db_subj_id = $row["subj_id"];
								$subject = $row["subject"];
								
								echo "<option value='$db_subj_id'";
								if($db_subj_id == $subj_id){ echo " selected"; }
								echo ">$subject</option>\n";
							}
						}
					?>
				</select>
			</div>
		</div>
	</form>
	<div class="clearfix"></div>
	<?php
		if(isset($_REQUEST["_class"]) && !empty($_REQUEST["_class"]) 
		&& isset($_REQUEST["subject"]) && !empty($_REQUEST["subject"])){
			$subj_id = mysqli_prep(trim($_REQUEST["subject"]));
			$class_id = mysqli_prep(trim($_REQUEST["_class"]));
			
			echo "<div class='col-lg-12'>";
	
			$query = "SELECT * FROM cbt_results r
								LEFT JOIN cbt_students st
									ON r.student_id = st.student_id
								JOIN cbt_subjects sub
									ON sub.subj_id = r.subj_id
							WHERE r.class_id = '{$class_id}'
								AND sub.subj_id = '{$subj_id}'
							ORDER BY st.surname ASC, st.other_names ASC";
			$results_set = $mysqli->query($query) or confirm_query();
			$count = 1;
			if($results_set->num_rows >= 1){ // there is at least one result
				echo "<table class='table table-striped table-condensed'>
								<thead>
									<tr>
										<th>S/N</th>
										<th>Name</th>
										<th>Reg. No.</th>
										<th>Test Date</th>
										<th class='text-center'>Total Quest</th>
										<th class='text-center'>Answered Quest</th>
										<th class='text-center'>Correct Ans</th>
										<th class='text-center'>Wrong Ans</th>
										<th class='text-center'>Unans</th>
										<th class='text-center'>Score</th>
									</tr>
								</thead>
								<tbody>";
				while($results = $results_set->fetch_assoc()){
					$name = stripslashes($results["surname"]) . " " . stripslashes($results["other_names"]);
					$reg_no = $results["reg_no"];
					$total_quest = $results["total_question"];
					$answered_quest = $results["answered_quest"];
					$correct_ans = $results["total_valid_ans"];
					$wrong_ans = $results["total_wrong_ans"];
					$unanswered = $results["unanswered"];
					$score = $results["score"];
					$test_date = DateTime::createFromFormat('Y-m-d', $results["test_date"]);
					$test_date = $test_date->format('j-M-y');
					
					echo "<tr>
									<td>{$count}</td>
									<td>{$name}</td>
									<td>{$reg_no}</td>
									<td>{$test_date}</td>
									<td class='text-center'>{$total_quest}</td>
									<td class='text-center'>{$answered_quest}</td>
									<td class='text-center'>{$correct_ans}</td>
									<td class='text-center'>{$wrong_ans}</td>
									<td class='text-center'>{$unanswered}</td>
									<td class='text-center'><strong>{$correct_ans}/{$total_quest} ({$score}%)</strong></td>
								</tr>";
					++$count;
				}
				echo "</tbody>
						</table>
						
						<a href='print_result.php?subj_id=$subj_id&amp;class_id=$class_id' id='print-button'>
							<button class='print-button'>Print Result</button>
						</a>";
			}else{ // No result for selected class and subject
				echo "<p class='timer' style='text-align: left; color: #F00;'><em>Oops! No result for selected class and subject.</em></p>";
			}	

			echo "</div>";
		}
	?>
</div>		
<?php include_once("../includes/admin_footer.php"); ?>