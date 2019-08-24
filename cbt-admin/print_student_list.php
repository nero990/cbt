<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_staff_login(); ?>


<!doctype html>
<html>
	<head>
		<link href="../css/bootstrap.min.css" rel="stylesheet">
		<title>Student Result</title>
		<style>
			*{ margin: 0; font-family: cambria;	}
			.container{
				width: 680px;
			}
			h1{
				font-weight: bold;
				font-size: 26px;
			}
			.class-table{
				font-size: 18px;
				font-weight: bold;
				margin-bottom: 5px;
			}
			.class-table td{
				padding: 2px;
			}
			.class-table td:first-of-type{
				text-align: right;
			}
		</style>
	</head>
	<body onload="javascript:window.print()">
		<div class="container">
			<?php
				$class_id = "";
				if(isset($_REQUEST["_class"]) && !empty($_REQUEST["_class"])){
					$class_id = mysqli_prep(trim($_REQUEST["_class"]));
					
					echo "<div class='col-lg-12'>
									<h1>Students List</h1>";
											
					$query = "SELECT * FROM cbt_students s
									NATURAL JOIN cbt_classes c
									WHERE s.class_id = '{$class_id}'
									ORDER BY s.surname ASC, s.other_names ASC";
					$result = $mysqli->query($query) or confirm_query();
					if($result->num_rows >= 1){ // There is at least a student
						echo "<table class='table table-stripped'>
										<thead>
											<tr>
												<th>S/N</th>
												<th>Name</th>
												<th>Reg No.</th>
												<th>Class</th>
											</tr>
										</thead>
										<tbody>";
										
						$count = 1;
						while($row = $result->fetch_assoc()){
							$name = stripslashes($row["surname"]) . " " . stripslashes($row["other_names"]);
							$reg_no = $row["reg_no"];
							$_class = $row["_class"];
							
							echo "<tr>
											<td>$count.</td>
											<td>$name</td>
											<td>$reg_no</td>
											<td>$_class</td>
										</tr>";
							$count++;
						}
						
						echo "</tbody>
								</table>";
					}else{ echo "<p class='timer' style='text-align: left; color: #F00;'><em>No student for the selected class.</em></p>"; }
					
					echo "</div>";
				}
			
			
			
			?>
		</div>		
	</body>
</html>