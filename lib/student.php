<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/database.php');
?>

<?php


/**
 * 
 */
class Student
{
	private $db;
	public function __construct()
	{
		$this->db = new Database();
	}

	public function getStudent(){
		$query = "SELECT * FROM tbl_student";
		$result = $this->db->select($query);
		return $result;
	}

	public function insertStudent($name, $roll){
		$name = mysqli_real_escape_string($this->db->link, $name);
		$roll = mysqli_real_escape_string($this->db->link, $roll);
		if (empty($name) || empty($roll)) {
			$msg = "<div class='alert alert-danger'>Field Must Not Be Empty!</div>";
			return $msg;
		}else{
			$squery = "INSERT INTO tbl_student(name, roll) values('$name','$roll')";
			$result = $this->db->insert($squery);

			$aquery = "INSERT INTO tbl_attend(roll) values('$roll')";
			$result = $this->db->insert($aquery);

			if ($squery) {
				$msg = "<div class='alert alert-primary'>Success</div>";
			return $msg;
			}else{
				$msg = "<div class='alert alert-danger'>Field!</div>";
			return $msg;
			}
		}
	}

	public function insertAttend($cur_date, $attend = array()){
		$query = "SELECT DISTINCT att_time FROM tbl_attend";
		$getdata = $this->db->select($query);
		while($result = $getdata->fetch_assoc()){
			$db_date = $result['att_time'];
			if ($cur_date == $db_date) {
				$msg = "<div class='alert alert-warning'>Attendance Already Taken!</div>";
			return $msg;
			}
		}

		foreach ($attend as $atn_key => $atn_value) {
			if ($atn_value == "present") {
				$stu_query = "INSERT INTO tbl_attend(roll, attend, att_time) values('$atn_key', 'present', now())";
				$data_insert = $this->db->insert($stu_query);
			}elseif($atn_value == 'absent'){
				$stu_query = "INSERT INTO tbl_attend(roll, attend, att_time) values('$atn_key', 'absent', now())";
				$data_insert = $this->db->insert($stu_query);
			}
		}

		if ($data_insert) {
			$msg = "<div class='alert alert-primary'>Attendance Data Insert Success</div>";
			return $msg;
		}else{
			$msg = "<div class='alert alert-danger'>Attendance Data Insert Faild</div>";
			return $msg;
		}
		
	}

	public function getDatelist(){
		$query = "SELECT DISTINCT att_time FROM tbl_attend";
		$result = $this->db->select($query);
		return $result;
	}

	public function getAllData($dt){
		$query = "SELECT tbl_student.name, tbl_attend.*
		 FROM tbl_student
		 INNER JOIN tbl_attend
		 ON tbl_student.roll = tbl_attend.roll
		 WHERE att_time = '$dt'";
		$result = $this->db->select($query);
		return $result;
	}

	public function updateAttend($dt, $attend){
		foreach ($attend as $atn_key => $atn_value) {
			if ($atn_value == "present") {
				$query = "UPDATE tbl_attend
				SET attend = 'present'
				WHERE roll = '".$atn_key."' AND att_time = '".$dt."'";
				$data_update = $this->db->update($query);
				
			}elseif($atn_value == 'absent'){
				$query = "UPDATE tbl_attend
				SET attend = 'absent'
				WHERE roll = '".$atn_key."' AND att_time = '".$dt."'";
				$data_update = $this->db->update($query);
			}
		}

		if ($data_update) {
			$msg = "<div class='alert alert-primary'>Attendance Data Update Success</div>";
			return $msg;
		}else{
			$msg = "<div class='alert alert-danger'>Attendance Data Update Failed</div>";
			return $msg;
		}
	}
}

?>