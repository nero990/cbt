<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/connection.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php confirm_staff_login(); ?>

<!doctype html>
<html>
	<head>
		<link href="../css/bootstrap.min.css" rel="stylesheet">
		<title>Student Result</title>
		<style>
			*{ margin: 0; font-family: cambria;	}
			.container{
				width: 990px;
			}
			h1{
				font-weight: bold;
				font-size: 26px;
			}
			.class-table{
				font-size: 18px;
				font-weight: bold;
				margin-bottom: 5px;
			}
			.class-table td{
				padding: 2px;
			}
			.class-table td:first-of-type{
				text-align: right;
			}
		</style>
	</head>
	<body onload="javascript:window.print()">
		<div class="container">
			<?php
				if(isset($_REQUEST["class_id"]) && !empty($_REQUEST["class_id"]) 
				&& isset($_REQUEST["subj_id"]) && !empty($_REQUEST["subj_id"])){
					$subj_id = mysqli_prep(trim($_REQUEST["subj_id"]));
					$class_id = mysqli_prep(trim($_REQUEST["class_id"]));
					
					echo "<div class='col-lg-12'>
									<h1>Students Results</h1>";
										
					$query = "SELECT * FROM cbt_subjs_classes sc
										NATURAL JOIN cbt_classes c
										NATURAL JOIN cbt_subjects s
									WHERE c.class_id = '{$class_id}'
									AND s.subj_id = '{$subj_id}'";
					$subjs_classes_set = $mysqli->query($query) or confirm_query();
					if($subjs_classes = $subjs_classes_set->fetch_assoc()){
						$_class = $subjs_classes["_class"];
						$subject = $subjs_classes["subject"];
						
					echo "<table class='class-table'>
									<tr>
										<td>Subject: </td>
										<td>$subject</td>
									<tr>
									<tr>
										<td>Class: </td>
										<td>$_class</td>
									<tr>
								</table>";
					}else{ redirect_to("results.php"); }
					
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
						echo "<table class='table table-striped table-condensed table-bordered'>
										<thead>
											<tr>
												<th class='text-center'>S/N</th>
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
											<td class='text-center'>{$count}</td>
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
								</table>";
					}else{ // No result for selected class and subject
						echo "<p class='timer' style='text-align: left; color: #F00;'><em>Oops! No result for selected class and subject.</em></p>";
					}	

					echo "</div>";
				}
			?>
		</div>
	</body>
</html>