<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/connection.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php confirm_staff_login(); ?>

<?php 
	$title = "Ongoing Test";
	$page = "ongoing_test";
	$sub_page = "ongoing_test";
	include_once("../includes/admin_header.php");
?>
<script>
	$(document).ready(function(){
		var url;
		$("#confirm-stop").dialog({
			autoOpen: false,
			modal: true,
			resizable: false,
			buttons: {
				Yes: function(){
					$(location).attr('href', url);
				},
				No: function(){
					$(this).dialog('close');
				}
			}
		});
		
		$(".stop-test").click(function(){
			url = $(this).attr("href");
			$("#confirm-stop").dialog("open");
			return false;
		}); // end click
	}); // end ready
</script>
<!-- This is the main content of the site -->
<div class="main">
	<h2>Ongoing Test</h2>
	<?php
		$query = "SELECT * FROM cbt_students s
						NATURAL JOIN cbt_classes c
						WHERE s.state = 1
						ORDER BY c.class_id ASC, s.surname ASC, s.other_names ASC";
		$students_set = $mysqli->query($query) or confirm_query();
		if($students_set->num_rows >= 1){ // These is at least a test going on
			echo "<table class='table table-striped table-condensed'>
							<thead>
								<tr>
									<th>S/N</th>
									<th>Name</th>
									<th>Reg No.</th>
									<th>Class</th>
									<th>Subject</th>
									<th>Duration</th>
									<th>Start</th>
									<th>Stop</th>
									<th>Time Left</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>";
			$count = 1;
			while($students = $students_set->fetch_assoc()){
				$student_id = $students["student_id"];
				$name = stripslashes($students["surname"]) . " " . stripslashes($students["other_names"]);
				$reg_no = $students["reg_no"];
				$class_id = $students["class_id"];
				$_class = $students["_class"];
				$subj_id = $students["subj_id"];
				$duration = $students["duration"];
				$start_time = $students["start_time"];
				$start = DateTime::createFromFormat("Y-m-d H:i:s", $start_time);
				$start = $start->format("g:i:s A");
				
				$stop_time = $students["stop_time"];
				$stop = DateTime::createFromFormat("Y-m-d H:i:s", $stop_time);
				$stop = $stop->format("g:i:s A");
				
				$now = strtotime(date("Y-m-d H:i:s"));
				$stop_time = strtotime($stop_time);
				$rem_time = $stop_time - $now;
				
				if($rem_time < 0){ // Time up
					process_result($student_id, $class_id, $subj_id);
					redirect_to($_SERVER["PHP_SELF"]);
				}else{
					$rem_time = date("H:i:s", $rem_time-(60*60)); 
				}
				
				echo "<tr>
								<td>{$count}</td>
								<td>{$name}</td>
								<td>{$reg_no}</td>
								<td>{$_class}</td>
								<td>" . get_subj($subj_id) . "</td>
								<td>{$duration}</td>
								<td>{$start}</td>
								<td>{$stop}</td>
								<td class='text-center' style='color: #F00;'>{$rem_time}</td>
								<td><a href='stop_test.php?student=$student_id&amp;_class=$class_id&amp;subject=$subj_id' class='stop-test'>Stop Test</a></td>
							</tr>";
				$count++;
			}
			echo "</tbody>
					</table>";
		}else{  // No test currently going on
			echo "<p class='warning-msg'>Oop! No test currently going on.</p>";
		}
	?>
	<div title="Confirm" id="confirm-stop">
		<p>Are sure you want <strong>STOP</strong> this student's test?</p>
	</div>
	<div class="clearfix"></div>
</div>		
<?php include_once("../includes/admin_footer.php"); ?>