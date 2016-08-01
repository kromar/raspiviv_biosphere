<?php
	include_once '/var/www/html/log.php';
	global $temperature, $humidity, $debugMode;
	$debugMode = true;


	function filterValues($value, $i) {
		//change the filtering so we compare our values to previous value in the database,
		// if it deviates by a certain delta then filter the value

		$deltaTemperature = 5;
		$deltaHumidity = 5;

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
		$sql = "SELECT * FROM datalogger where sensor = 8 ORDER BY date_time DESC LIMIT 1";
		$result = mysqli_query($db, $sql);

		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				$tempSensor = $row["temperature"];
				$humiditySensor = $row["humidity"];

				//check if sensor reading deviates by delta to the last sensor reading
				if ($i == 0) {	//humidity
					$diffHumidity = abs($humiditySensor - $value);

					if ($diffHumidity < $deltaHumidity) {
						return (true);
					} else {
						return (false);
					}
					if ($debugMode==true) {
						logToFile("humidity delta", $diffHumidity, '');
					}
				}

				if ($i == 1) { //temperature
					$diffTemperature = abs($tempSensor - $value);
					if ($diffTemperature < $deltaTemperature) {
						return (true);
					} else {
						return (false);
					}
					if ($debugMode==true) {
						logToFile("temperature delta", $diffTemperature, '');
					}
				}



		if ($value > $min && $value < $max) {
			return($value);
		} else {
			if ($debugMode==true) {
				logToFile("filtered", $name, $value);
			}
		}
	}



	function readSensor($sensor) {
		$time = date('H:i:s');
		$output = array();

		//$escaped_command = escapeshellcmd("sudo loldht $sensor | grep -o [0-9][0-9].[0-9][0-9]");
		exec("sudo loldht $sensor | grep -o [0-9][0-9].[0-9][0-9]", $output);

		$count = count($output);
		echo "output size: $count \n";

		for ($i = 0; $i < $count; $i++) {
			$value = floatval($output[$i]);

			if ($value) {
				if ($i == 0) {	//humidity
					 $valueInDeltaRange = filterValues($value, $i);
					 if ($valueInDeltaRange == true) {
					 	$humidity = $value;
					 } else {
					 	$humidity  = null;
					 }
				}
				if ($i == 1) { 	//temperature
					$valueInDeltaRange = filterValues($value, $i);
					 if ($valueInDeltaRange == true) {
					 	$temperature = $value;
					 } else {
					 	$temperature  = null;
					 }
				}


				//only if we get both values we write to the database
				if ($temperature && $humidity) {

					if ($debugMode==true) {
						logToFile("both values", $humidity, $temperature);
					}

					$servername = "localhost";
					$username = "datalogger";
					$password = "datalogger";
					$dbname = "datalogger";

					// Create connection
					$db = mysqli_connect($servername, $username, $password, $dbname);
					// Check connection
					if (!$db) { die("Connection failed: " . mysqli_connect_error()); }

					mysqli_select_db($db, "datalogger");
					$q = "INSERT INTO datalogger VALUES (now(), '$sensor', '$temperature', '$humidity', 0)";
					mysqli_query($db, $q);
					mysqli_close($db);
					return;

				} else {
					if ($debugMode==true) {
						logToFile("only one value", '', '');
					}
				}
			}
		}
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

