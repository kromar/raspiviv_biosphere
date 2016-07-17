<?php
	include_once '/var/www/html/log.php';

	function readSensor($sensor) {
		$maxValue = 100;
		$minValue = 0;
		$interval = 30;
		$temperature = 0;
		$humidity = 0;
		$debugMode = true;

		if ($debugMode==true) {
			logToFile("call sensors (min/max)",$minValue,$maxValue);
		}

		$time = date('H:i:s');
		$output = array();

		//$escaped_command = escapeshellcmd("sudo loldht $sensor | grep -o [0-9][0-9].[0-9][0-9]");
		exec("sudo loldht $sensor | grep -o [0-9][0-9].[0-9][0-9]", $output);

		$count = count($output);
		echo "output size: $count \n";

		for ($i=0; $i<$count; $i++) {
			$value = floatval($output[$i]);
			if ($value && $value < $maxValue && $value > $minValue) {		//filter for realistic values
				$name;
				if ($i == 0) {
					$name = "humidity";
					$humidity = $value;
					echo "$name $value\n";
				} elseif ($i == 1){
					$name = "temperature";
					$temperature = $value;
					echo "$name $value\n";
				}
				if ($debugMode==true) {
					logToFile($name, $sensor, $value);
				}

				$db = mysqli_connect("localhost","datalogger","datalogger") or die("DB Connect error");
				mysqli_select_db($db, "datalogger");
				$q = "INSERT INTO datalogger VALUES (now(), $sensor, '$temperature', '$humidity',0)";
				mysqli_query($db, $q);
				mysqli_close($db);


			} else {
				if ($debugMode==true) {
					logToFile("filtered values $name", $sensor, $value);
				}
			}
		//} return; 	//end sensor reading
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

