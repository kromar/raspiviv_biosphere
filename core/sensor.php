<?php
	include_once '/var/www/html/log.php';
	global $temperature, $humidity, $debugMode;
	$debugMode = true;


	function filterValues($value, $min, $max, $name) {
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
		$maxTemperature = 50;
		$minTemperature = 15;
		$maxHumidity = 100;
		$minHumidity = 30;


		//$escaped_command = escapeshellcmd("sudo loldht $sensor | grep -o [0-9][0-9].[0-9][0-9]");
		exec("sudo loldht $sensor | grep -o [0-9][0-9].[0-9][0-9]", $output);

		$count = count($output);
		echo "output size: $count \n";

		for ($i = 0; $i < $count; $i++) {
			$value = floatval($output[$i]);

			if ($value) {
				if ($i == 0) {
					$humidity = filterValues($value, $minHumidity, $maxHumidity, 'Humidity');
				}
				if ($i == 1) {
					$temperature = filterValues($value, $minTemperature, $maxTemperature, 'Temperature');
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

