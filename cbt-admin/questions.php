<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/connection.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php confirm_staff_login(); ?>

<?php
		$subj_id = $class_id = "";
		
		if(isset($_REQUEST["_class"]) && !empty($_REQUEST["_class"]) && isset($_REQUEST["subject"]) && !empty($_REQUEST["subject"])){
			$subj_id = mysqli_prep(trim($_REQUEST["subject"]));
			$class_id = mysqli_prep(trim($_REQUEST["_class"]));
		}elseif(isset($_REQUEST["subject"]) && !empty($_REQUEST["subject"])){
			$subj_id = mysqli_prep(trim($_REQUEST["subject"]));
		}
		
		// This deletes a question
		if(isset($_GET["quest_id"]) && isset($_GET["delete"]) && $_GET["delete"] == "true"){
			$quest_id = mysqli_prep($_GET["quest_id"]);
			
			if(!is_numeric($quest_id)){
				$error_msg = "Oops! An error occured, please try again.";
			}else{
				$query = "DELETE FROM cbt_students_answers
								WHERE quest_id = '{$quest_id}'";
				$mysqli->query($query) or confirm_query();
				
				$query = "DELETE FROM cbt_questions
								WHERE quest_id = '{$quest_id}'
								LIMIT 1";
				$mysqli->query($query) or confirm_query();
				if($mysqli->affected_rows == 1){ $success_msg = "Question deleted"; }
				else{ $error_msg = "Oops! An error occured, please try again."; }
			}
		}
		
		if(isset($_POST["update"])){
			$question = mysqli_prep(ucfirst(trim($_POST["question"])));
			$quest_id = mysqli_prep(ucfirst(trim($_POST["quest_id"])));
			$a = mysqli_prep(ucfirst(trim($_POST["A"])));
			$b = mysqli_prep(ucfirst(trim($_POST["B"])));
			$c = mysqli_prep(ucfirst(trim($_POST["C"])));
			$d = mysqli_prep(ucfirst(trim($_POST["D"])));
			$answer = mysqli_prep(ucfirst(trim($_POST["answer"])));
			
			$query = "UPDATE cbt_questions
							SET question = '{$question}',
									a = '{$a}',
									b = '{$b}',
									c = '{$c}',
									d = '{$d}',
									answer = '{$answer}'
							WHERE quest_id = '{$quest_id}'";
			
			$mysqli->query($query) or confirm_query();
			if($mysqli->affected_rows == 1){ $success = TRUE; }
			else{ $success = FALSE; }
			
		}
?>
<?php 
	$title = "Questions";
	$page = "questions";
	$sub_page = "questions";
	include_once("../includes/admin_header.php");
