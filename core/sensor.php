<?php
	include_once '/var/www/html/log.php';

	function readSensor($sensor) {
		$maxTemperature = 50;
		$minTemperature = 15;
		$maxHumidity = 100;
		$minHumidity = 50;

		$interval = 30;
		global $temperature, $humidity;
		$time = date('H:i:s');
		$output = array();
		$debugMode = true;

		//$escaped_command = escapeshellcmd("sudo loldht $sensor | grep -o [0-9][0-9].[0-9][0-9]");
		exec("sudo loldht $sensor | grep -o [0-9][0-9].[0-9][0-9]", $output);

		$count = count($output);
		echo "output size: $count \n";

		for ($i=0; $i<$count; $i++) {
			$value = floatval($output[$i]);
			$name;
			if ($value) {
				if ($i == 0) {
					if ($value < $maxHumidity and $value > $minHumidity) {		//filter for realistic values
						$name = "humidity";
						$humidity = $value;
						echo "$name $value\n";
					} else {
						if ($debugMode==true) {
							logToFile("filtered $name values", $sensor, $value);
						}
					}
				} elseif ($i == 1){
					if ($value < $maxTemperature and $value > $minTemperature) {		//filter for realistic values
						$name = "temperature";
						$temperature = $value;
						echo "$name $value\n";
					} else {
						if ($debugMode==true) {
							logToFile("filtered $name values", $sensor, $value);
						}
					}
				}
				if ($debugMode==true) {
					logToFile($name, $sensor, $value);
				}
			}
		}
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
		mysqli_select_db($db, "datalogger");
		$q = "INSERT INTO datalogger VALUES (now(), '$sensor', '$temperature', '$humidity', 0)";
		mysqli_query($db, $q);
		mysqli_close($db);
		return; 	//end sensor reading
		//}
	}


	readSensor(8);
	readSensor(9);


	//change pull for a given amount of time and then switch back to previous pull state
	/*
	function timerSensor($pin, $time, $inverted, $reason) {
		include_once 'log.php';
		$inverted;
		$high;
		$low;

		if ($inverted == true) {
			$high = 1;
			$low = 0;
		} else {
			$high = 0;
			$low = 1;
		}

		if ($time > 0) {
			exec('/usr/local/bin/gpio mode $pin out');
			exec('/usr/local/bin/gpio write $pin $low');
			sleep($time);
			logToFile("sensor timer", $time."s", $reason);
			exec('/usr/local/bin/gpio write $pin $high');
		} elseif ($time == 0) {
			logToFile("sensor timer", $time."s", $reason);
			exec('/usr/local/bin/gpio write $pin $high');
		}
	}
	//*/
?>

