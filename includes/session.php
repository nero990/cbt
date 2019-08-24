<?php
	session_start();
	
	function confirm_student_login(){
		if(!isset($_SESSION["cbt_reg_no"])){
			header("Location: login.php");
			exit;
		}
	}
	function check_student_log_in(){
		if(isset($_SESSION['cbt_reg_no'])){
			redirect_to("index.php");
		}
	}
	
	function confirm_staff_login(){
		if(!isset($_SESSION["cbt_user_id"])){
			header("Location: login.php");
			exit;
		}
	}
	function check_staff_log_in(){
		if(isset($_SESSION['cbt_user_id'])){
			redirect_to("index.php");
		}
	}
	
?>