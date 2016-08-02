<?php
	function delOld(){
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
		mysqli_select_db("datalogger");
		$q="delete from datalogger";
		mysqli_query($db, $q);
		mysqli_close($db);
		return 0;
	}

	function hist($sensor){
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
		mysqli_select_db("datalogger");
		for ($i=0;$i<=23;$i++)
		{
			$q=   "insert into history ( ";
			$q=$q."select date_add(curdate(),interval $i hour),'$sensor', round(avg(temperature),2),round(avg(humidity),2) ";
			$q=$q."from datalogger ";
			$q=$q."where sensor = '$sensor' ";
			$q=$q."and date_time >=date_add(curdate(),interval $i hour) "; $ii=$i+1;
			$q=$q."and date_time < date_add(curdate(),interval $ii hour) ";
			$q=$q.") ";
			mysqli_query($db, $q);
		}
		mysqli_close($db);
		return 0;
	}
	hist(8);
	hist(9);
	//delOld();
?>

