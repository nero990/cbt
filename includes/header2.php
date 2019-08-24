<h1>My Dashboard</h1>
<table class="cand-details">
	<tr>
		<th>Candidate's name:</th>
		<td><?php echo get_student_name($_SESSION["cbt_reg_no"]); ?></td>
	</tr>
	<tr>
		<th>Registration No.:</th>
		<td><?php echo $_SESSION["cbt_reg_no"]; ?></td>
	</tr>
	<tr>
		<th>Class:</th>
		<td><?php echo get_student_class($_SESSION["cbt_reg_no"]); ?></td>
	</tr>
</table>
<div class="clearfix"></div>
<div class="nav">
	<a href="index.php"><p <?php if($page=="exam"){ echo "class='cap'"; }?>>Take an Exam</p></a>
	<!--<ul class="submenu">
		<a href="questions.php"><li <?php //if($sub_page=="questions"){ echo "class='cap'"; }?>>All Questions</li></a>
		<a href="question_new.php"><li <?php //if($sub_page=="question_new"){ echo "class='cap'"; }?>>Add New</li></a>
	</ul>-->
	<a href="result_checker.php"><p <?php if($page=="result_checker"){ echo "class='cap'"; }?>>Check Result</p></a>
	<a href="cbt-admin/" target="_blank"><p>Switch to Admin Panel</p></a>
	<a href="logout.php"><p>Logout</p></a>
</div>