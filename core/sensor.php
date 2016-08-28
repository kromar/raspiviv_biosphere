<?php
	include_once '/var/www/html/log.php';
	global $temperature, $humidity, $debugMode;
	global $deltaTemperature, $deltaHumidity;
	$debugMode = true;


	if ($debugMode==true) {
		logToFile("running sensors.php", '', '');
	}

	function filterValues($value, $i, $sensor) {
		global $debugMode;
		//change the filtering so we compare our values to previous value in the database,
		// if it deviates by a certain delta then filter the value

		$deltaTemperature = 100;
		$deltaHumidity = 100;
		$filterMax = 100;
		$filterMin = 0;

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
		$sql = "SELECT * FROM datalogger where sensor = $sensor ORDER BY date_time DESC LIMIT 1";
		$result = mysqli_query($db, $sql);

		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				$tempSensor = $row["temperature"];
				$humiditySensor = $row["humidity"];

				// todo: when within 0-100 then continue
				if ($humiditySensor > $filterMin && $humiditySensor < $filterMax) {
					if ($debugMode==true) {
						logToFile("filtering value $i", $value, $i);
					}

					//check if sensor reading deviates by delta to the last sensor reading
					if ($i == 0) {	//humidity
						$diffHumidity = abs($humiditySensor - $value);
						echo $diffHumidity;

						if ($debugMode==true) {
							logToFile("humidity delta", $diffHumidity, "$humiditySensor -- $value");
						}

						if ($diffHumidity < $deltaHumidity) {
							return (true);
						} else {
							return (false);
						}
					}
				}

				//filter temperature within specified range
				if ($tempSensor > $filterMin && $tempSensor < $filterMax) {
					if ($i == 1) { //temperature
						$diffTemperature = abs($tempSensor - $value);

						if ($debugMode==true) {
							logToFile("temperature delta", $diffTemperature, "$tempSensor -- $value");
						}

						if ($diffTemperature < $deltaTemperature) {
							return (true);
						} else {
							return (false);
						}
					}
				}
				//else out of range
			}
		} else {
    		if ($debugMode==true) {
				logToFile("no db results", '', '');
				return (true);
			}
		}
		mysqli_close($db);
	}




	function readSensor($sensor) {
		$time = date('H:i:s');
		$output = array();
		global $debugMode;

		//$escaped_command = escapeshellcmd("sudo loldht $sensor | grep -o [0-9][0-9].[0-9][0-9]");
		exec("sudo loldht $sensor | grep -o [0-9][0-9].[0-9][0-9]", $output);
		$count = count($output);
		for ($i = 0; $i < $count; $i++) {
			$value = floatval($output[$i]);
			if ($value) {
				//filter humidity
				if ($i == 0) {
					if ($debugMode==true) {
						logToFile("get filter value humidity", $value, $i);
					}
					 $valueInDeltaRange = filterValues($value, $i, $sensor);
					 if ($valueInDeltaRange == true) {
					 	$humidity = $value;
					 } else {
					 	$humidity  = null;
					 }
				}
				//filter temperature
				if ($i == 1) {
					if ($debugMode==true) {
						logToFile("get filter value temperature", $value, $i);
					}
					$valueInDeltaRange = filterValues($value, $i, $sensor);
					 if ($valueInDeltaRange == true) {
					 	$temperature = $value;
					 } else {
					 	$temperature  = null;
					 }
				}


				//only if we get both values we write to the database
				if ($temperature && $humidity) {
					// TODO: here we need to check for deltas and only write if within
					if ($debugMode==true) {
						logToFile("both values exist", $humidity, $temperature);
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
		if ($debugMode==true) {
			logToFile("=============================", '', '');
		}
	}


	readSensor(8);
	//readSensor(9);


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

