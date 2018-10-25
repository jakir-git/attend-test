<?php 
include 'inc/header.php';
include 'lib/student.php';

$stu = new Student();
$dt = $_GET['dt'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$attend = $_POST['attend'];
	$att_update = $stu->updateAttend($dt, $attend);
}

if(isset($att_update)){
	echo $att_update;
}


?>

<div style="display: none;" class='alert alert-warning'>Student Roll Missing!</div>
<div class="row">
<div class="col-md-12">
	<div class="panel">
		<div class="panel-heading">
			<a class="btn btn-success" href="add.php">Add Student</a>
			<a class="btn btn-info pull-right" href="date_view.php">Back</a>
		</div>
	</div>
	<div class="text-center">
		<strong>Date:</strong><?php echo $dt; ?>
	</div>
	<div class="panel-body">
		<form action="" method="post">
			<table class="table table-striped">
				<tr>
					<th width="25%">Serial</th>
					<th width="25%">Student Name</th>
					<th width="25%">Student Roll</th>
					<th width="25%">Attendence</th>
				</tr>
					
				<?php
				$get_student = $stu->getAllData($dt);
				if ($get_student) {
					$i=0;
					while($value = $get_student->fetch_assoc()){
						$i++;
				
				?>
 
				<tr>
					<td><?php echo $i++; ?></td>
					<td><?php echo $value['name']; ?></td>
					<td><?php echo $value['roll']; ?></td>
					<td>
						<input type="radio" name="attend[<?php echo $value['roll']; ?>]" value="present" <?php if($value['attend'] == "present") { echo "checked"; }?>>P
						<input type="radio" name="attend[<?php echo $value['roll']; ?>]" value="absent" <?php if($value['attend'] == "absent") { echo "checked"; }?>A
					</td>
				</tr>
				
				<?php } }?>
				<tr>
					<td colspan="4">
						<input class="btn btn-primary" type="submit" name="submit" value="Update">
					</td>
				</tr>
			</table>
		</form>
	</div>

<?php include 'inc/footer.php'; ?>