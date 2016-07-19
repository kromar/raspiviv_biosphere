<?php
	$servername = "localhost";
	$username = "datalogger";
	$password = "datalogger";
	$dbname = "datalogger";

	// Create connection
	$db = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if (!$db) {
		die("Connection failed: " . mysqli_connect_error());
	}
	mysqli_select_db("vivs")or die("Connection Failed");
	$user = $_POST['user'];
	$password = $_POST['userpassword'];
	$query = "UPDATE test SET password = '$password' WHERE name = '$user'";
	if(mysqli_query($query)){
		echo "updated";}
	else{
		echo "fail";}
?>
