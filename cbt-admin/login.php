<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php check_staff_log_in(); ?>
<?php
	$username = "";
	$error_msgs = array();
	if(isset($_POST['sign_in'])){
		$username = mysqli_prep(trim($_POST['username']));
		$hashed_password = sha1(mysqli_prep(trim($_POST['password'])));
		
		$query = "SELECT user_id, username
						FROM cbt_users 
						WHERE username = '{$username}'
						AND hashed_password = '{$hashed_password}'
						LIMIT 1";
		$users_set = $mysqli->query($query) or confirm_query();
		if($users = $users_set->fetch_assoc()){
			$_SESSION['cbt_user_id'] = $users['user_id'];
			$_SESSION['cbt_username'] = $users['username'];
			redirect_to("index.php");
		}else{
			$error_msgs[] = "Username or password not valid";
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="Sign-in" content="">
    <meta name="author" content="">
    <link rel="icon" href="images/favicon.ico">

    <title>CBT | Signin</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../assets/js/ie-emulation-modes-warning.js"></script>
  </head>

  <body>
    <div class="container">

      <form method="POST" action="" class="form-signin">
        <h2 class="form-signin-heading">Please sign in</h2>
        <?php
					if(!empty($error_msgs)){
						echo "<div class='alert alert-danger alert-dismissable'>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'> &times; </button>";
						foreach($error_msgs as $error_msg){
							echo "<p style='font-size: 12px;'><em>$error_msg</em></p>";
						}
						echo "</div>";
					}
				?>
				<label for="inputEmail" class="sr-only">username</label>
        <input type="text" id="inputEmail" name="username" class="form-control" placeholder="Username" value="<?php echo $username ?>" required autofocus>
        
				<label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
        
        <button class="btn btn-lg btn-primary btn-block" name="sign_in" type="submit">Sign in</button>
				<p style="margin-top: 10px;"><a href="../index.php" target="_blank">Click here </a>to return to the student area.</p>
			</form>
			
    </div> <!-- /container -->
  </body>
</html>