<?php
	include_once '/var/www/html/log.php';
	include 'datafilter.php';

	global $temperature, $humidity, $debugMode;
	$debugMode = true;

	if ($debugMode==true) {
		logToFile("running sensors.php", '', '');
	}


	function readSensor($sensor) {
		global $temperature, $humidity, $debugMode;
		$time = date('H:i:s');
		$output = array();

		$delta_test = new deltaFilter();

		//$escaped_command = escapeshellcmd("sudo loldht $sensor | grep -o [0-9][0-9].[0-9][0-9]");
		exec("sudo loldht $sensor | grep -o [0-9][0-9].[0-9][0-9]", $output);
		$count = count($output);

		for ($i = 0; $i < $count; $i++) {
			$value = floatval($output[$i]);
			if ($value) {
				if ($i == 0) {		//humidity sensor
					//$delta = $delta_test->filter($value);
 					$delta = deltaFilter::createPersistent( 'humidity' );
					logToFile("delta return", $delta, '<<<<<<<<<');
					$humidity = $value;

				} if ($i == 1) {  	// temp sensor
					$temperature = $value;
				}
			} else {
				break;
				if ($debugMode==true) {
						logToFile("mysql value missing", '', '');
					}
			}
		}
		//only if we get both values we write to the database
		if ($temperature && $humidity) {
			if ($debugMode==true) {
				logToFile("all values exist", $humidity, $temperature);
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
			//continue;
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

