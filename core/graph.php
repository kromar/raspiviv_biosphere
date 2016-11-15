<?php
		$servername = "localhost";
		$username = "datalogger";
		$password = "datalogger";
		$dbname = "datalogger";
		$datenuebergabe = array();
		$history = 3;

		// Create connection
		$db = mysqli_connect($servername, $username, $password, $dbname);
		// Check connection
		if (!$db) {
			die("Connection failed: " . mysqli_connect_error());
		}
		$sql = "SELECT * FROM datalogger where sensor = 8 ORDER BY date_time DESC LIMIT $history";
		$result = mysqli_query($db, $sql);

		if (mysqli_num_rows($result)>0) {
			while($row = mysqli_fetch_object($result)) {
				$datenuebergabe[] = array(
						date_time => (string) $row['TIME'],
						temperature => (float) $row['TEMP'],
						humidity => (float) $row['HUMID']
				);
				echo json_encode($datenuebergabe);
			}
		} else {
			echo "0 results";
		}
		mysqli_close($db);
?>