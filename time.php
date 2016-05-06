<?php
	$servername = "localhost";
	$username = "datalogger";
	$password = "datalogger";
	$dbname = "datalogger";

	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	$phpdate = strtotime( $mysqldate );
	$mysqldate = date( 'Y-m-d H:i:s', $phpdate );

	$sql = "SELECT date_time, sensor, temperature, humidity FROM datalogger ORDER BY date_time DESC LIMIT 1";
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			echo "<b>". "LAST UPDATE: " . $row["date_time"]. "</b>";
		}
	} else {
		echo "0 results";
	}

	mysqli_close($conn);
?> 
