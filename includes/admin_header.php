<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		
		<link rel="stylesheet" href="../css/bootstrap.min.css">
		<link rel="stylesheet" href="../css/admin_style.css">
		
		<link rel="stylesheet" href="../css/jquery-ui.min.css">
		<link rel="stylesheet" href="../css/jquery-ui.structure.min.css">
		<link rel="stylesheet" href="../css/jquery-ui.theme.min.css">
		
		<script src="../js/jquery.min.js"></script>
		<script src="../js/jquery-ui.min.js"></script>
		<script src="../js/jquery_validate/jquery.validate.min.js"></script>
		<script src="../js/jquery_validate/additional-methods.min.js"></script>
		<script>
			$(document).ready(function(){
				
			});
		</script>
		<title>Computer Based Test</title>
	</head>
	<body>
		<div class="wrapper">
			<!-- This is the header of the site -->
			<div class="header">
				<h1>Computer Based Test</h1>
				<p class="text">Admin Panel<p>
			</div>
			
			<!-- This is the navigation side bar -->
			<div class="nav">
				<a href="student_new.php"><p <?php if($page=="students"){ echo "class='cap'"; } ?>>Students</p></a>
					<ul class="submenu <?php if($page=="students"){ echo " active"; } ?>" >
						<a href="student_new.php"><li <?php if($sub_page=="student_new"){ echo "class='cap'"; }?>>Add Student</li></a>
						<a href="students.php"><li <?php if($sub_page=="students"){ echo "class='cap'"; }?>>Students</li></a>
					</ul>
				<a href="classes.php"><p <?php if($page=="classes"){ echo "class='cap'"; }?>>Classes</p></a>
				<a href="subjects.php"><p <?php if($page=="subjects"){ echo "class='cap'"; }?>>Subjects</p></a>
				<a href="questions.php"><p <?php if($page=="questions"){ echo "class='cap'"; }?>>Questions</p></a>
					<ul class="submenu <?php if($page=="questions"){ echo " active"; } ?>">
						<a href="questions.php"><li <?php if($sub_page=="questions"){ echo "class='cap'"; }?>>All Questions</li></a>
						<a href="question_new.php"><li <?php if($sub_page=="question_new"){ echo "class='cap'"; }?>>Add New</li></a>
						<a href="timer.php"><li <?php if($sub_page=="timer"){ echo "class='cap'"; }?>>Set Timer</li></a>
					</ul>
				<a href="ongoing_test.php"><p <?php if($page=="ongoing_test"){ echo "class='cap'"; }?>>Ongoing Test</p></a>
				<a href="results.php"><p <?php if($page=="results"){ echo "class='cap'"; }?>>Results</p></a>
				<a href="users.php"><p <?php if($page=="users"){ echo "class='cap'"; }?>>Users</p></a>
				<a href="../index.php" target="_blank"><p>Switch to Student Area</p></a>
				<a href="logout.php"><p <?php if($page=="logout"){ echo "class='cap'"; }?>>Logout</p></a>
			</div>
			