
<?php
	//var_dump($argv); //variables from climate_core.php

	$tempThreshold;
	$tempNight = 24.5;  	// 24.5
	$tempDay = 30.0;		// 26.5

	$humidityThreshold;
	$humidityMin = 70.0;
	$humidityNight = 85.0;
	$humidityDay = 95.0;

	$override = false;		// override temperature and rain every minute
	$pumpPrimer = false; 	// set this to true to build up rain system pressure
	$debugMode = true;

	$curentTime = date('H:i');
	$morningTime = ('10:00');
	$eveningTime = ('22:00');
	//fixed rain trigger times (time => seconds)
	$rainShedule = array('12:00' => 5,
							'18:00' => 1);

	$rainTime = 1; 			// time in seconds to rain
	$windTime = 10;			// time to vent in seconds

	$db = mysql_connect("localhost","datalogger","datalogger") or die("DB Connect error");
	mysql_select_db("datalogger");
	$sql = "SELECT * FROM datalogger where sensor = 8 ORDER BY date_time DESC LIMIT 1";
	$result = mysql_query($sql);
	if (mysql_num_rows($result) > 0) {
		while($row = mysql_fetch_assoc($result)) {
			$tempSensor = $row["temperature"];
			$humiditySensor = $row["humidity"];
			if ($row["temperature"] > 50) {
				logToFile("high temperature reading", $row["temperature"] );
			}
			if ($row["humidity"] > 100) {
				logToFile("high humidity reading", $row["humidity"] );
			}
		}
	}
	logToFile("humidity",  $humiditySensor);
	logToFile("temperature",  $tempSensor);


	//night time climate
	if (($curentTime < $morningTime) or ($curentTime > $eveningTime)) {
		$tempThreshold = $tempNight;
		$humidityThreshold = $humidityNight;
		$humDelta = ($humiditySensor - $humidityThreshold);

		//wind when humidity is high
		if ($humiditySensor > $humidityThreshold) {
			$windTime = 10 + (50/(100-$humidityThreshold)*($humiditySensor-$humidityThreshold));
			$reason = "humidity".$humiditySensor;
			bringTheAir($windTime, $reason);
		} else {
			$reason = "humidity".$humiditySensor;
			bringTheAir(0, $reason);
		}
		//TODO: what to do when temps are high?

	} else { //day time climate
		$humidityThreshold = $humidityDay;
		$tempThreshold = $tempDay;
		//trigger rain shedules
		if (array_key_exists($curentTime, $rainShedule)) {
			$time = current($rainShedule);
			$reason = "rain shedule";
			letItRain($time, $reason);
		}

		//react to high temperatures
		if ($tempSensor > $tempThreshold) {
			$tempDelta = ($tempSensor - $tempThreshold);
			if (($tempDelta > 0) and ($tempDelta < 10)) {
				$rainTime = $tempDelta + $rainTime;
				$windTime = $windTime + $tempDelta;
				$reason = "temperature".$tempSensor;
				letItRain($rainTime, $reason);
				bringTheAir($windTime, $reason);		//TODO: define windtime
			} else {
				$reason = "temperature".$tempSensor;
				letItRain($rainTime,  $reason);
				bringTheAir($windTime, $reason);
			}
		} elseif ($humiditySensor > $humidityThreshold) {
		//wind on high humidity
			$humidityDelta = ($humiditySensor - $humidityThreshold);
			$windTime = 10 + (50 / (100-$humidityThreshold) * $humidityDelta);
			$reason = "humidity: ".$humiditySensor;
			bringTheAir($windTime, $reason);

		} elseif ($humiditySensor < $humidityMin) {
		//react to low humidity
			$humidityDelta = ($humidityMin - $humiditySensor);
			if (($humidityDelta > 0) and ($humidityDelta < 10)) {
				$humidityDelta = $rainTime;
				$reason = "humidity: ".$humiditySensor;
				letItRain($humidityDelta, $reason);
			} else {
				$reason = "humidity: ".$humiditySensor;
				letItRain($rainTime, $reason);
			}
		}

		//override to pressure pump
		if ($pumpPrimer==true and $override==true) {
			$i = 0;
			while($i < 30) {
				$reason = "override function";
				letItRain($delta, $reason);
				$i++;
			}
		}
	}



	// functions
	function letItRain($time, $reason) {
		if ($time > 0) {
			exec('/usr/local/bin/gpio mode 2 out');
			exec('/usr/local/bin/gpio write 2 0');
			sleep($time);
			logToFile("let it rain", $time."s", $reason);
			exec('/usr/local/bin/gpio write 2 1');
		} elseif ($time == 0) {
			logToFile("let it rain", $time."s", $reason);
			exec('/usr/local/bin/gpio write 2 1');
		}
	}


	function bringTheAir($time, $reason) {
		if ($time > 0) {
			exec('/usr/local/bin/gpio mode 5 out');
			exec('/usr/local/bin/gpio write 5 1');
			//time till wind stops
			sleep ($time);
			logToFile("bring the air", $time."s", $reason);
			exec('/usr/local/bin/gpio write 5 0');
		} elseif ($time == 0) {
			logToFile("bring the air", $time."s", $reason);
			exec('/usr/local/bin/gpio write 5 0');

		}
	}


	function logToFile($string, $value) {
		$file = "/../debug.log";
		$size = filesize(__DIR__ . $file);
		$curentTime = date('H:i:s');
		if ($size < 4096) {
			$mylogfile = fopen(__DIR__ . $file, "a") or die("Unable to open file!");
			try {
				//fwrite($mylogfile, $curentTime . " size: " . $size ." file: " . __DIR__ . $file ."\n");
				fwrite($mylogfile, "<b>". $curentTime . "  " . $string . ": " . $value . "</b>" . "\n");
				fclose($mylogfile);

			} catch (Exception $e) {
				echo 'Caught exception: ',  $e->getMessage(), "\n";
			}
		} else {
			$mylogfile = fopen(__DIR__ . $file, "w") or die("Unable to open file!");
			fwrite($mylogfile, $curentTime . " reset file size \n");
			fclose($mylogfile);
		}
	}

	mysql_query($sql);
	mysql_close($db);

?>
