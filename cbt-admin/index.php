<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_staff_login(); ?>
<?php 
	$title = "";
	$page = "home";
	include_once("../includes/admin_header.php");
?>
<!-- This is the main content of the site -->
<div class="main">
	<h2>Welcome</h2>
	<p class="welcome_msg">You are welcome to the admin panel, you  logged in as <strong><em><?php echo $_SESSION["cbt_username"]; ?><em></strong></p>
	
	<div class="col-lg-6">
		<div class="panel panel-success"> 
			<div class="panel-heading"> 
				<h3 class="panel-title">Tip?</h3> 
			</div> 
			<div class="panel-body">
				<p style="margin: 5px 10px; font-size: 17px;">To begin a tour, please click on any of the modules from the left-hand panel</p>
			</div>
		</div>
	</div>
</div>		
<?php include_once("../includes/admin_footer.php"); ?>