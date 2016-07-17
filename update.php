<?php
	mysqli_connect("localhost", "datalogger", "datalogger") or die("Connection Failed");
	mysqli_select_db("vivs")or die("Connection Failed");
	$user = $_POST['user'];
	$password = $_POST['userpassword'];
	$query = "UPDATE test SET password = '$password' WHERE name = '$user'";
	if(mysqli_query($query)){
		echo "updated";}
	else{
		echo "fail";}
?>
