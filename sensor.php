<?php
	include_once 'log.php';
	logToFile("sensor trigger",'','');
	$interval = 30;
	$v = 0;

	//write sensor values to sql database every update interval
	function readSensor($sensor)
	{
		$output = array();
		exec("sudo loldht $sensor | grep -i 'humidity' | cut -d ' ' -f3", $output);
		exec("sudo loldht $sensor | grep -i 'temperature' | cut -d ' ' -f7", $output);

		echo "output size: ".count($output)."\n";
		while (count($output)==0){
			echo $v;
			$v++;
		}

		$humidity = $output[0];
		$temperature = $output[1];
		logToFile("climate", $humidity, $temperature);
		echo "humidity: $humidity temperature: $temperature";


		/*
	    $db = mysql_connect("localhost","datalogger","datalogger") or die("DB Connect error");
		mysql_select_db("datalogger");
		$q = "INSERT INTO datalogger VALUES (now(), $sensor, '$temp', '$humid',0)";
		mysql_query($q);
		mysql_close($db);
		return;
		//*/
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

