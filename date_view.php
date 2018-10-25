<?php 
include 'inc/header.php';
include 'lib/student.php';

?>
<div class="row">
<div class="col-md-12">
	<div class="panel">
		<div class="panel-heading">
			<a class="btn btn-success" href="add.php">Add Student</a>
			<a class="btn btn-info pull-right" href="index.php">Take Attendence</a>
		</div>
	</div>
	<div class="text-center">
		<strong>Date:</strong><?php $cur_date = date('Y-m-d'); echo $cur_date; ?>
	</div>
	<div class="panel-body">
		<form action="" method="post">
			<table class="table table-striped">
				<tr>
					<th width="30%">Serial</th>
					<th width="50%">Attendance Date</th>
					<th width="20%">Action</th>
				</tr>
					
				<?php
				$stu = new Student();
				$get_date = $stu->getDatelist();
				if ($get_date) {
					$i=0;
					while($value = $get_date->fetch_assoc()){
						$i++;
				?>

				<tr>
					<td><?php echo $i++; ?></td>
					<td><?php echo $value['att_time']; ?></td>
					<td>
						<a class="btn btn-primary" href="student_view.php?dt=<?php echo $value['att_time']; ?>">View</a>
					</td>
				</tr>
				
				<?php } }?>
				<tr>
					<td colspan="4">
						<input class="btn btn-primary" type="submit" name="submit" value="Submit">
					</td>
				</tr>
			</table>
		</form>
	</div>

<?php include 'inc/footer.php'; ?>