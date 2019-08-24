<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/connection.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php confirm_staff_login(); ?>
<?php
	$username = $password = $r_password = $hint = "";
	if(isset($_POST["add_user"])){
		$username = mysqli_prep(trim(strtolower($_POST["username"])));
		$password = mysqli_prep(trim($_POST["password"]));
		$r_password = mysqli_prep(trim($_POST["r_password"]));
		$hint = mysqli_prep(trim($_POST["hint"]));
		
		if(empty($username)){
			$error_msgs[] = "Username is required."; 
		}else{
			$query = "SELECT username FROM cbt_users WHERE username = '{$username}' LIMIT 1";
			$result = $mysqli->query($query) or confirm_query();
			if($result->num_rows == 1){ $error_msgs[] = "Username already exist, please choose another."; }
		}
		
		if(empty($password)){ $error_msgs[] = "Password is required."; }
		if(empty($hint)){ $error_msgs[] = "Password hint is required."; }
		if($password != $r_password){ "The passwords you entered don't match. Try again."; }
		
		if(empty($error_msgs)){
			$hashed_password = sha1($password);
			$date_created = date("Y-m-d H:i:s", time() + 60*60);
			$creator_id = $_SESSION["cbt_user_id"];
			
			$query = "INSERT INTO cbt_users (
									username, hashed_password, hint, date_created, creator_id
										) VALUES (
											'{$username}', '{$hashed_password}', '{$hint}', '{$date_created}', '{$creator_id}'
											)";
			$mysqli->query($query) or confirm_query();
			if($mysqli->affected_rows == 1){ $success = TRUE; }
			else{ $success = FALSE; }
		}
	}
?>
<?php
	$title = "User Account";
	$page = "user";
	include_once("../includes/admin_header.php") 
?>
<script>
	$(document).ready(function(){
		$('#user_form').validate({
			rules : {
				username  : {
					required: true,
					maxlength: 20,
					remote: {
						url: "../includes/check_user.php",
						type: "POST"
					}
				},
				password : {
					required: true,
					rangelength: [8, 20]
				},
				r_password : {
					equalTo: '#password'
				},
				hint : {
					required: true,
					maxlength: 30
				}
			},
			messages : {
				username  : {
					required: "Username is required.",
					maxlength: "Username must not be longer than 20 characters.",
					remote: "Username already exist, please choose another."
				},
				password : {
					required: "Password is required.",
					rangelength: "Password must be between 8 and 20 characters long."
				},
				r_password : {
					equalTo: "The passwords you entered don't match. Try again."
				},
				hint : {
					required: "Password hint is required.",
					maxlength: "Password hint must not be longer than 30 characters."
				}
			}
		}); // end validate
	});
</script>

<!-- This is the main content of the site -->
<div class="main">
	<h2>Add a User</h2>
	<div class="col-lg-6">
		<p><em>Choose a password that will be easy for you to remember but difficult for others to guess. If you forget, we will show you the hint.</em></p>
		
		<?php
			if(isset($error_msgs)){
				foreach($error_msgs as $error_msg){
					echo "<p class='error_msg'>$error_msg</p>\n";
				}
			}elseif(isset($success)){
				if($success == TRUE){
					echo "<div class='alert alert-success alert-dismissable'>
									<button type='button' class='close' data-dismiss='alert' aria-hidden='true'> &times; </button>
									<p>Success! Account Created.</p>
								</div>";
				}else{
					echo "<div class='alert alert-info alert-dismissable'>
									<button type='button' class='close' data-dismiss='alert' aria-hidden='true'> &times; </button>
									<p>Error! Account Failed, Try again.</p>
								</div>";
				}
			}
		?>
		<form method="POST" action="" class="form-horizontal" role="form" id="user_form">
			<div class="form-group">
				<label class="col-lg-4 control-label">Username</label>
				<div class="col-lg-8">
					<input type="text" id="username" name="username" value="<?php echo $username; ?>" placeholder="Enter username" class="form-control">
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-lg-4 control-label">Password</label>
				<div class="col-lg-8">
					<input type="password" id="password" name="password" value="<?php echo $password; ?>" placeholder="Enter password" class="form-control">
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-lg-4 control-label">Reenter Password</label>
				<div class="col-lg-8">
					<input type="password" id="r_password" name="r_password" value="<?php echo $r_password; ?>" placeholder="Reenter password" class="form-control">
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-lg-4 control-label">Password hint</label>
				<div class="col-lg-8">
					<input type="text" id="hint" name="hint" value="<?php echo $hint; ?>" placeholder="Enter password hint" class="form-control">
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-lg-4"></div>
				<div class="col-lg-8">
					<input type="submit" id="add_subj" name="add_user" value="Add User" class="btn btn-primary">
				</div>
			</div>
		</form>
	</div>
	
	<div class="col-lg-6">
		<table class="table table-stripped">
			<thead>
				<tr>
					<th>S/N</th>
					<th>Username</th>
					<th>Date Created</th>
					<th>Creator</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$query = "SELECT * FROM cbt_users ORDER BY username";
					$result = $mysqli->query($query) or confirm_query();
					$count = 1;
					while($row = $result->fetch_assoc()){
						$username = $row["username"];
						$creator = get_username($row["creator_id"]);
						$date = DateTime::createFromFormat("Y-m-d H:i:s", $row["date_created"]);
						$date = $date->format("j-M-Y");
						echo "<tr>
										<td>$count.</td>
										<td>$username</td>
										<td>$date</td>
										<td>$creator</td>
									</tr>";
						$count++;
					}
				?>
			</tbody>
		</table>
	</div>
</div>		
<?php include_once("../includes/admin_footer.php"); ?>