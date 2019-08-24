<?php
	require_once("connection.php");
	require_once("functions.php");
	
	if(isset($_POST["username"])){
		$username = mysqli_prep(trim($_POST["username"]));
		
		$query = "SELECT username FROM cbt_users
						WHERE username = '{$username}'";
		$result = $mysqli->query($query) or confirm_query();
		if($result->num_rows == 0){ echo "true"; }
		else{ echo "false"; }
	}else{ redirect_to("../cbt-admin/index.php"); }
?>