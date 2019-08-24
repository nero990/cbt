<?php require_once("includes/session.php") ?>
<?php require_once("includes/connection.php") ?>
<?php require_once("includes/functions.php") ?>
<?php confirm_student_login(); ?>
<?php check_exam_active(); ?>
<?php
	$student_id = $_SESSION["cbt_student_id"];
	
	// delete previous answers from the database
	$query = "DELETE FROM cbt_students_answers
					WHERE student_id = '{$student_id}'";
	$mysqli->query($query) or confirm_query();
?>
<?php 
	$page = "exam";
	include_once("includes/header.php"); 
	include_once("includes/header2.php"); 
?>
<script>
	$(document).ready(function(){
		$("#confirm-box").dialog({
			autoOpen: false,
			modal: true,
			resizable: false,
			buttons: {
				Yes: function(){
					$(location).attr('href', url); // this gets the url from the <a> tag
				},
				No: function(){
					$(this).dialog('close');
				}
			}
		}); // end dialog
		
		$(".confirm").click(function(){
			$("#confirm-box").dialog('open');
			url = $(this).attr('href');
			return false;
		}); // end click
	}); // end ready
</script>
<div class="content">
	<h2>Available Subjects</h2>
	<p class="note">Select a subject to take exam.<br>
	Once you select a subject, your time automatically start counting down.<br>
	If time is not specified for a subject, the default time (i.e. 30 minutes) shall be used.</p>
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
				$subj_id = $row["subj_id"];
				$subj = $row["subject"];
				$max_time = $row["max_time"];
				
				if(empty($max_time)){
					$time = "";
				}else{
					$arr = explode(":", $max_time);
					$hours = intval($arr[0]);
					$minutes = intval($arr[1]);
					$max_time = "";
					
					if($hours != 0){
						$max_time = $hours;
						if($hours == 1){ $max_time .= " hr "; }else{ $max_time .= " hrs "; }
					}
					if($minutes != 0){
						$max_time .= $minutes;
						if($minutes == 1){ $max_time .= " min "; }else{ $max_time .= " mins "; }
					}
					$time = "(" . $max_time . ")";
				}
				
				$msg = get_total_quest($subj_id, $class_id);
				if($msg==0){
					$msg = " No question yet";
				}
				elseif($msg==1){ $msg .= " Question"; }
				else{ $msg .= " Questions"; }
				echo "<li><a href='initialize_exam.php?subj_id=$subj_id' class='confirm'>$subj -- $msg <span class='time'>$time</span></a></li>\n";
			}
		?>
	</ul>
</div>
<div class="footer">
	
</div>
<div id="confirm-box" title="Confirm Start" class="confirm">
	<p>Are you sure you are ready to start this test because your time start immediately you click Yes?</p>
</div>
<?php include_once("includes/footer.php"); ?>