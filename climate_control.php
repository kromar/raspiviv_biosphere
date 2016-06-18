
<?php

	$db = mysql_connect("localhost","datalogger","datalogger") or die("DB Connect error");
	mysql_select_db("datalogger");

	$qt = "SELECT temperature FROM datalogger where sensor = 8 ORDER BY date_time DESC LIMIT 1";
	$dt = mysql_query($qt);
	$tempSensor=(float)mysql_fetch_object($dt)->temperature;

	$qh = "SELECT humidity FROM datalogger where sensor = 8 ORDER BY date_time DESC LIMIT 1";
	$dh = mysql_query($qh);
	$humiditySensor=(float)mysql_fetch_object($dh)->humidity;

	//change threshold depening on time of day
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

	$t = time();
	$curentTime = date('H:i');
	$morningTime = ('10:00');
	$eveningTime = ('22:00');
	//fixed rain trigger times (time => seconds)
	$rainShedule = array('12:00'=>5,
						'18:10'=> 5);

	$rainTime = 1; 			// time in seconds to rain
	$windTime = 10;			// time to vent in seconds



	//night time climate
	if (($curentTime < $morningTime) or ($curentTime > $eveningTime)) {
		$tempThreshold = $tempNight;
		$humidityThreshold = $humidityNight;

		//wind when humidity is high
		if ($humiditySensor > $humidityThreshold) {
			$windTime = 10 + (50/(100-$humidityThreshold)*($humiditySensor-$humidityThreshold));
			bringTheAir($windTime);
		}
		//TODO: what to do when temps are high?

	}

	//day time climate
	else {
		$humidityThreshold = $humidityDay;
		$tempThreshold = $tempDay;

		//trigger rain shedules
		if (array_key_exists($curentTime, $rainShedule)) {
			$time = current($curentTime);
			letItRain($time);
			logToFile("time: ", $time);
		}


		//react to high temperatures
		if ($tempSensor > $tempThreshold or $override==true) {
			$tempDelta = ($tempSensor - $tempThreshold);

			if (($tempDelta > 0) and ($tempDelta < 10)) {
				$rainTime = $tempDelta + $rainTime;
				$windTime = $windTime + $tempDelta;
				letItRain($rainTime);
				bringTheAir($windTime);		//TODO: define windtime
			} else {
				letItRain($rainTime);
				bringTheAir($windTime);
			}
		}


		//wind depending on how much humidity is over our limit
		elseif ($humiditySensor > $humidityThreshold) {
			$humidityDelta = ($humiditySensor - $humidityThreshold);
			$windTime = 10 + (50 / (100-$humidityThreshold) * $humidityDelta);
			bringTheAir($windTime);
		}


		//react to low humidity
		elseif ($humiditySensor < $humidityMin) {
			$humidityDelta = ($humidityMin - $humiditySensor);
			if (($humidityDelta > 0) and ($humidityDelta < 10)) {
				$humidityDelta = $rainTime;
				letItRain($humidityDelta);
			} else {
				letItRain($rainTime);
			}
		}



		//override to pressure pump
		if ($pumpPrimer==true and $override==true) {
			$i = 0;
			while($i < 30) {
				letItRain($delta);
				$i++;
			}
		}
	}



	// functions
	function letItRain($time) {
		exec('/usr/local/bin/gpio mode 2 out');
		exec('/usr/local/bin/gpio write 2 0');
		sleep($time);
		exec('/usr/local/bin/gpio write 2 1');
	}


	function bringTheAir($time) {
		exec('/usr/local/bin/gpio mode 5 out');
		exec('/usr/local/bin/gpio write 5 1');
		//time till wind stops
		sleep ($time);
		exec('/usr/local/bin/gpio write 5 0');
	}

	function logToFile($string, $value) {
		$mylogfile = fopen(__DIR__ . "/../debug.log", "a") or die("Unable to open file!");
		$curentTime = date('H:i:s');
		fwrite($mylogfile, $curentTime . " : " . $string . " : " . $value . "\n");
		fclose($mylogfile);
	}

	mysql_query($qt);
	mysql_query($qh);
	mysql_close($db);

?>
