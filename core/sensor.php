<?php
	include_once '/var/www/html/log.php';
	include 'datafilter.php';
	global $temperature, $humidity, $debugMode;
	global $deltaTemperature, $deltaHumidity;
	$debugMode = true;


	if ($debugMode==true) {
		logToFile("running sensors.php", '', '<<<<<<<<');
	}


	function readSensor($sensor) {
		$time = date('H:i:s');
		$output = array();
		global $debugMode;

		if ($debugMode==true) {
			logToFile("running sensors.php", "readSensor", '');
		}

		//$escaped_command = escapeshellcmd("sudo loldht $sensor | grep -o [0-9][0-9].[0-9][0-9]");
		exec("sudo loldht $sensor | grep -o [0-9][0-9].[0-9][0-9]", $output);
		$count = count($output);

		for ($i = 0; $i < $count; $i++) {
			$value = floatval($output[$i]);

			if ($value) {
				//filter humidity
				if ($i == 0) { 			//humidity sensor
					//Apply kalman filter
					$filteredValue = kalmanFilter($value);
					if ($debugMode==true) {
						logToFile("get filter humidity", $value, $i);
						logToFile("filtered humidity", $filteredValue, '<<<<<<<<');
					}


					 //apply delta filter
					 //*
					$valueInDeltaRange = deltaFilter($value, $i, $sensor);
					 if ($valueInDeltaRange == true) {
					 	$humidity = $value;
					 } else {
					 	$humidity  = null;
					 }
					 //**/
				}

				//filter temperature
				if ($i == 1) {  		// temp sensor
					//Apply kalman filter
					$filteredValue = kalmanFilter($value);
					if ($debugMode==true) {
						logToFile("get filter temperature", $value, $i);
						logToFile("filtered temperature", $filteredValue, '<<<<<<<<');
					}

					//apply delta filter
					//*
					$valueInDeltaRange = deltaFilter($value, $i, $sensor);
					 if ($valueInDeltaRange == true) {
					 	$temperature = $value;
					 } else {
					 	$temperature  = null;
					 }
					 //**/
				}


				//only if we get both values we write to the database
				//*
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
			} else {
				if ($debugMode==true) {
						logToFile("mysql value missing", '', '');
					}
			}
			//**/
		}
		if ($debugMode==true) {
			logToFile("=============================", '', '');
		}
	}

	//Expire PHP session immediately
	$expireAfter = 0;

	readSensor(8);
	//readSensor(9);

?>

