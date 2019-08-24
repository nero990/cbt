<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/connection.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php confirm_staff_login(); ?>

<?php
		$subj_id = $class_id = "";
		
		if(isset($_REQUEST["subject"]) && !empty($_REQUEST["subject"]) && 
		isset($_REQUEST["_class"]) && !empty($_REQUEST["_class"])){
			$subj_id = mysqli_prep(trim($_REQUEST["subject"]));
			$class_id = mysqli_prep(trim($_REQUEST["_class"]));
			$form_mode = 2; // This variable changes the form id
		}elseif(isset($_REQUEST["subject"]) && !empty($_REQUEST["subject"])){
			$subj_id = mysqli_prep(trim($_REQUEST["subject"]));
			$form_mode = 2; // This variable changes the form id
		}
		
		if(isset($_POST["set_timer"])){
			$subj_id = mysqli_prep(trim($_POST["subject"]));
			$class_id = mysqli_prep(trim($_POST["_class"]));
			$timer = mysqli_prep(trim($_POST["timer"]));
			if(empty($subj_id)){ $error_msgs[] = "Please select subject."; }
			if(empty($class_id)){ $error_msgs[] = "Please select class."; }
			if(empty($timer)){ $error_msgs[] = "Please enter max time."; }
			
			if(empty($error_msgs)){
				$query = "UPDATE cbt_subjs_classes
								SET max_time = '{$timer}'
								WHERE subj_id = '{$subj_id}'
								AND class_id = '{$class_id}'
								LIMIT 1";
				$mysqli->query($query) or confirm_query();
				if($mysqli->affected_rows == 1){ 
					$success = TRUE; 
				}
				else { $success = FALSE; }
			}
		}
?>
<?php 
	$title = "Set Timer";
	$page = "questions";
	$sub_page = "timer";
	include_once("../includes/admin_header.php");
?>
<script>
	$(document).ready(function(){
		$('#subj-form').validate({
			rules: {
				subject: {
					required: true
				}
			},
			messages: {
				subject: {
					required: "Please select a subject."
				}
			}
		}); // end validate
		
		$('#timer-form').validate({
			rules: {
				subject: {
					required: true
				},
				_class: {
					required: true
				},
				timer: {
					required: true,
					time: true
				}
			},
			messages: {
				subject: {
					required: "Please select a subject."
				},
				_class: {
					required: "Please select a class."
				},
				timer: {
					required: "Please enter max time."
				}
			}
		}); // end validate
		
		$('#subj').change(function(){
			if ($(this).val() != ''){
				$('#subj-form').submit();
			}
		}); // end change
		
	}); // end ready
</script>
<!-- This is the main content of the site -->
<div class="main">
	<h2>Set Timer</h2>
	<?php
		if(!empty($error_msgs)){
			echo "<div class='alert alert-danger alert-dismissable'>\n
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'> &times; </button>\n
							<p>Error! There was a problem.</p>\n
							
							<ul>";
							foreach($error_msgs as $error_msg){
								echo "<li>{$error_msg}</li>";
							}
			echo "</ul>
					</div>\n";
		}elseif(isset($success)){
			if($success == TRUE){
				echo "<div class='alert alert-success alert-dismissable'>
								<button type='button' class='close' data-dismiss='alert' aria-hidden='true'> &times; </button>\n
								<p>Success! Timer set.</p>\n
							</div>\n";
			}else{
				echo "<div class='alert alert-info alert-dismissable'>
								<button type='button' class='close' data-dismiss='alert' aria-hidden='true'> &times; </button>\n
								<p>Opps! No changes made, please try again.</p>\n
							</div>\n";
			}
		}
	?>
	<p class="msg">Please select subject and class, then Type-in Maximum time in hours and minutes using HH:MM format.</p>
	<form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="form-horizontal col-lg-6" <?php if(isset($form_mode) && $form_mode == 2){ echo "id='timer-form'"; }else{ echo "id='subj-form'"; } ?>>
		<div class="form-group">
			<label for="subject" class="col-lg-4 control-label">Subject</label>
			<div class="col-lg-7">
				<select id="subj" name="subject" class="form-control">
					<option value="">--Select Subject--</option>
					<?php
						$query = "SELECT * FROM cbt_subjects ORDER BY subject ASC";
						$result = $mysqli->query($query) or confirm_query();
						while($row=$result->fetch_assoc()){
							$db_subj_id = $row["subj_id"];
							$subject = $row["subject"];
							
							echo "<option value='$db_subj_id'";
							if($db_subj_id == $subj_id){ echo " selected"; }
							echo ">$subject</option>\n";
						}
					?>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label for="subject" class="col-lg-4 control-label">Class</label>
			<div class="col-lg-5">
				<select id="_class" name="_class" class="form-control">
					<option value="">--Select Class--</option>
					<?php
						if(isset($_REQUEST["subject"]) && !empty($_REQUEST["subject"])){
							$query = "SELECT * FROM cbt_classes c
											NATURAL JOIN cbt_subjs_classes sc
											WHERE sc.subj_id = '{$subj_id}'
											ORDER BY c.class_id ASC";
							$result = $mysqli->query($query) or confirm_query();
							while($row=$result->fetch_assoc()){
								$db_class_id = $row["class_id"];
								$_class = $row["_class"];
								
								echo "<option value='$db_class_id'";
								if($db_class_id == $class_id){ echo " selected"; }
								echo ">$_class</option>\n";
							}
						}
					?>
				</select>
			</div>
		</div>
	
		<?php if(isset($form_mode) && $form_mode == 2){ ?>
		<div class="form-group">
			<label for="time" class="col-lg-4 control-label">Maximum Time</label>
			<div class="col-lg-5">
				<input type="text" name="timer" id="timer" value="" placeholder="Enter time in HH:MM" class="form-control">
			</div>
		</div>
		
		<div class="form-group">
			<div class="col-lg-4"></div>
			<div class="col-lg-5">
				<input type="submit" name="set_timer" value="Set Timer" class="btn btn-primary submit">
			</div>
		</div>
		<?php
			}
		?>
	</form>
	<div class="clearfix"></div>
</div>		
<?php include_once("../includes/admin_footer.php"); ?>