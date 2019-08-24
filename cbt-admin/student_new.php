<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_staff_login(); ?>

<?php
	$surname = $other_names = $class_id = "";
	
	if(isset($_GET["reg_no"])){ 
		$form_state = "update";
		
		$reg_no = trim(mysqli_prep($_GET["reg_no"]));
		
		$query = "SELECT * FROM cbt_students
						WHERE reg_no = '{$reg_no}'";
		$result = $mysqli->query($query) or confirm_query();
		if($row = $result->fetch_assoc()){
			$surname = stripslashes($row["surname"]);
			$other_names = stripslashes($row["other_names"]);
			$class_id = $row["class_id"];
		}
	}
	else { 
		$form_state = "add";
	}
	
	if(isset($_POST["add_student"]) || isset($_POST["update_student"])){
		$surname = mysqli_prep(strtoupper(trim($_POST["surname"])));
		$other_names = mysqli_prep(strtoupper(trim($_POST["other_names"])));
		$class_id = mysqli_prep(strtoupper(trim($_POST["_class"])));
		
		if(isset($_POST["add_student"])){
			// Generating reg_no
			do{
				$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$rand_string = "";
				for($count=0; $count<2; $count++){
					$rand_string .= $characters[mt_rand(0, 25)];
				}
				$year = date("Y", time()+(60*60));
				$arr = str_split($year);
				
				$reg_no = $arr["3"] . mt_rand(1111111, 9999999) . $rand_string;
				
				// check if reg_no already exist
				$query = "SELECT COUNT(*) FROM cbt_students WHERE reg_no = '{$reg_no}' LIMIT 1";
				$result = $mysqli->query($query) or confirm_query();
				$row = $result->fetch_array();
			}while($row[0] == 1);
			
			// insert record into the database
			$query = "INSERT INTO cbt_students (
									surname, other_names, class_id, reg_no
									) VALUES (
											'{$surname}', '{$other_names}', '{$class_id}', '{$reg_no}'
										)";
			$result = $mysqli->query($query) or confirm_query();
			$surname = $other_names = $class_id = "";
		}
		elseif(isset($_POST["update_student"])){
			$query = "UPDATE cbt_students
							SET surname = '{$surname}',
									other_names = '{$other_names}',
									class_id = '{$class_id}'
							WHERE reg_no = '{$reg_no}'
							LIMIT 1";
			$result = $mysqli->query($query) or confirm_query();
		}
	}
?>
<?php 
	$title = "Add a Student";
	$page = "students";
	$sub_page = "student_new";
	include_once("../includes/admin_header.php");
?>
<script>
	$(document).ready(function(){
		$('#student_form').validate({
			rules : {
				surname : {
					required: true,
					maxlength: 25
				},
				other_names : {
					required: true,
					maxlength: 50
				},
				_class : {
					required: true
				}
			},
			messages : {
				surname : {
					required: "Surname is required.",
					maxlength: "Surname must not be longer than 25 characters."
				},
				other_names : {
					required: "Other name is required.",
					maxlength: "Other names must not be longer than 50 characters."
				},
				_class : {
					required: "Select a class."
				}
			}
		}); // end validate
	}); // end ready
</script>
<!-- This is the main content of the site -->
<div class="main">
	<h2>Students</h2>
	
	<div class="col-lg-5">
		<?php 
			if($form_state=="add"){
				$form_msg = "Add New Student";
			}else{ $form_msg = "Update Student's Record"; }
			
			echo "<p><strong>$form_msg</strong></p>";
		?>
		
		<form method="POST" action="" class="form-horizontal" role="form" id="student_form">
			<div class="form-group">
				<label for="surname" class="col-lg-4 control-label">Surname</label>
				<div class="col-lg-8">
					<input type="text" id="surname" name="surname" value="<?php echo $surname; ?>" placeholder="Enter the student's surname" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label for="other_names" class="col-lg-4 control-label">Other Names</label>
				<div class="col-lg-8">
					<input type="text" id="other_names" name="other_names" value="<?php echo $other_names; ?>" placeholder="Enter the student's other names" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label for="_class" class="col-lg-4 control-label">Class</label>
				<div class="col-lg-5">
					<select name="_class" class="form-control">
						<option value="">--Select class--</option>
						<?php 
							$query = "SELECT * FROM cbt_classes ORDER BY class_id ASC" or confirm_query();
							$result = $mysqli->query($query);
							while($row = $result->fetch_assoc()){
								$db_class_id = $row["class_id"];
								$_class = $row["_class"];
								
								echo "<option value='$db_class_id'";
								if($db_class_id == $class_id){ echo " selected"; }
								echo ">$_class</option>";
							}
						?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-4"></div>
				<div class="col-lg-8">
					<input type="submit" id="add_student" name="<?php echo $form_state; ?>_student" value="<?php echo $form_msg; ?>" class="btn btn-primary">
				</div>
			</div>
		</form>
	</div>
	
	<div class="col-lg-7 student-list">
		<table class="table table-stripped">
			<thead>
				<tr>
					<th>S/N</th>
					<th>Name</th>
					<th>Class</th>
					<th>Reg No.</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$query = "SELECT * FROM cbt_students s
									NATURAL JOIN cbt_classes c
									ORDER BY s.surname";
					$result = $mysqli->query($query) or confirm_query();
					$count = 1;
					while($row = $result->fetch_assoc()){
						$name = stripslashes($row["surname"]) . " " . stripslashes($row["other_names"]);
						$class = $row["_class"];
						$reg_no = $row["reg_no"];
						
						echo "<tr>
										<td>$count.</td>
										<td>$name</td>
										<td>$class</td>
										<td>$reg_no</td>
										<td><a href='?reg_no=$reg_no'>Update</a></td>
									</tr>";
						$count++;
					}
				?>
			</tbody>
		</table>
	</div>
	
</div>		
<?php include_once("../includes/admin_footer.php"); ?>