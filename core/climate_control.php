
<?php
	include_once '/var/www/html/log.php';
	global $debugMode,$tempThreshold;

	//$interval = $argv[1];
	$tempThreshold = 0;
	//$tempSensor;
	//$humiditySensor;

	$tempNight = 24.5;  	// 24.5
	$tempDay = 30.0;		// 26.5

	$humidityThreshold;
	$humidityMin = 65.0;
	$humidityNight = 90.0;
	$humidityDay = 95.0;



	$curentTime = date('H:i');
	$morningTime = ('10:00');
	$eveningTime = ('22:00');
	//fixed rain trigger times (time => seconds)
	$rainShedule = array('12:00' => 10,
						 '18:00' => 10);

	$rainTime = 1; 			// time in seconds to rain
	$windTime = 10;			// time to vent in seconds

	$override = false;		// override temperature and rain every minute
	$pumpPrimer = false; 	// set this to true to build up rain system pressure

	$debugMode = true;
	$highTempRain = false;


	function climateCore(){
		global $debugMode;

		if ($debugMode == true) {
			logToFile("running climateCore",'','');
		}
		$db = mysql_connect("localhost","datalogger","datalogger") or die("DB Connect error");
		mysql_select_db("datalogger");
		$sql = "SELECT * FROM datalogger where sensor = 8 ORDER BY date_time DESC LIMIT 1";
		$result = mysql_query($sql);
		//$humiditySensor=(float)mysql_fetch_object($dh)->humidity;

		if (mysql_num_rows($result) > 0) {
			while($row = (float)mysql_fetch_assoc($result)) {
				$tempSensor = $row["temperature"];
				$humiditySensor = $row["humidity"];

				//run climate
				cliamteDaytime();

				if ($debugMode==true) {
					if ($tempSensor > 50) {
						logToFile("high temperature reading", $tempSensor, "");
					}
					if ($humiditySensor > 100) {
						logToFile("high humidity reading", $humiditySensor, "");
					}
				}
			}
		}
		mysql_query($sql);
		mysql_close($db);
	}


	function cliamteDaytime() {
		global $debugMode;

		if ($debugMode == true) {
			logToFile("running cliamteDaytime",'','');
		}

		//night time climate
		if (($curentTime < $morningTime) && ($curentTime > $eveningTime)) {
			$tempThreshold = $tempNight;
			$humidityThreshold = $humidityNight;

			//climateTemperature();
			//climateHumidity();

			if ($debugMode==true) {
				logToFile("night time", $tempThreshold, $humidityThreshold);
			}
		}

		//day time climate
		if (($curentTime >= $morningTime) && ($curentTime <= $eveningTime)) {
			$humidityThreshold = $humidityDay;
			$tempThreshold = $tempDay;

			climateRainShedule();
			//climateTemperature();
			//climateHumidity();

			if ($debugMode==true) {
				logToFile("day time", $tempThreshold, $humidityThreshold);
			}
		}
	}


	function climateTemperature() {
		global $debugMode;

		if ($debugMode == true) {
			logToFile("running climateTemperature",'','');
		}

		//react to high temperatures
		if ($tempSensor > $tempThreshold) {
			$tempDelta = ($tempSensor - $tempThreshold);

			if (($tempDelta > 0) and ($tempDelta < 10)) {
				$rainTime = $tempDelta + $rainTime;
				$windTime = $windTime + $tempDelta;
				$reason = "temperature: ".$tempSensor;
				if ($highTempRain == true) {
					letItRain($rainTime, $reason);
				}
				bringTheAir($windTime, $reason);		//TODO: define windtime
			} else {
				$reason = "temperature: ".$tempSensor;
				if ($highTempRain == true) {
					letItRain($rainTime, $reason);
				}
				bringTheAir($windTime, $reason);
			}

			//TODO: what to do when temps are high?
		}
	}


	function climateRainShedule() {
		global $debugMode;

		if ($debugMode == true) {
			logToFile("running climateRainShedule",'','');
		}

		//trigger rain shedules
		if (array_key_exists($curentTime, $rainShedule)) {
			$time = current($rainShedule);
			$reason = "rain shedule";
			letItRain($time, $reason);
		}
	}


	function climateHumidity() {
		global $debugMode;

		if ($debugMode == true) {
			logToFile("running climateHumidity",'','');
		}

		if ($tempSensor > $tempThreshold) {
			$tempDelta = ($tempSensor - $tempThreshold);
			if ($humiditySensor > $humidityThreshold) {
				//wind on high humidity
				$humidityDelta = ($humiditySensor - $humidityThreshold);
				$windTime = 10 + (50 / (100-$humidityThreshold) * $humidityDelta);
				$reason = "humidity: ".$humiditySensor;
				bringTheAir($windTime, $reason);
			}

			if ($humiditySensor < $humidityMin) {
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

			//wind when humidity is high
			$humDelta = ($humiditySensor - $humidityThreshold);
			if ($humiditySensor > $humidityThreshold) {
				$windTime = 10 + (50/(100-$humidityThreshold)*($humiditySensor-$humidityThreshold));
				$reason = "humidity: ".$humiditySensor;
				bringTheAir($windTime, $reason);
			} else {
				$reason = "humidity: ".$humiditySensor;
				bringTheAir(0, $reason);
			}

		}
	}


	function climateOverride() {
		global $debugMode;

		if ($debugMode == true) {
			logToFile("running climateOverride",'','');
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


	function letItRain($time, $reason) {
		global $debugMode;

		if ($debugMode == true) {
			logToFile("running letItRain",'','');
		}

		//timerSensor($pin = 2, $time, $inverted = true, $reason);
		$pin = 2;
		if ($time > 0) {
			exec("/usr/local/bin/gpio mode $pin out");
			exec("/usr/local/bin/gpio write $pin 0");
			sleep($time);
			if ($debugMode==true) {
				logToFile("let it rain", $time."s", $reason);
			}
			exec("/usr/local/bin/gpio write $pin 1");
		} elseif ($time == 0) {
			if ($debugMode==true) {
				logToFile("let it rain", $time."s", $reason);
			}
			exec("/usr/local/bin/gpio write $pin 1");
		}
	}


	function bringTheAir($time, $reason) {
		global $debugMode;

		if ($debugMode == true) {
			logToFile("running bringTheAir",'','');
		}

		$pin = 5;
		if ($time > 0) {
			exec("/usr/local/bin/gpio mode $pin out");
			exec("/usr/local/bin/gpio write $pin 1");
			//time till wind stops
			sleep ($time);
			if ($debugMode==true) {
				logToFile("bring the air", $time."s", $reason);
			}
			exec("/usr/local/bin/gpio write $pin 0");
		} elseif ($time == 0) {
			if ($debugMode==true) {
				logToFile("bring the air", $time."s", $reason);
			}
			exec("/usr/local/bin/gpio write $pin 0");
		}
	}


	//run climateCore
	climateCore();

?>
