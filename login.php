<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php check_student_log_in(); ?>
<?php
	$reg_no = "";
	if(isset($_POST["login"]) && !empty($_POST["reg_no"])){
		$reg_no = mysqli_prep(trim($_POST["reg_no"]));
		
		$query = "SELECT * FROM cbt_students
						WHERE reg_no = '{$reg_no}'";
		$result = $mysqli->query($query) or confirm_query();
		if($result->num_rows == 1){
			$row = $result->fetch_assoc();
			$_SESSION["cbt_student_id"] = $row["student_id"];
			$_SESSION["cbt_reg_no"] = strtoupper($reg_no);
			redirect_to("index.php");
		}else{ $error_msgs[] = "Registration No. not valid, please check reg. No. and try again."; }
	}
?>
<?php include_once("includes/header.php"); ?>
<script>
	$(document).ready(function(){
		$('#login-form').validate({
			rules : {
				reg_no: {
					required: true
				}
			},
			messages : {
				reg_no: {
					required: "Enter Registration No."
				}
			}
		}); // end validate
	}); // end ready
</script>
<h1>Computer Based Test</h1>
<div class="clearfix"></div>
<h2>Student Login</h2>
<?php
	if(isset($error_msgs)){
		echo "<div class='alert alert-danger alert-dismissable'>
						<button type='button' class='close' data-dismiss='alert' aria-hidden='true'> &times; </button>";
		foreach($error_msgs as $error_msg){
			echo "<p style='font-size: 12px;'><em>$error_msg</em></p>";
		}
		echo "</div>";
	}
?>
<p class="note">Login with your registration number, if you don't have contact the admistrator for it.</p>
<form method="POST" action="" class="form-horizontal" id="login-form" style="min-height: 275px;">
	<div class="form-group">
		<label for="" class="control-label col-lg-2">Registration No.:</label>
		<div class="col-lg-4">
			<input type="text" name="reg_no" value="<?php echo $reg_no; ?>" placeholder="Please Enter Registration No." class="form-control">
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-2"></div>
		<div class="col-lg-4">
			<input type="submit" name="login" value="Login" class="btn btn-primary">
		</div>
	</div>
</form>
<p class="link"><a href="cbt-admin/" target="_blank">Click here to visit the admin panel</a></p>
<?php include_once("includes/footer.php"); ?>