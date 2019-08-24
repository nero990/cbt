<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/connection.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php confirm_staff_login(); ?>

<?php
	$subj_id = $class_id = "";
	if(isset($_POST["add_quest"])){
		$subj_id = mysqli_prep(trim($_POST["subj_id"]));
		$class_id = mysqli_prep(trim($_POST["class_id"]));
		
		if(empty($class_id) || empty($subj_id)){
			$error_msgs[] = "There was a problem with the class/subject.";
		}
		
		for($count=1; $count<=10; $count++){
			if(!empty($_POST["question" . $count])){
				$questions[] = mysqli_prep(trim($_POST["question" . $count]));
				if(!empty($_POST["A" . $count]) && !empty($_POST["B" . $count]) && !empty($_POST["C" . $count]) && !empty($_POST["D" . $count])){
					$a[] = mysqli_prep(trim($_POST["A" . $count]));
					$b[] = mysqli_prep(trim($_POST["B" . $count]));
					$c[] = mysqli_prep(trim($_POST["C" . $count]));
					$d[] = mysqli_prep(trim($_POST["D" . $count]));
				}else{ $error_msgs[] = "An option wasn't selected, please check and try again."; }
				
				if(!empty($_POST["answer" . $count])){
					$answers[] = mysqli_prep(trim($_POST["answer" . $count]));
				}else { $error_msgs[] = "An answer wasn't selected, please check and try again."; }
			}
		}
		
		if(empty($error_msgs)){
			$total_question = count($questions);
			
			$query = "INSERT INTO cbt_questions (
								subj_id, class_id, question, a, b, c, d, answer
								) VALUES ";
			for($count=0; $count<$total_question; $count++){
				$query .= "('{$subj_id}', '{$class_id}', '{$questions[$count]}', '{$a[$count]}', '{$b[$count]}', '{$c[$count]}', '{$d[$count]}', '{$answers[$count]}')";
				if($count != ($total_question-1)){
					$query .= ", ";
				}
			}
			
			$mysqli->query($query) or confirm_query();
			if($mysqli->affected_rows >= 1){ $success = TRUE; }
			else { $success = FALSE; }
		}
		
		
	}
	elseif(isset($_REQUEST["_class"]) && !empty($_REQUEST["_class"]) && isset($_REQUEST["subject"]) && !empty($_REQUEST["subject"])){
		$subj_id = mysqli_prep(trim($_REQUEST["subject"]));
		$class_id = mysqli_prep(trim($_REQUEST["_class"]));
	}
	elseif(isset($_REQUEST["subject"]) && !empty($_REQUEST["subject"])){
		$subj_id = mysqli_prep(trim($_REQUEST["subject"]));
	}
?>
<?php 
	$title = "Add Questions";
	$page = "questions";
	$sub_page = "question_new";
	include_once("../includes/admin_header.php");
?>
<script>
	$(document).ready(function(){
		$('#cancel').click(function(){
			$(location).attr("href", "question_new.php");
		}); // end click
		
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
		
		$('#subj').change(function(){
			if ($(this).val() != ''){
				$('#subj-form').submit();
			}
		}); // end change
		
		$('#_class').change(function(){
			if ($(this).val() != ''){
				$('#subj-form').submit();
			}
		}); // end change
	}); // end ready
</script>
<!-- This is the main content of the site -->
<div class="main">
	<h2>Add Questions</h2>
	
	<?php if(!empty($class_id)){
		if(!empty($error_msgs)){
			foreach($error_msgs as $error_msg){
				echo "<p class='error_msg'>$error_msg</p>\n";
			}
		}elseif(isset($success) && $success == TRUE){
			echo "<div class='alert alert-success alert-dismissable'>
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'> &times; </button>
							<p>Success! Questions Added.</p>
						</div>";
		}
	?>
		<p class="msg">To add a question, type-in a question, type-in each of the options and finally, select the correct answer.</p>
		<table class="quest_details">
			<tr>
				<th>Subject:</th>
				<td><?php echo get_subj($subj_id); ?></td>
			</tr>
			<tr>
				<th>Class:</th>
				<td><?php echo get_class_name($class_id); ?></td>
			</tr>
		</table>
		<form method="POST" action="" class="form-horizontal" id="">
			<?php
				$query = "SELECT COUNT(*) FROM cbt_questions
								WHERE subj_id = '{$subj_id}'
								AND class_id = '{$class_id}'";
				$result = $mysqli->query($query) or confirm_query();
				$row = $result->fetch_array();
				$quest_start = $row[0] + 1;
				
				if($row[0]>=1){
					if($row[0]==1){
						$msg = $row[0] . " question ";
					}else{
						$msg = $row[0] . " questions ";
					}
					$msg .= "have been added already for the selected subject and class";
					echo "<p class='note'><span>Note</span>: $msg</p>\n";
				}
				for($i=1; $i<=10; $i++){
			?>
			<div class="question">
				<div class="form-group">
					<label for="" class="control-label col-lg-2">Question <?php echo $quest_start; ?></label>
					<div class="col-lg-5">
						<textarea name="question<?php echo $i; ?>" id="question<?php echo $i; ?>" placeholder="Enter Question <?php echo $quest_start; ?>." class="form-control"></textarea>
					</div>
				</div>
				<?php
					$opt = "ABCD";
					for($j=0; $j<4; $j++){
				?>
				<div class="form-group">
					<label for="<?php echo $opt[$j] . $i; ?>" class="control-label col-lg-2"><?php echo $opt[$j]; ?></label>
					<div class="col-lg-5">
						<input type="text" name="<?php echo $opt[$j] . $i; ?>" id="" value="" placeholder="Enter Option <?php echo $opt[$j]; ?>" class="form-control">
					</div>
				</div>
				<?php } ?>
				<div class="form-group">
					<label for="" class="control-label col-lg-2">Answer</label>
					<div class="col-lg-2">
						<select name="answer<?php echo $i ?>" class="form-control">
							<option>--Select--</option>
							<?php
								for($count=0; $count<4; $count++){
									echo "<option>" . $opt[$count]. "</option>";
								}
							?>
						</select>
					</div>
				</div>
			</div>
			<?php
				$quest_start++;
				} 
			?>
			<input type="hidden" name="subj_id" value="<?php echo $subj_id ?>">
			<input type="hidden" name="class_id" value="<?php echo $class_id ?>">
			<div class="form-group">
				<div class="col-lg-2"></div>
				<div class="col-lg-5">
					<input type="submit" name="add_quest" value="Add Questions" class="btn btn-primary">
					<button class="btn btn-warning" id="cancel">Cancel</button>
				</div>
			</div>
		</form>
		
	<?php }else { ?>
	
	<p class="msg">Select subject and class to add questions.</p>
	<form method="POST" action="" class="form-horizontal col-lg-6" id="subj-form">
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
						if(isset($_POST["subject"]) && !empty($_POST["subject"])){
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
	</form>
	<?php } ?>
</div>		
<?php include_once("../includes/admin_footer.php"); ?>