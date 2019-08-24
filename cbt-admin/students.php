<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_staff_login(); ?>
<?php
		$class_id = "";
		if(isset($_REQUEST["_class"]) && !empty($_REQUEST["_class"])){
			$class_id = mysqli_prep(trim($_REQUEST["_class"]));
		}
?>
<?php 
	$title = "Students";
	$page = "students";
	$sub_page = "students";
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
		
		$('#print-button').click(function(){
			var winProps = 'height=900, width=680, top=0, left=0, scrollbars=yes';
			var newWin = open($(this).attr('href'), 'aWin', winProps);
			newWin.focus();
			return false;
		}); // end click
	}); // end ready
</script>
<!-- This is the main content of the site -->
<div class="main">
	<h2>Students</h2>
	<p>Please select class to view students.</p>
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
	</form>
	<div class="clearfix"></div>
	<?php 
		if(isset($_REQUEST["_class"]) && !empty($_REQUEST["_class"])){
			$class_id = mysqli_prep(trim($_REQUEST["_class"]));
			
			$query = "SELECT * FROM cbt_students s
							NATURAL JOIN cbt_classes c
							WHERE s.class_id = '{$class_id}'
							ORDER BY s.surname ASC, s.other_names ASC";
			
			$result = $mysqli->query($query) or confirm_query();
			if($result->num_rows >= 1){ // There is at least a student
				echo "<div class='col-lg-12 student-list'>
								<table class='table table-stripped'>
									<thead>
										<tr>
											<th>S/N</th>
											<th>Name</th>
											<th>Reg No.</th>
											<th>Class</th>
											<th>&nbsp;</th>
										</tr>
									</thead>
									<tbody>";
								
				$count = 1;
				while($row = $result->fetch_assoc()){
					$name = stripslashes($row["surname"]) . " " . stripslashes($row["other_names"]);
					$reg_no = $row["reg_no"];
					$_class = $row["_class"];
					
					echo "<tr>
									<td>$count.</td>
									<td>$name</td>
									<td>$reg_no</td>
									<td>$_class</td>
									<td><a href='student_new.php?reg_no=$reg_no'>Update</a></td>
								</tr>";
					$count++;
				}
				
				echo "</tbody>
						</table>
						
					</div>
					<a href='print_student_list.php?_class=$class_id' id='print-button'>
						<button class='print-button'>Print Student List</button>
					</a>";
			}else{ 
				echo "<p class='warning-msg'>No student in the selected class.</p>";
			}
			
		}
	?>
</div>		
<?php include_once("../includes/admin_footer.php"); ?>