
<?php
	include_once '/var/www/html/log.php';
	global $tempThreshold, $humidityThreshold;
	$tempThreshold = 0;
	//$interval = $argv[1];
	global $tempDay, $tempNight, $humidityDay, $humidityNight;
	$tempNight = 24.5;  	// 24.5
	$tempDay = 30.0;		// 26.5
	$humidityNight = 85.0;
	$humidityDay = 90.0;
	global $highTempRain, $humidityMin;
	$humidityMin = 65.0;
	$highTempRain = false;
	global $currentTime, $sunriseTime, $sunsetTime;
	$currentTime = date('H:i');
	$sunriseTime = ('10:00');
	$sunsetTime = ('22:00');
	//fixed rain trigger times (time => seconds)
	global $rainShedule, $rainTime, $windTime;
	$rainShedule = array('12:00' => 15, '18:00' => 15);
	$rainTime = 1; 			// time in seconds to rain
	$windTime = 10;			// time to vent in seconds
	global $debugMode, $override, $pumpPrimer, $climateControl;
	$override = false;		// override temperature and rain every minute
	$pumpPrimer = false; 	// set this to true to build up rain system pressure
	$debugMode = false;
	$climateControl = true;	//toggle climate control


	function climateCore(){
		global $debugMode, $climateControl;

		if ($debugMode == true) {
			log_to_file("running climateCore");
		}

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

				//run climate
				if ($climateControl == true) {
					cliamteDaytime($tempSensor, $humiditySensor);
				}

				$maxTemperature = 50;
				$minTemperature = 15;
				$maxHumidity = 100;
				$minHumidity = 50;

			 	if ($debugMode==true) {
					log_to_file("sensor test", $tempSensor, $humiditySensor);
					if ($tempSensor > $maxTemperature or $tempSensor < $minTemperature) {
						log_to_file("extreme temperature reading", $tempSensor, "");
					} else {
						log_to_file("temperature reading", $tempSensor, "");
					}
					if ($humiditySensor > $maxHumidity or $humiditySensor < $minHumidity) {
						log_to_file("extreme humidity reading", $humiditySensor, "");
					} else {
						log_to_file("humidity reading", $humiditySensor, "");
					}
				}
			}
		} else {
    		echo "0 results";
		}
		mysqli_close($db);
	}



	function cliamteDaytime($tempSensor,$humiditySensor) {
		global $debugMode;
		global $currentTime, $sunriseTime, $sunsetTime;
		global $humidityThreshold, $tempThreshold;
		global $tempNight, $humidityNight;
		global $tempDay, $humidityDay;

		if ($debugMode == true) {
			log_to_file("running cliamteDaytime $currentTime",$sunriseTime, $sunsetTime);
		}

		//night time climate
		if (($currentTime < $sunriseTime) or ($currentTime > $sunsetTime)) {
			$tempThreshold = $tempNight;
			$humidityThreshold = $humidityNight;
			$day = false;

			climateTemperature($tempSensor, $humiditySensor, $day);
			climateHumidity($tempSensor, $humiditySensor, $day);

			if ($debugMode==true) {

				log_to_file("night time limits", $tempThreshold, $humidityThreshold);
			}
		}

		//day time climate
		if (($currentTime > $sunriseTime) and ($currentTime < $sunsetTime)) {
			$humidityThreshold = $humidityDay;
			$tempThreshold = $tempDay;
			$day = true;

			climateRainShedule();
			climateTemperature($tempSensor, $humiditySensor, $day);
			climateHumidity($tempSensor, $humiditySensor, $day);

			if ($debugMode==true) {
				log_to_file("day time limits", $tempThreshold, $humidityThreshold);
			}
		}
	}




	function climateRainShedule() {
		global $debugMode;
		global $currentTime, $rainShedule;

		if ($debugMode == true) {
			log_to_file("running climateRainShedule",'','');
		}

		//trigger rain shedules
		if (array_key_exists($currentTime, $rainShedule)) {
			$time = current($rainShedule);
			$reason = "rain shedule";
			letItRain($time, $reason);
		}
	}




	function climateTemperature($tempSensor, $humiditySensor, $day) {
		global $debugMode;
		global $tempThreshold;
		global $rainTime, $windTime;
		global $highTempRain;

		if ($debugMode == true) {
			log_to_file("running climateTemperature",'','');
		}

		//react to high temperatures
		if ($tempSensor > $tempThreshold) {
			$tempDelta = ($tempSensor - $tempThreshold);

			if (($tempDelta > 0) and ($tempDelta < 10)) {
				$rainTime = $tempDelta + $rainTime;
				$windTime = $windTime + $tempDelta;
				$reason = "high temperature: ".$tempSensor;
				if ($highTempRain == true && $day == true) {
					letItRain($rainTime, $reason);
				}
				bringTheAir($windTime, $reason);		//TODO: define windtime
			} else {
				$reason = "high temperature: ".$tempSensor;
				if ($highTempRain == true && $day == true) {
					letItRain($rainTime, $reason);
				}
				bringTheAir($windTime, $reason);
			}
		}
	}




	function climateHumidity($tempSensor, $humiditySensor, $day) {
		global $debugMode;
		global $tempThresold;
		global $humidityThreshold, $humidityMin;
		global $windTime, $rainTime;

		if ($debugMode == true) {
			log_to_file("running climateHumidity",'','');
		}

		// rain when humidity drops below specified minimum valuee
		//if ($humiditySensor > 0 and $humiditySensor < $humidityMin) {
		if ($humiditySensor < $humidityMin && $day == true) {

			//react to low humidity
			$humidityDelta = ($humidityMin - $humiditySensor);
			if (($humidityDelta > 0) and ($humidityDelta < 10)) { //filter spike values
				$humidityDelta = $rainTime;
				$reason = "low humidity: ".$humiditySensor;
				letItRain($rainTime, $reason);
			} else {
				$reason = "low humidity: ".$humiditySensor;
				letItRain($rainTime, $reason);
			}
		}

		//air when humidity reaches a specified maximum
		if ($humiditySensor > $humidityThreshold) {
			$humDelta = ($humiditySensor - $humidityThreshold);
			$windTime = 10 + (50/(100-$humidityThreshold)*($humiditySensor-$humidityThreshold));

			$reason = "high humidity: ".$humiditySensor;
			bringTheAir($windTime, $reason);
		} else { //turn off air when below humidity value
			$reason = "low humidity: ".$humiditySensor;
			bringTheAir(0, $reason);
		}
	}




	function climateOverride() {
		global $debugMode;

		if ($debugMode == true) {
			log_to_file("running climateOverride",'','');
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
			log_to_file("running letItRain",'','');
		}

		//timerSensor($pin = 2, $time, $inverted = true, $reason);
		$pin = 2;
		if ($time > 0) {
			exec("/usr/local/bin/gpio mode $pin out");
			exec("/usr/local/bin/gpio write $pin 0");
			sleep($time);
			if ($debugMode==true) {
				log_to_file("let it rain", $time."s", $reason);
			}
			exec("/usr/local/bin/gpio write $pin 1");
		} elseif ($time == 0) {
			if ($debugMode==true) {
				log_to_file("let it rain", $time."s", $reason);
			}
			exec("/usr/local/bin/gpio write $pin 1");
		}
	}




	function bringTheAir($time, $reason) {
		global $debugMode;

		if ($debugMode == true) {
			log_to_file("running bringTheAir",'','');
		}

		$pin = 5;
		if ($time > 0) {
			exec("/usr/local/bin/gpio mode $pin out");
			exec("/usr/local/bin/gpio write $pin 1");
			//time till wind stops
			sleep ($time);
			if ($debugMode==true) {
				log_to_file("bring the air", $time."s", $reason);
			}
			exec("/usr/local/bin/gpio write $pin 0");
		} elseif ($time == 0) {
			if ($debugMode==true) {
				log_to_file("bring the air", $time."s", $reason);
			}
			exec("/usr/local/bin/gpio write $pin 0");
		}
	}


	//run climateCore
	climateCore();

?>