?>
<script>
	$(document).ready(function(){
		$('#cancel').click(function(){
			$(location).attr("href", "questions.php");
			return false;
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
		
		var url; // this variable was made global so that it can be accessed anywhere
		
		$('.delete').click(function(){
			$('#delete-box').dialog('open');
			url = $(this).attr('href');
			return false;
		}); // end click
		
		$('#delete-box').dialog({
			autoOpen: false,
			modal: true,
			resizable: false,
			buttons: {
				"Yes" : function(){
					$(location).attr('href', url); // this gets the url from the <a> tag
				},
				"No" : function(){
					$(this).dialog('close');
				}
			}
		}); // end dialog
	}); // end ready
</script>
<!-- This is the main content of the site -->
<div class="main">
	<h2>Questions</h2>
	<?php
		if(!empty($error_msg)){
			echo "<div class='alert alert-danger alert-dismissable'>
								<button type='button' class='close' data-dismiss='alert' aria-hidden='true'> &times; </button>\n
								<p>Error! {$error_msg}</p>\n
					</div>\n";
		}
		elseif(isset($success_msg)){
			echo "<div class='alert alert-success alert-dismissable'>
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'> &times; </button>\n
							<p>Success! {$success_msg}</p>\n
						</div>\n";
		}elseif(isset($success)){
			if($success == TRUE){
				echo "<div class='alert alert-success alert-dismissable'>
								<button type='button' class='close' data-dismiss='alert' aria-hidden='true'> &times; </button>\n
								<p>Success! Question updated.</p>\n
							</div>\n";
			}else{
				echo "<div class='alert alert-info alert-dismissable'>
								<button type='button' class='close' data-dismiss='alert' aria-hidden='true'> &times; </button>\n
								<p>Opps! No changes made.</p>\n
							</div>\n";
			}
		}
	?>
	<p class="msg">Select subject and class to view questions.</p>
	<form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="form-horizontal col-lg-6" id="subj-form">
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
	</form>
	<div class="clearfix"></div>
	<?php
		if(isset($_GET["quest_id"]) && isset($_GET["edit"]) && $_GET["edit"] == "true"){ // This edit a question
			$quest_id = mysqli_prep($_GET["quest_id"]);
			
			$query = "SELECT * FROM cbt_questions
							WHERE quest_id = '{$quest_id}'
							LIMIT 1";
			$questions_set = $mysqli->query($query) or confirm_query();
			if($questions = $questions_set->fetch_assoc()){
				$quest_id = stripslashes($questions["quest_id"]);
				$question = stripslashes($questions["question"]);
				$a = stripslashes($questions["a"]);
				$b = stripslashes($questions["b"]);
				$c = stripslashes($questions["c"]);
				$d = stripslashes($questions["d"]);
				$ans = stripslashes($questions["answer"]);
				$options = array($a, $b, $c, $d);
			}else{ redirect_to($_SERVER["PHP_SELF"]); }
			
	?>
	<form action="" method="POST" class="form-horizontal">
		<input type="hidden" name="quest_id" value="<?php echo $quest_id; ?>">
		<div class="question">
			<div class="form-group">
				<label for="question" class="control-label col-lg-2">Question</label>
				<div class="col-lg-5">
					<textarea name="question" id="question" placeholder="Enter a Question." class="form-control"><?php echo $question; ?></textarea>
				</div>
			</div>
			<?php
				$opt = "ABCD";
				for($j=0; $j<4; $j++){
			?>
			<div class="form-group">
				<label for="<" class="control-label col-lg-2"><?php echo $opt[$j]; ?></label>
				<div class="col-lg-5">
					<input type="text" name="<?php echo $opt[$j]; ?>" id="" value="<?php echo $options[$j]; ?>" placeholder="Enter Option <?php echo $opt[$j]; ?>" class="form-control">
				</div>
			</div>
			<?php } ?>
			<div class="form-group">
				<label for="answer" class="control-label col-lg-2">Answer</label>
				<div class="col-lg-2">
					<select name="answer" class="form-control">
						<option>--Select--</option>
						<?php
							for($count=0; $count<4; $count++){
								echo "<option";
								if($ans == $opt[$count]){ echo " selected"; }
								echo ">" . $opt[$count]. "</option>";
							}
						?>
					</select>
				</div>
			</div>
		</div>
			
		<div class="form-group">
			<div class="col-lg-2"></div>
			<div class="col-lg-4">
				<input type="submit" name="update" value="Update" class="btn btn-primary">
				<button class="btn btn-warning" id="cancel">Cancel</button>
			</div>
		</div>
			
	</form>
	<?php
		}
		
		elseif(isset($_REQUEST["_class"]) && !empty($_REQUEST["_class"]) && isset($_REQUEST["subject"]) && !empty($_REQUEST["subject"])){ // This displays the questions and their respective answers
			$query = "SELECT * FROM cbt_questions
							WHERE subj_id = '{$subj_id}'
							AND class_id = '{$class_id}'";
			$questions_set = $mysqli->query($query) or confirm_query();
			
			$count = 1;
			$option1 = $option2 = $option3 = $option4 = "_not";
			
			if($questions_set->num_rows >= 1){ // there exist a question
				{ // This block displays the timer
					$query = "SELECT * FROM cbt_subjs_classes
									WHERE subj_id = '{$subj_id}'
									AND class_id = '{$class_id}'
									LIMIT 1";
					$subjs_classes_set = $mysqli->query($query) or confirm_query();
					$subjs_classes = $subjs_classes_set->fetch_assoc();
					if(empty($subjs_classes["max_time"])){
						echo "<p class='timer'>Time not set yet</p>";
						echo "<p style='text-align: center;'><a href='timer.php?subject=$subj_id&_class=$class_id'>Click here</a> to set the time</p>";
						echo "<p style='text-align: center; color: #F00;'>Note: If no time is specified, the default time will be use (That is 30 minutes).</p>";
					}else{
						$max_time = new DateTime($subjs_classes["max_time"]);
						$max_time = $max_time->format('G:i');

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
								
						echo "<p class='timer'>Time allocated for this Test: <span>{$max_time}</span></p>";
						echo "<p style='text-align: center;'><a href='timer.php?subject=$subj_id&_class=$class_id'>Click here</a> to update the time</p>";
					}
					
				}
				
				echo "<div class='col-lg-12 question-div'>
								<table class='table question'>";
								
				while($questions = $questions_set->fetch_assoc()){
					$quest_id = stripslashes($questions["quest_id"]);
					$question = stripslashes($questions["question"]);
					$a = stripslashes($questions["a"]);
					$b = stripslashes($questions["b"]);
					$c = stripslashes($questions["c"]);
					$d = stripslashes($questions["d"]);
					$answer = stripslashes($questions["answer"]);
					
					switch($answer){
						case "A": 
								$option1 = "ans";
								break;
						case "B":
								$option2 = "ans";
								break;
						case "C":
								$option3 = "ans";
								break;
						case "D":
								$option4 = "ans";
								break;
					}
					
					echo "<tr>
									<th width='12%'>Question {$count}:</th>
									<td>$question</td>
								</tr>
								<tr class='$option1'>
									<th>A:</th>
									<td>$a</td>
								</tr>
								<tr class='$option2'>
									<th>B:</th>
									<td>$b</td>
								</tr>
								<tr class='$option3'>
									<th>C:</th>
									<td>$c</td>
								</tr>
								<tr class='$option4'>
									<th>D:</th>
									<td>$d</td>
								</tr>
								<tr>
									<td colspan='2' class='text-center end'>
										<a href='?quest_id=$quest_id&amp;edit=true&amp;_class=$class_id&amp;subject=$subj_id'>Edit</a>	|	
										<a href='?quest_id=$quest_id&amp;delete=true&amp;_class=$class_id&amp;subject=$subj_id' class='delete'>Delete</a>
									</td>
								</tr>";
					$count++;
					$option1 = $option2 = $option3 =$option4 = "_not";
				}
				echo "</table>
						</div>";
			}else{ // No question
				echo "<div class='col-lg-7'>
								<p class='timer'>No Question set yet.</p>
								<p style='text-align: center;'><a href='question_new.php?subject=$subj_id&_class=$class_id'>Click here</a> to set question.</p>
						</div>";
			}
			
	?>
	<div id="delete-box" title="Confirm Delete">
		<p>Are you sure you want to delete this question?</p>
	</div>
	<?php
		}
	?>
</div>		
<?php include_once("../includes/admin_footer.php"); ?>