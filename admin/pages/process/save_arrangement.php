<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('../../../config.php');

//Database connection selection
// $db=new db();
// $db->db_connect();
// $db->db_select();

if($_SESSION)
{
	/*..................get session variable ....................*/
	$theater_id = isset($_POST['event_id']) ? $_POST['event_id'] : null;
	$action = isset($_POST['action']) ? $_POST['action'] : null;
	$bookdt = date('Y-m-d h:i:s');
	
	if (!$theater_id) {
		die("Theater ID is required");
	}
	
	/*........................check for existence of booking id......................*/
	$sql = "select * from seats where fk_theater_id = '$theater_id'";
	$result = mysqli_query($con, $sql);
	$cnt = mysqli_num_rows($result);
	
	$tdId = isset($_POST['tdId']) ? $_POST['tdId'] : [];
	$seatName = isset($_POST['seatName']) ? $_POST['seatName'] : [];
	
	if (empty($tdId) || empty($seatName)) {
		die("Seat data is required");
	}
	
	$dataCnt = count($tdId); // to get the total number of seats
		
	if($action == 'edit')
	{
		$sql = "delete from seats where fk_theater_id = '$theater_id'";
		$result = mysqli_query($con, $sql);
	}
			
	for($i=0; $i<$dataCnt; $i++)
	{
		$td_id = $tdId[$i];
		$seat_name = $seatName[$i];
			
		$sql1 = "insert into seats(seat_name,td_id,fk_theater_id) values ('$seat_name','$td_id','$theater_id')";
		if(!$result1 = mysqli_query($con, $sql1))
		{
				die('SQL1 ERROR : '.mysqli_error($con));
		}
	}
	if($action == 'edit')
	{
		echo"<script>alert('Seat arrangement updated successfully');</script>";
		echo"<script>self.location='../index.php'</script>";
	}
	else
	{
		echo"<script>alert('Seat arrangement saved successfully');</script>";
		echo"<script>self.location='../index.php'</script>";
	}	
}