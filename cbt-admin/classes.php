<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/connection.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php confirm_staff_login(); ?>

<?php
	if(isset($_POST["add_subj"])){
		$_class = ucfirst(mysqli_prep(trim($_POST["_class"])));
		
		if(!empty($class)){
			$query = "INSERT INTO cbt_classes (_class) VALUES ('{$_class}')"
							or confirm_query();
			$mysqli->query($query);
		}
	}
?>
<?php 
	$title = "";
	$page = "classes";
	include_once("../includes/admin_header.php");
?>
<script>
	$(document).ready(function(){
		$('#class_form').validate({
			rules : {
				_class : {
					required: true,
					maxlength: 7
				}
			},
			messages : {
				_class : {
					required: 'Class is required.',
					maxlength: 'Class cannot be longer than 7 characters.'
				}
			}
		}); // end validate
	});

</script>
<!-- This is the main content of the site -->
<div class="main">
	<h2>Classes</h2>
	<div class="col-lg-4">
		<p><strong>Add New Class</strong></p>
		
		<form method="POST" action="" class="form-horizontal" role="form" id="class_form">
			<div class="form-group">
				<label class="col-lg-3 control-label">Class</label>
				<div class="col-lg-9">
					<input type="text" id="_class" name="_class" value="" placeholder="Enter the name of a class" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-3"></div>
				<div class="col-lg-9">
					<input type="submit" id="add_subj" name="add_subj" value="Add New Class" class="btn btn-primary">
				</div>
			</div>
		</form>
	</div>
	
	<div class="col-lg-8">
		<table class="table table-stripped">
			<thead>
				<tr>
					<th>S/N</th>
					<th>Classes</th>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$query = "SELECT * FROM cbt_classes ORDER BY _class" or confirm_query();
					$result = $mysqli->query($query);
					$count = 1;
					while($row = $result->fetch_assoc()){
						echo "<tr>
										<td>$count.</td>
										<td>" . $row["_class"] . "</td>
										<td><a href='#'>Update</a></td>
										<td><a href='#'>Delete</a></td>
									</tr>";
						$count++;
					}
				?>
			</tbody>
		</table>
	</div>
</div>		
<?php include_once("../includes/admin_footer.php"); ?>