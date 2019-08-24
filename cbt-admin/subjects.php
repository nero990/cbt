<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/connection.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php confirm_staff_login(); ?>

<?php
	$subject = $class_id = "";
	$classes_id = array();
	
	if(isset($_GET["subj_id"]) && $_GET["subject"]){ 
		$form_state = "update";
		
		$subj_id = trim(mysqli_prep($_GET["subj_id"]));
		$subject = trim(mysqli_prep($_GET["subject"]));
		
		$query = "SELECT * FROM cbt_subjects
						WHERE subj_id = '{$subj_id}'
						AND subject = '{$subject}'";
		$result = $mysqli->query($query) or confirm_query();
		if($row = $result->fetch_assoc()){
			$subject = stripslashes($row["subject"]);
			
			$query = "SELECT * FROM cbt_subjs_classes
							WHERE subj_id = '{$subj_id}'";
			$result = $mysqli->query($query) or confirm_query();
			while($row = $result->fetch_assoc()){
				$classes_id[] = $row["class_id"];
			}
		}
	}else { 
		$form_state = "add";
	}
	
	if(isset($_POST["add_subj"]) || isset($_POST["update_subj"])){
		$subject = ucfirst(mysqli_prep(trim($_POST["subject"])));
		
		if(!empty($_POST["_class"])){
			$classes_id = $_POST["_class"];
		}else{
			$error_msgs[] = "Select atleast one class.";
		}
		
		if(isset($_POST["add_subj"])){
			// check if subj already exist
			$query = "SELECT COUNT(*) FROM cbt_subjects WHERE subject = '{$subject}'";
			$result = $mysqli->query($query) or confirm_query();
			$row = $result->fetch_array();
			if($row[0] == 1){
				$error_msgs[] = "Subject already exist.";
			}
			
			if(!empty($subject) && empty($error_msgs)){
				$query = "INSERT INTO cbt_subjects (subject) VALUES ('{$subject}')"
								or confirm_query();
				$mysqli->query($query) or confirm_query();
				$subj_id = $mysqli->insert_id;
				
				$query = "INSERT INTO cbt_subjs_classes (subj_id, class_id) VALUES ";
				
				$array_size = count($classes_id);
				$count=1;
				foreach($classes_id as $class_id){
					$query .= "({$subj_id}, {$class_id})";
					if($count<$array_size){ $query .= ", "; }
					$count++;
				}
				$mysqli->query($query) or confirm_query();
				$subject = $class_id = "";
			}
		}elseif(isset($_POST["update_subj"])){
			// check if subj already exist
			$query = "SELECT COUNT(*) FROM cbt_subjects 
							WHERE subj_id != '{$subj_id}'
							AND subject = '{$subject}'";
			$result = $mysqli->query($query) or confirm_query();
			$row = $result->fetch_array();
			if($row[0] == 1){
				$error_msgs[] = "Subject already exist.";
			}
			
			if(!empty($subject) && empty($error_msgs)){
				// Update cbt_subjects table
				$query = "UPDATE cbt_subjects
								SET subject = '{$subject}'
								WHERE subj_id = '{$subj_id}'";
				$mysqli->query($query) or confirm_query();
				
				// Delete existing record before doing an update on cbt_subjs_classes
				$query = "DELETE FROM cbt_subjs_classes
								WHERE subj_id = '{$subj_id}'";
				$mysqli->query($query) or confirm_query();
				
				// Do an insert
				$query = "INSERT INTO cbt_subjs_classes (subj_id, class_id) VALUES ";
				
				$array_size = count($classes_id);
				$count=1;
				foreach($classes_id as $class_id){
					$query .= "({$subj_id}, {$class_id})";
					if($count<$array_size){ $query .= ", "; }
					$count++;
				}
				$mysqli->query($query) or confirm_query();
				$subject = $class_id = "";
				$classes_id = array();
				$success = TRUE;
				$form_state = "add";
			}
		}
	}
?>
<?php
	$title = "Subject";
	$page = "subjects";
	include_once("../includes/admin_header.php") 
?>
<script>
	$(document).ready(function(){
		$('#subj_form').validate({
			rules : {
				subject : {
					required: true,
					maxlength: 40
				},
				_class : {
					required: true
				}
			},
			messages : {
				subject : {
					required: 'Subject is required.',
					maxlength: 'Subject cannot be longer than 40 characters.'
				},
				_class : {
					required: "Select atleast one class."
				}
			}
		}); // end validate
	});

</script>

<!-- This is the main content of the site -->
<div class="main">
	<h2>Subjects</h2>
	<div class="col-lg-4">
		<?php 
			if($form_state=="add"){
				$form_msg = "Add New Subject";
			}else{ $form_msg = "Update Subject"; }
			
			echo "<p><strong>$form_msg</strong></p>";
		?>
		<?php
			if(isset($error_msgs)){
				foreach($error_msgs as $error_msg){
					echo "<p class='error_msg'>$error_msg</p>\n";
				}
			}elseif(isset($success) && $success == TRUE){
				echo "<div class='alert alert-success alert-dismissable'>
								<button type='button' class='close' data-dismiss='alert' aria-hidden='true'> &times; </button>
								<p>Success! Subject updated.</p>
							</div>";
			}
		?>
		<form method="POST" action="" class="form-horizontal" role="form" id="subj_form">
			<div class="form-group">
				<label class="col-lg-3 control-label">Subject</label>
				<div class="col-lg-9">
					<input type="text" id="subject" name="subject" value="<?php echo $subject; ?>" placeholder="Enter the name of a subject" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label for="class" class="col-lg-3 control-label">Classes</label>
				<div class="col-lg-9">
					<select name="_class[]" class="form-control" size="7" multiple>
						<?php 
							$query = "SELECT * FROM cbt_classes ORDER BY class_id ASC" or confirm_query();
							$result = $mysqli->query($query);
							while($row = $result->fetch_assoc()){
								$db_class_id = $row["class_id"];
								$_class = $row["_class"];
								
								echo "<option value='$db_class_id'";
								foreach($classes_id as $class_id){
									if($db_class_id == $class_id){ echo " selected"; }
								}
								echo ">$_class</option>";
							}
						?>
					</select>
					<p>Specify the classes which offers the subject</p>
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-3"></div>
				<div class="col-lg-9">
					<input type="submit" id="add_subj" name="<?php echo $form_state; ?>_subj" value="<?php echo $form_msg; ?>" class="btn btn-primary">
				</div>
			</div>
		</form>
	</div>
	
	<div class="col-lg-8 student-list">
		<table class="table table-stripped">
			<thead>
				<tr>
					<th>S/N</th>
					<th>Subjects</th>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$query = "SELECT * FROM cbt_subjects ORDER BY subject" or confirm_query();
					$result = $mysqli->query($query);
					$count = 1;
					while($row = $result->fetch_assoc()){
						$subj_id = $row["subj_id"];
						$subj = $row["subject"];
						echo "<tr>
										<td>$count.</td>
										<td>$subj</td>
										<td><a href='?subj_id=$subj_id&amp;subject=" . urlencode($subj) . "'>Update</a></td>
										<td><a href='#'>Delete</a></td>
									</tr>";
						$count++;
					}
				?>
			</tbody>
		</table>
	</div>
</div>		
<?php include_once("../includes/admin_footer.php"); ?>