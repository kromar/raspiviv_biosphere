<?php
	function delOldHistory(){
		$servername = "localhost";
		$username = "datalogger";
		$password = "datalogger";
		$dbname = "history";

		// Create connection
		$db = mysqli_connect($servername, $username, $password, $dbname);
		// Check connection
		if (!$db) {
			die("Connection failed: " . mysqli_connect_error());
		}
		mysqli_select_db($db, $dbname);
		$q="delete from $dbname";
		mysqli_query($db, $q);
		mysqli_close($db);
		return 0;
	}

	function sensorHistory($sensor){
		$servername = "localhost";
		$username = "datalogger";
		$password = "datalogger";
		$dbname = "history";

		// Create connection
		$db = mysqli_connect($servername, $username, $password, $dbname);
		// Check connection
		if (!$db) {
			die("Connection failed: " . mysqli_connect_error());
		}
		mysqli_select_db($db, $dbname);
		for ($i=0;$i<=23;$i++)
		{
			$q=   "insert into history ( ";
			$q=$q."select date_add(curdate(),interval $i hour),'$sensor', round(avg(temperature),2),round(avg(humidity),2) ";
			$q=$q."from $dbname ";
			$q=$q."where sensor = '$sensor' ";
			$q=$q."and date_time >=date_add(curdate(),interval $i hour) "; $ii=$i+1;
			$q=$q."and date_time < date_add(curdate(),interval $ii hour) ";
			$q=$q.") ";
			mysqli_query($db, $q);
		}
		mysqli_close($db);
		return 0;
	}
	sensorHistory(8);
	sensorHistory(9);
	sensorHistory(7);
	delOldHistory();
?>

